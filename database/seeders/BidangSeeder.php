<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bidang;

class BidangSeeder extends Seeder
{
    public function run(): void
    {
        Bidang::firstOrCreate([
            'nama' => 'IKP'
        ], [
            'deskripsi' => 'Informasi dan Komunikasi Publik',
        ]);

        Bidang::firstOrCreate([
            'nama' => 'Kesekretariatan'
        ], [
            'deskripsi' => 'Bagian administrasi umum dan surat menyurat',
        ]);

        Bidang::firstOrCreate([
            'nama' => 'Persandian'
        ], [
            'deskripsi' => 'Bidang keamanan dan enkripsi data',
        ]);

        Bidang::firstOrCreate([
            'nama' => 'E-Government'
        ], [
            'deskripsi' => 'Layanan sistem pemerintahan berbasis elektronik',
        ]);
    }
}
