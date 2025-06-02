@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow-lg mt-12">
    <h2 class="text-3xl font-semibold text-gray-800 mb-8 text-center">Tambah User Baru</h2>

    <form action="{{ route('superadmin.users.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="block text-gray-700 font-medium mb-2">Nama</label>
            <input 
                type="text" 
                name="name" 
                id="name" 
                value="{{ old('name') }}" 
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required>
            @error('name') 
                <small class="text-red-600 mt-1 block">{{ $message }}</small> 
            @enderror
        </div>

        <div>
            <label for="email" class="block text-gray-700 font-medium mb-2">Email</label>
            <input 
                type="email" 
                name="email" 
                id="email" 
                value="{{ old('email') }}" 
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required>
            @error('email') 
                <small class="text-red-600 mt-1 block">{{ $message }}</small> 
            @enderror
        </div>

        <div>
            <label for="phone_number" class="block text-gray-700 font-medium mb-2">Nomor HP</label>
            <input 
                type="text" 
                name="phone_number" 
                id="phone_number" 
                value="{{ old('phone_number') }}" 
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required>
            @error('phone_number') 
                <small class="text-red-600 mt-1 block">{{ $message }}</small> 
            @enderror
        </div>

        <div>
            <label for="password" class="block text-gray-700 font-medium mb-2">Password</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required>
            @error('password') 
                <small class="text-red-600 mt-1 block">{{ $message }}</small> 
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Konfirmasi Password</label>
            <input 
                type="password" 
                name="password_confirmation" 
                id="password_confirmation" 
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required>
        </div>

        <div>
            <label for="role" class="block text-gray-700 font-medium mb-2">Role</label>
            <select 
                name="role" 
                id="role" 
                class="w-full border border-gray-300 rounded-md px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                required>
                <option value="" disabled selected>Pilih Role</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
            </select>
            @error('role') 
                <small class="text-red-600 mt-1 block">{{ $message }}</small> 
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" 
                class="bg-blue-600 hover:bg-blue-700 transition text-white font-semibold px-6 py-3 rounded-md shadow">
                Simpan
            </button>
            <a href="{{ route('superadmin.users.index') }}" 
                class="text-gray-600 underline hover:text-gray-800 transition ml-4">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection