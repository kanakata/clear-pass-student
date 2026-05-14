<?php

namespace App\Controllers;

class LandingController
{
    public static function show()
    {
        return require ROOT . "/resources/views/landing.php";
    }
}
