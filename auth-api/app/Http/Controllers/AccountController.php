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
