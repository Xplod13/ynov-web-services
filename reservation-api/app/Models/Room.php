<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Room extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'seats'
    ];

    public function cinemas(): BelongsToMany
    {
        return $this->belongsToMany(Cinema::class, 'cinema_rooms');
    }
}
