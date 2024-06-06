<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        "name",
        "description",
        'rate',
        'duration'
    ];

    public function seances()
    {
        return $this->belongsToMany(Seance::class, 'movie_seances')->withTimestamps();
    }
}
