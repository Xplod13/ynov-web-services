<?php

namespace App\Models;

use eloquentFilter\QueryFilter\ModelFilters\Filterable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Movie",
 *     type="object",
 *     title="Movie",
 *     description="Movie model",
 *     required={"id", "name", "created_at", "updated_at"},
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="User ID"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Movie name"
 *     ),
  *     @OA\Property(
 *         property="description",
 *         type="string",
 *         description="Movie description",
 *     ),
 *     @OA\Property(
 *         property="released_at",
 *         type="date",
 *         description="Movie release date",
 *     ),
 *     @OA\Property(
 *         property="rate",
 *         type="number",
 *         description="Movie rate",
 *         minimum=1, 
 *         maximum=5,
 *     ),
 *     @OA\Property(
 *         property="duration",
 *         type="number",
 *         description="Movie duration",
 *         minimum=1, 
 *         maximum=239,
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp",
 *         example="2024-06-05T12:34:56.789Z"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update timestamp",
 *         example="2024-06-05T12:34:56.789Z"
 *     )
 * )
 */
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
