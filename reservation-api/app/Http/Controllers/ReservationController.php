<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMovieReservationRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\ReservationCollection;
use App\Http\Resources\ReservationResource;
use App\Models\Movie;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\Seance;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    public function store(StoreMovieReservationRequest $request, Movie $movie)
    {
        $data = $request->validated();

        $seance = Seance::findOrFail($data['seance_id']);
        $room = Room::findOrFail($data['room_id']);
        $nbSeats = $data['nbSeats'];

        if ($movie->id !== $seance->movie_id) {
            abort(400);
        }

        DB::beginTransaction();

        try {
            $room->lockForUpdate()->find($room->id);

            if (!$room->seances()->wherePivot('seance_id', $seance->id)->exists()) {
                throw new \Exception('Seance not found in the specified room');
            }

            $now = Carbon::now();

            $totalReservedSeats = $movie->seances()
                ->where('id', $seance->id)
                ->with(['reservations' => function ($query) use ($now) {
                    $query->where(function ($query) {
                        $query->where('status', 'open')
                            ->orWhere('status', 'confirmed');
                    })
                        ->where('expires_at', '>', $now);
                }])
                ->get()
                ->flatMap(function ($seance) {
                    return $seance->reservations;
                })
                ->sum('seats');

            if ($totalReservedSeats + $nbSeats > $room->seats) {
                throw new \Exception('Not enough seats available');
            }

            $reservation = Reservation::create([
                'rank' => 0,
                'status' => 'open',
                'seats' => $nbSeats,
                'expires_at' => Carbon::now()->addMinutes(15)
            ]);

            $seance->reservations()->attach($reservation->id);

            $reservation->users()->attach(Auth::id());

            DB::commit();

            return new ReservationResource($reservation);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function confirm(Reservation $reservation)
    {
        DB::beginTransaction();

        try {
            $reservation = Reservation::lockForUpdate()->find($reservation->id);

            if ($reservation->expires_at < Carbon::now()) {
                $reservation->update([
                    'status' => 'expired'
                ]);

                DB::commit();

                abort(410);
            }

            if (!$reservation->users()->wherePivot('user_id', Auth::id())->exists()) {
                throw new \Exception('User not found in the specified reservation');
            }

            if ($reservation->status !== 'open') {
                throw new \Exception('Reservation is not open');
            }

            $reservation->update([
                'status' => 'confirmed'
            ]);

            DB::commit();

            return response()->json(['message' => 'Reservation confirmed'], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 400);
        }
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

        abort(404);
    }
}
