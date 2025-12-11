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
        // 1. Buscamos el registro junto con la habitación (para saber el precio)
        $registration = \App\Models\Registration::with('room')->findOrFail($id);

        // 2. Capturamos el momento exacto de AHORA
        $now = \Carbon\Carbon::now();

        // 3. Guardamos la FECHA y la HORA de salida
        // Usamos toDateString() para que guarde solo '2025-12-11'
        // Usamos toTimeString() para que guarde solo '08:30:00'
        $registration->checkoutdate = $now->toDateString(); 
        $registration->checkouttime = $now->toTimeString(); 

        // 4. Calcular cuántos días se quedó
        $checkin = \Carbon\Carbon::parse($registration->checkindate);
        
        // Calculamos la diferencia en días entre la entrada y hoy
        $days = $checkin->diffInDays($now);
        
        // Si la diferencia es 0 (entró y salió el mismo día), cobramos 1 día
        if ($days == 0) {
            $days = 1;
        }

        // 5. Calcular el Total $$ (Días * Precio de la Habitación)
        $total = $days * $registration->room->price;
        
        // 6. Guardar los cambios en la base de datos
        $registration->save();

        // 7. Redirigir avisando cuánto cobrar
        return redirect()->back()->with('success', 'Checkout exitoso. Total a cobrar: $' . number_format($total, 0));
    }

    public function calculateTotal($id)
    {
        $registration = \App\Models\Registration::with('room')->findOrFail($id);
        
        $checkin = \Carbon\Carbon::parse($registration->checkindate);
        
        // CORRECCIÓN: 'checkoutdate'
        $checkout = $registration->checkoutdate ? \Carbon\Carbon::parse($registration->checkoutdate) : \Carbon\Carbon::now();
        
        $days = $checkin->diffInDays($checkout) ?: 1;
        $total = $days * $registration->room->price;
        
        return response()->json(['total' => $total]);
    }
    
}
