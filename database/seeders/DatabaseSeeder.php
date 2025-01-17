<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;
use App\Models\Category;
use App\Models\User;
use App\Models\Menu;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Category::create([
            'category_name' => 'makanan',
        ]);

        Category::create([
            'category_name' => 'minuman',
        ]);

        Category::create([
            'category_name' => 'snack',
        ]);

        Category::create([
            'category_name' => 'prasmanan',
        ]);

        // Tambahkan contoh user admin
        User::create([
            'nama_lengkap' => 'Admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => 'admin',
            'verify_key' => '',
            'no_tlp' => '000000000',
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
            'no_tlp' => '000000000',
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
            'no_tlp' => '000000000',
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
            'no_tlp' => '000000000',
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
            'no_tlp' => '000000000',
            'unit_kerja' => 'User Unit',
            'alamat' => 'Alamat User',
            'remember_token' => '',
        ]);

        Menu::create([
            'menu_pic' => asset('storage/menu_images/bakso-mas-roy.jpg'),
            'menu_name' => 'Bakso-example',
            'seller' => 'Seller',
            'category_id' => '1',
            'users_id' => '2',
            'menu_price' => 10000,
            'menu_desc' => 'This is the first sample Menu.',
        ]);

        Menu::create([
            'menu_pic' => asset('storage/menu_images/cincau.jpg'),
            'menu_name' => 'Cao-example',
            'seller' => 'Seller',
            'category_id' => '2',
            'users_id' => '2',
            'menu_price' => 6000,
            'menu_desc' => 'This is the second sample Menu.',
        ]);

        Menu::create([
            'menu_pic' => asset('storage/menu_images/teh.jpg'),
            'menu_name' => 'Teh-example',
            'seller' => 'Seller2',
            'category_id' => '3',
            'users_id' => '3',
            'menu_price' => 5000,
            'menu_desc' => 'This is the third sample Menu.',
        ]);

        Menu::create([
            'menu_pic' => asset('storage/menu_images/teh.jpg'),
            'menu_name' => 'Prasmanan-1-example',
            'seller' => 'Seller',
            'category_id' => '4',
            'users_id' => '2',
            'menu_price' => 40000,
            'menu_desc' => 'This is the fourth sample Menu.',
            'makanan_1' => 'Nasi Putih',
            'makanan_2' => 'Ayam Goreng',
            'makanan_3' => 'Es Jeruk',
        ]);
    }
}