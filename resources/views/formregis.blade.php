@extends('layouts.app')

@section('content')
<div class="bg-[#a85454] min-h-screen flex items-center justify-center py-10 px-4">
    <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
        <h2 class="text-center text-xl font-bold mb-6 font-[cursive]">FORM REGISTRASI</h2>
        
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="name" class="block font-semibold">Nama <span class="text-red-600">*</span></label>
                <input type="text" name="name" id="name" required placeholder="Masukkan Nama"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#843737]">
            </div>

            <div>
                <label for="email" class="block font-semibold">Email <span class="text-red-600">*</span></label>
                <input type="email" name="email" id="email" required placeholder="Masukkan Email"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#843737]">
            </div>

            <div>
                <label for="phone" class="block font-semibold">No Telp <span class="text-red-600">*</span></label>
                <input type="text" name="phone" id="phone" required placeholder="No Telp"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#843737]">
            </div>

            <div>
                <label for="password" class="block font-semibold">Password <span class="text-red-600">*</span></label>
                <input type="password" name="password" id="password" required placeholder="Masukkan Password"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#843737]">
            </div>

            <div>
                <label for="password_confirmation" class="block font-semibold">Konfirmasi Password <span class="text-red-600">*</span></label>
                <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="Konfirmasi Password"
                    class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-[#843737]">
            </div>

            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-md transition duration-200">Registrasi</button>
        </form>

        <p class="text-center text-sm mt-4">
            Sudah punya akun? Silakan
            <a href="{{ route('login') }}"
                class="inline-block bg-blue-800 text-white px-3 py-1 rounded hover:bg-blue-900 ml-1">Login</a>
        </p>
    </div>
</div>
@endsection
