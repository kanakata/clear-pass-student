<?php

namespace App\Controllers;

use App\Models\Query\SharedQuery;
use App\Models\Services\SelectInstitutionService;

class SelectInstitutionController extends SharedQuery
{
    public static function show()
    {
        $schools = self::CollectAvailableSchools();

        if (isset($_POST['proceed'])) {
            $auth = SelectInstitutionService::Proceed();
            $action_status = $auth;
        }

        return require ROOT . "/resources/views/selectInstitution.php";
    }
}
