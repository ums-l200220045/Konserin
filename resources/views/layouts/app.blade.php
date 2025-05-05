<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konser'in</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet">

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

</body>
</html>
