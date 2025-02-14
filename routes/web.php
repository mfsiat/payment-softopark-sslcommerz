<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
});

// SSLCOMMERZ Start
// Route::get('/example1', 'App\Http\Controllers\SslCommerzPaymentController@exampleEasyCheckout');
// ui ux 
Route::get('/uiux', 'App\Http\Controllers\SslCommerzPaymentController@uiux');
// python
Route::get('/python', 'App\Http\Controllers\SslCommerzPaymentController@python');

// For Testing Controller
Route::get('/demo', function(){
    return view('demo');
});

Route::post('/pay', 'App\Http\Controllers\SslCommerzPaymentController@index');
Route::post('/pay-via-ajax', 'App\Http\Controllers\SslCommerzPaymentController@payViaAjax');

Route::post('/success', 'App\Http\Controllers\SslCommerzPaymentController@success');
Route::post('/fail', 'App\Http\Controllers\SslCommerzPaymentController@fail');
Route::post('/cancel', 'App\Http\Controllers\SslCommerzPaymentController@cancel');

Route::post('/ipn', 'App\Http\Controllers\SslCommerzPaymentController@ipn');
//SSLCOMMERZ END