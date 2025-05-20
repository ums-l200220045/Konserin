<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konser'in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
</head>
<body class="font-sans leading-normal tracking-normal bg-[#c57a7a]">

    <!-- Komponen Header -->
    <x-header />

    <!-- Konten Utama -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Komponen Footer -->
    <x-footer />

    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

    @if (session('success'))
    <script>
        Toastify({
            text: "{{ session('success') }}",
            duration: 4000,
            gravity: "top",
            position: "center",
            backgroundColor: "#16a34a",
        }).showToast();
    </script>
    @endif

    @if (session('error'))
    <script>
        Toastify({
            text: "{{ session('error') }}",
            duration: 4000,
            gravity: "top",
            position: "center",
            backgroundColor: "#dc2626",
        }).showToast();
    </script>
    @endif

</body>
</html>