<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Client;
use App\Models\Employee;
use App\Models\PaymentMethod;
use App\Models\RoomType;
use App\Models\Room;
use App\Models\Registration;
use App\Models\Invoice;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear o recuperar el usuario de prueba (evita error por duplicado)
        // User::firstOrCreate(
        //     ['email' => 'test@example.com'],
        //     [
        //         'name' => 'Test User',
        //         'password' => Hash::make('password'),
        //     ]
        // );

        // // Empleado administrador base (sencillo)
        // $admin = Employee::factory()->create([
        //     'name' => 'Administrador Principal',
        // ]);

        // // Más empleados
        Employee::factory(5)->create();

        // // Métodos de pago
        // PaymentMethod::factory(3)->create();

        // // Clientes
        Client::factory(10)->create();

        // // Tipos de habitación y habitaciones
        // RoomType::factory(4)->create();
        // Room::factory(20)->create();

        // // Registros y facturas
        // Registration::factory(8)->create();
        // Invoice::factory(15)->create();
    }
}