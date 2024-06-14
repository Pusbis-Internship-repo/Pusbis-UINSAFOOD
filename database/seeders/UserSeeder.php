<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Tambahkan contoh user admin
        User::create([
            'nama_lengkap' => 'Admin',
            'email' => 'adminfood@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'verify_key' => '',
            'no_tlp' => '123456789',
            'unit_kerja' => 'Admin Unit',
            'alamat' => 'Alamat Admin',
            'remember_token' => '',
        ]);

        // Tambahkan contoh user seller
        User::create([
            'nama_lengkap' => 'Seller',
            'email' => 'seller@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'seller',
            'verify_key' => '',
            'no_tlp' => '987654321',
            'unit_kerja' => 'Seller Unit',
            'alamat' => 'Alamat Seller',
            'remember_token' => '',
        ]);
        User::create([
            'nama_lengkap' => 'Seller2',
            'email' => 'seller2@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'seller',
            'verify_key' => '',
            'no_tlp' => '987654321',
            'unit_kerja' => 'Seller Unit',
            'alamat' => 'Alamat Seller',
            'remember_token' => '',
        ]);
        

        // Tambahkan contoh user regular
        User::create([
            'nama_lengkap' => 'User',
            'email' => 'user@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'user',
            'verify_key' => '',
            'no_tlp' => '111222333',
            'unit_kerja' => 'User Unit',
            'alamat' => 'Alamat User',
            'remember_token' => '',
        ]);
        User::create([
            'nama_lengkap' => 'User2',
            'email' => 'user2@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'user',
            'verify_key' => '',
            'no_tlp' => '111222333',
            'unit_kerja' => 'User Unit',
            'alamat' => 'Alamat User',
            'remember_token' => '',
        ]);

        // Tambahkan lebih banyak pengguna sesuai kebutuhan Anda
    }
}
