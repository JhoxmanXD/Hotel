<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Comando para AGREGAR la columna si no existe
        DB::statement('ALTER TABLE registrations ADD COLUMN IF NOT EXISTS checkout_date DATE NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE registrations DROP COLUMN IF EXISTS checkout_date');
    }
};
