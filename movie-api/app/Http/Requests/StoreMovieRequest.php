<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="StoreMovieRequest",
 *     type="object",
 *     title="StoreMovieRequest",
 *     description="Store movie model request",
 *     required={"name","description","released_at"},
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         description="Movie name",
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
 * )
 */
class StoreMovieRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:128',
            'description' => 'required|string|max:4096',
            'released_at' => 'required|date',
            'rate' => 'integer|min:0|max:5',
            'duration' => 'integer|min:1|max:239',
        ];
    }
}
