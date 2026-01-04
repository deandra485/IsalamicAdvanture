<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice Booking</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 30px;
            color: #333;
        }

        .invoice-container {
            max-width: 800px;
            margin: auto;
            background: #ffffff;
            border-radius: 8px;
            padding: 30px;
        }

        .header {
            display: table;
            width: 100%;
            margin-bottom: 25px;
        }

        .header .left,
        .header .right {
            display: table-cell;
            vertical-align: middle;
        }

        .header .right {
            text-align: right;
        }

        .header h1 {
            margin: 0;
            color: #2563eb;
            font-size: 26px;
        }

        .header p {
            margin: 4px 0 0;
            font-size: 13px;
            color: #666;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 6px 0;
            font-size: 14px;
        }

        .info strong {
            width: 140px;
            display: inline-block;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 14px;
        }

        th, td {
            border: 1px solid #e5e7eb;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        .total-box {
            margin-top: 25px;
            padding: 15px;
            background: #eff6ff;
            border-radius: 6px;
            text-align: right;
        }

        .total-box h3 {
            margin: 0 0 5px;
            font-size: 16px;
            color: #1e3a8a;
        }

        .total-box p {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
            color: #2563eb;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="invoice-container">

    <!-- HEADER -->
    <div class="header">
        <div class="left">
            <h1>Invoice Booking</h1>
            <p>Islamic Adventure</p>
        </div>
        <div class="right">
            <p><strong>Kode Booking</strong></p>
            <p>{{ $booking->booking_code }}</p>
        </div>
    </div>

    <!-- INFO -->
    <div class="info">
        <p><strong>Nama </strong>: {{ $booking->user?->name ?? '-' }}</p>
        <p><strong>Paket</strong>: {{ $booking->package?->nama_paket ?? '-' }}</p>
        <p><strong>Gunung</strong>: {{ $booking->package?->mountain?->name ?? '-' }}</p>
    </div>

    <!-- TABLE -->
    <table>
        <thead>
            <tr>
                <th>Tanggal Mulai</th>
                <th>Tanggal Selesai</th>
                <th>Durasi</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $booking->tanggal_mulai->format('d M Y') }}</td>
                <td>{{ $booking->tanggal_selesai->format('d M Y') }}</td>
                <td>{{ $booking->durasi_hari }} Hari</td>
            </tr>
        </tbody>
    </table>

    <!-- TOTAL -->
    <div class="total-box">
        <h3>Total Pembayaran</h3>
        <p>Rp {{ number_format($booking->total_biaya, 0, ',', '.') }}</p>
    </div>

    <!-- FOOTER -->
    <div class="footer">
        <p>Terima kasih telah melakukan booking bersama kami.</p>
        <p>Invoice ini dibuat secara otomatis dan sah tanpa tanda tangan.</p>
    </div>

</div>

</body>
</html>
