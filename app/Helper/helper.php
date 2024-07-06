<?php

use App\Models\Amenity;
use App\Models\City;
use App\Models\Testimonial;
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

        $cache = Cache::remember("setting", 86400, function () use ($key) {
            return \App\Models\Website::first();
        });

        return $cache->$key;
    }
}



if (!function_exists('coupons')) {
    function coupons()
    {

        $coupons = Cache::remember("coupons", 86400, function ()  {
            return \App\Models\Coupon::where('thumbnail','!=',null)->get();
        });

        return $coupons;
    }
}



if (!function_exists('popular_cities')) {
    function popular_cities()
    {
      return  Cache::remember('popular_cities',604800, function () {
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
      return  Cache::remember('amentities',604800, function () {
            return Amenity::select('id','thumbnail')
            ->get();
        });
    }
}



if (!function_exists('testimonials')) {
    function testimonials()
    {
      return  Cache::remember('testimonials',604800,function(){
        return Testimonial::query()
        ->where('status', 1)
        ->where('property_id', null)
        ->where('feedback','!=', null)
        ->limit(6)
        ->get();
    });

}
}

