<?php

use App\Http\Controllers\API\CityController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PlaceController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UpdateController;
use App\Http\Controllers\API\BookingController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\ImageController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$router->group([
    'prefix' => 'app',
    'namespace' => 'API',
    'as' => 'api_app_',
    'middleware' => []
], function () use ($router) {
    $router->get('/cities/popular', [CityController::class, 'popularCity']);
    $router->get('/cities/{ishomepage?}', [CityController::class, 'list']);
    $router->get('/posts/inspiration', [PostController::class, 'postInspiration']);
    $router->get('/placebycity/{city_id}', [PlaceController::class, 'placeBycity']);
    $router->get('/places/{id}', [PlaceController::class, 'detail']);
    $router->get('/placesbytype/{type_id}/{is_toprated?}', [PlaceController::class, 'PlaceBytype']);
    $router->get('/places-search', [PlaceController::class, 'search']);
    $router->get('/location/search', [PlaceController::class, 'locationSearch']);
    $router->get('/nearbyplace', [PlaceController::class, 'nearbyplace']);
    $router->get('/testimonial', [PostController::class, 'Testimonial']);
    $router->get('/banners', [PostController::class, 'Bannerlist']);

    $router->post('customer/registers', [AuthController::class, 'register']);
    $router->post('customer/login', [AuthController::class, 'loginCustomer']);
    $router->post('send/otp', [AuthController::class, 'sendOtp']);
    $router->post('verify/login', [AuthController::class, 'getLogin']);
    $router->get('customer/delete-account', [AuthController::class, 'deactiveAccount']);

    $router->middleware(['Hastoken'])->group(function () use ($router) {
        $router->post('update/profile/customer', [UpdateController::class, 'updateCustomerProfile']);
        $router->post('room/booking', [BookingController::class, 'bookRoom']);
        $router->post('/checkout', [CheckoutController::class, 'store']);
        $router->post('/update-checkout', [CheckoutController::class, 'updateAfterPayment']);
        $router->get('/users', [UserController::class, 'getUserInfo']);
        $router->get('/coupon', [CheckoutController::class, 'Coupon']);
        $router->get('/booking-list', [AuthController::class, 'mybooking']);
        $router->get('/cancel-booking', [AuthController::class, 'cancelBooking']);
    });

    $router->get('/filter', [PlaceController::class, 'filter']);
});
