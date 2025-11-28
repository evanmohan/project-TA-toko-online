<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $table = 'keranjang';

    protected $fillable = [
        'user_id',
        'product_id',
        'variant_id',   // aman, jika tidak ada di DB, tidak masalah
        'size',         // aman
        'color',        // aman
        'image',        // aman
        'qty',
        'harga_satuan',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function getSubtotalAttribute()
    {
        return $this->qty * $this->harga_satuan;
    }
}
