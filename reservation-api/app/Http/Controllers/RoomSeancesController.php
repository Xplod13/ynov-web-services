<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoomSeancesRequest;
use App\Http\Requests\StoreSeanceRequest;
use App\Http\Requests\UpdateRoomSeancesRequest;
use App\Http\Requests\UpdateSeanceRequest;
use App\Http\Resources\SeanceCollection;
use App\Http\Resources\SeanceResource;
use App\Models\Cinema;
use App\Models\Room;
use App\Models\RoomSeances;
use App\Models\Seance;

class RoomSeancesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Cinema $cinema, Room $room)
    {
        if ($cinema->rooms()->wherePivot('room_id', $room->id)->exists()) {
            return new SeanceCollection($room->seances()->paginate());
        }

        return response()->noContent();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSeanceRequest $request, Cinema $cinema, Room $room)
    {
        if ($cinema->rooms()->wherePivot('room_id', $room->id)->exists()) {

            $seance = Seance::create($request->validated());

            $seance->rooms()->attach($room->id);

            return new SeanceResource($seance);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cinema $cinema, Room $room, Seance $seance)
    {
        if ($room->seances()->wherePivot('seance_id', $seance->id)->exists()) {
            return new SeanceResource($seance);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSeanceRequest $request, Cinema $cinema, Room $room, Seance $seance)
    {
        $data = $request->validated();

        if ($room->seances()->wherePivot('seance_id', $seance->id)->exists()) {

            $seance->update($data);

            return new SeanceResource($seance);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cinema $cinema, Room $room, Seance $seance)
    {
        $seance->forceDelete();

        return response()->noContent();
    }
}
