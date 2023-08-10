<?php

namespace App\Helpers;

class InputHelper
{

    public static function prepare(string $input): string
    {
        return htmlspecialchars(trim($input));
    }

}