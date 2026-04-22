@extends('layouts.petugas')

@section('title', 'Monitor Transaksi - Parkira')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-950 mb-1">Transaksi Parkir</h1>
            <p class="text-slate-500 font-medium">Kelola kendaraan masuk dan keluar secara real-time.</p>
        </div>
        <button onclick="document.getElementById('modalMasuk').classList.remove('hidden')"
            class="px-6 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Input Kendaraan Masuk
        </button>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 font-medium rounded-r-lg shadow-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 font-medium rounded-r-lg shadow-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        @foreach ($areas as $a)
            <div class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="text-slate-900 font-bold uppercase">{{ $a->nama_area }}</h3>
                        <p class="text-xs text-slate-500 font-medium">Kapasitas: {{ $a->kapasitas }} Slot</p>
                    </div>
                    @if ($a->terisi >= $a->kapasitas)
                        <span class="px-2 py-1 bg-red-100 text-red-600 text-[10px] font-black rounded-md">PENUH</span>
                    @else
                        <span
                            class="px-2 py-1 bg-green-100 text-green-600 text-[10px] font-black rounded-md">TERSEDIA</span>
                    @endif
                </div>

                <div class="w-full bg-slate-100 h-2 rounded-full overflow-hidden">
                    @php $persen = ($a->terisi / $a->kapasitas) * 100; @endphp
                    <div class="h-full {{ $persen >= 100 ? 'bg-red-500' : 'bg-blue-600' }} transition-all duration-500"
                        style="width: {{ $persen }}%"></div>
                </div>
                <p class="text-right text-[11px] font-bold mt-2 text-slate-600">{{ $a->terisi }} / {{ $a->kapasitas }}
                    Terisi</p>
            </div>
        @endforeach
    </div>

    <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-[#F8FAFC] text-slate-900 font-semibold border-b border-slate-100">
                <tr>
                    <th class="px-6 py-4">PLAT NOMOR</th>
                    <th class="px-6 py-4">JENIS / WARNA</th>
                    <th class="px-6 py-4">AREA</th>
                    <th class="px-6 py-4">WAKTU MASUK</th>
                    <th class="px-6 py-4 text-center">AKSI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse($transaksis as $t)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-5 font-bold text-slate-900 uppercase">{{ $t->kendaraan->plat_nomor }}</td>
                        <td class="px-6 py-5 text-slate-600">
                            <span class="block font-medium">{{ $t->kendaraan->jenis_kendaraan }}</span>
                            <span class="text-xs text-slate-400">{{ $t->kendaraan->warna }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <span
                                class="px-3 py-1 bg-blue-50 text-blue-700 rounded-full text-xs font-bold border border-blue-100">
                                {{ $t->areaParkir->nama_area }}
                            </span>
                        </td>
                        <td class="px-6 py-5 text-slate-500 font-medium">
                            {{ date('H:i', strtotime($t->waktu_masuk)) }}
                        </td>
                        <td class="px-6 py-5 text-center">
                            <button
                                onclick="bukaModalKeluar('{{ $t->id_parkir }}', '{{ $t->kendaraan->plat_nomor }}', '{{ $t->waktu_masuk }}', {{ $t->tarif->tarif_per_jam }})"
                                class="px-4 py-2 bg-red-50 text-red-600 rounded-lg font-bold text-xs hover:bg-red-600 hover:text-white transition border border-red-100">
                                PROSES KELUAR
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center text-slate-400 italic font-medium">
                            Belum ada kendaraan yang sedang parkir.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="modalMasuk"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="text-xl font-bold text-slate-900">Parkir Masuk</h3>
                <button onclick="document.getElementById('modalMasuk').classList.add('hidden')"
                    class="text-slate-400 hover:text-slate-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form action="/transaksi/masuk" method="POST" class="p-8 space-y-6">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Pilih Plat Nomor</label>
                    <select name="id_kendaraan" id="pilihPlat"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none uppercase">
                        <option value="" disabled selected hidden>-- Ketik / Cari Plat Nomor --</option>
                        @foreach ($kendaraans as $k)
                            <option value="{{ $k->id_kendaraan }}">{{ $k->plat_nomor }} ({{ $k->jenis_kendaraan }} -
                                {{ $k->pemilik }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Area Parkir</label>
                    <select name="id_area"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none appearance-none">
                        <option value="" disabled selected hidden>-- Pilih Area --</option>
                        @foreach ($areas as $a)
                            @if ($a->terisi >= $a->kapasitas)
                                <option value="{{ $a->id_area }}" disabled class="text-slate-400">
                                    {{ $a->nama_area }} (PENUH)
                                </option>
                            @else
                                <option value="{{ $a->id_area }}">{{ $a->nama_area }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <button type="submit"
                    class="w-full py-4 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 shadow-lg mt-4">Simpan
                    & Masuk</button>
            </form>
        </div>
    </div>

    <div id="modalKeluar"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-md overflow-hidden transform transition-all">
            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-red-50">
                <h3 class="text-xl font-bold text-red-700">Pembayaran Parkir</h3>
                <button type="button" onclick="document.getElementById('modalKeluar').classList.add('hidden')"
                    class="text-red-400 hover:text-red-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <form id="formKeluar" method="POST" class="p-8 space-y-4">
                @csrf
                @method('PUT')
                <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 mb-4">
                    <p class="text-sm text-slate-500 font-medium">Plat Nomor</p>
                    <p id="keluar_plat" class="text-2xl font-black text-slate-900 uppercase tracking-wider mb-2">-</p>
                    <div class="flex justify-between items-center pt-3 border-t border-slate-200">
                        <p class="text-sm font-medium text-slate-600">Durasi Parkir</p>
                        <p id="keluar_jam" class="text-sm font-bold text-slate-900">- Jam</p>
                    </div>
                    <div class="flex justify-between items-center pt-2">
                        <p class="text-sm font-medium text-slate-600">Total Biaya</p>
                        <p id="keluar_total_text" class="text-xl font-black text-blue-600">Rp 0</p>
                    </div>
                </div>
                <input type="hidden" id="keluar_total_input" name="total_biaya">
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-2">Uang Diterima (Rp)</label>
                    <input type="number" name="uang_bayar" id="input_bayar" required onkeyup="hitungKembalian()"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 outline-none text-lg font-bold">
                </div>
                <div class="flex justify-between items-center p-4 bg-green-50 rounded-xl border border-green-100">
                    <p class="text-sm font-bold text-green-700">Kembalian</p>
                    <p id="keluar_kembali" class="text-xl font-black text-green-700">Rp 0</p>
                </div>
                <button type="submit" id="btnSubmitKeluar" disabled
                    class="w-full py-4 bg-red-600 text-white rounded-xl font-bold hover:bg-red-700 transition mt-4 opacity-50 cursor-not-allowed">Bayar
                    & Cetak Struk</button>
            </form>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const elemenPlat = document.getElementById('pilihPlat');
            if (elemenPlat) {
                new Choices(elemenPlat, {
                    searchEnabled: true,
                    searchPlaceholderValue: 'Cari plat...',
                    itemSelectText: '',
                    shouldSort: false
                });
            }
        });

        function bukaModalKeluar(id, plat, waktuMasukStr, tarifPerJam) {
            document.getElementById('formKeluar').action = '/transaksi/keluar/' + id;
            document.getElementById('keluar_plat').innerText = plat;

            let masuk = new Date(waktuMasukStr);
            let sekarang = new Date();
            let menit = Math.floor((sekarang - masuk) / 60000);
            let jam = Math.ceil(menit / 60);
            if (jam <= 0) jam = 1;

            let total = jam * tarifPerJam;

            document.getElementById('keluar_jam').innerText = jam + ' Jam';
            document.getElementById('keluar_total_text').innerText = 'Rp ' + total.toLocaleString('id-ID');
            document.getElementById('keluar_total_input').value = total;
            document.getElementById('input_bayar').value = '';
            document.getElementById('keluar_kembali').innerText = 'Rp 0';
            document.getElementById('btnSubmitKeluar').disabled = true;
            document.getElementById('btnSubmitKeluar').classList.add('opacity-50', 'cursor-not-allowed');
            document.getElementById('modalKeluar').classList.remove('hidden');
        }

        function hitungKembalian() {
            let total = parseInt(document.getElementById('keluar_total_input').value);
            let bayar = parseInt(document.getElementById('input_bayar').value) || 0;
            let kembali = bayar - total;
            document.getElementById('keluar_kembali').innerText = 'Rp ' + (kembali < 0 ? 0 : kembali).toLocaleString(
                'id-ID');
            let btn = document.getElementById('btnSubmitKeluar');
            if (kembali < 0 || bayar === 0) {
                btn.disabled = true;
                btn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                btn.disabled = false;
                btn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }
    </script>
@endsection
