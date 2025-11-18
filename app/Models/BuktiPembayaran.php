<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BuktiPembayaran extends Model
{
    protected $fillable = [
        'kode_order',
        'bukti_pembayaran',
        'status',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
