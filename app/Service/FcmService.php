<?php
namespace App\Service;

class FcmService{


    public function send($title,$body,$token){
        $url = 'https://fcm.googleapis.com/fcm/send';
        $serverKey = 'AAAA_8sthsQ:APA91bFJgz0LpCz8mEqpwoFeWTL1OBwTIjJVxwflq_8gnxDnNV24HFwA6EOawv-TOyCcFnNtj-CnxmYMbKkNpPIsn9pGVfLDYw0h2LI3JFJTTKdBXkD1hWylIE6kPnU9VsuBCuLHE4hf';

        $data = [
            "registration_ids" =>$token,
            "notification" => [
                "title" => $title,
                "body" =>  $body
            ]
        ];
        $encodedData = json_encode($data);

        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);

        // Close connection
        curl_close($ch);


    }

}
