<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() ?: true;
    }

    public function rules(): array
    {
        return [
            'employee_id'  => ['required', 'exists:employees,id'],
            'room_id'      => ['required', 'exists:rooms,id'],
            'client_id'    => ['required', 'exists:clients,id'],
            'checkindate'  => ['required', 'date'],
            'checkintime'  => ['required', 'date_format:H:i'],
            'checkoutdate' => ['nullable', 'date', 'after_or_equal:checkindate'],
            'checkouttime' => ['nullable', 'date_format:H:i', 'required_with:checkoutdate'],
        ];
    }

    public function attributes(): array
    {
        return [
            'employee_id'  => 'empleado',
            'room_id'      => 'habitación',
            'client_id'    => 'cliente',
            'checkindate'  => 'fecha de entrada',
            'checkintime'  => 'hora de entrada',
            'checkoutdate' => 'fecha de salida',
            'checkouttime' => 'hora de salida',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $inDate   = $this->input('checkindate');
            $inTime   = $this->input('checkintime');
            $outDate  = $this->input('checkoutdate');
            $outTime  = $this->input('checkouttime');

            if ($inDate && $inTime && $outDate && $outTime) {
                if ($inDate === $outDate && $outTime <= $inTime) {
                    $validator->errors()->add('checkouttime', 'La hora de salida debe ser posterior a la hora de entrada cuando la fecha es la misma.');
                }
            }
        });
    }
}