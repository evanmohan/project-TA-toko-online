<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    protected $table = 'users';
    protected $fillable = [
        'nama',
        'email',
        'no_hp',
        'alamat',
        'username',
        'password',
        'role',
    ];
    protected $hidden = [
        'password',
    ];
}

