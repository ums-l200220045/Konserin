@extends('layouts.app')

@section('content')
<div class="bg-[#c57a7a] py-6">
    <div class="max-w-7xl mx-auto px-4">

        <!-- Judul -->
        <h2 class="text-center text-2xl font-bold mb-4" style="font-family: 'Pacifico', cursive;">DAFTAR KONSER !!!</h2>

        <!-- Search bar -->
        <div class="flex justify-start mb-8">
            <div class="flex items-center w-full max-w-md bg-white rounded-full overflow-hidden shadow-md">
                <input 
                    type="text" 
                    placeholder="Search" 
                    class="w-full px-4 py-2 text-gray-800 focus:outline-none"
                >
                <button class="px-4 text-gray-600 hover:text-black">
                    <!-- Icon search -->
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Grid konser -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <!-- Contoh kartu konser -->
            <div class="bg-white rounded shadow p-4">
                <img src="/images/image1.png" alt="Konser" class="mb-2 rounded">
                <h3 class="font-bold text-lg">AN EVENING WITH : NEW PANBERS</h3>
                <p class="text-sm text-gray-600">17-20 April 2025, Solo</p>
                <p class="text-sm">Rp. 300.000</p>
                <p class="text-sm text-green-600 font-semibold">Status: Tersedia</p>
            </div>

            <div class="bg-white rounded shadow p-4">
                <img src="/images/image2.png" alt="Konser" class="mb-2 rounded">
                <h3 class="font-bold text-lg">Trison Point: Standing</h3>
                <p class="text-sm text-gray-600">17-20 April 2025, Solo</p>
                <p class="text-sm">Rp. 300.000</p>
                <p class="text-sm text-green-600 font-semibold">Status: Tersedia</p>
            </div>

            <div class="bg-white rounded shadow p-4">
                <img src="/images/image3.png" alt="Konser" class="mb-2 rounded">
                <h3 class="font-bold text-lg">Trison Point: Standing</h3>
                <p class="text-sm text-gray-600">17-20 April 2025, Solo</p>
                <p class="text-sm">Rp. 300.000</p>
                <p class="text-sm text-green-600 font-semibold">Status: Tersedia</p>
            </div>

            <div class="bg-white rounded shadow p-4">
                <img src="/images/image.png" alt="Konser" class="mb-2 rounded">
                <h3 class="font-bold text-lg">Trison Point: Standing</h3>
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

            <div class="bg-white rounded shadow p-4">
                <img src="/images/pestapora.jpeg" alt="Konser" class="mb-2 rounded">
                <h3 class="font-bold text-lg">Trison Point: Standing</h3>
                <p class="text-sm text-gray-600">17-20 April 2025, Solo</p>
                <p class="text-sm">Rp. 300.000</p>
                <p class="text-sm text-green-600 font-semibold">Status: Tersedia</p>
            </div>

            <div class="bg-white rounded shadow p-4">
                <img src="/images/okaeri.jpg" alt="Konser" class="mb-2 rounded">
                <h3 class="font-bold text-lg">Trison Point: Standing</h3>
                <p class="text-sm text-gray-600">17-20 April 2025, Solo</p>
                <p class="text-sm">Rp. 300.000</p>
                <p class="text-sm text-green-600 font-semibold">Status: Tersedia</p>
            </div>

            <div class="bg-white rounded shadow p-4">
                <img src="https://via.placeholder.com/300x150" alt="Konser" class="mb-2 rounded">
                <h3 class="font-bold text-lg">Trison Point: Standing</h3>
                <p class="text-sm text-gray-600">17-20 April 2025, Solo</p>
                <p class="text-sm">Rp. 300.000</p>
                <p class="text-sm text-green-600 font-semibold">Status: Tersedia</p>
            </div>

            <!-- Tambahkan konser lainnya sesuai kebutuhan -->
        </div>
    </div>
</div>
@endsection
