<?php

use Illuminate\Support\Facades\Route;
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
    Route::resource('employees', EmployeeController::class);
    Route::get('cambioestadoemployee', [EmployeeController::class, 'cambioestadoemployee'])->name('cambioestadoemployee');
    Route::resource('clients', ClientController::class);
    Route::get('cambioestadoclients', [ClientController::class, 'cambioestadoclients'])->name('cambioestadoclients');
    Route::resource('paymentmethods', PaymentMethodController::class);
    Route::get('cambioestadopaymentMethods', [PaymentMethodController::class, 'cambioestadopaymentMethods'])->name('cambioestadopaymentMethods');
    Route::resource('roomtypes', RoomTypeController::class);
    Route::get('cambioestadoroomtypes', [RoomTypeController::class, 'cambioestadoroomtypes'])->name('cambioestadoroomtypes');
    Route::resource('rooms', RoomController::class);
    Route::get('cambioestadorooms', [RoomController::class, 'cambioestadorooms'])->name('cambioestadorooms');
    Route::resource('registrations', RegistrationController::class);
    Route::get('cambioestadoregistrations', [RegistrationController::class, 'cambioestadoregistrations'])->name('cambioestadoregistrations');
    Route::resource('invoices', InvoiceController::class);
    Route::get('cambioestadoinvoices', [InvoiceController::class, 'cambioestadoinvoices'])->name('cambioestadoinvoices');

});


// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::resource('clients', ClientController::class);
// Route::resource('employees', EmployeeController::class);
// Route::resource('rooms', RoomController::class);
// Route::resource('registrations', RegistrationController::class);
// Route::get('cambioestadoemployee', [EmployeeController::class, 'cambioestadoemployee'])->name('cambioestadoemployee');


// Route::get('/about', function () {
// return 'Acerca de nosotros';
// });

// Route::get('/user/{id}', function ($id) {
//     return 'ID de usuario: ' . $id;
// });

// Route::get('/contacto', function () {
// return 'Página de contacto';
// })->name('contacto');

// Route::get('/user/{id}', function ($id) {
//     return 'ID de usuario: ' . $id;
// })->where('id', '[0-9]{3}');

// Route::prefix('admin')->group(function () {
//     Route::post('/', function () {
//     return 'Panel de administración';
// });
// Route::post('/users', function () {
//     return 'Lista de usuarios';
// });
// });


Route::get('/probar-404', function () {
        abort(404);
});