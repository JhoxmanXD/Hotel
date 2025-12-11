<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // INTENTO DE ARREGLO:
        // Si la columna no existe, la creamos.
        // Si existe pero se llama diferente, esto agregará la correcta 'checkout_date'.
        
        DB::statement('ALTER TABLE registrations ADD COLUMN IF NOT EXISTS checkout_date DATE NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('ALTER TABLE registrations DROP COLUMN IF EXISTS checkout_date');
    }
};
