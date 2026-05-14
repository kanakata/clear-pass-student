<?php
//this file contains the logic for date disbursement.
namespace App\Models\Date;

use App\Middleware\Database;
use App\Models\Query\SharedQuery;
use Exception;

class Date extends SharedQuery
{
    private static $connection = null;
    private static function init()
    {
        return self::$connection = (new Database())
            ->databaseConnect();
    }

    public static function date()
    {
        $info = parent::CollectStudentData();
        $departments = parent::CollectSubscriptionData();
        $valid_statuses = ["cleared", "pending_physical_payment", "online"];

        $categories = [];

        foreach ($departments as $department) {
            array_push($categories, $department . ' status');
        }

        $is_eligible = true;
        foreach ($categories as $cat) {
            if (!in_array($info[$cat], $valid_statuses)) {
                $is_eligible = false;
                break;
            }
        }

        if ($is_eligible && $info['clearance status'] != "cleared") {
            try {
                $sec = 86400;
                $stamp = time();
                $clearance_days = ["Mon", "Wed"];
                $holidays = [
                    "2026-01-01",
                    "2026-01-05",
                    "2026-03-20",
                    "2026-03-21",
                    "2026-04-03",
                    "2026-04-06",
                    "2026-06-01",
                    "2026-10-20",
                    "2026-12-12",
                    "2026-12-25",
                    "2026-12-26"
                ];

                // 2. Logic: Find the next valid clearance day (Mon or Wed) that isn't a holiday
                $found = false;
                $attempts = 0;
                while (!$found && $attempts < 15) { // Safety cap to prevent infinite loops
                    $stamp += $sec;
                    $current_day_name = date("D", $stamp);
                    $current_date_fmt = date("Y-m-d", $stamp);

                    if (in_array($current_day_name, $clearance_days) && !in_array($current_date_fmt, $holidays)) {
                        $found = true;
                    }
                    $attempts++;
                }

                // 3. Database Operations (Run only once)
                $report_day = date("D j F Y", $stamp);
                $report_date = date("Y-m-d", $stamp);

                // Set cookie
                setcookie("report_day", $report_day, time() + (5 * $sec), "/");

                $message = "{$info['username']} admission {$info['admission number']} is fully cleared and is due on $report_day";

                $sql = self::init()->prepare(("UPDATE `chebisaas login`  SET `report day`=? WHERE `admission number`=?"));
                if ($sql->execute([$report_date, $info['admission number']])) {
                    $stmt1 = self::init()->prepare("INSERT INTO `chebisaas notifications`(`notification`) VALUES (?)");
                    if ($stmt1->execute([$message])) {
                        $stmt2 = self::init()->prepare("UPDATE `chebisaas student data` SET `clearance status`=? WHERE `admission number`=?");
                        $stmt2->execute(["cleared", $info['admission number']]);
                    }
                }
            } catch (Exception $e) {
                $error = "Error " . $e->getMessage() . " on file " . $e->getFile() . " on line " . $e->getLine();
            }
        }
    }
}
