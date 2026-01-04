<?php

// database/seeders/EquipmentSeeder.php
namespace Database\Seeders;

use App\Models\Equipment;
use App\Models\EquipmentImage;
use Illuminate\Database\Seeder;

class EquipmentSeeder extends Seeder
{
    public function run(): void
    {
        $equipment = [
            // Tenda
            [
                'category_id' => 1,
                'nama_peralatan' => 'Tenda Kapasitas 2 Orang',
                'deskripsi' => 'Tenda dome untuk 2 orang, ringan dan mudah dipasang.',
                'merk' => 'Eiger',
                'harga_sewa_perhari' => 50000,
                'stok_tersedia' => 10,
                'kondisi' => 'baik',
                'spesifikasi' => 'Kapasitas: 2 orang, Berat: 2.5kg, Waterproof: 3000mm',
                'is_available' => true,
                'created_by' => 1,
            ],
            [
                'category_id' => 1,
                'nama_peralatan' => 'Tenda Kapasitas 4 Orang',
                'deskripsi' => 'Tenda besar untuk 4 orang dengan ruang yang luas.',
                'merk' => 'Consina',
                'harga_sewa_perhari' => 75000,
                'stok_tersedia' => 5,
                'kondisi' => 'baik',
                'spesifikasi' => 'Kapasitas: 4 orang, Berat: 4kg, Waterproof: 3000mm',
                'is_available' => true,
                'created_by' => 1,
            ],
            // Carrier
            [
                'category_id' => 2,
                'nama_peralatan' => 'Carrier 60L',
                'deskripsi' => 'Tas carrier 60 liter cocok untuk pendakian 2-3 hari.',
                'merk' => 'Deuter',
                'harga_sewa_perhari' => 35000,
                'stok_tersedia' => 15,
                'kondisi' => 'baik',
                'spesifikasi' => 'Kapasitas: 60L, Berat: 2kg, Sistem Aircontact',
                'is_available' => true,
                'created_by' => 1,
            ],
            [
                'category_id' => 2,
                'nama_peralatan' => 'Carrier 80L',
                'deskripsi' => 'Tas carrier besar 80 liter untuk pendakian panjang.',
                'merk' => 'Osprey',
                'harga_sewa_perhari' => 45000,
                'stok_tersedia' => 8,
                'kondisi' => 'baru',
                'spesifikasi' => 'Kapasitas: 80L, Berat: 2.5kg, Anti Gravity System',
                'is_available' => true,
                'created_by' => 1,
            ],
            // Sleeping Bag
            [
                'category_id' => 3,
                'nama_peralatan' => 'Sleeping Bag -5°C',
                'deskripsi' => 'Sleeping bag hangat untuk suhu dingin hingga -5°C.',
                'merk' => 'Coleman',
                'harga_sewa_perhari' => 30000,
                'stok_tersedia' => 20,
                'kondisi' => 'baik',
                'spesifikasi' => 'Temperature: -5°C, Berat: 1.5kg, Down filling',
                'is_available' => true,
                'created_by' => 1,
            ],
            // Kompor
            [
                'category_id' => 4,
                'nama_peralatan' => 'Kompor Portable + Gas',
                'deskripsi' => 'Kompor portable dengan tabung gas 230gr.',
                'merk' => 'Trangia',
                'harga_sewa_perhari' => 20000,
                'stok_tersedia' => 12,
                'kondisi' => 'baik',
                'spesifikasi' => 'Berat: 0.5kg, Konsumsi: 150gr/jam',
                'is_available' => true,
                'created_by' => 1,
            ],
            [
                'category_id' => 4,
                'nama_peralatan' => 'Nesting Cookset 4 Pcs',
                'deskripsi' => 'Set peralatan masak 4 pieces dengan tas penyimpanan.',
                'merk' => 'Naturehike',
                'harga_sewa_perhari' => 25000,
                'stok_tersedia' => 10,
                'kondisi' => 'baik',
                'spesifikasi' => 'Isi: Panci 2, Frypan 1, Tutup 1, Material: Aluminium',
                'is_available' => true,
                'created_by' => 1,
            ],
            // Jaket
            [
                'category_id' => 5,
                'nama_peralatan' => 'Jaket Gunung Waterproof',
                'deskripsi' => 'Jaket gunung waterproof dan windproof.',
                'merk' => 'The North Face',
                'harga_sewa_perhari' => 40000,
                'stok_tersedia' => 8,
                'kondisi' => 'baik',
                'spesifikasi' => 'Size: M-XL, Waterproof: 10000mm, Breathable',
                'is_available' => true,
                'created_by' => 1,
            ],
            // Sepatu
            [
                'category_id' => 6,
                'nama_peralatan' => 'Sepatu Hiking High Cut',
                'deskripsi' => 'Sepatu hiking high cut dengan ankle support.',
                'merk' => 'Salomon',
                'harga_sewa_perhari' => 35000,
                'stok_tersedia' => 6,
                'kondisi' => 'baik',
                'spesifikasi' => 'Size: 40-44, Waterproof: Gore-Tex, Vibram Sole',
                'is_available' => true,
                'created_by' => 1,
            ],
            // Lampu
            [
                'category_id' => 7,
                'nama_peralatan' => 'Headlamp LED 300 Lumens',
                'deskripsi' => 'Headlamp LED terang dengan 3 mode pencahayaan.',
                'merk' => 'Petzl',
                'harga_sewa_perhari' => 15000,
                'stok_tersedia' => 25,
                'kondisi' => 'baik',
                'spesifikasi' => 'Brightness: 300 lumens, Battery: AAA x3, Runtime: 8 jam',
                'is_available' => true,
                'created_by' => 1,
            ],
        ];

        foreach ($equipment as $item) {
            Equipment::create($item);
        }
    }
}
