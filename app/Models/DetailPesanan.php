<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanan';

    // sesuai field di database
    protected $fillable = [
        'pesanan_id',
        'produk_id',
        'kuantiti',
        'satuan',
        'harga',
        'total_harga',
    ];

    // Relasi ke Pesanan
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    // Relasi ke Produk
    public function produk()
    {
        return $this->belongsTo(Product::class, 'produk_id');
    }
}
