<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori'; // sesuai nama tabel di database (bukan 'kategoris')

    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
        'deskripsi',
    ];

    // Relasi ke Produk (1 kategori punya banyak produk)
    public function produk()
    {
        return $this->hasMany(Product::class, 'kategori_id');
    }
}
