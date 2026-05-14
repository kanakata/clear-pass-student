<?php

namespace App\Controllers;

use App\Models\Auth\RegisterAuth;

class RegisterController
{
    public static function show()
    {

        if (isset($_POST['signup'])) {
            RegisterAuth::register();
        }

        return require ROOT . "/resources/views/register.php";
    }
}
