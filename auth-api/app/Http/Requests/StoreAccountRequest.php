<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Schema(
 *     schema="StoreAccountRequest",
 *     type="object",
 *     title="StoreAccountRequest",
 *     description="Store user model request",
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
class StoreAccountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {

        return in_array('ROLE_ADMIN', Auth::user()->roles);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'login' => 'required|string|max:255',
            'password' => 'required|string|max:255',
            'roles' => 'required|array',
            'roles.*' => 'in:ROLE_USER,ROLE_ADMIN',
            'status' => 'sometimes|in:open,closed'
        ];
    }
}
