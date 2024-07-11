<?php

use App\Models\Amenity;
use App\Models\City;
use App\Models\Property;
use App\Models\Room;
use App\Models\Tax;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

function getImageUrl($image_file, $static = false)
{
    if ($static) {
        return asset($image_file);
    }

    if ($image_file) {
        // if (config()['app']['env']=='local') {
        //     return asset('uploads/'.$image_file);
        // }
        return config('services.s3.url') . 'uploads/' . $image_file;
    }
    return "https://via.placeholder.com/300x300?text=NSN";
}

function filepath($image_file)
{
    // dd();
    // if (config()['app']['env']=='local') {
    //     return asset($image_file);
    // }

    return config('services.s3.url') . $image_file;
}

function getUserAvatar($image_file)
{
    if ($image_file) {
        return "/uploads/{$image_file}";
    }
    return "/assets/images/default_avatar.svg";
}


if (!function_exists('setting')) {
    function setting($key)
    {

        $cache = Cache::remember("setting",6048000000, function () use ($key) {
            return \App\Models\Website::first();
        });

        return $cache->$key;
    }
}


if (!function_exists('coupons')) {
    function coupons()
    {

        $coupons = Cache::remember("coupons", 6048000000,function ()  {
            return \App\Models\Coupon::where('thumbnail','!=',null)->get();
        });

        return $coupons;
    }
}



if (!function_exists('popular_cities')) {
    function popular_cities()
    {
      return  Cache::remember('popular_cities', 6048000000,function () {
            return City::query()
            ->whereIn('id', [57,151,154,125,39,95,124,123,139,144,104,34])
            ->orderBy('slug','asc')
            ->select('name','id','slug','thumbnail as thumb')
            ->get();
        });
    }
}


if (!function_exists('amentities')) {
    function amentities()
    {
      return  Cache::remember('amentities', 6048000000,function () {
            return Amenity::select('id','thumbnail')
            ->get();
        });
    }
}


if (!function_exists('taxes')) {
    function taxes()
    {
      return  Cache::remember('taxes',6048000000, function () {
            return Tax::all();
        });
    }
}





if (!function_exists('testimonials')) {
    function testimonials()
    {
      return  Cache::remember('testimonials',6048000000,function(){
        return Testimonial::query()
        ->where('status', 1)
        ->where('property_id', null)
        ->where('feedback','!=', null)
        ->limit(6)
        ->get();
    });

}
}



if (!function_exists('getFinalPrice')) {
    function getFinalPrice(Request $request)
    {

        $no_of_room = $request->no_of_room ?? 1;
        $no_of_adult = $request->no_of_adult ?? 1;
        $days = $request->days ?? 1;
        $room_id = $request->room_id;
        $hourly = $request->is_hourly ?? 0;
        $coupon = $request->coupon;

        $prices = getPrice($no_of_adult, $no_of_room, $room_id, $hourly, $days);
        $actualprice=$prices['actualprice'];
        $room_discount_percent=$prices['room_discount_percent'];


        $tax_percent = taxes()->where('price_min', '<=', $actualprice)->where('price_max', '>=', $actualprice)->first()->percentage;

        $tax = ($actualprice * $tax_percent) / 100;

        $discount = 0;
        if ($coupon != null) {
            $discount_percent = coupons()->where('coupon_name', $coupon)->first()->coupon_percent ?? 0;
            $discount = (int)$discount_percent * (int)$actualprice / 100;
        }

        $price_discount=$room_discount_percent??5;
        if ($price_discount) {
           $price_before_discount=(int) number_format($price_discount * (int)$actualprice / 100, 0);
        }
        $data = [
            'subtotal' => (int) $actualprice,
            'tax' => (int) $tax,
            'discount' => (int) $discount,
            'total' => (int) $actualprice + $tax - $discount,
            'mrp'=>(int) $actualprice+$price_before_discount
        ];

        return $data;

}
}


if (!function_exists('getPrice')) {
     function getPrice($number_of_adult=1, $number_of_room=1, $room_id,$ishourly=0,$days=1)
    {
        $room = Room::find($room_id);
        $oneprice = $room->onepersonprice;
        $twoprice = $room->twopersonprice ? $room->twopersonprice : $oneprice;
        $diffinprice = $room->threepersonprice ? $room->threepersonprice - $twoprice : $twoprice - $oneprice;
        $threeprice = $room->threepersonprice ? $room->threepersonprice : $twoprice + $diffinprice;

        if ($ishourly==1) {
            $final_adult_price=($room->hourlyprice==null||$room->hourlyprice==0||$room->hourlyprice==''?$room->oneprice:$room->hourlyprice) * $number_of_room;
        }else{
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
                    $final_adult_price = (2 * $threeprice) + (2 * $twoprice);
                } else {
                    $final_adult_price = $number_of_room * $twoprice;
                }

                break;
            case 11:
                $final_adult_price = (2 * $threeprice) + $twoprice;

                if ($number_of_room == 4) {
                    $final_adult_price = (2 * $threeprice) + (2 * $twoprice) + $diffinprice;
                } else {
                    $final_adult_price = $number_of_room * $twoprice;
                }

                break;
            case 12:
                if ($number_of_room == 4) {
                    $final_adult_price = 4 * $threeprice;
                } else {
                    $final_adult_price = (3 * $threeprice) +  $twoprice + $diffinprice;
                }
                break;
            case 13:
                if ($number_of_room == 4) {
                    $final_adult_price = (4 * $threeprice) + $diffinprice;
                } else {
                    $final_adult_price = (3 * $threeprice) + (2 * $twoprice);
                }
                break;
            case 14:
                if ($number_of_room == 4) {
                    $final_adult_price = (3 * $threeprice) + (2 * $twoprice) + $diffinprice;
                } else {
                    $final_adult_price = (3 * $threeprice) + (3 * $twoprice);
                }
                break;
            case 15:
                $final_adult_price = 5 * $threeprice;
                break;

            default:
                $final_adult_price = $number_of_room * $oneprice;

                break;
        }
    }

        return [
           'actualprice' =>$final_adult_price*$days,
           'room_discount_percent'=>$room->discount_percent
        ];
    }
}
