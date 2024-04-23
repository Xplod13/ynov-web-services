<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
