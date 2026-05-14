<?php

namespace App\Models\Query;

use App\Middleware\Database;
use PDO;
class PayShipmentQuery extends Database
{
    private static $connection = null;
    private static function init()
    {
        return self::$connection = (new Database())
            ->databaseConnect();
    }
    public static function CollectAvailableDestinations()
    {
        $table = $_SESSION['school_name'] . " shipment cost";
        $sql = self::init()->prepare("SELECT `location` FROM `$table`");
        $sql->execute();
        $destination_info = $sql->fetchAll(PDO::FETCH_ASSOC);
        return $destination_info;
    }
}
