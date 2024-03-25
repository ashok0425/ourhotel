<?php

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

Route::get('/mapapi', [HomeController::class, 'mapapi']);

Route::get('/webhooks', [WebHookController::class, 'webhook']);
Route::post('/webhooks', [WebHookController::class, 'webhookPost']);

Route::get('/banquet', [HomeController::class, 'banquote'])->name('banquet');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('loadcontent/{contentId}', [HomeController::class, 'loadContent']);
Route::get('load-mobile-content/', [HomeController::class, 'mobileLocation']);

Route::get('load-subcity', [HomeController::class, 'subCity']);

Route::get('/sitemapCity.xml', [SitemapController::class, 'sitemapCity']);
Route::get('/sitemapBlog.xml', [SitemapController::class, 'sitemapBlog']);
Route::get('/sitemapHotel.xml/{slug}', [SitemapController::class, 'sitemapHotel']);
Route::get('/sitemapindex.xml', [SitemapController::class, 'index']);
Route::get('/blog/all', [PostController::class, 'list'])->name('post_list_all');
Route::get('/blog/{cat_slug}', [PostController::class, 'list'])->where('cat_slug', '[a-zA-Z0-9-_]+')->name('post_list');
Route::get('/post/{slug}-{id}', [PostController::class, 'detail'])
    ->where('slug', '[a-zA-Z0-9-_]+')
    ->where('id', '[0-9]+')->name('post_detail');

Route::get('/page/contact', [HomeController::class, 'pageContact'])->name('page_contact');
Route::get('/refer', [HomeController::class, 'refer'])->name('refer');
Route::any('corporate', [HomeController::class, 'corporate'])->name('corporate');
Route::post('/page/contact', [HomeController::class, 'sendContact'])->name('page_contact_send');

Route::get('/page/landing/{page_number}', [HomeController::class, 'pageLanding'])->name('page_landing');

Route::get('/city/{slug}', [CityController::class, 'detail'])->name('city_detail');
Route::get('/city/{slug}/{cat_slug}', [CityController::class, 'detail'])->name('city_category_detail');

Route::get('/hotels/{slug}/{id?}', [PlaceController::class, 'detail'])->name('place_detail');
Route::get('/become-a-partner', [PlaceController::class, 'pageAddNew'])->name('become_a_partner');
Route::get('/edit-place/{id}', [PlaceController::class, 'pageAddNew'])->name('place_edit')->middleware('auth');

Route::get('/near-by-hotels', [PlaceController::class, 'nearByHotels'])->name('near_by_hotels');

Route::post('/place', [PlaceController::class, 'create'])->name('place_create');
Route::put('/place', [PlaceController::class, 'update'])->name('place_update')->middleware('auth');
Route::get('/places/filter', [PlaceController::class, 'getListFilter'])->name('place_get_list_filter');

Route::post('/review', [ReviewController::class, 'create'])->name('review_create')->middleware('auth');
Route::post('/create-rating', [ReviewController::class, 'createRating'])->name('create_rating');
Route::post('/wishlist', [UserController::class, 'addWishlist'])->name('add_wishlist')->middleware('auth');
Route::delete('/wishlist', [UserController::class, 'removeWishlist'])->name('remove_wishlist')->middleware('auth');

Route::get('/user/profile', [UserController::class, 'pageProfile'])->name('user_profile')->middleware('auth');
Route::put('/user/profile', [UserController::class, 'updateProfile'])->name('user_profile_update')->middleware('auth');
Route::put('/user/profile/password', [UserController::class, 'updatePassword'])->name('user_password_update')->middleware('auth');
Route::get('/user/reset-password', [UserController::class, 'pageResetPassword'])->name('user_reset_password');
Route::put('/user/reset-password', [ResetPasswordController::class, 'reset'])->name('user_update_password');
Route::get('/user/my-place', [UserController::class, 'pageMyPlace'])->name('user_my_place')->middleware('auth');
Route::get('/user/my-wallet', [UserController::class, 'pageMyWallet'])->name('user_my_wallet')->middleware('auth');

Route::any('/user/thanku', [UserController::class, 'thanku'])->name('thanku')->middleware('auth');

Route::get('/user/wishlist', [UserController::class, 'pageWishList'])->name('user_wishlist')->middleware('auth');


Route::get('/book-now', [BookingController::class, 'bookingPage'])->name('book.now');
Route::post('/bookings', [BookingController::class, 'booking'])->name('booking_submit');
Route::get('/cancel-booking/{id}', [BookingController::class, 'cancelBooking'])->name('cancel_booking');
Route::get('/load-booking-detail/{id}', [BookingController::class, 'loadDetail']);
Route::get('recipt/{id}', [BookingController::class, 'recipt'])->name('recipt');



Route::get('/auth/{social}', [SocialAuthController::class, 'redirect'])->name('login_social');
Route::get('/auth/{social}/callback', [SocialAuthController::class, 'callback'])->name('login_social_callback');

Route::get('/ajax-search', [HomeController::class, 'ajaxSearch']);
Route::get('/ajax-search-listing', [HomeController::class, 'searchListing']);
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/places/map', [PlaceController::class, 'getListMap'])->name('place_get_list_map');

Route::get('/cities/{country_id}', [CityController::class, 'getListByCountry'])->name('city_get_list');
Route::get('/cities', [CityController::class, 'search'])->name('city_search');
Route::get('/location-search', [HomeController::class, 'locationSearch'])->name('location_search');

Route::get('/hotel/best-hotel-in-{city_name?}-near-{location?}', [HomeController::class, 'pageSearchListing'])->name('location.search');

Route::get('/search-listing', [HomeController::class, 'pageSearchListing'])->name('page_search_listing');

Route::get('/hotel/best-hotel-in-{slug}', [HomeController::class, 'pageSearchListing'])->name('city-search');
Route::get('/category/{slug}', [CategoryController::class, 'listPlace'])->name('category_list');

Route::get('/categories', [CategoryController::class, 'search'])->name('category_search');

Route::post('/checkout/payment', [CheckoutController::class, 'checkout'])->name('payment.checkout');
Route::post('rozer/payment/pay-success/{booking_id}', [RazorpayController::class, 'payment'])->name('payment.rozer');
Route::post('coupon', [CheckoutController::class, 'checkCoupon'])->name('check.coupon');
Route::get('apply-offer', [CheckoutController::class, 'applyoffer']);


Route::get('/user/login', [UserController::class, 'loginPage'])->name('user_login');
Route::get('/login', [UserController::class, 'loginPage'])->name('login');

Route::get('/user/register', [UserController::class, 'registerPage'])->name('user_register');
Route::post('/user/register', [UserController::class, 'registerStore'])->name('user_register');
Route::post('loginWithOtp', [UserController::class, 'loginWithOtp'])->name('loginWithOtp');
Route::post('sendOtp', [UserController::class, 'sendOtp'])->name('send_otp');
Route::get('/setcookie', [HomeController::class, 'setCookie'])->name('set_cookie');
Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('subscribe');

Route::post('review-store',[HotelReviewController::class, 'store'])->name('review.store');

Route::post('review-reply',[HotelReviewController::class, 'replyStore'])->name('review.reply');
Route::get('load-review/{place}',[HotelReviewController::class, 'loadreview']);
