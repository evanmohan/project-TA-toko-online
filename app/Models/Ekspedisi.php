<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ekspedisi extends Model
{
    use HasFactory;

    protected $table = 'ekspedisi';

    protected $fillable = [
        'nama',
        'deskripsi',
    ];

    /**
     * Relasi ke tabel pengiriman
     * Satu ekspedisi bisa dipakai banyak pengiriman
     */
    public function pengiriman()
    {
        return $this->hasMany(Pengiriman::class, 'ekspedisi_id');
    }
}
