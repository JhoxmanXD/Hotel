<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() ?: true;
    }

    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'name'        => ['required','string','max:255', Rule::unique('room_types','name')],
                'description' => ['required','string','max:500'],
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            // El parámetro de resource es {roomtype}
            $param = $this->route('roomtype');
            $id = is_object($param) ? $param->id : $param;

            return [
                'name'        => ['required','string','max:255', Rule::unique('room_types','name')->ignore($id)],
                'description' => ['required','string','max:500'],
            ];
        }

        return [];
    }

    public function attributes(): array
    {
        return [
            'name'        => 'nombre',
            'description' => 'descripción',
        ];
    }
}