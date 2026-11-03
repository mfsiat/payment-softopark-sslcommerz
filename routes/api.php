<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded from bootstrap/app.php within the "api" middleware group.
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
