<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Arreglamos la columna REAL 'checkoutdate' para que acepte nulos
        DB::statement('ALTER TABLE registrations ALTER COLUMN checkoutdate DROP NOT NULL');
    }

    public function down(): void
    {
        // Revertir (volver a ponerla obligatoria)
        DB::statement('ALTER TABLE registrations ALTER COLUMN checkoutdate SET NOT NULL');
    }
};
