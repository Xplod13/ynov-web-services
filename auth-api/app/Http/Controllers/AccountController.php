<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    /**
     *  @OA\Post(
     *      path="/api/account",
     *      tags={"Account"},
     *      summary="Création d'un compte utilisateur",
     *      description="Renvoie un compte utilisateur",
     *      @OA\Parameter(
     *          required=true,
     *          name="createAccountRequest",
     *          in="query",
     *          @OA\JsonContent(ref="#/components/schemas/StoreAccountRequest"),
     *      ),
     *      @OA\Response(
     *           response=201,
     *           @OA\JsonContent(ref="#/components/schemas/User"),
     *           description="Utilisateur crée avec succès",
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
    public function store(StoreAccountRequest $request)
    {
        $data = $request->validated();

        if (in_array('ROLE_ADMIN', $data['roles']) && !in_array('ROLE_USER', $data['roles'])) {
            $data['roles'][] = 'ROLE_USER';
        }

        return new UserResource(User::create($data));
    }

    /**
     * Display the specified resource.
     */
    /**
     *  @OA\get(
     *      path="/api/account",
     *      tags={"Account"},
     *      summary="Affichage d'un compte utilisateur",
     *      description="Renvoie un compte utilisateur",
     *      @OA\Response(
     *           response=201,
     *           @OA\JsonContent(ref="#/components/schemas/User"),
     *           description="Affiche un utilisateur",
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
    public function show(string $id)
    {
        if ($id === 'me') {
            return new UserResource(auth()->user());
        }

        if ($id == Auth::id()) {
            return new UserResource(auth()->user());
        }

        if (in_array('ROLE_ADMIN', Auth::user()->roles)) {
            return new UserResource(User::findOrFail($id));
        }

        abort(403);
    }

    /**
     *  @OA\Put(
     *      path="/api/account",
     *      tags={"Account"},
     *      summary="Modification d'un compte utilisateur",
     *      description="Renvoie un compte utilisateur",
     *      @OA\Parameter(
     *          name="uid",
     *          required=true,
     *          in="path",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  description="Identifiant utilisateur",
     *                  type="string",
     *                  required={ "uid" },
     *                  @OA\Property(property="uid", type="string")
     *              )
     *          ),
     *      ),
     *      @OA\Parameter(
     *          required=true,
     *          name="createAccountRequest",
     *          in="query",
     *          @OA\JsonContent(ref="#/components/schemas/UpdateAccountRequest"),
     *      ),
     *      @OA\Response(
     *           response=201,
     *           @OA\JsonContent(ref="#/components/schemas/User"),
     *           description="Utilisateur modifié avec succès",
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
    public function update(UpdateAccountRequest $request, string $id)
    {
        $data = $request->validated();

        // Get the authenticated user
        $authUser = Auth::user();

        // Determine the user to be updated
        $user = ($id === 'me') ? $authUser : User::findOrFail($id);

        // Only allow ROLE_ADMIN to edit roles
        if (!empty($data['roles']) && !$authUser->hasRole('ROLE_ADMIN')) {
            return response()->json(['error' => 'Unauthorized to edit roles'], 403);
        }

        $user->update($data);

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
