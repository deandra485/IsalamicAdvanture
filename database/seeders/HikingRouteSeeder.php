<?php

namespace Database\Seeders;

use App\Models\HikingRoute;
use Illuminate\Database\Seeder;

class HikingRouteSeeder extends Seeder
{
    public function run(): void
    {
        $routes = [
            // ===========================
            // 1. GUNUNG GEDE (ID: 1)
            // ===========================
            [
                'mountain_id' => 1,
                'nama_jalur' => 'Via Cibodas',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 10.5,
                'deskripsi_jalur' => 'Jalur populer melewati Telaga Biru dan Air Terjun Cibeureum, didominasi tangga batu.',
                'is_available' => true,
            ],
            [
                'mountain_id' => 1,
                'nama_jalur' => 'Via Putri',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 8.0,
                'deskripsi_jalur' => 'Jalur lebih pendek namun terjal dengan dominasi akar pepohonan (dengkul ketemu dagu).',
                'is_available' => true,
            ],

            // ===========================
            // 2. GUNUNG PAPANDAYAN (ID: 2)
            // ===========================
            [
                'mountain_id' => 2,
                'nama_jalur' => 'Via Cisurupan',
                'tingkat_kesulitan' => 'mudah',
                'estimasi_waktu_hari' => 1,
                'jarak_km' => 6.5,
                'deskripsi_jalur' => 'Cocok untuk pemula dan wisata keluarga, melewati kawah aktif dan Hutan Mati.',
                'is_available' => true,
            ],

            // ===========================
            // 3. GUNUNG CIREMAI (ID: 3)
            // ===========================
            [
                'mountain_id' => 3,
                'nama_jalur' => 'Via Apuy',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 10.0,
                'deskripsi_jalur' => 'Jalur via Majalengka, trek terjal namun waktu tempuh relatif lebih singkat.',
                'is_available' => true,
            ],
            [
                'mountain_id' => 3,
                'nama_jalur' => 'Via Sadarehe',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 11.0,
                'deskripsi_jalur' => 'Jalur baru yang menawarkan padang savana indah dan trek yang lebih bervariasi.',
                'is_available' => true,
            ],

            // ===========================
            // 4. GUNUNG MERBABU (ID: 4)
            // ===========================
            [
                'mountain_id' => 4,
                'nama_jalur' => 'Via Swanting',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 10.0,
                'deskripsi_jalur' => 'View premium namun trek sangat menantang, butuh fisik prima karena minim sumber air.',
                'is_available' => true,
            ],
            [
                'mountain_id' => 4,
                'nama_jalur' => 'Via Thekelan',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 9.0,
                'deskripsi_jalur' => 'Jalur klasik dengan pemandangan tebing kawah yang dramatis.',
                'is_available' => true,
            ],
            [
                'mountain_id' => 4,
                'nama_jalur' => 'Via Wekas',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 8.5,
                'deskripsi_jalur' => 'Jalur tercepat mencapai pos pemancar, sumber air melimpah di Pos 2.',
                'is_available' => true,
            ],
            [
                'mountain_id' => 4,
                'nama_jalur' => 'Via Selo',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 9.5,
                'deskripsi_jalur' => 'Jalur sejuta umat, pemandangan sabana indah, landai tapi panjang.',
                'is_available' => true,
            ],

            // ===========================
            // 5. GUNUNG PRAU (ID: 5)
            // ===========================
            [
                'mountain_id' => 5,
                'nama_jalur' => 'Via Patak Banteng',
                'tingkat_kesulitan' => 'mudah',
                'estimasi_waktu_hari' => 1,
                'jarak_km' => 3.5,
                'deskripsi_jalur' => 'Jalur sangat curam tapi sangat cepat sampai puncak (2-3 jam).',
                'is_available' => true,
            ],
            [
                'mountain_id' => 5,
                'nama_jalur' => 'Via Dwarawati',
                'tingkat_kesulitan' => 'mudah',
                'estimasi_waktu_hari' => 1,
                'jarak_km' => 4.5,
                'deskripsi_jalur' => 'Jalur lebih landai dan santai, cocok untuk keluarga, start dari area Candi.',
                'is_available' => true,
            ],

            // ===========================
            // 6. GUNUNG SLAMET (ID: 6)
            // ===========================
            [
                'mountain_id' => 6,
                'nama_jalur' => 'Via Permadi Guci',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 10.5,
                'deskripsi_jalur' => 'Bonus mandi air panas Guci setelah turun, trek hutan asri.',
                'is_available' => true,
            ],
            [
                'mountain_id' => 6,
                'nama_jalur' => 'Via Bambangan',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 11.0,
                'deskripsi_jalur' => 'Gerbang utama atap Jawa Tengah, trek tanah merah licin saat hujan.',
                'is_available' => true,
            ],

            // ===========================
            // 7. GUNUNG SUMBING (ID: 7)
            // ===========================
            [
                'mountain_id' => 7,
                'nama_jalur' => 'Via Garung',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 9.0,
                'deskripsi_jalur' => 'Jalur sejuta umat, trek batu (pestisida) dan tanjakan engkol-engkolan.',
                'is_available' => true,
            ],
            [
                'mountain_id' => 7,
                'nama_jalur' => 'Via Gajah Mungkur',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 10.0,
                'deskripsi_jalur' => 'Jalur dengan view punggungan naga yang eksotis, relatif lebih sepi.',
                'is_available' => true,
            ],
            [
                'mountain_id' => 7,
                'nama_jalur' => 'Via Kaliangkrik',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 10.5,
                'deskripsi_jalur' => 'Start dari Nepal van Java, pemandangan desa dan ladang sayur sangat indah.',
                'is_available' => true,
            ],

            // ===========================
            // 8. GUNUNG SINDORO (ID: 8)
            // ===========================
            [
                'mountain_id' => 8,
                'nama_jalur' => 'Via Kledung',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 7.5,
                'deskripsi_jalur' => 'Paling populer, akses mudah di pinggir jalan raya provinsi.',
                'is_available' => true,
            ],
            [
                'mountain_id' => 8,
                'nama_jalur' => 'Via Sigedang',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 8.0,
                'deskripsi_jalur' => 'Melewati perkebunan teh Tambi, pemandangan sangat hijau dan asri.',
                'is_available' => true,
            ],

            // ===========================
            // 9. GUNUNG RINJANI (ID: 9)
            // ===========================
            [
                'mountain_id' => 9,
                'nama_jalur' => 'Via Sembalun - Torean',
                'tingkat_kesulitan' => 'sangat sulit',
                'estimasi_waktu_hari' => 4,
                'jarak_km' => 35.0,
                'deskripsi_jalur' => 'Paket lengkap: Naik via padang savana Sembalun, turun via jalur lembah sungai Torean yang eksotis.',
                'is_available' => true,
            ],

            // ===========================
            // 10. GUNUNG CIKURAY (ID: 10)
            // ===========================
            [
                'mountain_id' => 10,
                'nama_jalur' => 'Via Tapak Gerot',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 8.0,
                'deskripsi_jalur' => 'Jalur terpendek menuju puncak Cikuray, trek terus menanjak tanpa "bonus".',
                'is_available' => true,
            ],

            // ===========================
            // 11. GUNUNG KEMBANG (ID: 11)
            // ===========================
            [
                'mountain_id' => 11,
                'nama_jalur' => 'Via Lengkong',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 1,
                'jarak_km' => 5.0,
                'deskripsi_jalur' => 'Jalur favorit, terkenal bersih dan dikelola dengan sangat baik (bebas sampah).',
                'is_available' => true,
            ],

            // ===========================
            // 12. GUNUNG UNGARAN (ID: 12)
            // ===========================
            [
                'mountain_id' => 12,
                'nama_jalur' => 'Via Perantunan',
                'tingkat_kesulitan' => 'mudah',
                'estimasi_waktu_hari' => 1,
                'jarak_km' => 4.0,
                'deskripsi_jalur' => 'Jalur santai dengan fasilitas camping ground yang nyaman, cocok untuk pemula.',
                'is_available' => true,
            ],

            // ===========================
            // 13. GUNUNG BISMO (ID: 13)
            // ===========================
            [
                'mountain_id' => 13,
                'nama_jalur' => 'Via Sikunang',
                'tingkat_kesulitan' => 'mudah',
                'estimasi_waktu_hari' => 1,
                'jarak_km' => 3.0,
                'deskripsi_jalur' => 'Jalur potong kompas, waktu tempuh sangat singkat untuk mencapai puncak.',
                'is_available' => true,
            ],

            // ===========================
            // 14. GUNUNG LAWU (ID: 14)
            // ===========================
            [
                'mountain_id' => 14,
                'nama_jalur' => 'Via Candi Cetho',
                'tingkat_kesulitan' => 'sedang',
                'estimasi_waktu_hari' => 2,
                'jarak_km' => 13.0,
                'deskripsi_jalur' => 'Jalur spiritual dengan pemandangan sabana terindah (Gupakan Menjangan) di Lawu.',
                'is_available' => true,
            ],

            // ===========================
            // 15. GUNUNG KERINCI (ID: 15)
            // ===========================
            [
                'mountain_id' => 15,
                'nama_jalur' => 'Via Kersik Tuo',
                'tingkat_kesulitan' => 'sulit',
                'estimasi_waktu_hari' => 3,
                'jarak_km' => 12.0,
                'deskripsi_jalur' => 'Satu-satunya jalur resmi, melewati hutan hujan tropis lebat hingga batas vegetasi di Shelter 3.',
                'is_available' => true,
            ],
        ];

        foreach ($routes as $route) {
            HikingRoute::create($route);
        }
    }
}