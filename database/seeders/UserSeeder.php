<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            // sesuaikan dengan kolom yang ada di migration tb_user kamu ya..
            'nama_lengkap' => 'Administrator', 
            'username' => 'admin',
            'password' => Hash::make('admin123'), // ini wajib pake Hash::make biar dienkripsi
            'role' => 'admin',
        ]);
    }
}
