<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="CompanyRequest",
 *     type="object",
 *     required={"name", "cnpj", "plan"},
 *     title="Company Request",
 *     description="Schema for creating a new company",
 *     @OA\Property(
 *         property="name",
 *         type="string",
 *         example="ACME Ltda"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Company description here"
 *     ),
 *     @OA\Property(
 *         property="cnpj",
 *         type="string",
 *         example="12.345.678/0001-99"
 *     ),
 *     @OA\Property(
 *         property="plan",
 *         type="string",
 *         enum={"Free", "Premium"},
 *         example="Free"
 *     ),
 * )
 */
class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cnpj' => ['required', 'string', 'unique:companies,cnpj', function ($attribute, $value, $fail) {
                if (!self::isValidCnpj($value)) {
                    $fail('The CNPJ is invalid.');
                }
            }],
            'plan' => ['required', Rule::in(['Free', 'Premium'])],
        ];
    }

    private static function isValidCnpj(string $cnpj): bool
    {
        $cnpj = preg_replace('/\D/', '', $cnpj);

        if (strlen($cnpj) != 14) {
            return false;
        }

        if (preg_match('/(\d)\1{13}/', $cnpj)) {
            return false;
        }

        $lengths = [5, 6];
        for ($t = 12; $t < 14; $t++) {
            $sum = 0;
            $pos = $lengths[$t - 12];
            for ($i = 0; $i < $t; $i++) {
                $sum += $cnpj[$i] * $pos;
                $pos = ($pos == 2) ? 9 : $pos - 1;
            }
            $check = ($sum % 11 < 2) ? 0 : 11 - ($sum % 11);
            if ($cnpj[$t] != $check) {
                return false;
            }
        }

        return true;
    }
}