<?php

namespace App\Models\Auth;

use App\Middleware\Database;
use Exception;
use PDO;
class RegisterAuth extends Database
{
    private static $message;
    private static $notification;
    private static $connection = null;
    private static function init()
    {
        return self::$connection = (new Database())
            ->databaseConnect();
    }
    public static function register()
    {
        try {

            $credentials = [
                "firstName" => $_POST['firstname'],
                "lastName"  => $_POST['lastname'],
                "surName"   => $_POST['surname'],
                "admission" => $_POST['admission'],
                "index"     => $_POST['index'],
            ];

            $password  = $_POST['password'];
            $confirm_password = $_POST['confirm_password'];
            $csrf  = $_POST['csrf'];

            if ($_SESSION['csrf'] !== $csrf) {
                header("location: /404");
                exit();
            } else {

                if ($password !== $confirm_password) {
                    self::$message = "😥😥😥 The passwords you entered do not match.";

                } else {
                    $username = $credentials['firstName'] . $credentials['lastName'] . $credentials['surName'];
                    $table = $_SESSION['school_name'] . " student data";
                    $check = self::init()->prepare("SELECT `admission number` FROM `$table` WHERE `admission number`=? AND `username`=?");
                    $check->execute([$credentials['admission'], $username]);
                    $result = $check->fetchColumn();

                    if ($result <= 0) {
                        self::$message = "😥😥😥 Cannot verify your eligibility, please contact your school to get help.";
                    } else {
                        $hashed_pass = password_hash($password, PASSWORD_DEFAULT);

                        $table = $_SESSION['school_name'] . " login";
                        $check = self::init()->prepare("SELECT `admission number` FROM `$table` WHERE `admission number`=?");
                        $check->execute([$credentials['admission']]);
                        $result = $check->fetchColumn();

                        if ($result >= 1) {
                            self::$message = "😥😥😥 An account with this credentials already exists, try logging in.";
                        } else {

                            $sql = self::init()->prepare("INSERT INTO `$table` (`admission number`, `index number`, `username`, `password`) VALUES (?, ?, ?, ? )");

                            if ($sql->execute([ $credentials['admission'], $credentials['index'], $username, $hashed_pass])) {
                                self::$message = "🥳🥳🥳 Registration successful! Please log in.";
                                $table = $_SESSION['school_name'] . " notifications";
                                self::$notification = "User " . $username . " admission " . $credentials['admission'] . " has successfully signed up";
                                $check = self::init()->prepare("INSERT INTO `$table` (`notification`) VALUES (?)");
                                $check->execute([self::$notification]);
                            }
                        }
                    }
                }
            }
        } catch (Exception $e) {
            $error = "Error " . $e->getMessage() . " on file: " . $e->getFile() . " on line: " . $e->getLine();
        }

        $_SESSION['popup_message'] = self::$message;

        
    }
}
