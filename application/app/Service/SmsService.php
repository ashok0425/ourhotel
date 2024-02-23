<?php

namespace App\Service;

use Illuminate\Support\Carbon;

class SmsService{

public function sendBookingMsg($phone,$hotel_name,$start_date,$end_date,$number_of_night,$numberofadult,$numberofchild,$booking_amount,$booking_payment_type,$number_of_rooms=1,$booking_id) {
    //Multiple mobiles numbers separated by comma
    $number_of_room = $number_of_rooms ;

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://api.msg91.com/api/v5/flow/",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_POSTFIELDS => "{\n  \"flow_id\": \"611fe916d25e4d68da3d14fc\",\n \"mobiles\": \"".$phone."\",\n  \"Booking ID\": \"".$booking_id."\",\n \"Hotel Name\": \"".$hotel_name."\",\n \"Check-in Date\": \"".$start_date."\",\n  \"Check-out Date\": \"".$end_date."\",\n \"Number of Rooms\": \"".$number_of_room."\",\n  \"Number of Nights\": \"".$number_of_night."\",\n \"Number of Adults\": \"".$numberofadult."\",\n \"Number of Child\": \"".$numberofchild."\",\n  \"Booking Amount\": \"".$booking_amount."\",\n \"Payment Mode\": \"".$booking_payment_type."\"\n \n}",
      CURLOPT_HTTPHEADER => array(
        "authkey: ".config('services.msg99.api_key'),
        "content-type: application/JSON"
      ),
    ));

    $response = curl_exec($curl);

    $err = curl_error($curl);

    curl_close($curl);
    if ($err) {

        "cURL Error #:" . $err;
    } else {

      return $response;

    }
}


}
