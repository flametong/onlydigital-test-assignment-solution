<?php

namespace App\Controllers;

class Controller
{

    public function loadView(string $filepath, array $params = []): string|false
    {
        $template =
            ROOT
            . DIRECTORY_SEPARATOR
            . 'app'
            . DIRECTORY_SEPARATOR
            . 'Views'
            . DIRECTORY_SEPARATOR
            . $filepath
            . '.php';

        extract($params);

        ob_start();
        require $template;

        return ob_get_clean();
    }

}