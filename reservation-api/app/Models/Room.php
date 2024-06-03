<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'name',
        'seats'
    ];

    public function seances()
    {
        return $this->hasMany(Seance::class);
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }
}
