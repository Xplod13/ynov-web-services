<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\ReservationCollection;
use App\Http\Resources\ReservationResource;
use App\Models\Movie;
use App\Models\Reservation;
use App\Models\Seance;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Movie $movie)
    {
        return new ReservationCollection($movie->seances()->with('reservations')->paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        //
    }

    public function confirm()
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        $user = Auth::user();

        if (in_array('ROLE_ADMIN', $user->roles)) {
            return new ReservationResource($reservation);
        }

        if ($reservation->user()->wherePivot('user_id', $user->id)->exists()) {
            return new ReservationResource($reservation);
        }

        return response()->abort(404);
    }
}
