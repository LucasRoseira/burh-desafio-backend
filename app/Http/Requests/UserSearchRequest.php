<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UserSearchRequest",
 *     type="object",
 *     title="User Search Request",
 *     @OA\Property(property="per_page", type="integer", example=10),
 *     @OA\Property(property="name", type="string", nullable=true),
 *     @OA\Property(property="email", type="string", nullable=true),
 *     @OA\Property(property="cpf", type="string", nullable=true)
 * )
 */
class UserSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'per_page' => 'sometimes|integer|min:1',
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|max:255',
            'cpf' => 'sometimes|string|max:20',
        ];
    }
}
