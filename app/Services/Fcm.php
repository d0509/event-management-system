<?php

namespace App\Services;

class Fcm
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = config('fcm.api_key');
    }

    public function sendBroadcastNotification($title, $body)
    {
        $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

        $headers = [
            'Authorization' => "key={$this->apiKey}",
            'Content-Type' => 'application/json',
        ];

        // dd('hi');

        $payload = [
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'to' => '/topics/all',
        ];

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $fcmUrl,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_RETURNTRANSFER => true,
        ]);

        $response = curl_exec($curl);

        curl_close($curl);

        return $response;
    }
}
