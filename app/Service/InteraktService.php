<?php
namespace App\Service;

class InteraktService{


    public function sendOtp($phone,$otp){

        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.interakt.ai/v1/public/message/',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "fullPhoneNumber": "'.$phone.'",
            "type": "Template",
            "template": {
                "name": "otp",
                "languageCode": "en",
                "bodyValues": [
                    "'.$otp.'"

                ]
            }
        }',
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ".config('services.interakt.api_key')."",
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    return $response;
    }

    public function sendBookingMsg($phone,$name,$id,$data){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.interakt.ai/v1/public/message/',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "fullPhoneNumber": "'.$phone.'",
            "type": "Template",
            "template": {
                "name": "hotel_booking",
                "languageCode": "en_US",
                "bodyValues": [
                    "'.$name.'",
                    "'.$id.'",
                    "'.$data.'"

                ]
            }
        }',
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ".config('services.interakt.api_key')."",
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    return $response;
    }


    public function sendBookingCanelMsg($phone,$name,$bookingId){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.interakt.ai/v1/public/message/',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "fullPhoneNumber": "'.$phone.'",
            "type": "Template",
            "template": {
                "name": "cancellation",
                "languageCode": "en",
                "bodyValues": [
                    "'.$name.'",
                    "'.$bookingId.'"

                ]
            }
        }',
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ".config('services.interakt.api_key')."",
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    return $response;
    }

 public function sendReviewMsg($phone,$name){
        $curl = curl_init();

        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.interakt.ai/v1/public/message/',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "fullPhoneNumber": "'.$phone.'",
            "type": "Template",
            "template": {
                "name": "review",
                "languageCode": "en",
                "bodyValues": [
                    "'.$name.'"
                ]
            }
        }',
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ".config('services.interakt.api_key')."",
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    return $response;
    }



    public function whatsapp_checkin($phone,$name){
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://api.interakt.ai/v1/public/message/',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "fullPhoneNumber": "'.$phone.'",
            "type": "Template",
            "template": {
                "name": "checkin",
                "languageCode": "en",
                "bodyValues": [
                    "'.$name.'"
                ]
            }
        }',
          CURLOPT_HTTPHEADER => array(
            "Authorization: Basic ".config('services.interakt.api_key')."",
            'Content-Type: application/json'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
    return $response;

    }

}
