<?php

use App\Http\Controllers\Admin\AmenityController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Common\BookingController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\EnquiryController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\FcmNotificationController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Common\PropertyController;
use App\Http\Controllers\Admin\PropertyTypeController;
use App\Http\Controllers\Admin\ReferPriceController;
use App\Http\Controllers\Admin\SeoController;
use App\Http\Controllers\Common\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\TourBookingController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\WebsiteController;
use App\Models\TourBooking;

Route::middleware('guest')->prefix('admin')->name('admin.')->group(function(){
Route::view('/login','admin.login');
Route::post('/login',[AuthController::class,'login']);
});
Route::get('admin/logout',[AuthController::class,'logout']);



Route::middleware('isadmin')->prefix('admin')->name('admin.')->group(function(){
    Route::resource('states', StateController::class);
    Route::resource('cities', CityController::class);
    Route::resource('locations', LocationController::class);
    Route::resource('propertyTypes', PropertyTypeController::class);
    Route::resource('amenities', AmenityController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('websites', WebsiteController::class)->only('edit','update');
    Route::resource('banners', BannerController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('categories', CategoryController::class);
    Route::patch('user/status',[UserController::class,'status'])->name('users.status');
    Route::resource('users', UserController::class);
    Route::resource('coupons', CouponController::class);
    Route::resource('refer_prices', ReferPriceController::class);
    Route::resource('fcms', FcmNotificationController::class);
    Route::resource('enquries', EnquiryController::class);
    Route::get('refer_moneys', [ReferPriceController::class,'referMoney'])->name('refer_moneys');
});

Route::resource('seos', SeoController::class);


Route::middleware(['ispartner','isactive'])->group(function(){
    Route::get('dashboard',[AuthController::class,'dashboard'])->name('dashboard');
    Route::patch('property/status', [PropertyController::class,'status'])->name('property.status');
    Route::resource('properties', PropertyController::class);
    Route::resource('rooms', RoomController::class);
    Route::resource('bookings', BookingController::class)->only(['index','show','update','edit']);
    Route::post('bookings/status', [BookingController::class,'update'])->name('bookings.status');
    Route::get('bookings/{id}/download', [BookingController::class,'download'])->name('bookings.download');

 Route::middleware(['isagent'])->group(function(){
    Route::get('booking/create/{property_id?}', [BookingController::class,'create'])->name('booking.create');
    Route::post('booking/create/{property_id?}', [BookingController::class,'store'])->name('booking.store');
    Route::resource('tour_bookings', TourBookingController::class);
    Route::get('tour_bookings/{id}/download', [TourBookingController::class,'download'])->name('tour_bookings.download');
    Route::post('tour_bookings/status', [TourBookingController::class,'update'])->name('tour_bookings.status');
});

});
