<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\Room; // Descomenta si quieres importar explícitamente

class RoomType extends Model
{
    use HasFactory;

    protected $table = 'room_types';
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'description',
    ];

    public function rooms()
    {
        // Asumiendo foreign key room_type_id en rooms
        return $this->hasMany(Room::class, 'room_type_id');
    }
}