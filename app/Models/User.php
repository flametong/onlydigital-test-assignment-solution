<?php

namespace App\Models;

use App\Storage\Db;
use PDO;
use PDOException;

class User
{

    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = (Db::getInstance())->getPdo();
    }

    public function getUserByLogin(string $login, string $mode = 'login'): array|false
    {
        $modes = [
            'login'  => "WHERE 
                            email       = :login 
                            OR phone    = :login",
            'signup' => "WHERE 
                            email       = :login 
                            OR phone    = :login
                            OR username = :login",
        ];

        $whereCondition = $modes[$mode];

        try {
            $stmt = $this->pdo->prepare(
                "SELECT *
                 FROM Users
                 $whereCondition"
            );

            $stmt->bindParam(':login', $login);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error getting user: ' . $e->getMessage();

            return false;
        }
    }

    public function getIdByLogin(string $login): int|false
    {
        $sql = "SELECT id 
                FROM users 
                WHERE 
                    username = :login 
                    OR email = :login 
                    OR phone = :login";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return false;
        }

        return $result['id'];
    }

    public function createUser(
        string $username,
        string $email,
        string $phone,
        string $password
    ): bool
    {
        try {
            $stmt = $this->pdo->prepare(
                "INSERT INTO users (username, email, phone, password) 
                 VALUES (?, ?, ?, ?)"
            );

            $stmt->execute([
                $username, $email, $phone, $password
            ]);

            return true;
        } catch (PDOException $e) {
            echo 'Error creating user: ' . $e->getMessage();

            return false;
        }
    }

    public function updateUser(
        int    $id,
        string $username,
        string $email,
        string $phone,
        string $password
    ): bool
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $setPassword = $password
            ? ", password = :password"
            : '';

        try {
            $stmt = $this->pdo->prepare(
                "UPDATE users 
                 SET username = :username, 
                    email     = :email,
                    phone     = :phone
                    $setPassword
                 WHERE id = :id"
            );

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':id', $id);

            if ($setPassword) {
                $stmt->bindParam(':password', $hashedPassword);
            }

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            echo 'Error creating user: ' . $e->getMessage();

            return false;
        }
    }

    public function loginUser(array $credentials): bool
    {
        [
            'login'    => $login,
            'password' => $password
        ] = $credentials;

        try {
            $user = $this->getUserByLogin($login);

            if (empty($user)) {
                return false;
            }

            $hashedPassword = $user['password'];

            if (!password_verify($password, $hashedPassword)) {
                return false;
            }

            return true;
        } catch (PDOException $e) {
            echo 'Error getting user: ' . $e->getMessage();

            return false;
        }
    }

}