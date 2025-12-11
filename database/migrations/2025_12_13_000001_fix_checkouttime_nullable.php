<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // COMANDO CLAVE: Alteramos la columna para quitarle la restricción NOT NULL
        DB::statement('ALTER TABLE registrations ALTER COLUMN checkouttime DROP NOT NULL');
    }

    public function down(): void
    {
        // Si quisiéramos revertir
        DB::statement('ALTER TABLE registrations ALTER COLUMN checkouttime SET NOT NULL');
    }
};
