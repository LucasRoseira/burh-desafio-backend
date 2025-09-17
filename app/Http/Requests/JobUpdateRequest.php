<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string|in:CLT,PJ,Internship',
            'salary' => 'nullable|numeric|min:0',
            'hours' => 'nullable|integer|min:1|max:24',
            'company_id' => 'nullable|exists:companies,id',
        ];
    }
}
