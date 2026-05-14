<?php

namespace App\Models\Services;

use App\Middleware\Database;

class DepartmentService extends Database
{
    private string $message;
    private string $notification;
    private static $connection = null;

    private static function init()
    {
        return self::$connection = (new Database())
            ->databaseConnect();
    }


    public static function payPhysically()
    {
        $admission = $_SESSION['admission'];
        $departmentStatus = $_GET['department'] . " status";
        $status = "pending_physical_payment";
        $table = $_SESSION['school_name'] . " student data";
        $sql = self::init()->prepare("UPDATE `$table` SET `$departmentStatus`=? WHERE `admission number`=?");
        $sql->execute([$status, $admission]);
        unset($sql);
    }
    public static function noDebt()
    {
        $admission = $_SESSION['admission'];
        $departmentStatus = $_GET['department'] . " status";
        $status = "cleared";
        $table = $_SESSION['school_name'] . " student data";
        $sql = self::init()->prepare("UPDATE `$table` SET `$departmentStatus`=? WHERE `admission number`=?");
        $sql->execute([$status, $admission]);
        unset($sql);
    }
}
