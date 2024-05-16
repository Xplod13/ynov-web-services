<?php

use App\Http\Controllers\MovieCategoryController;
use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryMovieController;

Route::apiResource('categories', CategoryController::class)->only('index', 'show');
Route::apiResource('movies', MovieController::class)->only('index', 'show');

Route::group([
    'middleware' => ['auth:api', 'admin.role'],
], function () {
    Route::apiResource('movies', MovieController::class)->except('index', 'show');
    Route::apiResource('categories', CategoryController::class)->except('index', 'show');
});

Route::apiResource('movies.categories', MovieCategoryController::class)->only(['index']);

Route::apiResource('categories.movies', CategoryMovieController::class)->only(['index']);
