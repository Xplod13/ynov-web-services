<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Http\Resources\MovieCollection;
use App\Http\Resources\MovieResource;
use App\Models\Movie;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $movies = Movie::filter($request->all())->paginate(15);
        // Assurez-vous que tous les paramètres de requête sont inclus dans les liens de pagination
        $movies->appends($request->all());

        return new MovieCollection($movies);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMovieRequest $request)
    {
        return new MovieResource(Movie::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Movie $movie): MovieResource
    {
        return new MovieResource($movie);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMovieRequest $request, Movie $movie): MovieResource
    {
        $movie->updateOrFail($request->validated());

       return new MovieResource($movie);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        $movie->delete();

        return response()->noContent();
    }
}
