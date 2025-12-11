<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table = 'rooms';
    protected $primaryKey = 'id';

    protected $fillable = [
        'room_type_id',
        'number',
        'floor',
        'value', // Tarifa real guardada en la DB
        'numpeople',
    ];

    protected $casts = [
        'value' => 'decimal:2', // Esto es genial, ayuda a que el valor sea numérico
        'floor' => 'integer',
        'numpeople' => 'integer',
    ];

    // ********************************************************
    // 🎯 ACCESOR (SOLUCIÓN FINAL para que la Factura funcione)
    // ********************************************************
    
    /**
     * Define el accesor para el atributo 'price'.
     * Cuando se llama $room->price, devuelve el valor de la tarifa ('value') limpio.
     */
    public function getPriceAttribute()
    {
        // 1. Obtener el valor crudo de la columna 'value'
        $rawPrice = $this->attributes['value'];
        
        // 2. Limpieza robusta: eliminar comas (,) y convertir a flotante.
        // Esto maneja formatos como "60,000.00" o "60000.00" o "60000"
        $cleanPrice = str_replace(',', '', (string)$rawPrice);
        
        // Retornamos el valor como un número decimal (float) listo para multiplicar.
        return (float) $cleanPrice;
    }

    // ********************************************************
    // RELACIONES
    // ********************************************************
    
    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }
}
