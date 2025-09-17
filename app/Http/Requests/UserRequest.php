<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="UserRequest",
 *     type="object",
 *     required={"name", "email", "cpf"},
 *     title="User Request",
 *     description="Schema for creating or updating a user",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="John Doe"
 *     ),
 *     @OA\Property(
 *         property="email",
 *         type="string",
 *         format="email",
 *         example="john@example.com"
 *     ),
 *     @OA\Property(
 *         property="cpf",
 *         type="string",
 *         example="123.456.789-00"
 *     ),
 *     @OA\Property(
 *         property="age",
 *         type="string",
 *         format="date",
 *         example="1995-05-15",
 *         nullable=true
 *     )
 * )
 */
class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->user,
            'cpf' => 'required|string|unique:users,cpf,' . $this->user,
            'age' => 'nullable|date',
        ];
    }
}
