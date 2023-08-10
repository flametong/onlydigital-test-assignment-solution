<?php

require_once dirname(__DIR__) . '/config/init.php';
require_once ROOT . '/vendor/autoload.php';

use App\App;
use App\Controllers\AccountController;
use App\Controllers\LoginController;
use App\Controllers\MainController;
use App\Controllers\SignUpController;

$app = new App();

$mainController    = new MainController();
$loginController   = new LoginController();
$signUpController  = new SignUpController();
$accountController = new AccountController();

$app->get(
    '/',
    function () {
        global $mainController;
        return $mainController->indexAction();
    }
);

$app->get(
    '/login',
    function () {
        global $loginController;
        return $loginController->indexAction();
    }
);

$app->post(
    '/login',
    function () {
        global $loginController;
        return $loginController->login($_POST);
    }
);

$app->get(
    '/logout',
    function () {
        global $loginController;
        return $loginController->logout();
    }
);

$app->get(
    '/signup',
    function () {
        global $signUpController;
        return $signUpController->indexAction();
    }
);

$app->post(
    '/signup',
    function () {
        global $signUpController;
        return $signUpController->signUp($_POST);
    }
);

$app->get(
    '/account',
    function () {
        global $accountController;
        return $accountController->indexAction();
    }
);

$app->post(
    '/account',
    function () {
        global $accountController;
        return $accountController->updateCredentials($_POST);
    }
);

$app->run();