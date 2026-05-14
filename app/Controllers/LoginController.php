<?php

namespace App\Controllers;

use App\Models\Auth\LoginAuth;

class LoginController extends LoginAuth
{
    public static function show()
    {

        if (isset($_POST['login'])) {
            LoginAuth::login();
        }

        return require ROOT . "/resources/views/login.php";
    }
}
