@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto p-6">
        <h2 class="text-2xl font-semibold mb-4">Manajemen Konser</h2>

        {{-- Form Tambah Konser --}}
        <div class="bg-white p-4 rounded shadow mb-6">
            <h3 class="text-lg font-bold mb-2">Tambah Konser Baru</h3>
            <form method="POST" action="{{ route('concerts.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block">Nama Konser</label>
                        <input type="text" name="name" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="block">Tempat</label>
                        <input type="text" name="venue" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="block">Tanggal Mulai</label>
                        <input type="datetime-local" name="start_date" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="block">Tanggal Selesai</label>
                        <input type="datetime-local" name="end_date" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="block">Harga Tiket</label>
                        <input type="number" name="price" class="w-full border px-3 py-2 rounded" required>
                    </div>
                    <div>
                        <label class="block">Kuota</label>
                        <input type="number" name="quota" class="w-full border px-3 py-2 rounded" required>
                    </div>
                </div>
                <div class="mt-4">
                    <label class="block">Deskripsi</label>
                    <textarea name="description" class="w-full border px-3 py-2 rounded" rows="3"></textarea>
                </div>
                <div class="mt-4">
                    <label class="block">Gambar Pamflet</label>
                    <input type="file" name="image" accept="image/*" class="w-full border px-3 py-2 rounded">
                </div>
                <button type="submit" class="mt-4 bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Simpan Konser
                </button>
            </form>
        </div>

        {{-- Daftar Konser --}}
        <div class="bg-white p-4 rounded shadow">
            <h3 class="text-lg font-bold mb-2">Daftar Konser</h3>
            @if ($concerts->count())
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="py-2 px-3">Nama</th>
                            <th class="py-2 px-3">Pamflet</th>
                            <th class="py-2 px-3">Tempat</th>
                            <th class="py-2 px-3">Tanggal</th>
                            <th class="py-2 px-3">Harga</th>
                            <th class="py-2 px-3">Kuota</th>
                            <th class="py-2 px-3">Status</th>
                            <th class="py-2 px-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($concerts as $concert)
                            <tr class="border-b">
                                <td class="py-2 px-3">{{ $concert->name }}</td>
                                <td class="py-2 px-3">
                                    @if ($concert->image)
                                        <img src="{{ asset($concert->image) }}" alt="Pamflet" class="h-16 rounded shadow">
                                    @else
                                        <span class="text-gray-400 italic text-sm">Tidak ada gambar</span>
                                    @endif
                                </td>
                                <td class="py-2 px-3">{{ $concert->venue }}</td>
                                <td class="py-2 px-3">
                                    {{ \Carbon\Carbon::parse($concert->start_date)->format('d M Y, H:i') }}
                                    <br class="md:hidden" />
                                    – {{ \Carbon\Carbon::parse($concert->end_date)->format('d M Y, H:i') }}
                                </td>
                                <td class="py-2 px-3">Rp {{ number_format($concert->price, 0, ',', '.') }}</td>
                                <td class="py-2 px-3">{{ $concert->quota }}</td>
                                <td class="py-2 px-3">{{ ucfirst($concert->status) }}</td>
                                <td class="py-2 px-3">
                                    <a href="{{ route('admin.edit', $concert->id) }}" class="text-blue-500 hover:text-blue-700 hover:underline">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.destroy', $concert->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus konser ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 hover:underline ml-2">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>Tidak ada konser terdaftar.</p>
            @endif
        </div>
    </div>
@endsection