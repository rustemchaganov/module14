<?php
require_once "process.php";

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_COOKIE['expiryTime'])) {
    setcookie('expiryTime', time() + 86400, 0, "/");
}

$auth = $_SESSION['auth'] ?? null;

?>
<!DOCTYPE>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Спа салон</title>
    <link rel="stylesheet" href="style.css" type="text/css">
    <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <div class="header">
        <div class="menu">
            <a href="#services">Услуги</a>
            <a href="#stock">Акции</a>
            <a href="#contacts">Контакты</a>
        </div>
        <div class="authorization">
            <?php if(!$auth) :?>
                    <a href="login/login.php">Войти</a>
            <?php endif; ?>
            <?php if($auth) :?>
            <div class="user-info">
                Привет, <?= htmlspecialchars(getCurrentUser(), ENT_QUOTES, 'UTF-8') ?>
            </div>
                <a href="logout.php">Выйти</a>
                <a href="profile/profile.php">Личный кабинет</a>
            <?php endif; ?>
        </div>
    </div>
</header>
<main>
    <div class ="salon">
        <h1>Спа Салон на Невском</h1>
    <div>
    <div id="services" class="services">
        <h2>Услуги</h2>
        <div class="body-massage">
            <h3>Массаж тела</h3>
            <img src="images/massage_body.jpg" alt="body massage img">
        </div>
        <div class="face-massage">
            <h3>Массаж лица</h3>
            <img src="images/massage_face.jpg" alt="face massage img">
        </div>
        <div class="spa-program">
            <h3>Спа программа</h3>
            <img src="images/spa_program.jpg" alt="spa program img">
        </div>
        <div class="gift">
            <h3>Подарочные сертификаты</h3>
            <img src="images/gift.jpeg" alt="spa gift img">
        </div>
    </div>
    <div id="stock" class="stock">
        <h2>Акции</h2>
        <div class="subscription">
            <h3>+1 Месяц бесплтано</h3>
            <img src="images/discount_spa.jpeg" alt="spa discount img">
        </div>
        <div class="subscription-discount-program">
            <h3>Абонемент на 10 часов</h3>
            <img src="images/discount_subscription.jpg" alt="discount subscription img">
        </div>
    </div>
</main>
<footer>
    <div id="contacts" class="contacts">
            <h2>Контакты :</h2>
            <div class="contact-item">
                <h3>Адрес:</h3>
                <p>Невский проспект, 27, Санкт-Петербург</p>
            </div>
            <div class="contact-item">
                <h3>Записаться:</h3>
                <p>+7-777-777-77-77</p>
            </div>
            <div class="contact-item">
                <h3>Почта:</h3>
                <p>spananevskom@milo.ru</p>
            </div>
        </div>
</footer>
</body>
</html>
