@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Data Pengembalian Alat</h1>
        <p class="text-gray-500 mt-1">Kelola denda untuk pengembalian alat yang terlambat</p>
    </div>

    <!-- Search -->
    <div class="mb-6">
        <form action="{{ route('petugas.denda.index') }}" method="GET" class="flex gap-2">
            <div class="relative flex-1">
                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text"
                       name="search"
                       class="pl-9 pr-4 py-2 w-full sm:w-80 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                       placeholder="Cari Nama Peminjam, Email, Alat, atau Status..."
                       value="{{ request('search') }}">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Cari
                            </button>       
            </div>
        </form>
    </div>

    <!-- Tabel Pengembalian -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Daftar Pengembalian</h3>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500">Total: {{ $returns->total() }} pengembalian</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            @if($returns->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Belum ada data pengembalian.</p>
                    @if(request('search'))
                        <p class="mt-1 text-xs text-gray-400">Coba dengan kata kunci yang berbeda.</p>
                    @endif
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Peminjam</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-36">Tgl Pinjam</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-44">Tgl Kembali (Aktual)</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-28">Petugas</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Denda</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Status Pembayaran</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($returns as $key => $r)
                            @php
                                $rencana = strtotime($r->tanggal_kembali_rencana);
                                $aktual = strtotime($r->tanggal_kembali_aktual);
                                $isLate = $aktual > $rencana;
                                $daysLate = $isLate ? ceil(($aktual - $rencana) / (60 * 60 * 24)) : 0;
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-sm text-gray-500">
                                    {{ ($returns->currentPage() - 1) * $returns->perPage() + $key + 1 }}
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white text-xs font-medium shadow-sm">
                                            {{ strtoupper(substr($r->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $r->user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ $r->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        @if($r->tool->gambar)
                                            <img src="{{ asset('storage/' . $r->tool->gambar) }}" alt="{{ $r->tool->nama_alat }}" class="w-8 h-8 object-cover rounded">
                                        @endif
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $r->tool->nama_alat }}</p>
                                            <p class="text-xs text-gray-500">{{ $r->tool->category->nama_kategori }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-3 h-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($r->tanggal_pinjam)->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="space-y-1">
                                        <div class="flex items-center gap-2">
                                            <svg class="w-3 h-3 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <span class="text-sm text-gray-700">{{ \Carbon\Carbon::parse($r->tanggal_kembali_aktual)->format('d/m/Y') }}</span>
                                        </div>
                                        @if($isLate)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Telat {{ $daysLate }} hari
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Tepat Waktu
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <div class="w-6 h-6 bg-purple-100 rounded-full flex items-center justify-center">
                                            <svg class="w-3 h-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                        </div>
                                        <span class="text-sm text-gray-700">{{ $r->petugas ? $r->petugas->name : 'Admin' }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    @if($r->denda > 0)
                                        <span class="text-red-600 font-medium">Rp {{ number_format($r->denda) }}</span>
                                    @else
                                        <span class="text-green-600">Tidak Ada</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    @if($r->midtrans_status)
                                        @if($r->midtrans_status === 'settlement')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                Lunas
                                            </span>
                                        @elseif($r->midtrans_status === 'pending')
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                {{ ucfirst($r->midtrans_status) }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-500">Belum Dibuat</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        @if($isLate && $r->denda > 0 && !$r->midtrans_status)
                                            <form action="{{ route('petugas.denda.generateLink', $r->id) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium rounded-lg transition duration-200">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                                                    </svg>
                                                    Generate Link
                                                </button>
                                            </form>
                                        @elseif($r->midtrans_status === 'settlement')
                                            <a href="{{ route('petugas.denda.showBukti', $r->id) }}" class="inline-flex items-center px-3 py-1.5 bg-green-600 hover:bg-green-700 text-white text-xs font-medium rounded-lg transition duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                Lihat Bukti
                                            </a>
                                        @endif
                                        <a href="{{ route('petugas.denda.formDenda', $r->id) }}" class="inline-flex items-center px-3 py-1.5 bg-gray-600 hover:bg-gray-700 text-white text-xs font-medium rounded-lg transition duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit Denda
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Pagination -->
        @if($returns->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-500">
                        Menampilkan <span class="font-medium">{{ $returns->firstItem() }}</span> 
                        sampai <span class="font-medium">{{ $returns->lastItem() }}</span> 
                        dari <span class="font-medium">{{ $returns->total() }}</span> data
                    </div>
                    <div>
                        {{ $returns->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Lihat Bukti Pembayaran -->
    {{-- Modal untuk petugas melihat bukti pembayaran denda dari peminjam --}}
    <div id="viewProofModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 overflow-y-auto">
        <div id="viewProofBackdrop" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
        
        <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all duration-300 my-8 mx-auto flex flex-col">
            {{-- Header modal --}}
            <div class="bg-blue-600 px-5 py-4 flex-shrink-0">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <div>
                            <h5 class="text-lg font-bold text-white">Bukti Pembayaran Denda</h5>
                            <p class="text-xs text-blue-100">Verifikasi bukti dari peminjam</p>
                        </div>
                    </div>
                    <button id="closeViewProofModal" type="button" class="w-8 h-8 flex items-center justify-center bg-white/10 hover:bg-white/20 rounded-full text-white transition-colors text-xl">
                        &times;
                    </button>
                </div>
            </div>

            {{-- Body modal menampilkan gambar --}}
            <div class="px-5 py-5 bg-gray-50 overflow-y-auto flex-1 text-center">
                <img id="viewProofImage" src="" class="w-full max-h-96 object-contain rounded-lg border border-gray-200">
            </div>

            {{-- Footer modal --}}
            <div class="px-5 py-4 bg-white border-t border-gray-100 flex-shrink-0">
                <button id="closeViewProofModalBtn" type="button" class="w-full inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // ===== View Proof Modal Scripts =====
        const viewProofModal = document.getElementById('viewProofModal');
        const viewProofBackdrop = document.getElementById('viewProofBackdrop');
        const closeViewProofBtn = document.getElementById('closeViewProofModal');
        const closeViewProofBtnFooter = document.getElementById('closeViewProofModalBtn');
        const viewProofTriggers = document.querySelectorAll('[data-open-proof-modal="true"]');
        const viewProofImage = document.getElementById('viewProofImage');

        function openViewProofModal(button) {
            const proofSrc = button.getAttribute('data-proof-src');
            viewProofImage.src = proofSrc;
            viewProofModal.classList.remove('hidden');
            viewProofModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeViewProofModal() {
            viewProofModal.classList.add('hidden');
            viewProofModal.classList.remove('flex');
            document.body.style.overflow = '';
            viewProofImage.src = '';
        }

        viewProofTriggers.forEach(function(button) {
            button.addEventListener('click', function() {
                openViewProofModal(button);
            });
        });

        if (viewProofBackdrop) viewProofBackdrop.addEventListener('click', closeViewProofModal);
        if (closeViewProofBtn) closeViewProofBtn.addEventListener('click', closeViewProofModal);
        if (closeViewProofBtnFooter) closeViewProofBtnFooter.addEventListener('click', closeViewProofModal);

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !viewProofModal.classList.contains('hidden')) {
                closeViewProofModal();
            }
        });
    });
    </script>
@endsection