<?php

use App\Http\Controllers\SslCommerzPaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded from bootstrap/app.php within the "web" middleware group.
|
*/

Route::get('/', function () {
    return view('dashboard');
});

// SSLCOMMERZ Start
// ui ux
Route::get('/uiux', [SslCommerzPaymentController::class, 'uiux']);
// python
Route::get('/python', [SslCommerzPaymentController::class, 'python']);

// For Testing Controller
Route::get('/demo', function () {
    return view('demo');
});

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END
