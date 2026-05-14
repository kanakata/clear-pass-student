<?php

namespace App\Controllers;

use App\Models\ClearanceProgress\ClearanceProgress;
use App\Models\Date\Date;
use App\Models\Query\SharedQuery;

class DashboardController extends SharedQuery
{
    public static function show()
    {

        $studentInfo = self::CollectStudentData();
        $clearanceProgress = ClearanceProgress::calculateClearanceProgress();
        $departments = self::CollectSubscriptionData();
        $totalPercentage = $clearanceProgress['totalPercentage'];

        if ($totalPercentage == 100) {
            Date::date();
        }

        $status = $clearanceProgress['status'];

        return require ROOT . "/resources/views/dashboard.php";
    }


}
