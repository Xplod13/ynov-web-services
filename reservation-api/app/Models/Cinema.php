<?php

namespace App\Models;

use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cinema extends Model
{
    use HasFactory, Filterable, HasUuids;

    private static $whiteListFilter =[
        'name',
    ];

    protected $fillable = [
      'name'
    ];

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
