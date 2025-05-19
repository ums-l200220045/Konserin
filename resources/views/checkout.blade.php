@extends('layouts.app')

@section('content')
<form method="POST" action="{{ route('tickets.checkout') }}">
    @csrf
    <input type="hidden" name="concert_id" value="{{ $concert->id }}">
    <input type="hidden" name="quantity" value="{{ $quantity }}">

    <div class="bg-[#843737] min-h-screen py-10 px-4 text-black">
        <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-x-10 gap-y-8 p-6 rounded-xl">

            {{-- STEP 1: DATA PEMEGANG TIKET --}}
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h2 class="font-bold mb-4 text-lg text-black">STEP 1: DATA PEMEGANG TIKET</h2>

                @for ($i = 0; $i < $quantity; $i++)
                    <div class="mb-6">
                        <h3 class="bg-gray-200 p-2 rounded text-sm font-semibold mb-4">DATA TIKET {{ $i + 1 }}</h3>
                        <div class="space-y-4">
                            <div>
                                <label class="block font-medium">Nama <span class="text-red-500">*</span></label>
                                <input type="text" name="holders[{{ $i }}][name]" placeholder="Masukkan Nama"
                                    class="w-full border rounded-full px-4 py-2" required>
                            </div>
                            <div>
                                <label class="block font-medium">NIK <span class="text-red-500">*</span></label>
                                <input type="text" name="holders[{{ $i }}][nik]" placeholder="Masukkan NIK"
                                    class="w-full border rounded-full px-4 py-2" required>
                            </div>
                            <div>
                                <label class="block font-medium">No Telp <span class="text-red-500">*</span></label>
                                <input type="text" name="holders[{{ $i }}][phone]" placeholder="No Telp"
                                    class="w-full border rounded-full px-4 py-2" required>
                            </div>
                        </div>
                    </div>
                @endfor
            </div>

            {{-- STEP 2: PEMBAYARAN --}}
            <div class="bg-white p-6 rounded-lg shadow md:pl-8">
                <h2 class="font-bold mb-4 text-lg text-black">STEP 2: PEMBAYARAN</h2>

                <div class="space-y-4">
                    <h3 class="text-xl font-bold">{{ $concert->name }}</h3>
                    <div class="flex justify-between">
                        <span>Rp. {{ number_format($concert->price, 0, ',', '.') }}</span>
                        <span>x{{ $quantity }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-lg border-t pt-2">
                        <span>Total Harga Tiket</span>
                        <span>Rp. {{ number_format($concert->price * $quantity, 0, ',', '.') }}</span>
                    </div>

                    <div class="mt-6">
                        <div class="text-center font-semibold py-2 mb-4 bg-gray-200 rounded">METODE PEMBAYARAN</div>
                        <div class="space-y-3">
                            @foreach (['Gopay', 'ShopeePay', 'Virtual Account', 'Credit Card'] as $method)
                                <label class="block border py-3 px-4 rounded text-center hover:bg-gray-100 cursor-pointer">
                                    <input type="radio" name="metode_pembayaran" value="{{ $method }}" class="sr-only" required>
                                    <span class="font-medium">{{ $method }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="mt-6 text-center">
                    <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700">
                        Konfirmasi & Pesan Tiket
                    </button>
                </div>
            </div>

        </div>
    </div>
</form>
@endsection