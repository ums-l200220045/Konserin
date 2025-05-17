@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <h2 class="text-xl font-bold mb-4">Edit Konser: {{ $concert->name }}</h2>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.update', $concert->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block">Nama Konser</label>
                <input type="text" name="name" value="{{ old('name', $concert->name) }}" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div>
                <label class="block">Tempat</label>
                <input type="text" name="venue" value="{{ old('venue', $concert->venue) }}" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div>
                <label class="block">Tanggal Mulai</label>
                <input type="datetime-local" name="start_date" value="{{ \Carbon\Carbon::parse($concert->start_date)->format('Y-m-d\TH:i') }}" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div>
                <label class="block">Tanggal Selesai</label>
                <input type="datetime-local" name="end_date" value="{{ \Carbon\Carbon::parse($concert->end_date)->format('Y-m-d\TH:i') }}" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div>
                <label class="block">Harga Tiket</label>
                <input type="number" name="price" value="{{ old('price', $concert->price) }}" class="w-full border px-3 py-2 rounded" required>
            </div>
            <div>
                <label class="block">Kuota</label>
                <input type="number" name="quota" value="{{ old('quota', $concert->quota) }}" class="w-full border px-3 py-2 rounded" required>
            </div>
        </div>

        <div class="mt-4">
            <label class="block">Deskripsi</label>
            <textarea name="description" class="w-full border px-3 py-2 rounded" rows="3">{{ old('description', $concert->description) }}</textarea>
        </div>

        <div class="mt-4">
            <label class="block mb-2">Pamflet Saat Ini:</label>
            @if ($concert->image)
                <img src="{{ asset($concert->image) }}" alt="Pamflet" class="h-32 rounded shadow mb-2">
            @else
                <p class="text-sm italic text-gray-500">Tidak ada gambar pamflet.</p>
            @endif

            <label class="block mt-2">Ganti Pamflet (opsional):</label>
            <input type="file" name="image" class="w-full border px-3 py-2 rounded" accept="image/*">
        </div>

        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Simpan Perubahan
        </button>
    </form>
</div>
@endsection
