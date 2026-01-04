<?php

// database/seeders/CategorySeeder.php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Tenda', 'deskripsi' => 'Berbagai jenis tenda untuk pendakian'],
            ['nama_kategori' => 'Carrier', 'deskripsi' => 'Tas carrier berbagai kapasitas'],
            ['nama_kategori' => 'Sleeping Bag', 'deskripsi' => 'Sleeping bag untuk berbagai suhu'],
            ['nama_kategori' => 'Kompor & Peralatan Masak', 'deskripsi' => 'Kompor portable dan peralatan masak'],
            ['nama_kategori' => 'Jaket & Pakaian', 'deskripsi' => 'Jaket gunung dan pakaian outdoor'],
            ['nama_kategori' => 'Sepatu', 'deskripsi' => 'Sepatu hiking dan trekking'],
            ['nama_kategori' => 'Lampu', 'deskripsi' => 'Headlamp dan senter'],
            ['nama_kategori' => 'Perlengkapan Navigasi', 'deskripsi' => 'GPS, kompas, dan peta'],
            ['nama_kategori' => 'Peralatan Safety', 'deskripsi' => 'Tali, carabiner, dan perlengkapan keselamatan'],
            ['nama_kategori' => 'Aksesoris', 'deskripsi' => 'Aksesoris pendukung lainnya'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
