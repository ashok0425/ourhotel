<?php

use App\Http\Controllers\Admin\AmenityController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Common\BookingController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Common\PropertyController;
use App\Http\Controllers\Admin\PropertyTypeController;
use App\Http\Controllers\Common\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WebsiteController;

Route::prefix('admin')->name('admin.')->group(function(){
    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('propertyTypes', PropertyTypeController::class);
    Route::resource('amenities', AmenityController::class);
    Route::resource('properties', PropertyController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('bookings', BookingController::class)->only(['index','show','update','edit']);
    Route::resource('users', UserController::class);
    Route::resource('coupons', CouponController::class);

    Route::resource('websites', WebsiteController::class)->only('edit','update');
    Route::resource('banners', BannerController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('categories', CategoryController::class);




});
