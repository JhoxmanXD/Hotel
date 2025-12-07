<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'documentNumber',
        'address',
        'phone',
        'email',
        'state',
        'registeredBy'
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'client_id');
    }
}