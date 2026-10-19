<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Package;

class PackageFasilitasSeeder extends Seeder
{
    /**
     * Mengisi kolom fasilitas & exclude untuk semua paket
     * berdasarkan data standar Open Trip IslamicAdventurer.
     */
    public function run(): void
    {
        $fasilitas = [
            'Ojek Pickup (PP)',
            'E-Ticket (Simaksi Pendakian)',
            'Guide / Tour Leader',
            'Sweeper kelompok',
            'Porter Tenda Kelompok',
            'Porter Logistik Kelompok',
            'Tenda Hak Pakai (sesuai kapasitas)',
            'Tenda Toilet (Kuota 15+)',
            'Peralatan Masak Kelompok',
            'Makan 2x (selama pendakian)',
            'Coffee Break di area camp',
            'Buah buahan',
            'Chef Gunung',
            'P3K Standar',
            'Kursi + Meja (kuota 30+)',
            'Peralatan Makan dan Minum',
            'Break Time (sholat 5 waktu)',
            'Dokumentasi Bersama',
            'Kawan nd Family Baru',
        ];

        $exclude = [
            'Perlengkapan Pribadi',
            'Cemilan dan Air Mineral pribadi',
            'Surat Sehat',
            'Yang tidak ada di Include',
        ];

        $updated = Package::whereNull('fasilitas')
            ->orWhere('fasilitas', '[]')
            ->orWhere('fasilitas', 'null')
            ->count();

        Package::query()->update([
            'fasilitas' => json_encode($fasilitas),
            'exclude'   => json_encode($exclude),
        ]);

        $this->command->info("✅ Berhasil mengisi fasilitas & exclude untuk " . Package::count() . " paket.");
        $this->command->line("   📋 Fasilitas: " . count($fasilitas) . " item");
        $this->command->line("   ❌ Exclude  : " . count($exclude) . " item");
    }
}
