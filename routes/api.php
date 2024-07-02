<?php

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

$router->group([
    'as' => 'api_',
    'middleware' => []], function () use ($router) {

    $router->post('/upload-image', 'ImageController@upload')->name('upload_image');

    $router->get('/cities', 'Frontend\CityController@search')->name('city_search');
    $router->put('/city/status', 'Admin\CityController@updateStatus')->name('city_update_status');
    $router->get('/cities/{country_id}', 'Admin\CityController@getListByCountry')->name('city_get_list');

    $router->get('/categories', 'Frontend\CategoryController@search')->name('category_search');
    $router->put('/category/status', 'Admin\CategoryController@updateStatus')->name('category_update_status');
    $router->put('/category/is-feature', 'Admin\CategoryController@updateIsFeature')->name('category_update_is_feature');

    $router->put('/places/status', 'Admin\PlaceController@updateStatus')->name('place_update_status');

    $router->put('/reviews/status', 'Admin\ReviewController@updateStatus')->name('review_update_status');


    $router->put('/posts/status', 'Admin\PostController@updateStatus')->name('post_update_status');


    $router->put('/users/status', 'Admin\UserController@updateStatus')->name('user_update_status');
    $router->put('/users/role/admin', 'Admin\UserController@updateRoleAdmin')->name('user_update_role_admin');
    $router->put('/users/role/partner', 'Admin\UserController@updateRolePartner')->name('user_update_role_partner');

    $router->put('/languages/default', 'Admin\LanguageController@setDefault')->name('language_set_default');

    $router->post('/user/reset-password', 'Frontend\ResetPasswordController@sendMail')->name('user_forgot_password');
});


$router->group([
    'prefix' => 'app',
    'namespace' => 'API',
    'as' => 'api_app_',
    'middleware' => []], function () use ($router) {

    $router->get('/cities/{ishomepage?}', 'CityController@list');
    $router->get('/cities/{id}', 'CityController@detail');
    $router->get('/cities/popular', 'CityController@popularCity');
    $router->get('/posts/inspiration', 'PostController@postInspiration');
    $router->get('/placebycity/{city_id}', 'PlaceController@placeBycity');
    $router->get('/places/{id}', 'PlaceController@detail');
    $router->get('/placesbytype/{type_id}/{is_toprated?}', 'PlaceController@PlaceBytype');
    $router->get('/places-search', 'PlaceController@search');
    $router->get('/location/search', 'PlaceController@locationSearch');
    $router->get('/nearbyplace', 'PlaceController@nearbyplace');
    $router->get('/testimonial', 'CustomerController@Testimonial');
    $router->get('/banners', 'CityController@Bannerlist');

    $router->post('customer/registers','CustomerController@register');
    $router->post('customer/login','CustomerController@loginCustomer');
    $router->post('send/otp','CustomerController@sendOtp');
    $router->post('verify/login','CustomerController@getLogin');
    $router->get('customer/delete-account','CustomerController@deactiveAccount');

    $router->middleware(['Hastoken'])->group(function () use ($router) {
        $router->post('update/profile/customer','UpdateController@updateCustomerProfile');
         $router->post('room/booking','BookingController@bookRoom');
           $router->post('/checkout','CheckoutController@store');
           $router->post('/update-checkout','CheckoutController@updateAfterPayment');
           $router->get('/users', 'UserController@getUserInfo');
           $router->get('/coupon', 'CheckoutController@Coupon');
           $router->get('/booking-list', 'CustomerController@mybooking');
           $router->get('/cancel-booking', 'CustomerController@cancelBooking');
    });


    $router->get('/filter', 'PlaceController@filter');

});
