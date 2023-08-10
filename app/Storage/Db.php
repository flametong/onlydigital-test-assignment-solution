<?php

namespace App\Storage;

use PDO;
use PDOException;

class Db
{

    use TSingleton;

    private PDO $pdo;

    private function __construct()
    {
        $db = require_once CONFIG . '/config_db.php';

        try {
            $this->pdo = new PDO(
                $db['dsn'],
                $db['user'],
                $db['password']
            );
            $this->pdo->setAttribute(
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION
            );
        } catch (PDOException $e) {
            echo 'Error connecting to database: ' . $e->getMessage();
            die();
        }
    }

    public function getPdo(): PDO
    {
        return $this->pdo;
    }

}