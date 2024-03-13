<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:clients,name'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
