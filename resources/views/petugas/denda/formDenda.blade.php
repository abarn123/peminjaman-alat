@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Input Denda Pengembalian</h1>
        <p class="text-gray-500 mt-1">Kelola denda untuk pengembalian alat yang terlambat</p>
    </div>

    <!-- Informasi Peminjaman Card -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden mb-6">
        <div class="px-6 py-4 bg-gradient-to-r from-red-600 to-red-700">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-sm font-semibold text-white">Detail Peminjaman Terlambat</h3>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white text-sm font-medium shadow-sm">
                            {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Peminjam</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $loan->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $loan->user->email }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-3">
                        @if($loan->tool->gambar)
                            <img src="{{ asset('storage/' . $loan->tool->gambar) }}" alt="{{ $loan->tool->nama_alat }}" class="w-10 h-10 object-cover rounded-lg">
                        @else
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <p class="text-xs text-gray-500">Alat</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $loan->tool->nama_alat }}</p>
                            <p class="text-xs text-gray-500">{{ $loan->tool->category->nama_kategori }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Tanggal Kembali Rencana</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $loan->tanggal_kembali_rencana }}</p>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Tanggal Kembali Aktual</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $loan->tanggal_kembali_aktual }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Status dan Denda -->
            <div class="mt-6 pt-4 border-t border-gray-100">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                        <span class="text-sm text-gray-600">Status</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Terlambat
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                        <span class="text-sm text-gray-600">Keterlambatan</span>
                        <span class="text-sm font-semibold text-red-800">
                            {{ (int) ($lateDays ?? 0) }} hari
                        </span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-yellow-50 rounded-lg">
                        <span class="text-sm text-gray-600">Denda Terhitung</span>
                        <span class="text-lg font-bold text-yellow-700">Rp {{ number_format($loan->denda !== null ? $loan->denda : $calculatedFine, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Input Denda -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-sm font-semibold text-gray-800">Form Input Denda</h3>
            </div>
        </div>

        <div class="p-6">
            @php
                $lateDaysValue = (int) ($lateDays ?? 0);
                $existingTotalFine = (int) ($loan->denda !== null ? $loan->denda : $calculatedFine);
                $defaultPerDayFine = 10000;
                if ($loan->denda !== null && $lateDaysValue > 0) {
                    $defaultPerDayFine = (int) floor($existingTotalFine / $lateDaysValue);
                }
            @endphp
            <form action="{{ route('petugas.denda.formDenda', $loan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Nominal Denda -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Nominal Denda per Hari (Rp) <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">Rp</span>
                        <input type="number"
                               id="denda_per_hari"
                               name="denda_per_hari"
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               value="{{ old('denda_per_hari', $defaultPerDayFine) }}"
                               required>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Rumus: total = nominal × telat ({{ (int) ($lateDays ?? 0) }} hari).</p>
                    <div class="mt-3 p-3 bg-blue-50 border border-blue-200 rounded-lg flex items-center justify-between">
                        <span class="text-sm font-medium text-blue-800">Jumlah yang harus dibayar</span>
                        <span class="text-lg font-bold text-blue-700" id="total_denda_text">Rp 0</span>
                    </div>
                </div>

                <!-- TF Kemana -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Transfer Ke <span class="text-red-500">*</span></label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                        </svg>
                        <input type="text"
                               name="denda_tf"
                               class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                               placeholder="Contoh: BCA 1234567890 a.n Lab Komputer"
                               value="{{ old('denda_tf', $loan->denda_tf) }}"
                               required>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Informasi rekening/tujuan pembayaran yang akan ditampilkan ke peminjam.</p>
                </div>

                <!-- Tombol Aksi -->
                <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                    <a href="{{ route('petugas.denda.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali
                    </a>
                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Simpan Denda
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Info Card -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="text-sm font-semibold text-blue-800">Informasi</h4>
                <ul class="text-xs text-blue-600 mt-1 space-y-1">
                    <li>• Denda akan dikenakan sesuai jumlah hari keterlambatan</li>
                    <li>• Total bayar dihitung otomatis: nominal × telat</li>
                    <li>• Peminjam akan melihat informasi pembayaran di dashboard mereka</li>
                    <li>• Upload QRIS agar peminjam dapat membayar denda dengan mudah</li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        (function () {
            const lateDays = Number(@json((int) ($lateDays ?? 0)));
            const input = document.getElementById('denda_per_hari');
            const totalText = document.getElementById('total_denda_text');

            function formatRupiah(n) {
                const num = Number(n) || 0;
                return 'Rp ' + num.toLocaleString('id-ID');
            }

            function updateTotal() {
                const perHari = Number(input?.value || 0);
                const total = perHari * lateDays;
                if (totalText) totalText.textContent = formatRupiah(total);
            }

            if (input) {
                input.addEventListener('input', updateTotal);
                updateTotal();
            }
        })();
    </script>
@endsection