<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $casts=[
    'gallery'=>"array",
    'amenities'=>'array'
];

   public function owner(){
        return $this->belongsTo(User::class,'owner_id','id');
    }



    public function city(){
        return $this->belongsTo(City::class);
    }

    public function roomsData(){
        return $this->hasMany(Room::class);
    }


    public function ratings(){
        return $this->hasMany(Testimonial::class);
    }



    static function getPrice($number_of_adult,$number_of_room,$room_id){
        $room=Room::find($room_id);
        $oneprice = $room->onepersonprice;
        $twoprice = $room->twopersonprice?$room->twopersonprice:$oneprice;
        $diffinprice = $room->threepersonprice?$room->threepersonprice-$twoprice:$twoprice-$oneprice;
      $threeprice=$room->threepersonprice?$room->threepersonprice:$twoprice+$diffinprice;

        switch ($number_of_adult) {
            case 1:
                $final_adult_price = $number_of_room * $oneprice;
                break;
            case 2:

                if ($number_of_room == 1) {
                    $final_adult_price = $twoprice;
                } else {
                    $final_adult_price = 2 * $oneprice;
                }

                break;
            case 3:

                if ($number_of_room == 1) {
                    $final_adult_price = $threeprice;
                }
                if ($number_of_room == 2) {
                    $final_adult_price = 2 * $twoprice;
                } else {
                    $final_adult_price = $number_of_room * $oneprice;
                }
                break;

            case 4:
                $final_adult_price = $number_of_room * $twoprice;
                break;

            case 5:
                if ($number_of_room == 2) {
                    $final_adult_price = (2 * $twoprice) + $diffinprice;
                } else {
                    $final_adult_price = $number_of_room * $twoprice;
                }
                break;

            case 6:
                $final_adult_price = $number_of_room * $threeprice;
                break;
            case 7:

                if ($number_of_room == 3) {
                    $final_adult_price = (3 * $twoprice) + $diffinprice;

                } else {
                    $final_adult_price = $number_of_room * $twoprice;
                }

                break;
            case 8:

                if ($number_of_room == 3) {
                    $final_adult_price = (3 * $twoprice) + $twoprice;
                } else {
                    $final_adult_price = $number_of_room * $twoprice;
                }
                break;
            case 9:

                if ($number_of_room == 3) {
                    $final_adult_price = 3 * $threeprice;

                } else {
                    $final_adult_price = $number_of_room * $twoprice;
                }
                break;
            case 10:

                if ($number_of_room == 4) {
                    $final_adult_price = (2 * $threeprice)+ (2 * $twoprice);

                } else {
                    $final_adult_price = $number_of_room * $twoprice;
                }

                break;
            case 11:
                $final_adult_price = (2 * $threeprice) + $twoprice;

                if ($number_of_room == 4) {
                    $final_adult_price = (2 * $threeprice)+ (2 * $twoprice)+$diffinprice;

                } else {
                    $final_adult_price = $number_of_room * $twoprice;
                }

                break;
            case 12:
                if ($number_of_room == 4) {
                    $final_adult_price = 4 * $threeprice;

                } else {
                    $final_adult_price = (3 * $threeprice)+  $twoprice+$diffinprice;
                }
                break;
            case 13:
            if ($number_of_room == 4) {
                    $final_adult_price =( 4 * $threeprice)+$diffinprice;

                } else {
                    $final_adult_price = (3 * $threeprice)+ (2 * $twoprice);
                }
                break;
            case 14:
            if ($number_of_room == 4) {
                    $final_adult_price =( 3* $threeprice)+(2*$twoprice)+$diffinprice;

                } else {
                    $final_adult_price = (3 * $threeprice)+ (3 * $twoprice);
                }
                break;
            case 15:
                $final_adult_price = 5 * $threeprice;
                break;

            default:
                $final_adult_price =$number_of_room * $oneprice;

                break;
        }

        return $final_adult_price;
    }


}
