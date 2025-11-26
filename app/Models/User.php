<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable

{
    use HasFactory, Notifiable;

    public $timestamps = false;
    protected $table = 'users';

    protected $fillable = [
        'email',
        'no_hp',
        'alamat',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    // Relasi ke pesanan (satu user bisa punya banyak pesanan)
    public function pesanan()
    {
        return $this->hasMany(Pesanan::class, 'user_id');
    }
    public function favorits()
    {
        return $this->hasMany(Favorit::class);
    }
}
