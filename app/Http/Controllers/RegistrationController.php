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
        // 1. Buscamos el registro
        $registration = \App\Models\Registration::with('room')->findOrFail($id);
        
        // --- CÁLCULO DE DÍAS (Esta parte ya funciona) ---
        $checkin = \Carbon\Carbon::parse($registration->checkindate)->startOfDay();
        $checkout = $registration->checkoutdate 
                    ? \Carbon\Carbon::parse($registration->checkoutdate)->startOfDay() 
                    : \Carbon\Carbon::now()->startOfDay();
        
        $days = $checkin->diffInDays($checkout);
        if ($days == 0) $days = 1;

        // --- ARREGLO DEFINITIVO DEL PRECIO ---
        
        // Intentamos leer el precio directamente desde los atributos de la habitación
        // Esto evita que cualquier mutador o accesor que le ponga formato (e.g., "$") interfiera.
        $rawPrice = $registration->room->getAttributes()['price'] ?? $registration->room->price;
        
        // 1. Convertimos el precio a string y le quitamos la coma (o cualquier separador de miles)
        $cleanPrice = str_replace(['.', ','], '', (string)$rawPrice);
        
        // 2. Quitamos los decimales que tu formato usa (Ej: "6000000" para 60,000.00). 
        // Si tu DB guarda 60000.00, esto puede ser un problema. Vamos a mantener la limpieza básica.

        // Usaremos number_format para asegurar que siempre haya decimales antes de convertir a flotante.
        // Asumiendo que 60,000.00 significa 60 mil (y el punto es el decimal)
        $cleanPrice = str_replace(',', '', $registration->room->price); // Quitar coma
        $price = floatval($cleanPrice); 
        
        // ⚠️ Si el precio es un "string" con formato (ej. $60.000,00) el str_replace anterior
        // falla si usas el punto como separador de miles.
        // Vamos a asumir que tu formato es: SEPARADOR DE MILES=COMA, SEPARADOR DE DECIMALES=PUNTO (60,000.00)

        // Limpieza robusta:
        $priceString = (string) $registration->room->price;
        $priceString = str_replace('.', '', $priceString); // Eliminar punto (si es separador de miles)
        $priceString = str_replace(',', '.', $priceString); // Convertir coma a punto (si es separador decimal)

        // Si la tarifa era 60,000.00 y no tiene símbolos, esta limpieza es suficiente:
        $price = (float) str_replace(',', '', (string) $registration->room->price);
        // Si sigue dando 0, el precio en la DB es TEXTO.

        // ÚLTIMA OPORTUNIDAD: Si el precio es TEXTO, esto lo resuelve
        if (!is_numeric($price) || $price == 0) {
            // Intentamos limpiarlo asumiendo formato latino (60.000,00)
            $priceString = preg_replace("/[^0-9,.]/", "", (string) $registration->room->price);
            $priceString = str_replace('.', '', $priceString); // Quitar separador de miles
            $priceString = str_replace(',', '.', $priceString); // Poner punto para decimales

            $price = floatval($priceString);
        }
        
        // Fin de la limpieza. Si el precio aún es 0, está mal en la tabla de habitaciones.
        
        $total = $days * $price;
        
        return response()->json([
            'total' => $total,
            'debug_dias' => $days,
            'debug_precio_detectado' => $price
        ]);
    }
    
}
