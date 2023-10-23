<?php

namespace App\Firebase;

use Firebase\JWT\JWT;

class Fcm
{
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function sendNotification($deviceTokens, $notification)
    {
        $headers = [
            'Authorization: Bearer ' . $this->apiKey,
            'Content-Type: application/json',
        ];

        $body = [
            'registration_ids' => $deviceTokens,
            'notification' => $notification,
        ];

        $curl = curl_init('https://fcm.googleapis.com/fcm/send');
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($body));

        $response = curl_exec($curl);

        curl_close($curl);

        return json_decode($response);
    }
}
