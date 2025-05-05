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
            <div class="flex justify-start mb-8">
                <div class="flex items-center w-full max-w-md bg-white rounded-full overflow-hidden shadow-md">
                    <input 
                        type="text" 
                        placeholder="Search" 
                        class="w-full px-4 py-2 text-gray-800 focus:outline-none"
                    >
                    <button class="px-4 text-gray-600 hover:text-black">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <div class="bg-white rounded shadow p-4">
                    <img src="/images/image1.png" alt="Konser" class="mb-2 rounded">
                    <h3 class="font-bold text-lg">AN EVENING WITH : NEW PANBERS</h3>
                    <p class="text-sm text-gray-600">17-20 April 2025, Solo</p>
                    <p class="text-sm">Rp. 300.000</p>
                    <p class="text-sm text-green-600 font-semibold">Status: Tersedia</p>
                </div>

                <div class="bg-white rounded shadow p-4">
                <img src="/images/image 9.png" alt="Konser" class="mb-2 rounded">
                <h3 class="font-bold text-lg">Trison Point: Standing</h3>
                <p class="text-sm text-gray-600">17-20 April 2025, Solo</p>
                <p class="text-sm">Rp. 300.000</p>
                <p class="text-sm text-green-600 font-semibold">Status: Tersedia</p>
            </div>

            <div class="bg-white rounded shadow p-4">
                <img src="/images/image 8.png" alt="Konser" class="mb-2 rounded">
                <h3 class="font-bold text-lg">Trison Point: Standing</h3>
                <p class="text-sm text-gray-600">17-20 April 2025, Solo</p>
                <p class="text-sm">Rp. 300.000</p>
                <p class="text-sm text-green-600 font-semibold">Status: Tersedia</p>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
