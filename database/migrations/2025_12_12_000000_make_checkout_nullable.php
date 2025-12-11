<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Comando directo para PostgreSQL: Hacer que la columna acepte NULOS
        DB::statement('ALTER TABLE registrations ALTER COLUMN checkout_date DROP NOT NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Comando para revertir: Volver a hacerla obligatoria
        // (Solo servirá si no hay datos nulos en la tabla)
        DB::statement('ALTER TABLE registrations ALTER COLUMN checkout_date SET NOT NULL');
    }
};
