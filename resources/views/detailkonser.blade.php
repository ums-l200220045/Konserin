@extends('layouts.app')

@section('content')
<div class="bg-[#843737] min-h-screen py-10 px-4 md:px-20">
    <div class="max-w-6xl mx-auto bg-[#d78c8c] p-6 rounded-xl shadow-md grid md:grid-cols-2 gap-8">
        
        <div>
            <div class="flex justify-center">
                <img src="/images/image 8.png" alt="Konser" class="rounded-lg mb-6">
            </div>

            <h2 class="text-white font-bold text-lg mb-2">DESKRIPSI</h2>
            <div class="text-white text-sm space-y-2">
                <p><strong>Koploin Fest</strong></p>
                <ul class="list-disc ml-5 space-y-1">
                    <li>Merupakan event tahunan di Inhu yang kali ini tidak hanya menampilkan artis koplo nasional, kali ini beberapa musik khas beberapa daerah dengan artis ternama dari setiap daerah akan ditampilkan. Seperti musik dari ide timur, Minang pride, Batak pride dan tentunya jawa pride sesuai judul event yang bertema koplo.</li>
                    <li>Tidak lupa konsep acara akan di rancang dengan unsur nasionalisme agar menumbuhkan rasa cinta dan bangga menjadi bangsa Indonesia.</li>
                </ul>
            </div>
        </div>

        {{-- Kanan: Info Tiket --}}
        <div class="bg-white rounded-lg p-6 shadow-md">
            <h3 class="text-lg font-bold mb-4">Koploin Fest</h3>
            <div class="text-sm space-y-2 mb-4">
                <p>📍 25 – 27 Apr 2025, Jakarta</p>
                <p>💸 Rp. 150.000</p>
                <p class="text-green-600 font-medium">🟢 Status: Tersedia</p>
            </div>

            <div class="bg-gray-100 p-4 rounded-lg mb-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="font-semibold">Jumlah Tiket :</span>
                    <input type="number" value="2" min="1" class="w-16 border rounded px-2 py-1 text-right" />
                </div>
                <div class="flex justify-between">
                    <span>Harga</span>
                    <span class="font-semibold">Rp. 300.000</span>
                </div>
            </div>

            <button class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700 transition">Beli Tiket</button>
        </div>
    </div>
</div>
@endsection
