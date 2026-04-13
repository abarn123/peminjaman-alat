@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Permintaan Peminjaman Masuk</h1>
        <p class="text-gray-500 mt-1">Kelola permintaan peminjaman alat dari siswa</p>
    </div>

    <!-- ============================================ -->
    <!-- TABEL MENUNGGU PERSETUJUAN                    -->
    <!-- ============================================ -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden mb-8">
        <div class="px-6 py-4 bg-gradient-to-r from-yellow-500 to-yellow-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-sm font-semibold text-white">Menunggu Persetujuan</h3>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input type="text" id="searchPending" placeholder="Cari peminjam..." class="px-3 py-1 text-sm rounded-lg border border-white/30 bg-white/10 text-white placeholder-white/50 focus:outline-none focus:ring-1 focus:ring-white">
                        <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-3 h-3 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs text-yellow-100">{{ $loans->count() }} permintaan</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            @if($loans->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Tidak ada permintaan baru.</p>
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Rencana Kembali</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="pendingTableBody" class="divide-y divide-gray-100">
                        @forelse($loans as $loan)
                            <tr class="hover:bg-gray-50 transition pending-row" data-name="{{ strtolower($loan->user->name) }}" data-email="{{ strtolower($loan->user->email) }}">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-full flex items-center justify-center text-white text-xs font-medium shadow-sm">
                                            {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $loan->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $loan->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        @if($loan->tool->gambar)
                                            <img src="{{ asset('storage/' . $loan->tool->gambar) }}" alt="{{ $loan->tool->nama_alat }}" class="w-8 h-8 object-cover rounded">
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $loan->tool->nama_alat }}</p>
                                            <p class="text-xs text-gray-500">{{ $loan->tool->category->nama_kategori }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ $loan->tanggal_pinjam }}
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $loan->tanggal_kembali_rencana }}
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <form action="{{ url('/petugas/approve/'.$loan->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition duration-200" onclick="return confirm('Setujui peminjaman ini?')">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Setujui
                                            </button>
                                        </form>
                                        <form action="{{ url('/petugas/reject/'.$loan->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition duration-200" onclick="return confirm('Tolak peminjaman ini?')">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                Tolak
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="pendingNoResult" class="text-center py-8 hidden">
                    <p class="text-sm text-gray-500">Tidak ada data yang ditemukan.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- ============================================ -->
    <!-- TABEL SEDANG DIPINJAM (BELUM KEMBALI)        -->
    <!-- ============================================ -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden mb-8">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="text-sm font-semibold text-white">Sedang Dipinjam (Belum Kembali)</h3>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input type="text" id="searchActive" placeholder="Cari peminjam..." class="px-3 py-1 text-sm rounded-lg border border-white/30 bg-white/10 text-white placeholder-white/50 focus:outline-none focus:ring-1 focus:ring-white">
                        <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-3 h-3 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs text-blue-100">{{ $activeLoans->count() }} peminjaman aktif</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            @if($activeLoans->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Tidak ada alat yang sedang dipinjam.</p>
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Rencana Kembali</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="activeTableBody" class="divide-y divide-gray-100">
                        @foreach($activeLoans as $active)
                            @php
                                $today = strtotime(date('Y-m-d'));
                                $rencana = strtotime($active->tanggal_kembali_rencana);
                                $daysDiff = ceil(($rencana - $today) / (60 * 60 * 24));
                                $isOverdue = $today > $rencana;
                                $daysLate = $isOverdue ? abs($daysDiff) : 0;
                                $daysLeft = !$isOverdue ? $daysDiff : 0;
                            @endphp
                            <tr class="hover:bg-gray-50 transition active-row" data-name="{{ strtolower($active->user->name) }}" data-email="{{ strtolower($active->user->email) }}">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white text-xs font-medium shadow-sm">
                                            {{ strtoupper(substr($active->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $active->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $active->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        @if($active->tool->gambar)
                                            <img src="{{ asset('storage/' . $active->tool->gambar) }}" alt="{{ $active->tool->nama_alat }}" class="w-8 h-8 object-cover rounded">
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $active->tool->nama_alat }}</p>
                                            <p class="text-xs text-gray-500">{{ $active->tool->category->nama_kategori }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($active->tanggal_pinjam)->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3 h-3 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($active->tanggal_kembali_rencana)->format('d/m/Y') }}</span>
                                        </div>
                                        @if($isOverdue)
                                            <span class="text-xs text-red-600 font-medium mt-1 ml-5">
                                                ⚠️ Terlambat {{ $daysLate }} hari
                                            </span>
                                        @else
                                            <span class="text-xs text-green-600 mt-1 ml-5">
                                                ✓ Sisa {{ $daysLeft }} hari
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $isOverdue ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                        {{ $active->status }}
                                        @if($isOverdue)
                                            <span class="ml-1 font-normal">(Telat)</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <form action="{{ url('/petugas/return/'.$active->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-medium rounded-lg transition duration-200" onclick="return confirm('Proses pengembalian alat ini?')">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Proses Pengembalian
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="activeNoResult" class="text-center py-8 hidden">
                    <p class="text-sm text-gray-500">Tidak ada data yang ditemukan.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- ============================================ -->
    <!-- TABEL SUDAH DIKEMBALIKAN                      -->
    <!-- ============================================ -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <h3 class="text-sm font-semibold text-white">Sudah Dikembalikan</h3>
                </div>
                <div class="flex items-center gap-3">
                    <div class="relative">
                        <input type="text" id="searchReturned" placeholder="Cari peminjam..." class="px-3 py-1 text-sm rounded-lg border border-white/30 bg-white/10 text-white placeholder-white/50 focus:outline-none focus:ring-1 focus:ring-white">
                        <svg class="absolute right-3 top-1/2 transform -translate-y-1/2 w-3 h-3 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <span class="text-xs text-green-100">{{ $sudahDikembalikan->count() }} peminjaman selesai</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            @if($sudahDikembalikan->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Belum ada riwayat pengembalian.</p>
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status Peminjaman</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status Kembali</th>
                        </tr>
                    </thead>
                    <tbody id="returnedTableBody" class="divide-y divide-gray-100">
                        @foreach($sudahDikembalikan as $sudah)
                            @php
                                $rencana = strtotime($sudah->tanggal_kembali_rencana);
                                $aktual = strtotime($sudah->tanggal_kembali_aktual);
                                $isLate = $aktual > $rencana;
                            @endphp
                            <tr class="hover:bg-gray-50 transition returned-row" data-name="{{ strtolower($sudah->user->name) }}" data-email="{{ strtolower($sudah->user->email) }}">
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center text-white text-xs font-medium shadow-sm">
                                            {{ strtoupper(substr($sudah->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $sudah->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $sudah->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        @if($sudah->tool->gambar)
                                            <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                                <img src="{{ asset('storage/' . $sudah->tool->gambar) }}" 
                                                    alt="{{ $sudah->tool->nama_alat }}" 
                                                    class="w-full h-full object-contain">
                                            </div>
                                        @else
                                            <div class="w-8 h-8 bg-gray-200 rounded-lg flex items-center justify-center text-gray-500">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $sudah->tool->nama_alat }}</p>
                                            <p class="text-xs text-gray-500">{{ $sudah->tool->category->nama_kategori }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        {{ $sudah->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    @if($isLate)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Telat
                                            <span class="ml-1 text-xs font-normal">
                                                ({{ floor(($aktual - $rencana) / (60 * 60 * 24)) }} hari)
                                            </span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Tepat Waktu
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div id="returnedNoResult" class="text-center py-8 hidden">
                    <p class="text-sm text-gray-500">Tidak ada data yang ditemukan.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Search function untuk tabel Menunggu Persetujuan
        function initSearch(searchInputId, rowSelector, noResultId) {
            const searchInput = document.getElementById(searchInputId);
            if (!searchInput) return;
            
            const rows = document.querySelectorAll(rowSelector);
            const noResultDiv = document.getElementById(noResultId);
            
            function filterRows() {
                const searchTerm = searchInput.value.toLowerCase();
                let hasVisibleRow = false;
                
                rows.forEach(row => {
                    const name = row.getAttribute('data-name') || '';
                    const email = row.getAttribute('data-email') || '';
                    
                    if (name.includes(searchTerm) || email.includes(searchTerm)) {
                        row.style.display = '';
                        hasVisibleRow = true;
                    } else {
                        row.style.display = 'none';
                    }
                });
                
                if (noResultDiv) {
                    noResultDiv.classList.toggle('hidden', hasVisibleRow);
                }
            }
            
            searchInput.addEventListener('keyup', filterRows);
            filterRows();
        }
        
        // Inisialisasi search untuk ketiga tabel
        initSearch('searchPending', '.pending-row', 'pendingNoResult');
        initSearch('searchActive', '.active-row', 'activeNoResult');
        initSearch('searchReturned', '.returned-row', 'returnedNoResult');
    </script>
@endsection