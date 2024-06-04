<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:api', 'admin.role'],
], function () {
    Route::apiResource('cinema', \App\Http\Controllers\CinemaController::class);

    Route::apiResource('cinema.rooms', \App\Http\Controllers\CinemaRoomsController::class);

    Route::apiResource('cinema.rooms.seances', \App\Http\Controllers\RoomSeancesController::class);
});

Route::group([
    'middleware' => ['auth:api'],
], function () {
    Route::apiResource('cinema', \App\Http\Controllers\CinemaController::class)->only(['index', 'show']);

    Route::apiResource('cinema.rooms', \App\Http\Controllers\CinemaRoomsController::class)->only(['index', 'show']);

    Route::apiResource('cinema.rooms.seances', \App\Http\Controllers\RoomSeancesController::class)->only(['index', 'show']);
});
