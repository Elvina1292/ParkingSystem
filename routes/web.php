<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ParkingController;
use App\Http\Controllers\PrintController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::resource('parkings', ParkingController::Class);
Route::get('parkings/{id}/edit/', 'App\Http\Controllers\ParkingController@edit');

Route::get('/parking/pdf', [PrintController::class, 'createPDF']);
?>
