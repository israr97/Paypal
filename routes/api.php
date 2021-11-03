<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


// Route::get('/users', 'App\Http\Controllers\SignupController@index')->name('users');
// Route::post('/userlogin', 'App\Http\Controllers\SignupController@login')->name('userlogin');
// Route::post('/userregister', 'App\Http\Controllers\SignupController@store')->name('userregister');



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('completepayment','App\Http\Controllers\PaymentController@capture')->name('complete.payment');