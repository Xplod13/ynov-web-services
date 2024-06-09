<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
/**
 * @OA\Schema(
 *     schema="UpdateAccountRequest",
 *     type="object",
 *     title="UpdateAccountRequest",
 *     description="Update user model request",
 *     required={"login", "password", "roles", "status"},
 *     @OA\Property(
 *         property="login",
 *         type="string",
 *         description="User login"
 *     ),
 *     @OA\Property(
 *         property="password",
 *         type="string",
 *         description="User password"
 *     ),
 *     @OA\Property(
 *         property="roles",
 *         description="User roles",
 *         type="array",
 *         @OA\Items(
 *              type="string",
 *              description="role",
 *              @OA\Schema(type="string")
 *         ),
 *     ),
 *     @OA\Property(
 *         property="status",
 *         type="string",
 *         description="User status"
 *     )
 * )
 */
class UpdateAccountRequest extends FormRequest
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
            'login' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'roles' => 'nullable|array|in:ROLE_USER,ROLE_ADMIN',
            'status' => 'nullable|in:open,closed',
        ];
    }
}
