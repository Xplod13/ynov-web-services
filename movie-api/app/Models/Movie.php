<?php

namespace App\Models;

use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory, Filterable, HasUuids;

    private static $whiteListFilter =[
        'name',
        'description',
    ];

    protected $fillable = [
        "name",
        "description",
        'rate',
        'duration'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'movie_categories');
    }

}
