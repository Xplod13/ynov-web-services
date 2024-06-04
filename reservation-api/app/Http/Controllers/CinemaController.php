<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCinemaRequest;
use App\Http\Requests\UpdateCinemaRequest;
use App\Http\Resources\CinemaCollection;
use App\Http\Resources\CinemaResource;
use App\Models\Cinema;
use Illuminate\Http\Request;

class CinemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return new CinemaCollection(Cinema::filter($request->all())->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCinemaRequest $request)
    {
        return new CinemaResource(Cinema::create($request->validated()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Cinema $cinema)
    {
        return new CinemaResource($cinema);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCinemaRequest $request, Cinema $cinema)
    {
        $cinema->updateOrFail($request->validated());

        return new CinemaResource($cinema);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cinema $cinema)
    {
        $cinema->forceDelete();

        return response()->noContent();
    }
}
