<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Common\PropertyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\WebHookController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\HotelReviewController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\RazorpayController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application.
| These routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/upload-image',[ImageController::class,'upload']);
Route::get('/delete-image',[ImageController::class,'delete']);
Route::get('/getCity/{stateId}',[PropertyController::class,'getCity'])->name('getcities');


Route::post('/fcm-token', [HomeController::class, 'updateToken'])->name('fcmToken');

Route::get('/banquet', [HomeController::class, 'banquote'])->name('banquet');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('loadcontent/{contentId}', [HomeController::class, 'loadContent']);
Route::get('load-mobile-content/', [HomeController::class, 'mobileLocation']);

Route::get('load-subcity', [HomeController::class, 'subCity']);

Route::get('/blog/all', [PostController::class, 'list'])->name('post_list_all');
Route::get('/blog/{cat_slug}', [PostController::class, 'list'])->where('cat_slug', '[a-zA-Z0-9-_]+')->name('post_list');
Route::get('/post/{slug}-{id}', [PostController::class, 'detail'])
    ->where('slug', '[a-zA-Z0-9-_]+')
    ->where('id', '[0-9]+')->name('post_detail');

Route::get('/page/contact', [HomeController::class, 'pageContact'])->name('page_contact');
Route::get('/refer', [HomeController::class, 'refer'])->name('refer');
Route::get('corporate', [HomeController::class, 'corporate'])->name('corporate');
Route::post('corporate', [HomeController::class, 'corporateStore']);

Route::post('/page/contact', [HomeController::class, 'sendContact'])->name('page_contact_send');
Route::get('/page/landing/{page_number}', [HomeController::class, 'pageLanding'])->name('page_landing');

Route::get('/hotels/{slug}/{id?}', [PlaceController::class, 'detail'])->name('place_detail');
Route::get('/become-a-partner', [PlaceController::class, 'pageAddNew'])->name('become_a_partner');
Route::get('/edit-place/{id}', [PlaceController::class, 'pageAddNew'])->name('place_edit')->middleware('auth');

Route::get('/near-by-hotels', [PlaceController::class, 'nearByHotels'])->name('near_by_hotels');

Route::post('/place', [PlaceController::class, 'create'])->name('place_create');
Route::put('/place', [PlaceController::class, 'update'])->name('place_update')->middleware('auth');
Route::get('/places/filter', [PlaceController::class, 'getListFilter'])->name('place_get_list_filter');

Route::group(['middleware'=>'auth','prefix'=>'user'], function () {

    Route::get('/profile', [UserController::class, 'pageProfile'])->name('user_profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('user_profile_update');
    Route::put('/profile/password', [AuthController::class, 'updatePassword'])->name('user_password_update');
    Route::get('/reset-password', [AuthController::class, 'pageResetPassword'])->name('user_reset_password');
    Route::put('/reset-password', [ResetPasswordController::class, 'reset'])->name('user_update_password');
    Route::get('/bookings', [BookingController::class, 'index'])->name('user_my_place');
    Route::get('reviews', [ReviewController::class, 'index'])->name('user_my_review');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('user_my_reviews_store');
    Route::get('/wallets', [UserController::class, 'wallet'])->name('user_my_wallet');
    Route::post('/refer-mail', [UserController::class, 'referMail'])->name('user_refer_mail');
    Route::post('bookings/cancel', [BookingController::class, 'cancelBooking'])->name('cancel_booking');
});


Route::group(['middleware'=>'guest','prefix'=>'user'], function () {

Route::get('/login', [AuthController::class, 'loginPage'])->name('user_login');
Route::post('/login', [AuthController::class, 'loginPage'])->name('login');

Route::get('/register', [AuthController::class, 'registerPage'])->name('user_register');
Route::post('/register', [AuthController::class, 'registerStore'])->name('user_register');
Route::post('loginWithOtp', [AuthController::class, 'loginWithOtp'])->name('loginWithOtp');
Route::post('sendOtp', [AuthController::class, 'sendOtp'])->name('send_otp');
});

Route::get('/thanku/{uuid}', [CheckoutController::class, 'thanku'])->name('thanku');
Route::post('/bookings', [BookingController::class, 'booking'])->name('booking_submit');
Route::get('booking-detail/{uuid?}', [BookingController::class, 'recipt'])->name('recipt');



Route::get('/auth/{social}', [SocialAuthController::class, 'redirect'])->name('login_social');
Route::get('/auth/{social}/callback', [SocialAuthController::class, 'callback'])->name('login_social_callback');

Route::get('/ajax-search', [HomeController::class, 'ajaxSearch']);
Route::get('/ajax-search-listing', [HomeController::class, 'searchListing']);
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/places/map', [PlaceController::class, 'getListMap'])->name('place_get_list_map');

Route::get('/location-search', [HomeController::class, 'locationSearch'])->name('location_search');
Route::get('/hotel/best-hotel-in-{city_name?}-near-{location?}', [HomeController::class, 'pageSearchListing'])->name('location.search');
Route::get('/search-listing', [HomeController::class, 'pageSearchListing'])->name('page_search_listing');
Route::get('/hotel/best-hotel-in-{slug}', [HomeController::class, 'pageSearchListing'])->name('city-search');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('book.now');
Route::post('/checkout', [CheckoutController::class, 'store'])->name('payment.checkout');
Route::post('rozer/payment/pay-success/{booking_id}', [RazorpayController::class, 'payment'])->name('payment.rozer');
Route::post('coupon/apply', [CheckoutController::class, 'applyCoupon'])->name('coupon.apply');
Route::get('coupon/remove', [CheckoutController::class, 'removeCoupon'])->name('coupon.remove');
Route::get('apply-offer', [CheckoutController::class, 'applyoffer']);
Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('subscribe');
