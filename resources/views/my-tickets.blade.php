@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4">
    <h2 class="text-2xl font-bold mb-6">Tiket Saya</h2>

    @foreach ($tickets as $ticket)
        <div class="bg-white rounded shadow p-4 mb-4">
            <h3 class="text-lg font-semibold mb-2">{{ $ticket->concert->name }}</h3>
            <p><strong>Waktu:</strong> {{ \Carbon\Carbon::parse($ticket->concert->start_date)->format('d M Y') }}</p>
            <p><strong>Jumlah Tiket:</strong> {{ $ticket->quantity }}</p>
            <p><strong>Total Harga:</strong> Rp {{ number_format($ticket->total_price, 0, ',', '.') }}</p>
            <p><strong>Status Pembayaran:</strong>
                @if ($ticket->status === 'paid')
                    <span class="text-green-600 font-semibold">Sudah Dibayar</span>
                @else
                    <span class="text-yellow-600 font-semibold">Belum Dibayar</span>
                @endif
            </p>

            @if ($ticket->status === 'pending')
                <form action="{{ route('tickets.pay', $ticket->id) }}" method="POST" class="mt-3">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Simulasikan Pembayaran
                    </button>
                </form>
            @endif
        </div>
    @endforeach
</div>
@endsection