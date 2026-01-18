<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Harian - {{ \Carbon\Carbon::parse($date)->format('d M Y') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none;
            }
            body {
                background-color: white;
                -webkit-print-color-adjust: exact;
            }
            @page {
                size: A4;
                margin: 2cm;
            }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800 font-sans">

    <div class="max-w-4xl mx-auto py-6 px-8 flex justify-between items-center no-print">
        <button onclick="window.close()" class="text-gray-600 hover:text-gray-900 font-medium">
            ← Kembali
        </button>
        <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-2 rounded-lg shadow hover:bg-blue-700 font-bold flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak Dokumen
        </button>
    </div>

    <div class="max-w-4xl mx-auto bg-white p-8 shadow-lg mb-10 printable-area">
        
        <div class="border-b-2 border-gray-800 pb-6 mb-8 flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 uppercase tracking-wide">Laporan Booking</h1>
                <p class="text-gray-500 mt-1">Rekapitulasi Transaksi Harian</p>
            </div>
            <div class="text-right">
                <h2 class="text-xl font-bold text-gray-900">IslamicAdvanture</h2>
                <p class="text-sm text-gray-600">Alamat Toko Anda Disini</p>
                <p class="text-sm text-gray-600">Telp: 0812-3456-7890</p>
            </div>
        </div>

        <div class="bg-gray-50 rounded-lg p-4 mb-8 border border-gray-200 flex justify-between items-center">
            <div>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Laporan</span>
                <div class="text-lg font-bold text-gray-900">{{ \Carbon\Carbon::parse($date)->locale('id')->isoFormat('dddd, D MMMM Y') }}</div>
            </div>
            <div class="text-right">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Total Transaksi</span>
                <div class="text-lg font-bold text-gray-900">{{ $totalTransactions }} Booking</div>
            </div>
        </div>

        <div class="overflow-hidden mb-8">
            <table class="min-w-full text-left text-sm">
                <thead>
                    <tr class="bg-gray-800 text-white">
                        <th class="py-3 px-4 font-semibold uppercase text-xs rounded-l">ID</th>
                        <th class="py-3 px-4 font-semibold uppercase text-xs">Pelanggan</th>
                        <th class="py-3 px-4 font-semibold uppercase text-xs">Detail Item</th>
                        <th class="py-3 px-4 font-semibold uppercase text-xs text-center">Status</th>
                        <th class="py-3 px-4 font-semibold uppercase text-xs text-right rounded-r">Total (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 border-b border-gray-200">
                    @forelse($bookings as $booking)
                    <tr>
                        <td class="py-3 px-4 font-bold align-top">
                            #{{ $booking->id }}
                            <div class="text-xs text-gray-400 font-normal mt-1">{{ $booking->created_at->format('H:i') }}</div>
                        </td>
                        <td class="py-3 px-4 align-top">
                            <div class="font-medium text-gray-900">{{ $booking->user->name }}</div>
                            <div class="text-xs text-gray-500">{{ $booking->user->email }}</div>
                        </td>
                        <td class="py-3 px-4 text-gray-600 align-top">
                            <ul class="list-disc list-inside text-xs">
                                @foreach($booking->items->take(3) as $item)
                                    <li>{{ $item->product_name ?? 'Item #'.$item->id }}</li>
                                @endforeach
                                @if($booking->items->count() > 3)
                                    <li class="italic text-gray-400">+ {{ $booking->items->count() - 3 }} item lainnya</li>
                                @endif
                            </ul>
                            <div class="mt-1 text-xs text-indigo-600 font-medium">
                                Jadwal: {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d/m') }} ({{ $booking->durasi_hari }} hari)
                            </div>
                        </td>
                        <td class="py-3 px-4 text-center align-top">
                            <span class="inline-block px-2 py-1 text-xs font-bold rounded border 
                                {{ $booking->status_booking === 'confirmed' || $booking->status_booking === 'completed' ? 'bg-white border-green-200 text-green-700' : '' }}
                                {{ $booking->status_booking === 'pending' ? 'bg-white border-orange-200 text-orange-700' : '' }}
                                {{ $booking->status_booking === 'cancelled' ? 'bg-white border-red-200 text-red-700' : '' }}">
                                {{ ucfirst($booking->status_booking) }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right font-bold text-gray-900 align-top">
                            {{ number_format($booking->total_biaya, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500 italic">
                            Tidak ada data booking pada tanggal ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="flex justify-end mb-12">
            <div class="w-1/2 md:w-1/3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm text-gray-600">Total Transaksi Valid</span>
                    <span class="font-medium text-gray-900">{{ $bookings->where('status_booking', '!=', 'cancelled')->count() }}</span>
                </div>
                <div class="flex justify-between items-center pt-3 border-t border-gray-200">
                    <span class="text-base font-bold text-gray-800">Total Pendapatan</span>
                    <span class="text-xl font-bold text-indigo-600">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-8 text-center text-sm text-gray-600 mt-12 break-inside-avoid">
            <div>
                <p class="mb-16">Dibuat Oleh,</p>
                <div class="border-t border-gray-300 w-2/3 mx-auto pt-2">
                    <p class="font-bold text-gray-900">{{ Auth::user()->name }}</p>
                    <p class="text-xs">Admin</p>
                </div>
            </div>
            <div>
                <p class="mb-16">Mengetahui,</p>
                <div class="border-t border-gray-300 w-2/3 mx-auto pt-2">
                    <p class="font-bold text-gray-900">Manager Operasional</p>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center text-xs text-gray-400">
            Dicetak otomatis pada {{ now()->format('d/m/Y H:i') }} WIB
        </div>

    </div>

    </body>
</html>