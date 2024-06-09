<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieCategoryCollection;
use App\Http\Resources\MovieCategoryResource;
use App\Http\Resources\MovieCollection;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     *  @OA\Get(
     *      path="/api/categories/movies",
     *      tags={"Movie"},
     *      summary="Affichage des films et de leur catégories",
     *      description="Renvoie les films et leur catégories",
     *      @OA\Response(
     *           response=201,
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="Movie and categories",
     *                  type="array",
     *                  @OA\Items(
     *                      ref="#/components/schemas/MovieCategoryResource"
     *                  )
     *              )
     *           ),
     *           description="Affiche les films et leur catégories",
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
    public function index(Request $request, Movie $movie)
    {
        return new MovieCategoryResource($movie);
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
