<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'kode_produk',
        'nama_produk',
        'deskripsi',
        'size',
        'satuan',
        'harga',
        'stok',
        'sisa_stok',
        'image',
        'kategori_id',
    ];

    // relasi ke kategori
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // buat kode produk otomatis
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            $lastId = static::max('id') ?? 0;
            $product->kode_produk = 'PRD-' . str_pad($lastId + 1, 4, '0', STR_PAD_LEFT);

            // kalau sisa stok kosong, otomatis sama dengan stok
            if ($product->sisa_stok === null) {
                $product->sisa_stok = $product->stok;
            }
        });
    }
    public function iklan()
{
    return $this->hasMany(Iklan::class, 'produk_id');
}

public function favorits()
{
    return $this->hasMany(Favorit::class);
}

}
