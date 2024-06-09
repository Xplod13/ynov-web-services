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
     */    /**
     *  @OA\Get(
     *      path="/api/movies/categories",
     *      tags={"Category"},
     *      summary="Affichage des catégories et de leur films",
     *      description="Renvoie les catégories et leur films",
     *      @OA\Response(
     *           response=201,
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="Category and movies",
     *                  type="array",
     *                  @OA\Items(
     *                      ref="#/components/schemas/CategoryMovieResource"
     *                  )
     *              )
     *           ),
     *           description="Affiche les catégorie et leur films",
     *      ),
     *      @OA\Response(
     *           response=401,
     *           description="Unauthorized",
     *      ),
     *      @OA\Response(
     *           response=403,
     *           description="Unauthorized",
     *      ),
     *      @OA\Response(
     *           response=422,
     *           description="Unauthorized",
     *      ),
     *  )     
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
