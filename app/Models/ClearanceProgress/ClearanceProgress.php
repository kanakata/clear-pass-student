<?php

namespace App\Models\ClearanceProgress;

use App\Models\Query\SharedQuery;

class ClearanceProgress extends SharedQuery
{
    public static function calculateClearanceProgress()
    {
        $studentData = self::CollectStudentData();

        $departments = self::CollectSubscriptionData();

        $depts = [];

        foreach ($departments as $department) {
            array_push($depts, $department . ' status');
        }

        $status = [];

        foreach ($depts as $dept) {
            array_push($status, $studentData[$dept]);
        }

        $total = 0;
        foreach ($status as $stat) {
            if ($stat == "cleared" || $stat == "pending_physical_payment" || $stat == "online") {
                $total += 100;
            } else {
                $totalPercentage = 0;
            }
        }

        $totalPercentage = number_format($total / count($departments), 0);

        return [
            "totalPercentage" => $totalPercentage,
            "status" => $status,
        ];
    }
}
