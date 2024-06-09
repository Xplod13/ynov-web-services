<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UpdateMovieRequest",
 *     type="object",
 *     title="UpdateMovieRequest",
 *     description="Update movie model request",
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
class UpdateMovieRequest extends FormRequest
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
            'name' => 'string|max:128',
            'description' => 'string|max:4096',
            'rate' => 'min:0|max:5',
            'duration' => 'min:1|max:239',
        ];
    }
}
