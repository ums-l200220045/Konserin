@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-10 px-4" x-data="{ 
    openModal: false, 
    selectedTicket: null,
    closeModal() {
        this.openModal = false;
        this.selectedTicket = null;
    }
}" 
@keydown.escape="closeModal"
@click.away="closeModal">
    <h2 class="text-2xl font-bold mb-6">Tiket Saya</h2>

    @if($tickets->isEmpty())
        <div class="bg-white rounded shadow p-8 text-center">
            <p class="text-gray-500">Anda belum memiliki tiket</p>
        </div>
    @else
        @foreach ($tickets as $ticket)
            <div class="bg-white rounded-lg shadow-md p-6 mb-6 transition-all hover:shadow-lg">
                <div class="flex flex-col md:flex-row md:justify-between">
                    <div class="mb-4 md:mb-0">
                        <h3 class="text-xl font-bold text-gray-800">{{ $ticket->concert->name }}</h3>
                        <div class="mt-2 text-gray-600">
                            <p><span class="font-medium">Waktu:</span> {{ \Carbon\Carbon::parse($ticket->concert->start_date)->translatedFormat('d F Y H:i') }}</p>
                            <p><span class="font-medium">Lokasi:</span> {{ $ticket->concert->venue }}</p>
                            <p><span class="font-medium">Jumlah Tiket:</span> {{ $ticket->quantity }}</p>
                            <p><span class="font-medium">Total Harga:</span> Rp {{ number_format($ticket->total_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex flex-col items-start md:items-end">
                        <div class="mb-4">
                            <span class="px-3 py-1 rounded-full text-sm font-medium 
                                @if($ticket->status === 'paid') 
                                    bg-emerald-100 text-emerald-800 
                                @else 
                                @endif">
                                {{ $ticket->status === 'paid' ? 'Sudah Dibayar' : 'Belum Dibayar' }}
                            </span>
                        </div>
                        
                        <div class="flex gap-2">
                            @if ($ticket->status === 'pending')
                                <form action="{{ route('tickets.pay', $ticket->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition-colors">
                                        Simulasikan Pembayaran
                                    </button>
                                </form>
                            @endif

                            @if ($ticket->status === 'paid')
                                <button
                                    @click="openModal = true; selectedTicket = {{ Js::from($ticket) }}"
                                    class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                                    Lihat Tiket
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <!-- Modal Tiket -->
    <div
        x-show="openModal"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        style="display: none"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4"
    >
        <div 
            class="bg-white rounded-lg shadow-xl w-full max-w-md max-h-[90vh] overflow-y-auto"
            @click.stop
        >
            <div class="sticky top-0 bg-white p-4 border-b flex justify-between items-center">
                <h3 class="text-xl font-bold text-gray-800">Detail Tiket</h3>
                <button 
                    @click="closeModal"
                    class="text-gray-500 hover:text-gray-700 focus:outline-none"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="p-6">
                <template x-if="selectedTicket">
                    <div>
                        <div class="mb-6 text-center">
                            <h4 class="text-2xl font-bold mb-2" x-text="selectedTicket.concert.name"></h4>
                            <p class="text-gray-600" x-text="'Waktu: ' + new Date(selectedTicket.concert.start_date).toLocaleString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' })"></p>
                            <p class="text-gray-600" x-text="'Lokasi: ' + selectedTicket.concert.venue"></p>
                        </div>

                        <template x-for="detail in selectedTicket.details" :key="detail.id">
                            <div class="mb-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                                <div class="space-y-4">
                                    <div class="text-center">
                                        <p class="font-bold text-gray-500">Nama Pemegang Tiket</p>
                                        <p x-text="detail.holder_name" class="text-xl font-semibold text-gray-800"></p>
                                    </div>
                                    
                                    <div class="text-center">
                                        <p class="font-bold text-gray-500">NIK</p>
                                        <p x-text="detail.holder_nik" class="text-lg text-gray-800"></p>
                                    </div>
                                    
                                    <div class="flex flex-col items-center mt-6">
                                        <p class="font-bold text-gray-500 mb-3">QR Code Tiket</p>
                                        <div class="p-3 bg-white rounded-lg border-2 border-gray-300">
                                            <img 
                                                :src="detail.qr_code" 
                                                alt="QR Code" 
                                                class="w-48 h-48 object-contain"
                                                onerror="this.onerror=null;this.src='{{ asset('images/qr-error.png') }}'"
                                            >
                                        </div>
                                        <p class="text-sm text-gray-500 mt-3">Scan QR code ini saat masuk venue</p>
                                    </div>
                                </div>
                            </div>
                        </template>
                        
                        <div class="mt-6 pt-4 border-t text-center">
                            <p class="text-gray-500 text-sm">ID Tiket: <span class="font-medium" x-text="selectedTicket.id"></span></p>
                            <p class="text-gray-500 text-sm mt-1" x-text="'Tanggal Pemesanan: ' + new Date(selectedTicket.created_at).toLocaleString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' })"></p>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </div>
</div>
@endsection