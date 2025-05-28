<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'alamat',
        'kode_pos',
        'provinsi',
        'kota_kabupaten',
        'kecamatan',
        'kelurahan',
        'no_wa',
        'foto',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function rooms()
    {
        return $this->hasMany(Room::class);
    }
}
