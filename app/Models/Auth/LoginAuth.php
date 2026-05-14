<?php

namespace App\Models\Auth;

use App\Middleware\Database;
use PDO;
use Exception;

class LoginAuth extends Database
{
    private static string $message;
    private static $connection = null;
    private static function init()
    {
        return self::$connection = (new Database())
            ->databaseConnect();
    }

    protected static function login()
    {
        try {

            $credentials = [
                "firstName" => $_POST['firstname'],
                "lastName" => $_POST['lastname'],
                "sirName"   => $_POST['surname'],
                "admission" => $_POST['admission'],
                "index"     => $_POST['index'],
                "password"  => $_POST['password'],
                "csrf"      => $_POST['csrf'],
            ];

            if ($_SESSION['csrf'] !== $credentials['csrf']) {

                redirect("/404", 404);
            } else {

                $username = trim($credentials['firstName'] . " " . $credentials['lastName'] . " " . $credentials['sirName']);
                $table = $_SESSION['school_name'] . " login";
                $stmt = self::init()->prepare("SELECT * FROM `$table` WHERE `admission number`=?");
                $stmt->execute([$credentials['admission']]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if (!empty($result)) {

                    $user = $result;
                    unset($stmt);
                    if (password_verify($credentials['password'], $user['password'])) {

                        if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {

                            $hashed_password = password_hash($credentials['password'], PASSWORD_DEFAULT);
                            $sql = self::init()->prepare("UPDATE `$table` SET `password`=? WHERE `admission number`=?");
                            $sql->execute([$hashed_password, $credentials['admission']]);
                        }

                        $_SESSION['admission'] = $user['admission number'];
                        $get_ip = $_SERVER['REMOTE_ADDR'];
                        $date = date("Y-m-d", time());
                        $table = $_SESSION['school_name'] . " login register";
                        $sql = self::init()->prepare("INSERT INTO `$table` (`admission number`, `username`, `index number`, `date`, `ip`) VALUE (?,?,?,?,?)");
                        if ($sql->execute([$credentials['password'], $username, $credentials['index'], $date, $get_ip])) {

                            unset($sql);
                            $table = $_SESSION['school_name'] . " student data";
                            $sql = self::init()->prepare("SELECT `admission number` FROM `$table` WHERE `admission number`=?");
                            $sql->execute([$_SESSION['admission']]);
                            $result = $sql->fetchColumn();
                            if ($result <= 0) {

                                self::$message = "😥😥😥 Cannot get your clearance details, please contact your school to get help.";
                            } else {

                                session_regenerate_id(true);
                                $_SESSION['popup_message'] = "Login successful!";
                                redirect("/dashboard", 200);

                            }
                        }
                    } else {
                        self::$message = "😥😥😥 Invalid credentials. Please try again.";
                    }
                } else {
                    self::$message = "😥😥😥 No account found with those details. Please try again with the right credentials.";
                }
            }
        } catch (Exception $e) {
            $error = "Error " . $e->getMessage() . " on file: " . $e->getFile() . " on line: " . $e->getLine();
        }

        $_SESSION['popup_message'] = self::$message;
    }
}
