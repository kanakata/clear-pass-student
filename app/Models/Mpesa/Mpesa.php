<?php

namespace App\Models\Mpesa;

class Mpesa
{

    private function accessToken()
    {
        // 1. Validate environment variables
        $consumerKey = $_ENV['CONSUMER_KEY'] ?? null;
        $consumerSecret = $_ENV['CONSUMER_SECRET'] ?? null;
        $url = $_ENV['AUTH_URL'] ?? null;

        if (!$consumerKey || !$consumerSecret || !$url) {
            error_log("M-Pesa Error: Missing Consumer Key, Secret, or Auth URL in .env");
            return false;
        }

        // 2. Prepare the Basic Auth credentials
        $credentials = base64_encode(trim($consumerKey) . ':' . trim($consumerSecret));

        // 3. Initialize cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Basic ' . $credentials,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Ensure SSL is handled correctly (standard for Daraja)
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        echo $curlError = curl_error($ch);

        // 4. Handle Errors
        if ($curlError) {
            error_log("M-Pesa cURL Error: " . $curlError);
            return false;
        }

        $result = json_decode($response, true);

        print_r($result);

        // 5. Check if the token exists in the response
        if ($httpCode === 200 && isset($result['access_token'])) {
            echo "hello";
            return $result['access_token'] ?? "clear-pass";
        }

        error_log("M-Pesa Auth Failed (HTTP $httpCode): " . ($result['errorMessage'] ?? 'Unknown Error'));
        return false;
    }

    public function stkPush($phone, $amount)
    {
        // 1. Get Access Token
        echo $token = $this->accessToken() . PHP_EOL;

        if ($token === "clear-pass") {
             echo $error = 'Could not generate access token';
         }

        // 2. Prepare Variables from .env
        $shortCode = trim($_ENV['SHORTCODE']);
        $passkey   = trim($_ENV['PASSKEY']);
        $timestamp = date('YmdHis');

        // The password must be base64 encoded: Shortcode + Passkey + Timestamp
        $password = base64_encode($shortCode . $passkey . $timestamp);

        // 3. Format Phone Number (Ensuring 254... format)
        $phone = (string)$phone;
        $phone = str_replace(['+', ' '], '', $phone);
        if (str_starts_with($phone, '0')) {
            $phone = '254' . substr($phone, 1);
        } elseif (str_starts_with($phone, '7') || str_starts_with($phone, '1')) {
            $phone = '254' . $phone;
        }

        // 4. Build the Payload
        $payload = [
            "BusinessShortCode" => trim($shortCode),
            "Password"          => $password,
            "Timestamp"         => $timestamp,
            "TransactionType"   => "CustomerPayBillOnline",
            "Amount"            => round($amount),
            "PartyA"            => trim($phone),
            "PartyB"            => trim($shortCode),
            //"PhoneNumber"       => trim($phone),
            "CallBackURL"       => trim($_ENV['CALLBACK_URL']),
            "AccountReference"  => substr(str_replace(' ', '', 'ClearPass_System'), 0, 12),
            "TransactionDesc"   => substr('Student Clearance Fees', 0, 20)
        ];

        // 5. Execute cURL Request
        $url = $_ENV['STKPUSH_URL'];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Bearer ' . $token
        ]);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        //curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        // Recommended: disable SSL verification ONLY for local development if needed
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($ch);
        print_r($response);
        $error = curl_error($ch);

        if ($error) {
            return ['error' => 'cURL Error: ' . $error];
        }

        return json_decode($response, true);
    }
    public function callback()
    {
        // 1. Capture the raw input
        $stkcallbackResponse = file_get_contents('php://input');
        $logFile = ROOT . "/logs/mpesa-logs/file.log";
        file_put_contents($logFile, $stkcallbackResponse . PHP_EOL, FILE_APPEND);

        $data = json_decode($stkcallbackResponse);

        // Check if decoding worked and if the path exists
        if (!$data || !isset($data->Body->stkCallback)) {
            return;
        }

        $stkCallback = $data->Body->stkCallback;
        $resultCode = $stkCallback->ResultCode;
        $checkoutRequestID = $stkCallback->CheckoutRequestID;

        if ($resultCode == 0) {
            $items = $stkCallback->CallbackMetadata->Item;
            $amount = 0;
            $receipt = "";
            $phone = "";

            foreach ($items as $item) {
                switch ($item->Name) {
                    case "Amount":
                        $amount = $item->Value;
                        break;
                    case "MpesaReceiptNumber":
                        $receipt = $item->Value;
                        break;
                    case "PhoneNumber":
                        $phone = $item->Value;
                        break;
                }
            }

            // TODO: Database update logic here
            // Tip: Use $checkoutRequestID to find which student initiated the payment
        }

        // Single source of truth for the response
        header("Content-Type: application/json");
        echo json_encode(["ResultCode" => 0, "ResultDesc" => "Accepted"]);
    }
}
