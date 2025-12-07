<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PaymentMethodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() ?: true;
    }

    public function rules(): array
    {
        // Detectamos si es create o update
        if ($this->isMethod('post')) {
            return [
                'name'        => ['required','string','max:255', Rule::unique('payment_methods','name')],
                'description' => ['required','string','max:500'],
            ];
        }

        if ($this->isMethod('put') || $this->isMethod('patch')) {
            // El parámetro de resource por defecto es {paymentmethod}
            $paymentMethodParam = $this->route('paymentmethod');
            $paymentMethodId = is_object($paymentMethodParam) ? $paymentMethodParam->id : $paymentMethodParam;

            return [
                'name'        => ['required','string','max:255', Rule::unique('payment_methods','name')->ignore($paymentMethodId)],
                'description' => ['required','string','max:500'],
            ];
        }

        return [];
    }
}