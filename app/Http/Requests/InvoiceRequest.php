<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() ?: true;
    }

    public function rules(): array
    {
        // Si quieres evitar duplicar factura por misma registration, aplica unique en store.
        if ($this->isMethod('post')) {
            return [
                'registration_id'    => ['required','exists:registrations,id', Rule::unique('invoices','registration_id')],
                'payment_method_id'  => ['required','exists:payment_methods,id'],
                'date'               => ['required','date'],
                'total'              => ['required','numeric','min:0'],
                'state'              => ['required','boolean'],
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $param = $this->route('invoice');
            $id    = is_object($param) ? $param->id : $param;

            return [
                'registration_id'    => [
                    'required','exists:registrations,id',
                    Rule::unique('invoices','registration_id')->ignore($id)
                ],
                'payment_method_id'  => ['required','exists:payment_methods,id'],
                'date'               => ['required','date'],
                'total'              => ['required','numeric','min:0'],
                'state'              => ['required','boolean'],
            ];
        }

        return [];
    }

    public function attributes(): array
    {
        return [
            'registration_id'   => 'registro',
            'payment_method_id' => 'método de pago',
            'date'              => 'fecha',
            'total'             => 'total',
            'state'             => 'estado',
        ];
    }
}