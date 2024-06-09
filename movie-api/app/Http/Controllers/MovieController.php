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
    /**
     *  @OA\Get(
     *      path="/api/movies",
     *      tags={"Movie"},
     *      summary="Affichage des films",
     *      description="Renvoie les films",
     *      @OA\Response(
     *           response=201,
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="Movie",
     *                  type="array",
     *                  @OA\Items(
     *                      ref="#/components/schemas/Movie"
     *                  )
     *              )
     *           ),
     *           description="Affiche les films",
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
    /**
     *  @OA\Post(
     *      path="/api/movies",
     *      tags={"Movie"},
     *      summary="Création d'un film",
     *      description="Renvoie un film",
     *      @OA\Parameter(
     *          required=true,
     *          name="CreateMovieRequest",
     *          in="query",
     *          @OA\JsonContent(ref="#/components/schemas/StoreMovieRequest"),
     *      ),
     *      @OA\Response(
     *           response=201,
     *           @OA\JsonContent(ref="#/components/schemas/Movie"),
     *           description="Film crée avec succès",
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
    public function store(StoreMovieRequest $request)
    {
        return new MovieResource(Movie::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    /**
     *  @OA\Get(
     *      path="/api/movies/{movie}",
     *      tags={"Movie"},
     *      summary="Affichage d'un film",
     *      description="Renvoie un film",
     *      @OA\Response(
     *           response=201,
     *           @OA\JsonContent(ref="#/components/schemas/Movie"),
     *           description="Affiche un film",
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
    public function show(Movie $movie): MovieResource
    {
        return new MovieResource($movie);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     *  @OA\Put(
     *      path="/api/movies",
     *      tags={"Movie"},
     *      summary="Modification d'un film",
     *      description="Renvoie un film",
     *      @OA\Parameter(
     *          name="uid",
     *          required=true,
     *          in="path",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  description="Identifiant film",
     *                  type="string",
     *                  required={ "uid" },
     *                  @OA\Property(property="uid", type="string")
     *              )
     *          ),
     *      ),
     *      @OA\Parameter(
     *          required=true,
     *          name="UpdateMovieRequest",
     *          in="query",
     *          @OA\JsonContent(ref="#/components/schemas/UpdateMovieRequest"),
     *      ),
     *      @OA\Response(
     *           response=201,
     *           @OA\JsonContent(ref="#/components/schemas/Movie"),
     *           description="Film modifié avec succès",
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
    public function update(UpdateMovieRequest $request, Movie $movie): MovieResource
    {
        $movie->updateOrFail($request->validated());

       return new MovieResource($movie);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     *  @OA\Delete(
     *      path="/api/movies",
     *      tags={"Movie"},
     *      summary="Suppression d'un film",
     *      description="Ne renvoie rien",
     *      @OA\Parameter(
     *          name="uid",
     *          required=true,
     *          in="path",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  description="Identifiant catégorie",
     *                  type="string",
     *                  required={ "uid" },
     *                  @OA\Property(property="uid", type="string")
     *              )
     *          ),
     *      ),
     *      @OA\Response(
     *           response=201,
     *           description="Film supprimé avec succès",
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
    public function destroy(Movie $movie)
    {
        $movie->delete();

        return response()->noContent();
    }
}
