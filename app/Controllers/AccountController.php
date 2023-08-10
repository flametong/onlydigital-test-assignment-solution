<?php

namespace App\Controllers;

use App\Helpers\InputHelper;
use App\Models\User;

class AccountController extends Controller
{

    public function indexAction(array $user = []): string|false
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (!array_key_exists('session', $_SESSION)) {
            header('Location: /');
            return (new LoginController())->indexAction();
        }

        if ($user === []) {
            $user = (new User())->getUserByLogin($_SESSION['session']['login']);
        }

        $userData = [
            'username' => $user['username'],
            'phone'    => $user['phone'],
            'email'    => $user['email'],
        ];

        return $this->loadView(
            'account',
            ['user' => $userData]
        );
    }

    public function updateCredentials(array $post): string|false
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $username = InputHelper::prepare($post['username']);
        $phone    = InputHelper::prepare($post['phone']);
        $email    = InputHelper::prepare($post['email']);
        $password = InputHelper::prepare($post['password']);

        $userModel = new User();

        $id = $userModel->getIdByLogin($_SESSION['session']['login']);

        $isUserAdded = $userModel->updateUser(
            $id,
            $username,
            $email,
            $phone,
            $password
        );

        if (!$isUserAdded) {
            return $this->indexAction();
        }

        $userData = [
            'username' => $username,
            'phone'    => $phone,
            'email'    => $email,
        ];

        $_SESSION['session'] = ['login' => $email];

        return (new AccountController())->indexAction($userData);
    }

}