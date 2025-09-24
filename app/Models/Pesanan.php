<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    protected $fillable = [
        'kode_pesanan', 'user_id', 'total_harga',
        'status_bayar', 'status_verifikasi', 'status_pengiriman',
        'bukti_pembayaran', 'ekspedisi_id', 'harga_pengiriman'
    ];

    // Relasi ke user (pembeli)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke detail pesanan
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    // Relasi ke ekspedisi
    public function ekspedisi()
    {
        return $this->belongsTo(Ekspedisi::class, 'ekspedisi_id');
    }

    // Relasi ke pengiriman
    public function pengiriman()
    {
        return $this->hasOne(Pengiriman::class, 'pesanan_id');
    }
}
