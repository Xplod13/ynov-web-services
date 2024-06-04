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

    public function user()
    {
        return $this->belongsTo(User::class, 'user_reservations')->withTimestamps();
    }

    public function seance()
    {
        return $this->belongsTo(Seance::class, 'reservation_seance')->withTimestamps();
    }
}
