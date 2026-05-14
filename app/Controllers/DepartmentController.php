<?php

namespace App\Controllers;

use App\Models\Query\SharedQuery;
use App\Models\Services\DepartmentService;

class DepartmentController extends SharedQuery
{

    public static function show()
    {

        if (isset($_GET['proceed'])) {
            DepartmentService::payPhysically();
        }

        $dept = $_GET['department'];
        $page_title = $dept;
        $studentInfo = self::CollectStudentData();

        return require ROOT . "/resources/views/department.php";
    }

    private function payPhysically(){

    }
    private function payOnline(){

    }

}
