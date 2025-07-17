<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
   public function run(): void
{
    $this->call([
        KategoriSeeder::class,
        BidangSeeder::class,     // Pastikan bidang dibuat sebelum barang
        BarangSeeder::class,
        UserSeeder::class,
    ]);
}


        // Menambahkan user hanya jika belum ada dengan email yang sama
        // User::firstOrCreate(
        //     ['email' => 'test@example.com'], // Kondisi pencarian berdasarkan email
        //     [
        //         'name' => 'Test User',
        //         'password' => bcrypt('password'), // Pastikan password di-hash
        //     ]
        // );
}

