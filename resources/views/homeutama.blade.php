@extends('layouts.app')

@section('content')
<div class="bg-[#843737] min-h-screen py-10 px-4 md:px-20">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow-lg text-center">
        <h2 class="text-2xl font-bold mb-4 border-b border-black w-max mx-auto" style="font-family: 'Pacifico', cursive;">DESKRIPSI</h2>
        <p class="text-black text-justify leading-relaxed">
            KONSER'IN adalah sebuah platform digital berbasis web yang dirancang untuk mempermudah pengguna dalam melakukan pemesanan tiket konser secara online. 
            Dengan antarmuka yang user-friendly dan proses pemesanan yang cepat, pengguna dapat mendaftar, memilih konser, mengisi data identitas, 
            melakukan pembayaran, dan mendapatkan e-ticket hanya dalam beberapa langkah.
        </p>
        <div class="mt-6">
            <a href="{{ url('/daftar') }}" class="bg-[#3d0b0b] text-white px-6 py-2 rounded-full shadow-md hover:bg-[#590f0f] transition duration-300">
                LIHAT SEMUA KONSER
            </a>
        </div>
    </div>

    <div id="daftar-konser" class="bg-[#c57a7a] py-6 mt-8">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-center text-2xl font-bold mb-4" style="font-family: 'Pacifico', cursive;">KONSER YANG SEDANG TRENDING !!!</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                @forelse($trendingConcerts as $concert)
                <div class="bg-white rounded shadow p-4 hover:shadow-lg transition-shadow">
                    <div class="h-48 overflow-hidden mb-2 rounded-lg shadow-md">
                        <img src="{{ asset($concert->image) }}" 
                            class="w-full h-full object-cover" 
                            alt="{{ $concert->name }}"
                            onerror="this.onerror=null;this.src='{{ asset('images/default-concert.jpg') }}'">
                    </div>
                    <h3 class="font-bold text-lg">{{ $concert->name }}</h3>
                    <p class="text-sm text-gray-600">
                        {{ \Carbon\Carbon::parse($concert->start_date)->translatedFormat('j F Y') }}, 
                        {{ $concert->venue }}
                    </p>
                    <p class="text-sm">Rp. {{ number_format($concert->price, 0, ',', '.') }}</p>
                    <p class="text-sm font-semibold @if($concert->quota > 0) text-green-600 @else @endif">
                        Status: {{ $concert->quota > 0 ? 'Tersedia' : 'Sold Out' }}
                    </p>
                    <div class="mt-2 text-xs text-gray-500">
                        {{ $concert->tickets_count }} tiket terjual
                    </div>
                    <a href="{{ route('concerts.list', $concert->id) }}" class="mt-3 inline-block bg-[#3d0b0b] text-white px-4 py-1 rounded-full text-sm hover:bg-[#590f0f] transition">
                        Detail
                    </a>
                </div>
                @empty
                <div class="col-span-3 text-center py-8">
                    <p class="text-gray-600">Belum ada konser trending saat ini</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection