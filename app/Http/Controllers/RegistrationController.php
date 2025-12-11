<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegistrationRequest;
use App\Models\Registration;
use App\Models\Employee;
use App\Models\Room;
use App\Models\Client;
use Carbon\Carbon; // <--- Agregamos esto para usar fechas más fácil

class RegistrationController extends Controller
{
    public function index()
    {
        // Ordenamos por los más recientes primero
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
        
        // Aseguramos que al crear, checkout sea null si no se envía
        // (Aunque la base de datos ya lo permite, esto es buena práctica)
        if (!isset($data['checkoutdate'])) {
            $data['checkoutdate'] = null;
            $data['checkouttime'] = null;
        }

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

    // --- FUNCIONES DE LÓGICA DE NEGOCIO ---

    // Función para cobrar y dar salida (Checkout)
    public function checkout($id)
    {
        // 1. Buscamos el registro
        $registration = Registration::with('room')->findOrFail($id);

        // 2. Capturamos el momento actual
        $now = Carbon::now();

        // 3. Guardamos fecha y hora de salida
        $registration->checkoutdate = $now->toDateString(); 
        $registration->checkouttime = $now->toTimeString(); 

        // ❌ ELIMINAMOS ESTA LÍNEA (Causaba el error)
        // $registration->state = '0'; 

        // 4. Calcular días
        $checkin = Carbon::parse($registration->checkindate);
        $days = $checkin->diffInDays($now);
        
        if ($days == 0) {
            $days = 1;
        }

        // 5. Calcular Total
        $total = $days * $registration->room->price;
        
        // 6. Guardar (Ahora sí funcionará)
        $registration->save();

        return redirect()->back()->with('success', 'Checkout exitoso. Total a cobrar: $' . number_format($total, 0));
    }

    // Función para calcular total en la Factura (AJAX)
    public function calculateTotal($id)
    {
        $registration = Registration::with('room')->findOrFail($id);
        
        $checkin = Carbon::parse($registration->checkindate);
        
        // Usamos checkoutdate si existe, si no, usamos AHORA
        $checkout = $registration->checkoutdate 
                    ? Carbon::parse($registration->checkoutdate) 
                    : Carbon::now();
        
        $days = $checkin->diffInDays($checkout);
        
        // Mínimo 1 día de cobro
        if ($days == 0) {
            $days = 1;
        }

        $total = $days * $registration->room->price;
        
        return response()->json(['total' => $total]);
    }
    
}
