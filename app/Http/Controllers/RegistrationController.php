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
    // Función para cobrar y dar salida
    public function checkout($id)
    {
        $registration = \App\Models\Registration::with('room')->findOrFail($id);

        // 1. Marcar salida hoy
        $checkout = \Carbon\Carbon::now();
        $registration->checkout_date = $checkout;

        // 2. Calcular días
        $checkin = \Carbon\Carbon::parse($registration->checkin_date);
        $days = $checkin->diffInDays($checkout);
        if ($days == 0) $days = 1; // Cobrar mínimo 1 día

        // 3. Calcular Total
        $total = $days * $registration->room->price;
        
        // Guardamos
        $registration->save();

        return redirect()->back()->with('success', 'Checkout exitoso. Total a cobrar: $' . number_format($total, 0));
    }

    // Función para la factura (Invoice)
    public function calculateTotal($id)
    {
        $registration = \App\Models\Registration::with('room')->findOrFail($id);
        
        $checkin = \Carbon\Carbon::parse($registration->checkin_date);
        $checkout = $registration->checkout_date ? \Carbon\Carbon::parse($registration->checkout_date) : \Carbon\Carbon::now();
        
        $days = $checkin->diffInDays($checkout) ?: 1;
        $total = $days * $registration->room->price;
        
        return response()->json(['total' => $total]);
    }
    
}
