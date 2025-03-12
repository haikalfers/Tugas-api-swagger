<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() != null;
    }

    public function rules(): array
    {
        return [
            'street' => ['nullable', 'max:255'],
            'city' => ['nullable', 'max:100'],
            'province' => ['nullable', 'max:100'],
            'country' => ['required', 'max:100'],
            'postal_code' => ['nullable', 'max:10']
        ];
    }
}
