<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCinemaRoomsRequest;
use App\Http\Requests\StoreRoomRequest;
use App\Http\Requests\UpdateCinemaRoomsRequest;
use App\Http\Requests\UpdateRoomRequest;
use App\Http\Resources\RoomCollection;
use App\Http\Resources\RoomResource;
use App\Models\Cinema;
use App\Models\CinemaRooms;
use App\Models\Room;
use PHPUnit\Event\CollectingDispatcher;

class CinemaRoomsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Cinema $cinema)
    {
        return new RoomCollection($cinema->rooms()->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoomRequest $request, Cinema $cinema)
    {
        $room = Room::create($request->validated());

        $cinema->rooms()->attach($room->id);

        return new RoomResource($room);
    }

    /**
     * Display the specified resource.
     */
    public function show(Cinema $cinema, Room $room)
    {

        if($cinema->rooms()->wherePivot('room_id', $room->id)->exists()) {
            return new RoomResource($room);
        }

        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoomRequest $request, Cinema $cinema, Room $room)
    {
        $data = $request->validated();

        if($cinema->rooms()->wherePivot('room_id', $room->id)->exists()) {

            $room->update($data);

            return new RoomResource($room);
        }

        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cinema $cinema, Room $room)
    {
        if($cinema->rooms()->wherePivot('room_id', $room->id)->exists()) {

            $room->forceDelete();

            return response()->noContent();
        }

        abort(404);

    }
}
