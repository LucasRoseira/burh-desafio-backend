<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *     schema="JobRequest",
 *     type="object",
 *     required={"title", "type", "company_id"},
 *     title="Job Request",
 *     description="Schema for creating or updating a job",
 *     @OA\Property(
 *         property="title",
 *         type="string",
 *         example="Backend Developer"
 *     ),
 *     @OA\Property(
 *         property="description",
 *         type="string",
 *         example="Develop APIs with Laravel",
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="type",
 *         type="string",
 *         enum={"PJ","CLT","Internship"},
 *         example="CLT"
 *     ),
 *     @OA\Property(
 *         property="salary",
 *         type="number",
 *         format="float",
 *         example=2500,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="hours",
 *         type="integer",
 *         example=6,
 *         nullable=true
 *     ),
 *     @OA\Property(
 *         property="company_id",
 *         type="integer",
 *         example=1
 *     )
 * )
 */
class JobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => ['required', Rule::in(['PJ', 'CLT', 'Internship'])],
            'salary' => [
                function ($attribute, $value, $fail) {
                    if (in_array($this->type, ['CLT', 'Internship']) && !$value) {
                        $fail($this->type . ' jobs must have salary specified.');
                    }
                    if ($this->type === 'CLT' && $value < 1212) {
                        $fail('CLT jobs must have a minimum salary of 1212.');
                    }
                }
            ],

            'hours' => [
                'integer',
                function ($attribute, $value, $fail) {
                    if (in_array($this->type, ['CLT', 'Internship']) && !$value) {
                        $fail($this->type . ' jobs must have hours specified.');
                    }
                    if ($this->type === 'Internship' && $value > 6) {
                        $fail('Internship jobs must have a maximum of 6 hours.');
                    }
                }
            ],

            'company_id' => 'required|exists:companies,id',
        ];
    }
}
