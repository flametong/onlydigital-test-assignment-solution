<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>OnlyDigital Test Assignment</title>
    <script src="https://smartcaptcha.yandexcloud.net/captcha.js" defer
    ></script>
</head>
<body>
<nav>
    <p>
        <a href="/">
            Main
        </a>
    </p>
    <?php if (isset($_SESSION['session'])): ?>
        <p>
            <a href="/account">
                Personal Account
            </a>
        </p>
        <p>
            <a href="/logout">
                Logout
            </a>
        </p>
    <?php else: ?>
        <p>
            <a href="/login">
                Login
            </a>
        </p>
        <p>
            <a href="/signup">
                Sign Up
            </a>
        </p>
    <?php endif; ?>
</nav>