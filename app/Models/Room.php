<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'nama',
        'fasilitas',
        'gambar',
        'harga',
        'status',
    ];

    protected $casts = [
        'fasilitas' => 'array', // Mengubah JSON menjadi array saat digunakan
    ];

    public function property() {
        return $this->belongsTo(Property::class);
    }

    public function tenants()
    {
        return $this->hasMany(Tenant::class);
    }
}
