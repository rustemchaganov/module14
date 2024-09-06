<?php

const USERS = '../login/users.json';
function getUsersList(): array
{
    $userList = file_get_contents(USERS);
    if ($userList === false) {
        return [];
    }

    return json_decode($userList, true) ?? [];
}

function addUser(string $login, string $password): bool
{
    if (existsUser($login)) {
        return false;
    }
    $users = getUsersList();
    $users[] = [
        'login' => $login,
        'password' => sha1($password),
    ];
    file_put_contents(USERS, json_encode($users), JSON_UNESCAPED_UNICODE);

    return true;
}

function existsUser(string $login): bool
{
    foreach (getUsersList() as $user) {
        if ($login === $user['login']) {
            return true;
        }
    }

    return false;
}

function validatePassword(string $password, string $hash): bool
{
    return sha1($password) === $hash;
}

function getPasswordHashByLogin(string $login): ?string
{
    foreach (getUsersList() as $user) {
        if ($user['login'] === $login) {
            return $user['password'];
        }
    }

    return null;
}

function checkPassword(string $login, string $password): bool
{
    if (!$hash = getPasswordHashByLogin($login)) {
        return false;
    }

    return validatePassword($password, $hash);
}

function getCurrentUser(): ?string
{
    return $_SESSION['login'] ?? null;
}

function getUser(): array
{
    $userData = [];
    foreach (getUsersList() as $user) {
        if ($user['login'] === getCurrentUser()) {
            $userData = $user;
            break;
        }
    }

    return $userData;
}

function existBirthday(): bool
{
    return isset(getUser()['birthday']);
}

function addBirthday(string $birthday): void
{
    $users = getUsersList();
    $currentUser = getCurrentUser();
    if ($birthday === '') {
        return;
    }
    if (!existBirthday()) {
        foreach ($users as &$user) {
            if ($user['login'] === $currentUser) {
                $user['birthday'] = $birthday;
                break;
            }
        }
        file_put_contents(USERS, json_encode($users), JSON_UNESCAPED_UNICODE);
    }
}

function getBirthdayDate(): ?string
{
    if (existBirthday()) {
        return getUser()['birthday'];
    }

    return null;
}

function getDayString(string $date): string
{
    $cases = [2, 0, 1, 1, 1, 2];
    $titles = ["день", "дня", "дней"];

    $mod100 = $date % 100;
    $mod10 = $date % 10;

    if ($mod100 > 10 && $mod100 < 20) {
        return $titles[2];
    }

    return $titles[($mod10 < 5) ? $cases[$mod10] : $cases[5]];
}

function getDaysUntilNextBirthday(): ?int
{
    $birthday = getBirthdayDate();

    if ($birthday === null) {
        return null;
    }

    $birthday = new DateTime($birthday);
    $birthday->modify('+1 day');
    $today = new DateTime();
    $birthday->setDate($today->format('Y'), $birthday->format('m'), $birthday->format('d'));

    if ($birthday < $today) {
        $birthday->modify('+1 year');
    }

    $interval = $today->diff($birthday);
    return $interval->days;
}
