<?php

namespace App\Controllers;

use App\Helpers\InputHelper;
use App\Models\User;
use App\Helpers\SmartCaptchaHelper;

class LoginController extends Controller
{

    public function indexAction(): string|false
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (array_key_exists('session', $_SESSION)) {
            header('Location: /account');
            return (new AccountController())->indexAction();
        }

        return $this->loadView('login');
    }

    public function login(array $post): string|false
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $login    = InputHelper::prepare($post['login']);
        $password = InputHelper::prepare($post['password']);
        $token    = $post['smart-token'];

        $userModel = new User();

        $isUserLogin = $userModel->loginUser(
            [
                'login'    => $login,
                'password' => $password
            ]
        );

        if (!$isUserLogin) {
            $message = 'Invalid login information. Please try again!';

            return $this->loadView(
                'login',
                ['message' => $message, 'login' => $login]
            );
        }

        if (!SmartCaptchaHelper::checkCaptcha($token)) {
            $message = 'You did not pass the captcha!';

            return $this->loadView(
                'login',
                ['message' => $message, 'login' => $login]
            );
        }

        $_SESSION['session'] = ['login' => $login];

        return (new AccountController())->indexAction();
    }

    public static function logout(): string|false
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (array_key_exists('session', $_SESSION)) {
            unset($_SESSION['session']);
        }

        session_destroy();

        return (new MainController())->indexAction();
    }

}