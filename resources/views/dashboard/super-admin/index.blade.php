@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h2 class="text-3xl font-extrabold text-gray-900 mb-8">Manajemen User</h2>

    @if(session('success'))
        <div class="mb-6 rounded bg-green-100 border border-green-400 text-green-700 px-6 py-4 shadow">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('superadmin.users.create') }}"
           class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-lg shadow transition duration-300">
           + Tambah User
        </a>
    </div>

    <div class="overflow-x-auto bg-white shadow rounded-lg border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Telepon</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-900 font-medium">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->phone_number }}</td>
                    <td class="px-6 py-4 whitespace-nowrap capitalize text-gray-700">{{ $user->role }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <button 
                            onclick="showUserDetail({{ $user->toJson() }})" 
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded transition duration-200">
                            Detail
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Background -->
<div id="userDetailModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <!-- Modal Container -->
    <div class="bg-white rounded-lg shadow-lg max-w-lg w-full mx-4 p-6 relative" onclick="event.stopPropagation()">
        <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-600 hover:text-gray-900 text-xl font-bold">&times;</button>
        <h3 class="text-2xl font-semibold mb-4">Detail User</h3>
        <div id="modalContent" class="text-gray-700 space-y-2">
            <!-- Konten detail user diisi via JS -->
        </div>
        <div class="mt-6 flex justify-end space-x-3">
            <a href="#" id="editLink" class="bg-yellow-400 hover:bg-yellow-500 text-white px-5 py-2 rounded transition duration-200 font-semibold">
                Edit
            </a>
            <form id="deleteForm" method="POST" action="#" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded transition duration-200 font-semibold">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    const modal = document.getElementById('userDetailModal');
    const modalContent = document.getElementById('modalContent');
    const editLink = document.getElementById('editLink');
    const deleteForm = document.getElementById('deleteForm');

    function showUserDetail(user) {
        modalContent.innerHTML = `
            <p><strong>Nama:</strong> ${user.name}</p>
            <p><strong>Email:</strong> ${user.email}</p>
            <p><strong>Telepon:</strong> ${user.phone_number}</p>
            <p><strong>Role:</strong> ${capitalize(user.role)}</p>
            <p><strong>Verifikasi Email:</strong> ${user.email_verified_at ? 'Ya' : 'Belum'}</p>
            <p><strong>OTP Aktif:</strong> ${user.otp_code ? 'Ya' : 'Tidak'}</p>
        `;

        editLink.href = `/superadmin/users/${user.id}/edit`;
        deleteForm.action = `/superadmin/users/${user.id}`;

        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Tutup modal kalau klik di luar konten modal
    modal.addEventListener('click', closeModal);

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }
</script>
@endpush