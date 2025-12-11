<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Registration;
use App\Models\Employee;
use App\Models\Room;
use App\Models\Client;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::with(['client','room','employee'])
            ->latest()
            ->paginate(15);

        return view('registrations.index', compact('registrations'));
    }

    public function create()
    {
        $employees = Employee::orderBy('name')->get();
        $rooms     = Room::with('roomType')->orderBy('number')->get();
        $clients   = Client::orderBy('name')->get();

        return view('registrations.create', compact('employees','rooms','clients'));
    }

    public function store(RegistrationRequest $request)
    {
        $data = $request->validated();
        Registration::create($data);

        return redirect()
            ->route('registrations.index')
            ->with('success', 'Registro de hospedaje creado correctamente.');
    }

    public function show(Registration $registration)
    {
        $registration->load(['client','room.roomType','employee']);
        return view('registrations.show', compact('registration'));
    }

    public function edit(Registration $registration)
    {
        $employees = Employee::orderBy('name')->get();
        $rooms     = Room::with('roomType')->orderBy('number')->get();
        $clients   = Client::orderBy('name')->get();

        return view('registrations.edit', compact('registration','employees','rooms','clients'));
    }

    public function update(RegistrationRequest $request, Registration $registration)
    {
        $data = $request->validated();
        $registration->update($data);

        return redirect()
            ->route('registrations.index')
            ->with('success','Registro de hospedaje actualizado correctamente.');
    }

    public function destroy(Registration $registration)
    {
        $registration->delete();

        return redirect()
            ->route('registrations.index')
            ->with('success','Registro de hospedaje eliminado.');
    }
    public function calculateTotal($id)
    {
        $registration = \App\Models\Registration::with('room')->findOrFail($id);
        
        // Usamos Carbon para manejar fechas
        $checkin = \Carbon\Carbon::parse($registration->checkin_date);
        // Si no ha salido, cobramos hasta hoy. Si ya salió, usamos la fecha de salida.
        $checkout = $registration->checkout_date ? \Carbon\Carbon::parse($registration->checkout_date) : \Carbon\Carbon::now();
        
        // Calcular días (Mínimo 1 día si entró y sale hoy mismo)
        $days = $checkin->diffInDays($checkout) ?: 1;
        
        // Calcular total
        $total = $days * $registration->room->price; // Asegúrate que tu modelo Room tenga columna 'price'
        
        return response()->json(['total' => $total]);
    }
    
}
