<?php

namespace App\Models;

use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory, Filterable;

    private static $whiteListFilter =[
        'name',
        'description',
    ];

    protected $fillable = [
        "name",
        "description",
        "released_at",
        "review",
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

}
