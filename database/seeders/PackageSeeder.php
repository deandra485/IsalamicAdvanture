<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    public function run(): void
    {
        // ==========================================
        // 1. TEMPLATE DESKRIPSI (Sesuai File PDF)
        // ==========================================
        
        // Template untuk Gunung Gede, Kerinci, Slamet, dsb.
        $descUmum = "INCLUDE:
- Transportasi Mepo - Bc (Elf/Bus) PP
- Driver, BBM, Tol, Parkir
- E-Tiket (Simaksi Pendakian)
- Homestay (Rumah singgah)
- Guide / Tour Leader
- Sweeper Kelompok
- Porter Tenda Kelompok
- Porter Logistik Kelompok
- Logistik Pendakian
- Tenda Hak Pakai sesuai kapasitas
- Tenda Toilet (kuota 15+)
- Peralatan Masak Kelompok
- Makan 2x (selama pendakian)
- Coffe Break diarea camp
- Buah buahan
- Chef Gunung
- P3K Standar
- Kursi + Meja (kuota 30+)
- Peralatan Makan dan Minum
- Break Time (sholat 5 waktu)
- Dokumentasi Bersama
- Kawan nd Family Baru

EXCLUDE:
- Perlengkapan Pribadi
- Cemilan dan Air Mineral Pribadi
- Surat Sehat
- Yang tidak ada di Include";

        // Template Khusus Gunung Ciremai
        $descCiremai = "INCLUDE:
- Ojek Pickup (PP)
- E-Ticket (Simaksi Pendakian)
- Guide / Tour Leader
- Sweeper kelompok
- Porter Tenda Kelompok
- Porter Logistik Kelompok
- Tenda Hak Pakai (sesuai kapasitas)
- Tenda Toilet (Kuota 15+)
- Peralatan Masak Kelompok
- Makan 2x (selama pendakian)
- Coffe Break di area camp
- Buah buahan
- Chef Gunung
- P3K Standar
- Kursi + Meja (kuota 30+)
- Peralatan Makan dan Minum
- Break Time (sholat 5 waktu)
- Dokumnetasi Bersama
- Kawan nd Family Baru

EXCLUDE:
- Perlengakapan Pribadi
- Cemilan dan Air Mineral pribadi
- Surat Sehat
- Yang tidak ada di Include";

        // ==========================================
        // 2. DATA PAKET
        // ==========================================
        $packages = [
            // 1. GUNUNG GEDE (ID: 1)
            ['m_id' => 1, 'name' => 'Open Trip Gede via Cibodas', 'price' => 600000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 1, 'name' => 'Open Trip Gede via Cibodas', 'price' => 700000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 1, 'name' => 'Open Trip Gede via Putri', 'price' => 550000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 1, 'name' => 'Open Trip Gede via Putri', 'price' => 650000, 'dur' => 2, 'type' => 'mjk'],

            // 2. GUNUNG PAPANDAYAN (ID: 2)
            ['m_id' => 2, 'name' => 'Open Trip Papandayan via Cisurupan', 'price' => 645000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 2, 'name' => 'Open Trip Papandayan via Cisurupan', 'price' => 450000, 'dur' => 2, 'type' => 'mjk'],

            // 3. GUNUNG CIREMAI (ID: 3)
            ['m_id' => 3, 'name' => 'Open Trip Ciremai via Apuy', 'price' => 525000, 'dur' => 2, 'type' => 'basecamp'],
            ['m_id' => 3, 'name' => 'Open Trip Ciremai via Sadarehe', 'price' => 575000, 'dur' => 2, 'type' => 'basecamp'],

            // 4. GUNUNG MERBABU (ID: 4)
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Swanting', 'price' => 850000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Swanting', 'price' => 620000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Thekelan', 'price' => 835000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Thekelan', 'price' => 600000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Wekas', 'price' => 850000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Wekas', 'price' => 600000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Selo', 'price' => 850000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 4, 'name' => 'Open Trip Merbabu via Selo', 'price' => 600000, 'dur' => 2, 'type' => 'mjk'],

            // 5. GUNUNG PRAU (ID: 5)
            ['m_id' => 5, 'name' => 'Open Trip Prau via Patak Banteng', 'price' => 700000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 5, 'name' => 'Open Trip Prau via Patak Banteng', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 5, 'name' => 'Open Trip Prau via Dwarawati', 'price' => 700000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 5, 'name' => 'Open Trip Prau via Dwarawati', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],

            // 6. GUNUNG SLAMET (ID: 6)
            ['m_id' => 6, 'name' => 'Open Trip Slamet via Permadi Guci', 'price' => 725000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 6, 'name' => 'Open Trip Slamet via Permadi Guci', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 6, 'name' => 'Open Trip Slamet via Bambangan', 'price' => 750000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 6, 'name' => 'Open Trip Slamet via Bambangan', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],

            // 7. GUNUNG SUMBING (ID: 7)
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Garung', 'price' => 725000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Garung', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Gajah Mungkur', 'price' => 739000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Gajah Mungkur', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Kaliangkrik', 'price' => 720000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 7, 'name' => 'Open Trip Sumbing via Kaliangkrik', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],

            // 8. GUNUNG SINDORO (ID: 8)
            ['m_id' => 8, 'name' => 'Open Trip Sindoro via Kledung', 'price' => 720000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 8, 'name' => 'Open Trip Sindoro via Kledung', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],
            ['m_id' => 8, 'name' => 'Open Trip Sindoro via Sigedang', 'price' => 720000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 8, 'name' => 'Open Trip Sindoro via Sigedang', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],

            // 9. GUNUNG RINJANI (ID: 9)
            ['m_id' => 9, 'name' => 'Open Trip Rinjani via Sembalun-Tore', 'price' => 2885000, 'dur' => 4, 'type' => 'jkt'],
            ['m_id' => 9, 'name' => 'Open Trip Rinjani via Sembalun-Tore', 'price' => 2625000, 'dur' => 4, 'type' => 'mjk'],
            ['m_id' => 9, 'name' => 'Open Trip Rinjani via Sembalun-Tore', 'price' => 1500000, 'dur' => 4, 'type' => 'basecamp'],

            // 10. GUNUNG CIKURAY (ID: 10)
            ['m_id' => 10, 'name' => 'Open Trip Cikuray via Tapak Gerot', 'price' => 575000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 10, 'name' => 'Open Trip Cikuray via Tapak Gerot', 'price' => 450000, 'dur' => 2, 'type' => 'mjk'],

            // 11. GUNUNG KEMBANG (ID: 11)
            ['m_id' => 11, 'name' => 'Open Trip Kembang via Lengkong', 'price' => 695000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 11, 'name' => 'Open Trip Kembang via Lengkong', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],

            // 12. GUNUNG UNGARAN (ID: 12)
            ['m_id' => 12, 'name' => 'Open Trip Ungaran via Perantunan', 'price' => 785000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 12, 'name' => 'Open Trip Ungaran via Perantunan', 'price' => 450000, 'dur' => 2, 'type' => 'mjk'],

            // 13. GUNUNG BISMO (ID: 13)
            ['m_id' => 13, 'name' => 'Open Trip Bismo via Sikunang', 'price' => 690000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 13, 'name' => 'Open Trip Bismo via Sikunang', 'price' => 475000, 'dur' => 2, 'type' => 'mjk'],

            // 14. GUNUNG LAWU (ID: 14)
            ['m_id' => 14, 'name' => 'Open Trip Lawu via Candi Cetho', 'price' => 825000, 'dur' => 2, 'type' => 'jkt'],
            ['m_id' => 14, 'name' => 'Open Trip Lawu via Candi Cetho', 'price' => 650000, 'dur' => 2, 'type' => 'mjk'],

            // 15. GUNUNG KERINCI (ID: 15)
            ['m_id' => 15, 'name' => 'Open Trip Kerinci', 'price' => 2250000, 'dur' => 4, 'type' => 'jkt'],
            ['m_id' => 15, 'name' => 'Open Trip Kerinci', 'price' => 2250000, 'dur' => 4, 'type' => 'mjk'],
        ];

        // ==========================================
        // 3. PROSES INPUT KE DATABASE
        // ==========================================
        foreach ($packages as $data) {
            $suffix = '';
            $description = '';

            // Penentuan Deskripsi berdasarkan m_id (Ciremai = id 3)
            if ($data['m_id'] == 3) {
                $description = $descCiremai;
            } else {
                $description = $descUmum;
            }

            // Penentuan Suffix Meeting Point
            if ($data['type'] == 'jkt') {
                $suffix = ' (Start Jakarta)';
            } elseif ($data['type'] == 'mjk') {
                $suffix = ' (Start Majalengka)';
            } elseif ($data['type'] == 'basecamp') {
                $suffix = ' (Start Basecamp)';
            }

            $pkg = Package::create([
                'mountain_id'   => $data['m_id'],
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