<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'telepon',
        'email',
        'tanggal_masuk',
        'room_id',
        'property_id',
        'catatan',
        'status',
    ];

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
