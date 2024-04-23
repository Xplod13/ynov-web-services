<?php

namespace App\Http\Resources;

use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
