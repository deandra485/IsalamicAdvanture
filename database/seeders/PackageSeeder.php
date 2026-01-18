<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        // Template Deskripsi sesuai gambar (Bisa dipakai berulang)
        $deskripsiOpenTrip = "FASILITAS ALL INCLUDE (TERIMA BERES):
- Transportasi Elf/Bus AC (Meeting Point - Basecamp PP)
- Driver, BBM, Tips Tol/Parkir
- E-Ticket / Simaksi Pendakian
- Rumah Singgah / Homestay
- Porter Tenda & Logistik Kelompok
- Pemandu (Guide) & Sweeper Profesional
- Tenda Kapasitas 4 (Hak Pakai)
- Tenda Toilet & Flysheet
- Perlengkapan Masak (Kompor, Gas, Nesting)
- Makan 2x Selama Pendakian
- Coffee Break, Teh Manis & Buah Semangka
- Sertifikat Pendakian & P3K Standar
- Dokumentasi Foto/Video

EXCLUDE:
- Perlengkapan Pribadi (Tas, Sepatu, Jaket, Sleeping Bag)
- Cemilan Pribadi";

        $packages = [
            // ===========================
            // JAWA BARAT (Start Jakarta/Bandung)
            // ===========================
            [
                'mountain_id' => 1, // Gede
                'nama_paket' => 'Open Trip Gunung Gede Pangrango',
                'deskripsi' => $deskripsiOpenTrip,
                'harga_paket' => 350000,
                'durasi_hari' => 2,
                'max_peserta' => 15, // Open trip biasanya rame
                'include_guide' => true,
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'mountain_id' => 2, // Papandayan
                'nama_paket' => 'Open Trip Ceria Papandayan',
                'deskripsi' => $deskripsiOpenTrip,
                'harga_paket' => 325000,
                'durasi_hari' => 2,
                'max_peserta' => 15,
                'include_guide' => true,
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'mountain_id' => 3, // Ciremai
                'nama_paket' => 'Open Trip Atap Jawa Barat (Ciremai)',
                'deskripsi' => $deskripsiOpenTrip,
                'harga_paket' => 400000,
                'durasi_hari' => 2,
                'max_peserta' => 15,
                'include_guide' => true,
                'is_active' => true,
                'created_by' => 1,
            ],

            // ===========================
            // JAWA TENGAH (Start Jakarta/Jateng)
            // ===========================
            [
                'mountain_id' => 4, // Merbabu
                'nama_paket' => 'Open Trip Merbabu via Selo',
                'deskripsi' => $deskripsiOpenTrip,
                'harga_paket' => 450000,
                'durasi_hari' => 2,
                'max_peserta' => 15,
                'include_guide' => true,
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'mountain_id' => 5, // Prau
                'nama_paket' => 'Open Trip Prau Golden Sunrise',
                'deskripsi' => $deskripsiOpenTrip,
                'harga_paket' => 350000,
                'durasi_hari' => 2,
                'max_peserta' => 15,
                'include_guide' => true,
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'mountain_id' => 6, // Slamet (Sesuai Gambar)
                'nama_paket' => 'Open Trip Slamet via Permadi Guci',
                'deskripsi' => $deskripsiOpenTrip,
                'harga_paket' => 450000, // Sesuai gambar 450k
                'durasi_hari' => 2,
                'max_peserta' => 15,
                'include_guide' => true,
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'mountain_id' => 7, // Sumbing
                'nama_paket' => 'Open Trip Sumbing via Garung',
                'deskripsi' => $deskripsiOpenTrip,
                'harga_paket' => 425000,
                'durasi_hari' => 2,
                'max_peserta' => 15,
                'include_guide' => true,
                'is_active' => true,
                'created_by' => 1,
            ],
            [
                'mountain_id' => 8, // Sindoro
                'nama_paket' => 'Open Trip Sindoro via Kledung',
                'deskripsi' => $deskripsiOpenTrip,
                'harga_paket' => 425000,
                'durasi_hari' => 2,
                'max_peserta' => 15,
                'include_guide' => true,
                'is_active' => true,
                'created_by' => 1,
            ],

            // ===========================
            // LOMBOK (Khusus Rinjani harga beda)
            // ===========================
            [
                'mountain_id' => 9, // Rinjani
                'nama_paket' => 'Open Trip Rinjani Summit 4D3N',
                'deskripsi' => str_replace('Transportasi Elf/Bus AC', 'Transportasi Bandara - Sembalun PP', $deskripsiOpenTrip), // Edit dikit transportnya
                'harga_paket' => 2800000, // Harga Rinjani jauh lebih mahal
                'durasi_hari' => 4,
                'max_peserta' => 10,
                'include_guide' => true,
                'is_active' => true,
                'created_by' => 1,
            ],
        ];

        foreach ($packages as $package) {
            $pkg = Package::create($package);

            // ==========================================
            // LOGIKA PERALATAN (SESUAI GAMBAR)
            // ==========================================
            // Gambar bilang: Include Tenda, Kompor, Nesting, Gas.
            // Gambar bilang: Exclude Perlengkapan Pribadi (Sleeping Bag, Matras, Carrier).
            
            // Maka kita hanya attach alat KELOMPOK saja.
            // Pastikan ID ini sesuai tabel 'equipment' Anda:
            // 1 = Tenda
            // 6 = Kompor
            // 7 = Nesting (Contoh ID)
            // 8 = Gas (Contoh ID)

            // Menggunakan ID yang umum (sesuaikan dengan DB Anda):
            $pkg->equipment()->attach([
                1 => ['quantity' => 1], // Tenda (1 tenda utk 4 orang)
                6 => ['quantity' => 1], // Kompor (1 kompor per regu)
                // Jika Anda punya ID untuk Nesting/Gas, tambahkan disini
            ]);
        }
    }
}