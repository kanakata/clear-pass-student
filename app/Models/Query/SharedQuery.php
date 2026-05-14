<?php

namespace App\Models\Query;

use App\Middleware\Database;
use Exception;
use PDO;

class SharedQuery extends Database
{
    private static $connection = null;
    private static function init()
    {
        return self::$connection = (new Database())
            ->databaseConnect();
    }
    protected static function CollectAvailableSchools()
    {
        try {
            $sql = self::init()->prepare(("SELECT * FROM `subscriptions`"));
            $sql->execute();
            return $sql->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            $error = "Error " . $e->getMessage() . " on file: " . $e->getFile() . " on line: " . $e->getLine();
        }
    }
    protected static function CollectStudentData()
    {
        try {
            if (isset($_SESSION['admission'])) {
                $admission = $_SESSION['admission'];
                $table = $_SESSION['school_name'] . " student data";
                $stmt = self::init()->prepare("SELECT * FROM `$table` WHERE `admission number`=?");
                $stmt->bindParam(1, $admission);
                $stmt->execute();

                return $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            $error = "Error " . $e->getMessage() . " on file: " . $e->getFile() . " on line: " . $e->getLine();
        }
    }
    protected static function CollectAvailableDestinationsData(string $destination)
    {
        $table = $_SESSION['school_name'] . " shipment cost";
        $sql = self::init()->prepare("SELECT * FROM `$table` WHERE `location`=?");
        $sql->execute([$destination]);

        return $sql->fetch(PDO::FETCH_ASSOC);

    }

    protected static function CollectSubscriptionData()
    {
        $sql = 'SELECT * FROM `subscriptions` WHERE `school name`=?';
        $sql = self::init()->prepare(($sql));
        $sql->execute([$_SESSION['school_name']]);
        $result = $sql->fetch(PDO::FETCH_ASSOC);

        $array_values = array_values($result);
        $array_filter = array_filter($array_values);
        $departments = array_splice($array_filter, 7);

        return $departments;
    }
    
}
