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

        // $coupons = Cache::remember("coupons", 6048000000,function ()  {
            $coupons= \App\Models\Coupon::where('thumbnail','!=',null)->get();
        // });

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

        $price_discount=$room_discount_percent??20;

           $price_before_discount=(int) $price_discount * ((int)$actualprice / 100);

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
    function getPrice($number_of_adult = 1, $number_of_room = 1, $room_id, $ishourly = 0, $days = 1)
{
    $room = Room::find($room_id);

    // Define base prices
    $oneprice = $room->onepersonprice;
    $twoprice = $room->twopersonprice ?: $oneprice;
    $threeprice = $room->threepersonprice ?: $twoprice + ($twoprice - $oneprice);

    // Hourly pricing
    if ($ishourly) {
        $final_adult_price = ($room->hourlyprice ?: $oneprice) * $number_of_room;
    } else {
        // Calculate base price depending on the number of adults
        if ($number_of_adult == 1) {
            $base_price = $oneprice;
        } elseif ($number_of_adult == 2) {
            $base_price = $twoprice;
        } else {
            $base_price = $threeprice + ($number_of_adult - 3) * $oneprice / 3;
        }

        // Calculate final price based on the number of rooms
        $final_adult_price = $base_price * $number_of_room;
    }

    return [
        'actualprice' => $final_adult_price * $days,
        'room_discount_percent' => $room->discount_percent
    ];
}
}
