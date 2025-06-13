<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

     protected $fillable = [
        'nama',
        'telepon',
        'email',
        'tanggal',
        'room_id',
        'harga',
        'property_id'
    ];

    // Relasi ke Kamar (opsional)
    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
