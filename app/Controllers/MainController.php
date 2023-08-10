<?php

namespace App\Controllers;

class MainController extends Controller
{

    public function indexAction(): string|false
    {
        if (!isset($_SESSION)) {
            session_start();
        }

        return $this->loadView('index');
    }

}