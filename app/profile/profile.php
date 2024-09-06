<?php

require_once "../process.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$auth = $_SESSION['auth'] ?? null;

if (!$auth) {
    header('Location: /index.php');
}

$birthday = $_POST['birthday'] ?? null;
$daysUntilBirthday = getDaysUntilNextBirthday();
$expiryTime = $_COOKIE['expiryTime'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['submit'] === 'Добавить') {
    addBirthday($birthday);
}

?>
<!DOCTYPE>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="header">
        <h1>СПА САЛОН НА НЕВСКОМ</h1>
        <div class="user-actions">
            <div class="user-info">
                Привет, <?= htmlspecialchars(getCurrentUser(), ENT_QUOTES, 'UTF-8') ?>
            </div>
            <a href="../index.php">На главную</a>
            <a href="../logout.php">Выйти</a>
        </div>
    </div>
</header>

<div class="container">
    <div class="sidebar">
        <button id="user-promo">Персональные акции</button>
        <button id="user-birthday">Личные данные</button>
        <button id="user-history">История посещений</button>
    </div>
    <div class="content" id="content">
        <div class="content-user promo active">
            <div>
                <?php
                if (!existBirthday()) : ?>
                    <p class="birthday-promo">Укажите дату рождения в разделе "Личные данные" для получения скидки</p>
                <?php
                endif; ?>

                <?php
                if ($daysUntilBirthday >= 1) : ?>
                    <p class="birthday-promo">До акции в честь дня рождения:
                        <?php
                        echo "$daysUntilBirthday " . getDayString($daysUntilBirthday); ?></p>
                <?php
                elseif ($daysUntilBirthday === 0) : ?>
                    <p class="birthday-promo">С днём рождения! Запишитесь сегодня для скидки 35%!</p>
                <?php
                endif; ?>
            </div>
            <div class="promo-highlight">
                <p>Персональная акция! Скидка 20%,позвони для записи</p>
                <p id="countdown" data-expiry-time="<?= $expiryTime; ?>"></p>
            </div>
        </div>
        <div class="content-user birthday">
            <div>Дата рождения: <?= getBirthdayDate() ?></div>
            <?php
            if (!existBirthday()) : ?>
                <form action="profile.php" method="post" class="form-container">
                    <label>
                        <input name="birthday" type="date" class="date-input">
                    </label>
                    <input name="submit" type="submit" value="Добавить" class="submit-button">
                </form>
            <?php
            endif; ?>
        </div>
        <div class="content-user history">
            <div>
                Тут будет история посещений нашего салона.
            </div>
        </div>
    </div>
</div>
<script src="profile.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
</body>
</html>
