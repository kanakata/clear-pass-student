<?php

namespace App\Models\Services;

use App\Middleware\Database;
use Exception;

class SelectInstitutionService extends Database
{
    private static $message;
    private static $connection = null;

    private static function init()
    {
        return self::$connection = (new Database())
            ->databaseConnect();
    }
    public static function Proceed()
    {
        try {

            $credentials = [
                "school_code" => $_POST['school_code'],
                "school_name" => $_POST['school_name'],
                "csrf"        => $_POST['csrf_token'],
            ];

            //$sanitized_credentials = array_map("parent::sanitizeInputs", $credentials);

            $sql = self::init()->prepare("SELECT `school name` FROM `subscriptions` WHERE `school code`=?");
            $sql->execute([$credentials['school_code']]);
            $result = $sql->fetchColumn();
            if ($result <= 0) {

                self::$message = "🔔🔔🔔 Please enter the correct school code !!!";
            } else {

                $_SESSION['school_name'] = $credentials['school_name'];
                $_SESSION['popup_message'] = "welcome to {$credentials['school_name']} register page";
                header("location: /register");
                exit();
            }

            $_SESSION['popup_message'] = self::$message;
        } catch (Exception $e) {

            $error = "Error " . $e->getMessage() . " on file: " . $e->getFile() . " on line: " . $e->getLine();
        }
    }
}
