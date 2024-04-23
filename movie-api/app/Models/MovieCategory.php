<?php

namespace App\Models;

use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MovieCategory extends Model
{
    use HasFactory, Filterable;

    private static $whiteListFilter =[
        'movie_id',
        'category_id',
    ];

    protected $fillable = [
        'movie_id',
        'category_id'
    ];

    /**
     * Get the movie associated with the MovieCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function movie(): HasOne
    {
        return $this->hasOne(Movie::class, 'id', 'movie_id');
    }

    /**
     * Get the category associated with the MovieCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category(): HasOne
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }
}
