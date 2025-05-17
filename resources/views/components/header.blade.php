<header class="bg-[#2b1c1c] text-white shadow-md">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <img src="/images/logo konserin4.png" alt="logo" class="h-12 w-12">
            <h1 class="text-xl font-bold">KONSER'IN</h1>
        </div>

        <nav class="space-x-6 hidden md:block">
            @auth
                @php
                    $role = Auth::user()->role;
                @endphp

                @if ($role === 'super_admin' || $role === 'admin')
                    <a href="/dashboard" class="hover:underline">DASHBOARD</a>
                @elseif ($role === 'user')
                    <a href="/" class="hover:underline">BERANDA</a>
                    <a href="/daftar" class="hover:underline">KONSER</a>
                    <a href="/co" class="hover:underline">PESANAN</a>
                    <a href="#footer" class="hover:underline">BANTUAN</a>
                @endif

                <!-- Dropdown User Info -->
                <div class="relative inline-block">
                    <button onclick="toggleDropdown()" class="bg-gray-300 text-gray-800 hover:bg-gray-400 px-4 py-1 rounded-full font-semibold">
                        {{ Auth::user()->name }}
                    </button>
                    <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white text-black rounded shadow-lg z-50">
                        <div class="px-4 py-2 border-b">
                            <p class="font-bold">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-gray-600">{{ Auth::user()->email }}</p>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100">Logout</button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Jika belum login -->
                <a href="/" class="hover:underline">BERANDA</a>
                <a href="/daftar" class="hover:underline">KONSER</a>
                <a href="#footer" class="hover:underline">BANTUAN</a>

                <a href="/register" class="bg-red-600 hover:bg-red-700 px-4 py-1 rounded-full font-semibold">DAFTAR</a>
                <a href="/login" class="bg-gray-300 text-gray-800 hover:bg-gray-400 px-4 py-1 rounded-full font-semibold">MASUK</a>
            @endauth
        </nav>

        <button class="md:hidden text-2xl">&#9776;</button>
    </div>
</header>

<script>
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
    }

    document.addEventListener('click', function (e) {
        const button = document.querySelector('button[onclick="toggleDropdown()"]');
        const dropdown = document.getElementById('userDropdown');
        if (!button.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add('hidden');
        }
    });
</script>