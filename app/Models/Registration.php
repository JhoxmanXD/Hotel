<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $table = 'registrations';
    protected $primaryKey = 'id';

    protected $fillable = [
        'employee_id',
        'room_id',
        'client_id',
        'checkindate',
        'checkoutdate',
        'checkintime',
        'checkouttime',
    ];

    protected $casts = [
        'checkindate'  => 'date',
        'checkoutdate' => 'date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id');
    }

    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }

    public function getCheckinAtAttribute(): ?string
    {
        if (!$this->checkindate || !$this->checkintime) return null;
        return $this->checkindate->format('Y-m-d') . ' ' . $this->checkintime;
    }

    public function getCheckoutAtAttribute(): ?string
    {
        if (!$this->checkoutdate || !$this->checkouttime) return null;
        return $this->checkoutdate->format('Y-m-d') . ' ' . $this->checkouttime;
    }
}