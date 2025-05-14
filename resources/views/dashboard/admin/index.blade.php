@if(session('error'))
    <div class="bg-red-100 text-red-700 p-4 rounded mb-4">
        {{ session('error') }}
    </div>
@endif
<x-app-layout>
    <div class="p-6 text-gray-900">
        Halo, {{ Auth::user()->name }}! Ini adalah dashboard admin.
    </div>
</x-app-layout>