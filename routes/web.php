<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth; // Agregue esto por si acaso
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\RoomTypeController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    
    // Employees
    Route::resource('employees', EmployeeController::class);
    Route::get('cambioestadoemployee', [EmployeeController::class, 'cambioestadoemployee'])->name('cambioestadoemployee');
    
    // Clients
    Route::resource('clients', ClientController::class);
    Route::get('cambioestadoclients', [ClientController::class, 'cambioestadoclients'])->name('cambioestadoclients');
    
    // Payment Methods
    Route::resource('paymentmethods', PaymentMethodController::class);
    Route::get('cambioestadopaymentMethods', [PaymentMethodController::class, 'cambioestadopaymentMethods'])->name('cambioestadopaymentMethods');
    
    // Room Types
    Route::resource('roomtypes', RoomTypeController::class);
    Route::get('cambioestadoroomtypes', [RoomTypeController::class, 'cambioestadoroomtypes'])->name('cambioestadoroomtypes');
    
    // Rooms
    Route::resource('rooms', RoomController::class);
    Route::get('cambioestadorooms', [RoomController::class, 'cambioestadorooms'])->name('cambioestadorooms');
    
    // Registrations (Reservas)
    Route::resource('registrations', RegistrationController::class);
    Route::get('cambioestadoregistrations', [RegistrationController::class, 'cambioestadoregistrations'])->name('cambioestadoregistrations');
    
    // --- RUTAS NUEVAS DE LÓGICA DE NEGOCIO ---
    
    // 1. Calcular precio para la factura (Ya la tenías)
    Route::get('/registration/{id}/calculate', [RegistrationController::class, 'calculateTotal']);
    
    // 2. Finalizar estancia / Checkout (ESTA ES LA NUEVA)
    Route::post('/registrations/{id}/checkout', [RegistrationController::class, 'checkout'])->name('registrations.checkout');

    // Invoices (Facturas)
    Route::resource('invoices', InvoiceController::class);
    Route::get('cambioestadoinvoices', [InvoiceController::class, 'cambioestadoinvoices'])->name('cambioestadoinvoices');
});

// Ruta para probar errores 404 (Opcional)
Route::get('/probar-404', function () {
    abort(404);
});
