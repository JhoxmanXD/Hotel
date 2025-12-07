<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Crear
        if ($this->isMethod('post')) {
            return [
                'name'           => 'required|string|max:255|unique:employees,name',
                'documentNumber' => 'required|string|max:50|unique:employees,documentNumber',
                'address'        => 'nullable|string|max:255',
                'phone'          => 'nullable|string|max:50|unique:employees,phone',
                'email'          => 'nullable|email|max:255|unique:employees,email',
            ];
        }

        // Actualizar (suponiendo route model binding: /employees/{employee})
        if ($this->isMethod('put') || $this->isMethod('patch')) {
            $employeeId = $this->route('employee'); // Puede ser objeto o ID
            if (is_object($employeeId)) {
                $employeeId = $employeeId->id;
            }

            return [
                'name'           => [
                    'required','string','max:255',
                    Rule::unique('employees','name')->ignore($employeeId)
                ],
                'documentNumber' => [
                    'required','string','max:50',
                    Rule::unique('employees','documentNumber')->ignore($employeeId)
                ],
                'address'        => 'nullable|string|max:255',
                'phone'          => [
                    'nullable','string','max:50',
                    Rule::unique('employees','phone')->ignore($employeeId)
                ],
                'email'          => [
                    'nullable','email','max:255',
                    Rule::unique('employees','email')->ignore($employeeId)
                ],
            ];
        }

        return [];
    }
}