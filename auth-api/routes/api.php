<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [\App\Http\Controllers\TokenController::class, 'login'])->middleware('customThrottle:3,5');
Route::get('validate/{accessToken}', [\App\Http\Controllers\TokenController::class, 'validate']);

Route::group([
    'middleware' => 'auth:api',
], function ($router) {
    Route::get('refresh-token/{refreshToken}/token', [\App\Http\Controllers\TokenController::class, 'refreshToken']);

    Route::apiResource('account', \App\Http\Controllers\AccountController::class);
});
