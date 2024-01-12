<?php

use App\Events\Chat;
use App\Http\Controllers\Common\PropertyController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('admin.dashboard');
})->name('/');

Route::post('/upload-image',[ImageController::class,'upload']);
Route::get('/delete-image',[ImageController::class,'delete']);
Route::get('/getCity/{stateId}',[PropertyController::class,'getCity'])->name('getcities');


Route::get('/print', function () {
    return view('common.booking.print');
});

