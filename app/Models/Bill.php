<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'tenant_id',
        'bulan',
        'tahun',
        'jumlah',
        'status', // 'lunas' atau 'belum_lunas'
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
