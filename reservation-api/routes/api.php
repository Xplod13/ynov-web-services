<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group([
    'middleware' => ['auth:api', 'admin.role'],
], function () {
    Route::apiResource('cinema', \App\Http\Controllers\CinemaController::class);
});

Route::group([
    'middleware' => ['auth:api'],
], function () {
    Route::apiResource('cinema', \App\Http\Controllers\CinemaController::class)->only(['index', 'show']);
});
