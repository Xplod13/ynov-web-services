<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryMovieResource;
use App\Http\Resources\MovieCategoryCollection;
use App\Http\Resources\MovieCategoryResource;
use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;

class CategoryMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, Category $category)
    {
        return new CategoryMovieResource($category);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
