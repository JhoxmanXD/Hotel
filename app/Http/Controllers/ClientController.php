<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest; // <--- Usamos el Request inteligente que creamos
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::latest()->paginate(15);
        return view('clients.index', compact('clients'));
    }

    public function create()
    {
        return view('clients.create');
    }

    public function store(ClientRequest $request) // <--- Tipo ClientRequest
    {
        $data = $request->validated();
        
        // Asignamos el usuario que registra
        $data['registeredBy'] = auth()->id();
        
        Client::create($data);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente registrado correctamente.');
    }

    public function show(Client $client)
    {
        // Asumiendo que la relación se llama 'user' o 'registeredUser' en el modelo Client
        // Si te da error, verifica el nombre en tu modelo Client.php
        // $client->load('registeredUser'); 
        
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(ClientRequest $request, Client $client) // <--- Tipo ClientRequest
    {
        // ¡MIRA QUÉ LIMPIO! 
        // Ya no necesitas modificar las reglas aquí manualmente.
        // El ClientRequest ya sabe que debe ignorar el ID de este $client.
        
        $data = $request->validated();

        $client->update($data);

        return redirect()
            ->route('clients.index')
            ->with('success','Cliente actualizado correctamente.');
    }

    public function destroy(Client $client)
    {
        $client->delete();
        
        return redirect()
            ->route('clients.index')
            ->with('success','Cliente eliminado.');
    }
}
