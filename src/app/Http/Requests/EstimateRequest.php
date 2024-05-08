<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstimateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|min:3',
            'description' => 'sometimes',
            'estimated_hours' => 'required|numeric|min:1',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
