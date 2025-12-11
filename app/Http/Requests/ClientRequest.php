<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Permitimos que cualquiera haga la petición (siempre que esté logueado, lo cual controla el middleware)
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // 1. Detectamos si estamos editando
        // Buscamos el objeto 'client' en la ruta. Si no existe (estamos creando), será null.
        $client = $this->route('client');
        $clientId = $client ? $client->id : null;

        return [
            'name' => 'required|string|max:255',
            
            // 2. Validación inteligente:
            // "unique:clients,documentNumber," . $clientId
            // Significa: "El documento debe ser único, EXCEPTO para el ID $clientId"
            'documentNumber' => 'required|string|max:20|unique:clients,documentNumber,' . $clientId,
            
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            
            // Lo mismo para el correo
            'email' => 'required|email|max:255|unique:clients,email,' . $clientId,
            
            // Validamos que state sea 1 o 0 (o true/false)
            // A veces el checkbox no envía nada si está desactivado, pero si lo envían debe ser booleano
            'state' => 'nullable', 
        ];
    }
    
    // (Opcional) Mensajes personalizados si quieres que salgan en español
    public function messages()
    {
        return [
            'documentNumber.unique' => 'Este número de documento ya está registrado.',
            'email.unique' => 'Este correo electrónico ya está registrado.',
        ];
    }
}
