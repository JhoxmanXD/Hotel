<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() ?: true;
    }

    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return [
                'room_type_id' => ['required','exists:room_types,id'],
                'number'       => ['required','string','max:50', Rule::unique('rooms','number')],
                'floor'        => ['required','integer','min:0'],
                'value'        => ['required','numeric','min:0'],
                'numpeople'    => ['required','integer','min:1','max:20'],
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $param = $this->route('room'); // objeto o id
            $id = is_object($param) ? $param->id : $param;

            return [
                'room_type_id' => ['required','exists:room_types,id'],
                'number'       => ['required','string','max:50', Rule::unique('rooms','number')->ignore($id)],
                'floor'        => ['required','integer','min:0'],
                'value'        => ['required','numeric','min:0'],
                'numpeople'    => ['required','integer','min:1','max:20'],
            ];
        }

        return [];
    }

    public function attributes(): array
    {
        return [
            'room_type_id' => 'tipo de habitación',
            'number'       => 'número',
            'floor'        => 'piso',
            'value'        => 'tarifa',
            'numpeople'    => 'capacidad',
        ];
    }
}