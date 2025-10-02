<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'produk';

    protected $fillable = [
        'kode_produk', 
        'nama_produk', 
        'deskripsi', 
        'size', 
        'satuan', 
        'harga', 
        'stok', 
        'sisa_stok',   // perbaikan: pakai sisa_stok sesuai tabel
        'image', 
        'kategori_id'
    ];

    // Relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Relasi ke detail pesanan
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'produk_id');
    }
}
