<?php

namespace App\Controllers;

use App\Models\Mpesa\Mpesa;
use App\Models\Query\SharedQuery;

class PayDebtController extends SharedQuery
{

    public function  show()
    {
        $studentInfo = self::CollectStudentData();

        if (isset($_POST['online_payment'])) {
            $this->processPayment($studentInfo);
        }

        return require ROOT . "/resources/views/payDebt.php";
    }

    private function processPayment(array $studentInfo)
    {

        $department = $_GET['department'];

        if (!$department) {
            return "oops something went wrong.";
        }

        $payload = [
            "name"             => $studentInfo['username'],
            "admission"        => $studentInfo['admission number'],
            "phone"            => filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT),
            "amount"           => $studentInfo[$department . " value"],
        ];

        $_SESSION['shipment payload'] = $payload;

        // Integration point for M-Pesa STK Push
        $mpesa = (new Mpesa())
            ->stkPush($payload['phone'], $payload['amount']);

        return "Check your phone to complete the payment.";
    }
}
