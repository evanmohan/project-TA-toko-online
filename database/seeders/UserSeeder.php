<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\users;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\db;
use Illuminate\Support\Facades\hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->truncate();

        User::factory()
            ->count(5)
            ->create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
            ]);
    }
}

?>