<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EstimateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'project_id' => 'required|exists:projects,id',
            'delivery_id' => 'required|exists:deliveries,id',
            'title' => 'required|min:3',
            'description' => 'sometimes',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
