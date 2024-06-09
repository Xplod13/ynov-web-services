<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Movie;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /**
     *  @OA\Get(
     *      path="/api/categories",
     *      tags={"Category"},
     *      summary="Affichage des catégories",
     *      description="Renvoie les catégories",
     *      @OA\Response(
     *           response=201,
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="Categories",
     *                  type="array",
     *                  @OA\Items(
     *                      ref="#/components/schemas/Category"
     *                  )
     *              )
     *           ),
     *           description="Affiche les catégories",
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
        $categories = Category::filter($request->all())->paginate(15);
        $categories->appends($request->all());

        return new CategoryCollection($categories);
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     *  @OA\Post(
     *      path="/api/categories",
     *      tags={"Category"},
     *      summary="Création d'une catégorie",
     *      description="Renvoie une catégorie",
     *      @OA\Parameter(
     *          required=true,
     *          name="CreateCategoryRequest",
     *          in="query",
     *          @OA\JsonContent(ref="#/components/schemas/StoreCategoryRequest"),
     *      ),
     *      @OA\Response(
     *           response=201,
     *           @OA\JsonContent(ref="#/components/schemas/Category"),
     *           description="Catégorie crée avec succès",
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
    public function store(StoreCategoryRequest $request)
    {
        return new CategoryResource(Movie::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    /**
     *  @OA\Get(
     *      path="/api/categories/{category}",
     *      tags={"Category"},
     *      summary="Affichage d'une catégorie",
     *      description="Renvoie une catégorie",
     *      @OA\Response(
     *           response=201,
     *           @OA\JsonContent(ref="#/components/schemas/Category"),
     *           description="Affiche une catégorie",
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
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     *  @OA\Put(
     *      path="/api/categories",
     *      tags={"Category"},
     *      summary="Modification d'une catégorie",
     *      description="Renvoie une catégorie",
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
     *      @OA\Parameter(
     *          required=true,
     *          name="UpdateCategoryRequest",
     *          in="query",
     *          @OA\JsonContent(ref="#/components/schemas/UpdateCategoryRequest"),
     *      ),
     *      @OA\Response(
     *           response=201,
     *           @OA\JsonContent(ref="#/components/schemas/Category"),
     *           description="Catégorie modifié avec succès",
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
    public function update(UpdateCategoryRequest $request, Category $category): CategoryResource
    {
        $category->updateOrFail($request->validated());

       return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    /**
     *  @OA\Delete(
     *      path="/api/categories",
     *      tags={"Category"},
     *      summary="Suppression d'une catégorie",
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
     *           description="Catégorie supprimée avec succès",
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
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }
}
