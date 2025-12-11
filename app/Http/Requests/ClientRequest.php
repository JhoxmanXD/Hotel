<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // 1. OBTENER EL ID DEL CLIENTE ACTUAL
        // Esto busca el cliente en la ruta (ej: clients/5/edit -> saca el 5)
        $client = $this->route('client');
        
        // Si $client es un objeto (modelo), sacamos su ID. Si es texto, usamos el texto.
        $clientId = optional($client)->id ?? $client;

        return [
            'name' => 'required|string|max:255',
            
            // 2. REGLA DE ORO: unique:tabla,columna,ID_A_IGNORAR
            // Aquí le decimos: "Revisa si existe, pero IGNORA la fila con ID $clientId"
            'documentNumber' => 'required|string|max:20|unique:clients,documentNumber,' . $clientId,
            
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            
            // Lo mismo para el email
            'email' => 'required|email|max:255|unique:clients,email,' . $clientId,
            
            'state' => 'nullable',
        ];
    }
}
