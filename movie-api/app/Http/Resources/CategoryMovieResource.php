<?php

namespace App\Http\Resources;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="CategoryMovieResource",
 *     type="object",
 *     title="CategoryMovieResource",
 *     description="Category + movies",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         format="int64",
 *         description="User ID"
 *     ),
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Category name"
 *     ),
 *      @OA\Property(
 *         property="movies",
 *         type="array",
 *         description="Category movies",
 *         @OA\Items(
 *           ref="#/components/schemas/Movie"
 *         )
 *     ),
 *     @OA\Property(
 *         property="links",
 *         type="array",
 *         description="Category movies links",
 *         @OA\Items(
 *              @OA\Property(
 *                  property="self",
 *                  type="array",
 *                  description="Category self links",
 *                  @OA\Items(
 *                      @OA\Property(
 *                          property="href",
 *                          type="string",
 *                          description="Category self link",
 *                      )
 *                  )
 *              ),
 *              @OA\Property(
 *                  property="movies",
 *                  type="array",
 *                  description="Category movies links",
 *                  @OA\Items(
 *                      @OA\Property(
 *                          property="href",
 *                          type="string",
 *                          description="Category movies link",
 *                      )
 *                  )
 *              ),
 *         )
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
class CategoryMovieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $baseUrl = config('app.url') . '/api';

        return [
            'id' => $this->id,
            'name' => $this->name,
            'movies' => MovieResource::collection($this->movies),
            'links' => [
                'self' => [
                    'href' => "{$baseUrl}/categories/{$this->id}"
                ],
                'movies' => [
                    'href' => "{$baseUrl}/categories/{$this->id}/movies"
                ]
            ]
        ];
    }
}
