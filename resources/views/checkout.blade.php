@extends('layouts.app')

@section('content')
<div class="bg-[#843737] min-h-screen py-10 px-4 text-black">
    <div class="max-w-6xl mx-auto grid md:grid-cols-2 gap-x-10 gap-y-8 p-6 rounded-xl">

        {{-- STEP 1: DATA PEMEGANG TIKET --}}
        <div class="bg-white p-6 rounded-lg shadow mb-6"> <!-- Tambahkan mb-6 untuk margin-bottom -->
            <h2 class="font-bold mb-4 text-lg text-black">STEP 1: DATA PEMEGANG TIKET</h2>

            {{-- Tiket 1 --}}
            <div class="mb-6">
                <h3 class="bg-gray-200 p-2 rounded text-sm font-semibold mb-4">DATA TIKET 1</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block font-medium">Nama <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Masukkan Nama"
                               class="w-full border rounded-full px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block font-medium">NIK <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Masukkan NIK"
                               class="w-full border rounded-full px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block font-medium">No Telp <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="No Telp"
                               class="w-full border rounded-full px-4 py-2" required>
                    </div>
                </div>
            </div>

            {{-- Tiket 2 --}}
            <div class="mb-6">
                <h3 class="bg-gray-200 p-2 rounded text-sm font-semibold mb-4">DATA TIKET 2</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block font-medium">Nama <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Masukkan Nama"
                               class="w-full border rounded-full px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block font-medium">NIK <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="Masukkan NIK"
                               class="w-full border rounded-full px-4 py-2" required>
                    </div>
                    <div>
                        <label class="block font-medium">No Telp <span class="text-red-500">*</span></label>
                        <input type="text" placeholder="No Telp"
                               class="w-full border rounded-full px-4 py-2" required>
                    </div>
                </div>
            </div>
        </div>

        {{-- STEP 2: PEMBAYARAN --}}
        <div class="bg-white p-6 rounded-lg shadow md:pl-8">
            <h2 class="font-bold mb-4 text-lg text-black">STEP 2: PEMBAYARAN</h2>

            <div class="space-y-4">
                <h3 class="text-xl font-bold">Koploin Fest</h3>
                <div class="flex justify-between">
                    <span>Rp. 150.000</span>
                    <span>x2</span>
                </div>
                <div class="flex justify-between font-semibold text-lg border-t pt-2">
                    <span>Total Harga Tiket</span>
                    <span>Rp. 300.000</span>
                </div>

                <div class="mt-6">
                    <div class="text-center font-semibold py-2 mb-4 bg-gray-200 rounded">METODE PEMBAYARAN</div>
                    <div class="space-y-3">
                        <label class="block border py-2 rounded text-center hover:bg-gray-100 cursor-pointer">
                            <input type="radio" name="metode_pembayaran" value="Gopay" class="sr-only"> Gopay
                        </label>
                        <label class="block border py-2 rounded text-center hover:bg-gray-100 cursor-pointer">
                            <input type="radio" name="metode_pembayaran" value="ShopeePay" class="sr-only"> ShopeePay
                        </label>
                        <label class="block border py-2 rounded text-center hover:bg-gray-100 cursor-pointer">
                            <input type="radio" name="metode_pembayaran" value="Virtual Account" class="sr-only"> Virtual Account
                        </label>
                        <label class="block border py-2 rounded text-center hover:bg-gray-100 cursor-pointer">
                            <input type="radio" name="metode_pembayaran" value="Credit Card" class="sr-only"> Credit Card
                        </label>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
