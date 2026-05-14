<?php

namespace App\Controllers;

use App\Models\Mpesa\Mpesa;
use App\Models\Query\PayShipmentQuery;
use App\Models\Query\SharedQuery;

class PayShipmentController extends SharedQuery
{
    public function show()
    {
        $studentInfo = self::CollectStudentData();
        $destinations = PayShipmentQuery::CollectAvailableDestinations();

        if (isset($_POST['destination'])) {
            $this->handleLocationSelection();
            $destinationInfo = self::CollectAvailableDestinationsData($_SESSION['shipment location']) ?? null;
        }

        $location = $_SESSION['shipment location'] ?? null;

        $actionStatus = null;

        if (isset($_POST['payShipment'])) {

            $actionStatus = $this->processPayment($studentInfo);

            $_SESSION['popup_message'] = "Check your phone to complete the payment.";

            header("Location: " . $_SERVER['REQUEST_URI']);
            exit();
        }

        require_once ROOT . "/resources/views/payShipment.php";
    }

    private function handleLocationSelection()
    {
        $location = filter_input(INPUT_POST, 'location', FILTER_SANITIZE_SPECIAL_CHARS);
        if ($location) {
            $_SESSION['shipment location'] = $location;
        }
    }

    /**
     * Logic for processing the payment payload
     * Separation of concerns: This method only cares about payment preparation.
     */
    private function processPayment(array $studentInfo)
    {
        $location = $_SESSION['shipment location'] ?? null;

        if (!$location) {
            return "Please select a destination first.";
        }

        $destinationInfo = self::CollectAvailableDestinationsData($location);

        $payload = [
            "name"             => $studentInfo['username'],
            "admission"        => $studentInfo['admission number'],
            "phone"            => filter_input(INPUT_POST, 'phone', FILTER_SANITIZE_NUMBER_INT),
            "shipmentLocation" => $destinationInfo['location'],
            "courier"          => $destinationInfo['courrier'],
            "collectionPoint"  => $destinationInfo['pic up location'],
            "shipmentCost"     => $destinationInfo['price'],
        ];

        $_SESSION['shipment payload'] = $payload;

        // Integration point for M-Pesa STK Push
        $mpesa = (new Mpesa())
            ->stkPush($payload['phone'], $payload['shipmentCost']);

        return "Check your phone to complete the payment.";
    }
}
