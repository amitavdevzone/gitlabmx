<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'sometimes|min:3',
            'start_date' => 'required|date_format:Y-m-d',
            'end_date' => 'required|date_format:Y-m-d',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
