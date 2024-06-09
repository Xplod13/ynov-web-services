<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="MovieCategoryResource",
 *     type="object",
 *     title="MovieCategoryResource",
 *     description="Movie + categories",
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
 *         property="categories",
 *         type="array",
 *         description="Movie categories",
 *         @OA\Items(
 *           ref="#/components/schemas/Category"
 *         )
 *     ),
 *     @OA\Property(
 *         property="links",
 *         type="array",
 *         description="Movie links and movie categories links",
 *         @OA\Items(
 *              @OA\Property(
 *                  property="self",
 *                  type="array",
 *                  description="Movie self links",
 *                  @OA\Items(
 *                      @OA\Property(
 *                          property="href",
 *                          type="string",
 *                          description="Movie self link",
 *                      )
 *                  )
 *              ),
 *              @OA\Property(
 *                  property="categories",
 *                  type="array",
 *                  description="Movie categories links",
 *                  @OA\Items(
 *                      @OA\Property(
 *                          property="href",
 *                          type="string",
 *                          description="Movie categories link",
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
class MovieCategoryResource extends JsonResource
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
            'description' => $this->description,
            'released_at' => $this->released_at,
            'review' => $this->when(!empty($this->review), $this->review),
            'categories' => CategoryResource::collection($this->categories),
            'links' => [
                'self' => [
                    'href' => "{$baseUrl}/movies/{$this->id}"
                ],
                'categories' => [
                    'href' => "{$baseUrl}/movies/{$this->id}/categories"
                ]
            ]
        ];
    }
}
