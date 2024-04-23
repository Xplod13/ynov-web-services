<?php

use App\Http\Controllers\MovieCategoryController;
use App\Http\Controllers\MovieController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryMovieController;

Route::apiResources([
    'movies' => MovieController::class,
    'categories' => CategoryController::class,
]);

Route::apiResource('movies.categories', MovieCategoryController::class)->only(['index']);

Route::apiResource('categories.movies', CategoryMovieController::class)->only(['index']);
