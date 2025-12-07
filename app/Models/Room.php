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
        'value',
        'numpeople',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'floor' => 'integer',
        'numpeople' => 'integer',
    ];

    public function roomType()
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }
}