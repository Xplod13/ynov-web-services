<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CinemaRooms extends Pivot
{
    protected $table = 'cinema_rooms';
}
