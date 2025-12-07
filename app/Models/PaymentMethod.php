<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $table = 'payment_methods';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'payment_method_id');
    }
}