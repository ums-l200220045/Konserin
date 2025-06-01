@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-20 max-w-md bg-white shadow-xl p-8 rounded-2xl text-center relative border border-gray-200">
    <!-- Tombol Kembali -->
    <a href="{{ url()->previous() }}" class="absolute left-4 top-4 bg-gray-800 text-white rounded-full p-2 hover:bg-gray-600 transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
             stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
    </a>

    <h1 class="text-2xl font-bold mb-3 text-gray-800">Verifikasi Kode OTP</h1>
    <p class="mb-5 text-gray-600">
        Masukkan kode yang kamu terima lewat SMS ke <span class="font-medium text-black">{{ Auth::user()->phone_number }}</span>
    </p>

    @if(isset($otp_code))
        <div class="mb-5 p-3 bg-yellow-100 text-yellow-800 rounded-lg font-mono text-sm shadow-inner">
            <strong>OTP (testing):</strong> {{ $otp_code }}
        </div>
    @endif

    <!-- Notifikasi -->
    @if (session('message'))
        <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded text-sm font-medium shadow">
            {{ session('message') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 text-red-600 text-sm space-y-1">
            @foreach ($errors->all() as $error)
                <p class="bg-red-50 rounded px-3 py-1">{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Form OTP -->
    <form method="POST" action="{{ route('otp.verify.submit') }}" class="space-y-6" id="otp-form">
        @csrf
        <div class="flex justify-center gap-3 overflow-x-auto" id="otp-inputs">
            @for ($i = 0; $i < 6; $i++)
                <input 
                    type="text" 
                    maxlength="1" 
                    inputmode="numeric" 
                    pattern="[0-9]*"
                    class="otp-digit w-12 h-12 text-center text-xl rounded-lg bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500 transition"
                    required
                >
            @endfor
        </div>

        <input type="hidden" name="otp" id="otp-value">

        <!-- Resend OTP -->
        <div class="mt-4 text-sm text-gray-700">
            Tidak menerima OTP?
            <button type="button" id="resend-btn" class="text-gray-600 font-semibold hover:text-blue-600 underline transition" disabled>
                Kirim Ulang (<span id="countdown">2:00</span> Menit)
            </button>
        </div>

        <!-- Submit -->
        <button type="submit" class="bg-[#3d0b0b] hover:bg-[#590f0f] transition duration-300 text-white font-semibold w-full py-3 rounded-xl">
            Verifikasi
        </button>

        <p class="text-sm mt-4 text-gray-700">
            Kamu memiliki <span class="font-bold">3</span> kali kesempatan untuk memasukkan kode OTP.
        </p>
    </form>
</div>

<!-- Script -->
<script>
    // Gabungkan OTP dari input
    document.getElementById('otp-form').addEventListener('submit', function (e) {
        const digits = Array.from(document.querySelectorAll('.otp-digit'))
            .map(input => input.value)
            .join('');
        document.getElementById('otp-value').value = digits;
    });

    // Input hanya angka dan navigasi otomatis
    document.querySelectorAll('.otp-digit').forEach((input, idx, inputs) => {
        input.addEventListener('input', () => {
            // Filter hanya angka
            input.value = input.value.replace(/\D/, '');

            if (input.value && idx < inputs.length - 1) {
                inputs[idx + 1].focus();
            }
        });

        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && idx > 0) {
                inputs[idx - 1].focus();
            }
        });
    });

    // Countdown timer
    let timer = 120;
    const countdown = document.getElementById('countdown');
    const resendBtn = document.getElementById('resend-btn');

    const interval = setInterval(() => {
        timer--;
        const minutes = Math.floor(timer / 60);
        const seconds = timer % 60;
        countdown.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

        if (timer <= 0) {
            clearInterval(interval);
            resendBtn.disabled = false;
            resendBtn.textContent = 'Kirim Ulang';
            resendBtn.classList.add('text-blue-600', 'cursor-pointer');
            resendBtn.addEventListener('click', () => {
                resendBtn.disabled = true;
                location.href = "{{ route('otp.resend') }}";
            });
        }
    }, 1000);

    const otpInputs = document.querySelectorAll('.otp-digit');
    const form = document.getElementById('otp-form');
    const hiddenInput = document.getElementById('otp-value');

    otpInputs.forEach((input, idx, inputs) => {
        input.addEventListener('input', () => {
            input.value = input.value.replace(/[^0-9]/g, ''); // hanya angka

            // Auto focus ke input selanjutnya
            if (input.value && idx < inputs.length - 1) {
                inputs[idx + 1].focus();
            }

            // Cek jika semua input terisi
            const isComplete = [...inputs].every(input => input.value.length === 1);

            if (isComplete) {
                // Gabungkan dan submit
                const code = [...inputs].map(i => i.value).join('');
                hiddenInput.value = code;
                form.submit();
            }
        });

        // Navigasi dengan backspace
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && !input.value && idx > 0) {
                inputs[idx - 1].focus();
            }
        });
    });

</script>
@endsection
