<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'nama',
        'telepon',
        'alamat',
        'total_barang',
        'total_harga',
        'ongkir',
        'total_bayar',
        'metode_pengiriman',
        'metode_pembayaran',
        'kode_order',
        'status'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
