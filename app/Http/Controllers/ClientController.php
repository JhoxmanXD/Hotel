<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
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

    public function store(StoreClientRequest $request)
    {
        $data = $request->validated();
        $data['registeredBy'] = auth()->id();
        $client = Client::create($data);

        return redirect()
            ->route('clients.index')
            ->with('success', 'Cliente registrado correctamente.');
    }

    public function show(Client $client)
    {
        $client->load('registeredUser');
        return view('clients.show', compact('client'));
    }

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(StoreClientRequest $request, Client $client)
    {
        // Ajustar reglas únicas para update
        $rules = $request->rules();
        $rules['documentNumber'][3] = 'unique:clients,documentNumber,' . $client->id;
        $rules['email'][2] = 'unique:clients,email,' . $client->id;

        $validated = $request->validate($rules);

        $client->update($validated);

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