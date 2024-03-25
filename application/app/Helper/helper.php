<?php

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

function getImageUrl($image_file,$static=false)
{
    if ($static) {
        return asset($image_file);
    }

    if ($image_file) {
        // if (config()['app']['env']=='local') {
        //     return asset('uploads/'.$image_file);
        // }
        return config('services.s3.url').'uploads/'.$image_file;
    }
    return "https://via.placeholder.com/300x300?text=NSN";
}

function filepath($image_file)
{
    // dd();
    // if (config()['app']['env']=='local') {
    //     return asset($image_file);
    // }

    return config('services.s3.url').$image_file;


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

            $cache = Cache::remember("setting_" . $key, 60, function () use ($key) {
                return \App\Models\Website::first();
            });

            return $cache->$key;
    }
}
