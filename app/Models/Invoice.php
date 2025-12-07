<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $primaryKey = 'id';

    protected $fillable = [
        'registration_id',
        'payment_method_id',
        'date',
        'total',
        'state',
    ];

    protected $casts = [
        'date'  => 'date',
        'total' => 'decimal:2',
        'state' => 'boolean',
    ];

    // Relación con registro (reserva / hospedaje)
    public function registration()
    {
        return $this->belongsTo(Registration::class, 'registration_id');
    }

    // Relación con método de pago
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class, 'payment_method_id');
    }
}