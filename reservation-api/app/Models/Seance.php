<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seance extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'movie_id',
        'date'
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'reservation_seance')->withTimestamps();
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_seances')->withTimestamps();
    }

    public function movie()
    {
        return $this->belongsTo(Movie::class, 'room_seances')->withTimestamps();
    }
}
