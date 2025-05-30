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
        'tanggal',
        'room_id',
        'harga',
    ];

    // Relasi ke Kamar (opsional)
    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
