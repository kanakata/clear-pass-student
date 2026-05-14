<?php

namespace App\Controllers;

class SessionController
{
    public function logOut()
    {
        session_destroy();
        header("location: /landing");
        exit();
    }
    public function notFound()
    {
        http_response_code(404);
        header("location: /404");
        exit();
    }

    public function pricingBack()
    {
        unset($_SESSION['value']);
        unset($_SESSION['plan']);
        unset($_SESSION['departments']);
        unset($_SESSION['limit']);
        header("location: /pricing");
        exit();
    }
}
