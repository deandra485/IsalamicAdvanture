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
        $descBasecamp = str_replace('Transportasi Elf/Bus AC (Jabodetabek - Basecamp PP)', 'Meeting Point di Basecamp', $descJkt);
        $descRinjani = str_replace('Transportasi Elf/Bus AC (Jabodetabek - Basecamp PP)', 'Transportasi Bandara Lombok - Sembalun PP', $descJkt);

        // DATA PAKET
        // type: 'jkt', 'mjk', 'basecamp'
        $packages = [
            // ===========================
            // 1. GUNUNG GEDE (ID: 1)
            // ===========================
            ['m_id' => 1, 'name' => 'Open Trip Gede via Cibodas', 'price' => 600000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 1, 'name' => 'Open Trip Gede via Cibodas', 'price' => 700000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 1, 'name' => 'Open Trip Gede via Putri', 'price' => 550000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 1, 'name' => 'Open Trip Gede via Putri', 'price' => 650000, 'dur' => 2, 'type' => 'mjk'],

            // ===========================
            // 2. GUNUNG PAPANDAYAN (ID: 2)
            // ===========================
            ['m_id' => 2, 'name' => 'Open Trip Papandayan via Cisurupan', 'price' => 645000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 2, 'name' => 'Open Trip Papandayan via Cisurupan', 'price' => 450000, 'dur' => 2, 'type' => 'mjk'],

            // ===========================
            // 3. GUNUNG CIREMAI (ID: 3)
            // ===========================
            // Ciremai di list hanya ada harga Basecamp/Gunung yang D
            ['m_id' => 3, 'name' => 'Open Trip Ciremai via Apuy', 'price' => 525000, 'dur' => 2, 'type' => 'basecamp'],
            ['m_id' => 3, 'name' => 'Open Trip Ciremai via Sadarehe', 'price' => 575000, 'dur' => 2, 'type' => 'basecamp'],

            // ===========================
            // 4. GUNUNG MERBABU (ID: 4)
            // ===========================
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Swanting', 'price' => 850000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Swanting', 'price' => 620000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Thekelan', 'price' => 835000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Thekelan', 'price' => 600000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Wekas', 'price' => 850000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Wekas', 'price' => 600000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Selo', 'price' => 850000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Selo', 'price' => 600000, 'dur' => 2, 'type' => 'mjk'],

            // ===========================
            // 5. GUNUNG PRAU (ID: 5)
            // ===========================
            ['m_id' => 5, 'name' => 'Open Trip Prau via Patak Banteng', 'price' => 700000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 5, 'name' => 'Open Trip Prau via Patak Banteng', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 5, 'name' => 'Open Trip Prau via Dwarawati', 'price' => 700000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 5, 'name' => 'Open Trip Prau via Dwarawati', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],

            // ===========================
            // 6. GUNUNG SLAMET (ID: 6)
            // ===========================
            ['m_id' => 6, 'name' => 'Open Trip Slamet via Permadi Guci', 'price' => 725000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 6, 'name' => 'Open Trip Slamet via Permadi Guci', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 6, 'name' => 'Open Trip Slamet via Bambangan', 'price' => 750000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 6, 'name' => 'Open Trip Slamet via Bambangan', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],

            // ===========================
            // 7. GUNUNG SUMBING (ID: 7)
            // ===========================
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Garung', 'price' => 725000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Garung', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Gajah Mungkur', 'price' => 739000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Gajah Mungkur', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Kaliangkrik', 'price' => 720000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Kaliangkrik', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],

            // ===========================
            // 8. GUNUNG SINDORO (ID: 8)
            // ===========================
            ['m_id' => 8, 'name' => 'Open Trip Sindoro via Kledung', 'price' => 720000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 8, 'name' => 'Open Trip Sindoro via Kledung', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 8, 'name' => 'Open Trip Sindoro via Sigedang', 'price' => 720000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 8, 'name' => 'Open Trip Sindoro via Sigedang', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],

            // ===========================
            // 9. GUNUNG RINJANI (ID: 9)
            // ===========================
            ['m_id' => 9, 'name' => 'Open Trip Rinjani via Sembalun-Tore', 'price' => 2885000, 'dur' => 4, 'type' => 'jkt'],
            ['m_id' => 9, 'name' => 'Open Trip Rinjani via Sembalun-Tore', 'price' => 2625000, 'dur' => 4, 'type' => 'mjk'],
            ['m_id' => 9, 'name' => 'Open Trip Rinjani via Sembalun-Tore', 'price' => 1500000, 'dur' => 4, 'type' => 'basecamp'],

            // ===========================
            // 10. GUNUNG CIKURAY (ID: 10)
            // ===========================
            ['m_id' => 10, 'name' => 'Open Trip Cikuray via Tapak Gerot', 'price' => 575000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 10, 'name' => 'Open Trip Cikuray via Tapak Gerot', 'price' => 450000, 'dur' => 2, 'type' => 'mjk'],

            // ===========================
            // 11. GUNUNG KEMBANG (ID: 11)
            // ===========================
            ['m_id' => 11, 'name' => 'Open Trip Kembang via Lengkong', 'price' => 695000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 11, 'name' => 'Open Trip Kembang via Lengkong', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],

            // ===========================
            // 12. GUNUNG UNGARAN (ID: 12)
            // ===========================
            ['m_id' => 12, 'name' => 'Open Trip Ungaran via Perantunan', 'price' => 785000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 12, 'name' => 'Open Trip Ungaran via Perantunan', 'price' => 450000, 'dur' => 2, 'type' => 'mjk'],

            // ===========================
            // 13. GUNUNG BISMO (ID: 13)
            // ===========================
            ['m_id' => 13, 'name' => 'Open Trip Bismo via Sikunang', 'price' => 690000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 13, 'name' => 'Open Trip Bismo via Sikunang', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],

            // ===========================
            // 14. GUNUNG LAWU (ID: 14)
            // ===========================
            ['m_id' => 14, 'name' => 'Open Trip Lawu via Candi Cetho', 'price' => 825000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 14, 'name' => 'Open Trip Lawu via Candi Cetho', 'price' => 650000, 'dur' => 2, 'type' => 'mjk'],

            // ===========================
            // 15. GUNUNG KERINCI (ID: 15)
            // ===========================
            ['m_id' => 15, 'name' => 'Open Trip Kerinci', 'price' => 2250000, 'dur' => 4, 'type' => 'jkt'],
            ['m_id' => 15, 'name' => 'Open Trip Kerinci', 'price' => 2250000, 'dur' => 4, 'type' => 'mjk'],
        ];

        foreach ($packages as $data) {
            $suffix = '';
            $description = '';

            if ($data['type'] == 'jkt') {
                $suffix = ' (Start Jakarta)';
                $description = ($data['m_id'] == 9) ? $descRinjani : $descJkt; // Cek Rinjani
            } elseif ($data['type'] == 'mjk') {
                $suffix = ' (Start Bc. Islamic)';
                $description = ($data['m_id'] == 9) ? $descRinjani : $descMjk;
            } elseif ($data['type'] == 'basecamp') {
                $suffix = ' (Start Basecamp)';
                $description = $descBasecamp;
            }

            $pkg = Package::create([
                'mountain_id'   => $data['m_id'],
                // 'hiking_route_id' KITA HAPUS
                'nama_paket'    => $data['name'] . $suffix,
                'deskripsi'     => $description,
                'harga_paket'   => $data['price'],
                'durasi_hari'   => $data['dur'],
                'max_peserta'   => 15,
                'include_guide' => true,
                'is_active'     => true,
                'created_by'    => 1,
            ]);

            // Attach Equipment (Default 1 Tenda, 1 Kompor per paket)
            $pkg->equipment()->attach([
                1 => ['quantity' => 1], // Tenda
                6 => ['quantity' => 1]  // Kompor
            ]);
        }
    }
}