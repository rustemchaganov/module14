<?php

require_once "../process.php";

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$username = $_POST['login'] ?? '';
$userPassword = $_POST['password'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] === 'Войти') {
    if (checkPassword($username, $userPassword)) {
        $_SESSION['auth'] = true;
        $_SESSION['login'] = $username;
        header('Location: ../profile/profile.php');
        exit();
    } else {
        $error = 'Неверный логин или пароль';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] === 'Зарегистрироваться') {
    $login = $_POST['login'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($login) || empty($password)) {
        $error = 'Заполните поля логин и пароль';
    } else {
        if (!addUser($login, $password)) {
            $error = 'Пользователь с таким логином уже существует';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Вход в личный кабинет</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
<div class="registration">
    <?php
    if (isset($error)): ?>
        <div class="error">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php
    endif; ?>
    <form action="login.php" method="post">
        <label>
            <input name="login" type="text" placeholder="Логин">
        </label>
        <label>
            <input name="password" type="password" placeholder="Пароль">
        </label>
        <input name="submit" type="submit" value="Войти">
        <input name="submit" type="submit" value="Зарегистрироваться">
    </form>
</div>
</body>
