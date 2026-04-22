@extends('layouts.admin')

@section('title', 'Kelola Akun - Parkira')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-950 mb-1">Kelola Akun Pengguna</h1>
            <p class="text-slate-500 font-medium">Manajemen data administrator, petugas, dan owner.</p>
        </div>
        <button onclick="openModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold text-sm transition-all shadow-md hover:shadow-lg active:scale-95">
            Tambah Akun Baru
        </button>
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#F8FAFC] text-slate-600 font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-5 uppercase tracking-wider text-xs">Nama Lengkap</th>
                        <th class="px-6 py-5 uppercase tracking-wider text-xs">Username</th>
                        <th class="px-6 py-5 uppercase tracking-wider text-xs text-center">Role</th>
                        <th class="px-6 py-5 uppercase tracking-wider text-xs text-center">Status</th>
                        <th class="px-6 py-5 uppercase tracking-wider text-xs text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-slate-800">

                    @foreach ($users as $user)
                        <tr class="hover:bg-slate-50/80 transition-colors">
                            <td class="px-6 py-5 font-semibold text-slate-900">{{ $user->nama_lengkap }}</td>
                            <td class="px-6 py-5 text-slate-600">{{ $user->username }}</td>

                            <td class="px-6 py-5 text-center">
                                <span
                                    class="px-3 py-1.5 rounded-full text-[11px] font-bold uppercase tracking-wider 
                                {{ $user->role == 'admin' ? 'bg-blue-100 text-blue-700' : '' }}
                                {{ $user->role == 'petugas' ? 'bg-amber-100 text-amber-700' : '' }}
                                {{ $user->role == 'owner' ? 'bg-purple-100 text-purple-700' : '' }}">
                                    {{ $user->role }}
                                </span>
                            </td>

                            <td class="px-6 py-5 text-center">
                                <span
                                    class="bg-green-100 text-green-700 px-3 py-1.5 rounded-full text-[11px] font-bold uppercase tracking-wider">
                                    Aktif
                                </span>
                            </td>

                            <td class="px-6 py-5">
                                <div class="flex justify-center items-center gap-5">
                                    <button onclick="openEditModal({{ json_encode($user) }})"
                                        class="transition-transform hover:scale-125" title="Edit User">
                                        <img src="{{ asset('edit.png') }}" alt="Edit" class="w-6 h-6 object-contain">
                                    </button>

                                    <form action="/kelola-akun/{{ $user->id_user }}" method="POST"
                                        id="form-delete-{{ $user->id_user }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button"
                                            onclick="konfirmasiHapus({{ $user->id_user }}, '{{ $user->nama_lengkap }}')"
                                            class="transition hover:scale-110" title="Hapus">
                                            <img src="{{ asset('delete.png') }}" alt="Hapus"
                                                class="w-6 h-6 object-contain">
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
    </div>

    <div id="modalTambah"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center transition-opacity">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl p-8 mx-4 transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-slate-900">Tambah Akun Baru</h2>
                <button onclick="closeModal()" class="text-slate-400 hover:text-slate-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form action="/kelola-akun" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" required placeholder="Nama Lengkap"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Username</label>
                    <input type="text" name="username" required placeholder="Username untuk Login"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Password</label>
                    <input type="password" name="password" required placeholder="•••••••"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Role</label>
                    <select name="role" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 bg-white transition text-sm appearance-none cursor-pointer">
                        <option value="" disabled selected hidden>Pilih Role: Admin/Petugas/Owner</option>
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                        <option value="owner">Owner</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 mt-8 pt-5 border-t border-slate-100">
                    <button type="button" onclick="closeModal()"
                        class="px-6 py-2.5 bg-slate-100 text-slate-600 rounded-lg font-semibold text-sm transition hover:bg-slate-200">Batal</button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold text-sm transition hover:bg-blue-700 shadow-sm">Simpan
                        Pengguna</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEdit"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-50 hidden flex items-center justify-center transition-opacity">
        <div class="bg-white w-full max-w-lg rounded-2xl shadow-2xl p-8 mx-4 transform transition-all">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-slate-900">Edit Pengguna</h2>
                <button onclick="closeEditModal()" class="text-slate-400 hover:text-slate-700 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form id="formEdit" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" id="edit_nama" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Username</label>
                    <input type="text" name="username" id="edit_username" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Password Baru (Kosongkan jika tidak
                        ganti)</label>
                    <input type="password" name="password" placeholder="••••••••"
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 transition text-sm">
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1">Role</label>
                    <select name="role" id="edit_role" required
                        class="w-full px-4 py-2.5 border border-slate-300 rounded-lg outline-none focus:ring-2 focus:ring-blue-500 bg-white transition text-sm appearance-none cursor-pointer">
                        <option value="admin">Admin</option>
                        <option value="petugas">Petugas</option>
                        <option value="owner">Owner</option>
                    </select>
                </div>
                <div class="flex justify-end gap-3 mt-8 pt-5 border-t border-slate-100">
                    <button type="button" onclick="closeEditModal()"
                        class="px-6 py-2.5 bg-slate-100 text-slate-600 rounded-lg font-semibold text-sm transition hover:bg-slate-200">Batal</button>
                    <button type="submit"
                        class="px-6 py-2.5 bg-blue-600 text-white rounded-lg font-semibold text-sm transition hover:bg-blue-700 shadow-sm">Simpan
                        Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Script Modal Tambah
        function openModal() {
            document.getElementById('modalTambah').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('modalTambah').classList.add('hidden');
        }

        // Script Modal Edit
        function openEditModal(user) {
            document.getElementById('edit_nama').value = user.nama_lengkap;
            document.getElementById('edit_username').value = user.username;
            document.getElementById('edit_role').value = user.role;

            document.getElementById('formEdit').action = '/kelola-akun/' + user.id_user;
            document.getElementById('modalEdit').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('modalEdit').classList.add('hidden');
        }

        // Script Konfirmasi Hapus SweetAlert
        function konfirmasiHapus(id, nama) {
            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: "Data " + nama + " akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#EF4444',
                cancelButtonColor: '#64748B',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('form-delete-' + id).submit();
                }
            })
        }
    </script>
@endsection
