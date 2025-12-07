<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{

    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained();
            $table->foreignId('room_id')->constrained();
            $table->foreignId('client_id')->constrained();

            // Esto es lo que necesitas:
            $table->date('checkindate');     // Guarda solo la fecha (Ej: '2025-11-13')
            $table->time('checkintime');     // Guarda solo la hora (Ej: '04:13:00')
            $table->date('checkoutdate');    // Guarda solo la fecha
            $table->time('checkouttime');    // Guarda solo la hora

            $table->timestamps(); // crea created_at y updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};