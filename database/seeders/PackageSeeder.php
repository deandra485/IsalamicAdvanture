<?php

// database/seeders/PackageSeeder.php
namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        $packages = [
            [
                'mountain_id' => 4, // Gunung Prau
                'nama_paket' => 'Paket Pemula Gunung Prau',
                'deskripsi' => 'Paket lengkap untuk pemula termasuk semua peralatan dasar.',
                'harga_paket' => 250000,
                'durasi_hari' => 2,
                'max_peserta' => 4,
                'include_guide' => true,
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'mountain_id' => 3, // Gunung Merbabu
                'nama_paket' => 'Paket Merbabu 2D1N',
                'deskripsi' => 'Paket hemat untuk pendakian Merbabu 2 hari 1 malam.',
                'harga_paket' => 350000,
                'durasi_hari' => 2,
                'max_peserta' => 6,
                'include_guide' => false,
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'mountain_id' => 1, // Gunung Semeru
                'nama_paket' => 'Paket Semeru Adventure',
                'deskripsi' => 'Paket lengkap pendakian Semeru dengan guide berpengalaman.',
                'harga_paket' => 850000,
                'durasi_hari' => 4,
                'max_peserta' => 6,
                'include_guide' => true,
                'is_active' => true,
                'created_by' => 1,
            ],
        ];

        foreach ($packages as $package) {
            $pkg = Package::create($package);
            
            // Add equipment to package
            if ($pkg->mountain_id == 4) {
                $pkg->equipment()->attach([
                    1 => ['quantity' => 2], // Tenda
                    3 => ['quantity' => 4], // Carrier
                    5 => ['quantity' => 4], // Sleeping bag
                    6 => ['quantity' => 1], // Kompor
                    10 => ['quantity' => 4], // Headlamp
                ]);
            }
        }
    }
}
