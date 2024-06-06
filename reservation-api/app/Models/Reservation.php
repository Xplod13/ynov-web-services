<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'rank',
        'status',
        'seats',
        'expires_at'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_reservations')->withTimestamps();
    }

    public function seances()
    {
        return $this->belongsToMany(Seance::class, 'reservation_seances')->withTimestamps();
    }
}
