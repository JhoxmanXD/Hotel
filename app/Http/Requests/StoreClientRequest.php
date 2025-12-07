<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'name'           => ['required','string','max:150'],
            'documentNumber' => ['required','string','max:50','unique:clients,documentNumber'],
            'address'        => ['nullable','string','max:180'],
            'phone'          => ['nullable','string','max:40'],
            'email'          => ['nullable','email','max:120','unique:clients,email'],
            'state'          => ['required','boolean'],
        ];
    }

    public function attributes(): array
    {
        return [
            'name'           => 'nombre',
            'documentNumber' => 'número de documento',
            'address'        => 'dirección',
            'phone'          => 'teléfono',
            'email'          => 'correo',
        ];
    }
}