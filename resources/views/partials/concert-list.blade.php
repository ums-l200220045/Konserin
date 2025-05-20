@foreach ($concerts as $concert)
    <!-- Kartu Konser -->
    <div class="bg-white rounded shadow overflow-hidden hover:shadow-md transition relative">
        <button onclick="showModal({{ $concert->id }})" class="text-left w-full">
            @if($concert->image)
                <img src="{{ asset($concert->image) }}" class="w-full h-48 object-cover">
            @endif
            <div class="p-4">
                <h2 class="font-bold text-lg">{{ $concert->name }}</h2>
                <p class="text-sm text-gray-600">
                    {{ \Carbon\Carbon::parse($concert->start_date)->format('d M') }} –
                    {{ \Carbon\Carbon::parse($concert->end_date)->format('d M Y') }},
                    {{ $concert->venue }}
                </p>
                <p class="text-sm mt-1">Rp {{ number_format($concert->price, 0, ',', '.') }}</p>
                <p class="text-sm font-semibold mt-1 text-green-600">
                    Status:
                    @switch($concert->status)
                        @case('active') Tersedia @break
                        @case('sold_out') <span class="text-red-600">Sold Out</span> @break
                        @case('ended') <span class="text-gray-500">Berakhir</span> @break
                    @endswitch
                </p>
            </div>
        </button>

        <!-- Modal -->
        <div id="modal-{{ $concert->id }}" 
            class="fixed inset-0 bg-black bg-opacity-60 z-50 hidden items-center justify-center" 
                onclick="hideModal({{ $concert->id }})">
                    
                    <div onclick="event.stopPropagation()" 
                        class="bg-white w-full max-w-3xl rounded-lg shadow-xl p-6 relative transform transition-all duration-300 scale-100">
                        
                        <!-- Tombol Tutup -->
                        <button onclick="hideModal({{ $concert->id }})" 
                                class="absolute top-3 right-4 text-gray-500 hover:text-red-600 text-2xl font-bold">
                            &times;
                        </button>

                        <div class="flex flex-col md:flex-row gap-6">
                            <div class="md:w-1/2">
                                <img src="{{ asset($concert->image) }}" class="rounded-lg w-full h-auto shadow-md">
                            </div>
                            <div class="md:w-1/2">
                                <h2 class="text-2xl font-bold mb-3">{{ $concert->name }}</h2>

                                <div class="space-y-1 text-sm text-gray-700">
                                    <p><span class="font-semibold">Tempat:</span> {{ $concert->venue }}</p>
                                    <p><span class="font-semibold">Tanggal:</span> 
                                        {{ \Carbon\Carbon::parse($concert->start_date)->format('d M Y, H:i') }} – 
                                        {{ \Carbon\Carbon::parse($concert->end_date)->format('d M Y, H:i') }}
                                    </p>
                                    <p><span class="font-semibold">Harga:</span> Rp {{ number_format($concert->price, 0, ',', '.') }}</p>
                                    <p><span class="font-semibold">Kuota:</span> {{ $concert->quota }}</p>
                                    <p><span class="font-semibold">Status:</span>
                                        @switch($concert->status)
                                            @case('active') <span class="text-green-600 font-semibold">Tersedia</span> @break
                                            @case('sold_out') <span class="text-red-600 font-semibold">Sold Out</span> @break
                                            @case('ended') <span class="text-gray-600 font-semibold">Berakhir</span> @break
                                        @endswitch
                                    </p>
                                </div>

                                <div class="mt-4">
                                    <h3 class="font-semibold mb-1">Deskripsi:</h3>
                                    <p class="text-sm text-gray-800 leading-relaxed text-justify">
                                        {{ $concert->description }}
                                    </p>
                                </div>
                                <div class="mt-6">
                                    @auth
                                        <form action="{{ route('tickets.check') }}" method="POST" onsubmit="return validateQty({{ $concert->quota }}, {{ $concert->id }})">
                                            @csrf
                                            <input type="hidden" name="concert_id" value="{{ $concert->id }}">

                                            <label class="block text-sm font-semibold mb-1">Jumlah Tiket:</label>
                                            <select name="quantity" id="qty-{{ $concert->id }}" 
                                                    class="mb-2 border rounded px-3 py-1 w-full" 
                                                    onchange="updateTotalPrice({{ $concert->id }}, {{ $concert->price }})">
                                                @for ($i = 1; $i <= min(4, $concert->quota); $i++)
                                                    <option value="{{ $i }}">{{ $i }} Tiket</option>
                                                @endfor
                                            </select>

                                            <p class="text-sm font-medium">Total Harga: 
                                                <span id="total-{{ $concert->id }}">
                                                    Rp {{ number_format($concert->price, 0, ',', '.') }}
                                                </span>
                                            </p>

                                            <button type="submit" 
                                                class="mt-2 bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-full w-full">
                                                Pesan Tiket
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" 
                                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-full block text-center">
                                            Login untuk Pesan Tiket
                                        </a>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach