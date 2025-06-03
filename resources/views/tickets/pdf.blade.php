<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Tiket {{ $ticket->concert->name }}</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; }
        .box { border: 1px solid #ccc; padding: 10px; margin-bottom: 20px; }
        .qr { text-align: center; margin-top: 10px; }
        .title { font-size: 18px; font-weight: bold; }
    </style>
</head>
<body>
    <h2>Tiket Konser: {{ $ticket->concert->name }}</h2>
    <p>Waktu: {{ \Carbon\Carbon::parse($ticket->concert->start_date)->translatedFormat('d F Y H:i') }}</p>
    <p>Lokasi: {{ $ticket->concert->venue }}</p>
    <p>Jumlah Tiket: {{ $ticket->quantity }}</p>
    <p>Total Harga: Rp {{ number_format($ticket->total_price, 0, ',', '.') }}</p>
    <hr>

    @foreach ($ticket->details as $detail)
        @php
            // Hilangkan leading slash jika ada, supaya path benar
            $relativePath = ltrim($detail->qr_code, '/'); // contoh: storage/qr_codes/xxx.png
            // Full path file di storage/app/public
            $qrPath = storage_path('app/public/' . str_replace('storage/', '', $relativePath));
            $qrBase64 = '';
            if (file_exists($qrPath)) {
                $qrBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($qrPath));
            }
        @endphp
        <div class="box">
            <p class="title">{{ $detail->holder_name }}</p>
            <p>NIK: {{ $detail->holder_nik }}</p>
            <div class="qr">
                @if ($qrBase64)
                    <img src="{{ $qrBase64 }}" alt="QR" width="150">
                @else
                    <p>QR code tidak ditemukan.</p>
                @endif
            </div>
        </div>
    @endforeach

    <p><small>ID Tiket: {{ $ticket->id }}</small></p>
    <p><small>Pesanan pada: {{ \Carbon\Carbon::parse($ticket->created_at)->translatedFormat('d F Y') }}</small></p>
</body>
</html>