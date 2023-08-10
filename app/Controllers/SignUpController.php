<?php

namespace App\Controllers;

use App\Helpers\InputHelper;
use App\Models\User;
use App\Validator\UserValidator;

class SignUpController extends Controller
{

    public function indexAction(array $data = []): string|false
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        if (array_key_exists('session', $_SESSION)) {
            header('Location: /account');
            return (new AccountController())->indexAction();
        }

        return $this->loadView(
            'signup',
            ['data' => $data]
        );
    }

    public function signUp(array $post): string|false
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        $username          = InputHelper::prepare($post['username']);
        $phone             = InputHelper::prepare($post['phone']);
        $email             = InputHelper::prepare($post['email']);
        $password          = InputHelper::prepare($post['password']);
        $passwordDuplicate = InputHelper::prepare($post['password_duplicate']);

        $errors = $this->getErrors(
            $username, $phone, $email, $password, $passwordDuplicate
        );

        if ($errors !== []) {
            $data = [
                'username' => $username,
                'phone'    => $phone,
                'email'    => $email,
                'error'    => $errors
            ];

            return $this->indexAction($data);
        }

        $userModel = new User();

        $isUserAdded = $userModel->createUser(
            $username,
            $email,
            $phone,
            password_hash($password, PASSWORD_DEFAULT)
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

    private function getErrors(
        string $username,
        string $phone,
        string $email,
        string $password,
        string $passwordDuplicate
    ): array
    {
        $validator = new UserValidator();

        $validator->setRules(
            [
                'username'           => 'require|unique',
                'phone'              => 'require|unique',
                'email'              => 'require|unique',
                'password'           => 'require|match:password_duplicate',
                'password_duplicate' => 'require'
            ]
        );

        return $validator->validate(
            [
                'username'           => $username,
                'phone'              => $phone,
                'email'              => $email,
                'password'           => $password,
                'password_duplicate' => $passwordDuplicate
            ]
        );
    }

}