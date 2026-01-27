<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        // 1. TEMPLATE DESKRIPSI
        $descJkt = "FASILITAS ALL INCLUDE (TERIMA BERES):
- Transportasi Elf/Bus AC (Jabodetabek - Basecamp PP)
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

        $descMjk = str_replace('(Jabodetabek - Basecamp PP)', '(Majalengka - Basecamp PP)', $descJkt);
        $descRinjani = str_replace('Transportasi Elf/Bus AC (Jabodetabek - Basecamp PP)', 'Transportasi Bandara Lombok - Sembalun PP', $descJkt);

        // DATA PAKET (Hanya butuh mountain_id, tanpa hiking_route_id)
        $packages = [
            // --- GUNUNG GEDE (ID: 1) ---
            ['m_id' => 1, 'name' => 'Open Trip Gede via Cibodas', 'price' => 350000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 1, 'name' => 'Open Trip Gede via Cibodas', 'price' => 375000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],
            ['m_id' => 1, 'name' => 'Open Trip Gede via Putri', 'price' => 350000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 1, 'name' => 'Open Trip Gede via Putri', 'price' => 375000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],
            ['m_id' => 1, 'name' => 'Open Trip Gede via Selabintana', 'price' => 400000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 1, 'name' => 'Open Trip Gede via Selabintana', 'price' => 425000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],

            // --- GUNUNG PAPANDAYAN (ID: 2) ---
            ['m_id' => 2, 'name' => 'Open Trip Papandayan via Camp David', 'price' => 325000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 2, 'name' => 'Open Trip Papandayan via Camp David', 'price' => 275000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],

            // --- GUNUNG CIREMAI (ID: 3) ---
            ['m_id' => 3, 'name' => 'Open Trip Ciremai via Apuy', 'price' => 400000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 3, 'name' => 'Open Trip Ciremai via Apuy', 'price' => 200000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],
            ['m_id' => 3, 'name' => 'Open Trip Ciremai via Palutungan', 'price' => 400000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 3, 'name' => 'Open Trip Ciremai via Palutungan', 'price' => 225000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],
            ['m_id' => 3, 'name' => 'Open Trip Ciremai via Linggarjati', 'price' => 450000, 'dur' => 3, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 3, 'name' => 'Open Trip Ciremai via Linggarjati', 'price' => 275000, 'dur' => 3, 'desc' => $descMjk, 'type' => 'mjk'],

            // --- GUNUNG MERBABU (ID: 4) ---
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Selo', 'price' => 450000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Selo', 'price' => 350000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Suwanting', 'price' => 450000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Suwanting', 'price' => 350000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Wekas', 'price' => 450000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Wekas', 'price' => 350000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],

            // --- GUNUNG PRAU (ID: 5) ---
            ['m_id' => 5, 'name' => 'Open Trip Prau via Patak Banteng', 'price' => 350000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 5, 'name' => 'Open Trip Prau via Patak Banteng', 'price' => 250000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],
            ['m_id' => 5, 'name' => 'Open Trip Prau via Dieng', 'price' => 350000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 5, 'name' => 'Open Trip Prau via Dieng', 'price' => 250000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],

            // --- GUNUNG SLAMET (ID: 6) ---
            ['m_id' => 6, 'name' => 'Open Trip Slamet via Bambangan', 'price' => 450000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 6, 'name' => 'Open Trip Slamet via Bambangan', 'price' => 350000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],
            ['m_id' => 6, 'name' => 'Open Trip Slamet via Permadi Guci', 'price' => 450000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 6, 'name' => 'Open Trip Slamet via Permadi Guci', 'price' => 350000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],

            // --- GUNUNG SUMBING (ID: 7) ---
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Garung', 'price' => 425000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Garung', 'price' => 325000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Kaliangkrik', 'price' => 425000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Kaliangkrik', 'price' => 325000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],

            // --- GUNUNG SINDORO (ID: 8) ---
            ['m_id' => 8, 'name' => 'Open Trip Sindoro via Kledung', 'price' => 425000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 8, 'name' => 'Open Trip Sindoro via Kledung', 'price' => 325000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],
            ['m_id' => 8, 'name' => 'Open Trip Sindoro via Alang-Alang Sewu', 'price' => 425000, 'dur' => 2, 'desc' => $descJkt, 'type' => 'jkt'],
            ['m_id' => 8, 'name' => 'Open Trip Sindoro via Alang-Alang Sewu', 'price' => 325000, 'dur' => 2, 'desc' => $descMjk, 'type' => 'mjk'],

            // --- GUNUNG RINJANI (ID: 9) ---
            ['m_id' => 9, 'name' => 'Open Trip Rinjani via Sembalun', 'price' => 3500000, 'dur' => 4, 'desc' => $descRinjani, 'type' => 'jkt'],
            ['m_id' => 9, 'name' => 'Open Trip Rinjani via Sembalun', 'price' => 2800000, 'dur' => 4, 'desc' => $descRinjani, 'type' => 'mjk'],
            ['m_id' => 9, 'name' => 'Open Trip Rinjani via Senaru', 'price' => 3500000, 'dur' => 4, 'desc' => $descRinjani, 'type' => 'jkt'],
            ['m_id' => 9, 'name' => 'Open Trip Rinjani via Senaru', 'price' => 2800000, 'dur' => 4, 'desc' => $descRinjani, 'type' => 'mjk'],
            ['m_id' => 9, 'name' => 'Open Trip Rinjani via Torean', 'price' => 3500000, 'dur' => 4, 'desc' => $descRinjani, 'type' => 'jkt'],
            ['m_id' => 9, 'name' => 'Open Trip Rinjani via Torean', 'price' => 2800000, 'dur' => 4, 'desc' => $descRinjani, 'type' => 'mjk'],
        ];

        foreach ($packages as $data) {
            $suffix = ($data['type'] == 'jkt') ? ' (Start Jabodetabek)' : ' (Start Majalengka)';

            $pkg = Package::create([
                'mountain_id'   => $data['m_id'],
                // 'hiking_route_id' KITA HAPUS
                'nama_paket'    => $data['name'] . $suffix,
                'deskripsi'     => $data['desc'],
                'harga_paket'   => $data['price'],
                'durasi_hari'   => $data['dur'],
                'max_peserta'   => 15,
                'include_guide' => true,
                'is_active'     => true,
                'created_by'    => 1,
            ]);

            // Attach Equipment
            $pkg->equipment()->attach([
                1 => ['quantity' => 1], // Tenda
                6 => ['quantity' => 1]  // Kompor
            ]);
        }
    }
}