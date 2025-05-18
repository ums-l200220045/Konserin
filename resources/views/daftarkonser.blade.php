@extends('layouts.app')

@section('content')
<div class="px-4 py-6">
    <h1 class="text-2xl font-bold text-center mb-6">DAFTAR KONSER!!!</h1>

    <div class="flex justify-center mb-6">
        <input type="text" id="search" placeholder="Cari nama konser..." 
            class="border rounded px-4 py-2 w-1/2">
    </div>

    <div id="concert-list" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @include('partials.concert-list', ['concerts' => $concerts])
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">

    </div>
</div>

{{-- Script Modal --}}
<script>
    function showModal(id) {
        const modal = document.getElementById('modal-' + id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function hideModal(id) {
        const modal = document.getElementById('modal-' + id);
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    document.getElementById('search').addEventListener('input', function() {
        const query = this.value;

        fetch(`/search-concerts?q=${encodeURIComponent(query)}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('concert-list').innerHTML = html;
            });
    });
</script>
@endsection