@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Riwayat Peminjaman Saya</h1>
        <p class="text-gray-500 mt-1">Lihat riwayat peminjaman alat Anda</p>
    </div>

    <!-- Tabel Riwayat -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-800">Daftar Peminjaman</h3>
        </div>

        <div class="overflow-x-auto">
            @if($loans->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Belum ada riwayat peminjaman.</p>
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Alat</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Tgl Pinjam</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Rencana Kembali</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Dikembalikan</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Catatan</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Denda</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($loans as $loan)
                            <tr>
                                <td class="px-6 py-3 text-sm font-medium text-gray-800">
                                    {{ $loan->tool->nama_alat }}
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-600">
                                    {{ $loan->tanggal_pinjam }}
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-600">
                                    {{ $loan->tanggal_kembali_rencana }}
                                </td>
                                <td class="px-6 py-3">
                                    @if($loan->status == 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                            Menunggu Persetujuan
                                        </span>
                                    @elseif($loan->status == 'disetujui')
                                        <span class="inline-flex items-center justify-center px-2.5 py-0.5 rounded-full text-xs font-medium text-center bg-blue-100 text-blue-800 w-full">
                                            Sedang Dipinjam
                                        </span>
                                    @elseif($loan->status == 'kembali')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Sudah Dikembalikan
                                        </span>
                                    @elseif($loan->status == 'ditolak')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Ditolak
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    @if($loan->status == 'kembali' && $loan->tanggal_kembali_aktual)
                                        @php
                                            $rencana = strtotime($loan->tanggal_kembali_rencana);
                                            $aktual = strtotime($loan->tanggal_kembali_aktual);
                                            $isLate = $aktual > $rencana;
                                        @endphp
                                        @if($isLate)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                Telat
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Tepat Waktu
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    @if($loan->status == 'disetujui')
                                        <span class="text-xs text-gray-500">Harap kembalikan ke petugas sebelum tanggal rencana.</span>
                                    @elseif($loan->status == 'kembali')
                                        @php
                                            $rencana = strtotime($loan->tanggal_kembali_rencana);
                                            $aktual = strtotime($loan->tanggal_kembali_aktual);
                                            $isLate = $aktual > $rencana;
                                        @endphp
                                        @if($isLate)
                                            <div class="flex flex-col gap-1">
                                                <span class="text-xs text-red-600 font-medium">Pengembalian terlambat!</span>
                                                <span class="text-xs text-red-500">Silakan segera bayar denda.</span>
                                            </div>
                                        @else
                                            <span class="text-xs text-green-600">✓ Diterima tanggal {{ $loan->tanggal_kembali_aktual }}</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    @if($loan->status === 'kembali' && (int) $loan->denda > 0)
                                        @if($loan->midtrans_status === 'settlement')
                                            <span class="text-green-600 font-medium">Lunas</span>
                                        @else
                                            <span class="text-red-600 font-medium">Rp {{ number_format($loan->denda) }}</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    {{-- Aksi untuk peminjaman yang sedang berlangsung --}}
                                    @if($loan->status == 'disetujui')
                                        <form action="{{ route('peminjam.return', $loan->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-orange-500 hover:bg-orange-600 text-white text-xs font-medium rounded-lg transition duration-200" onclick="return confirm('Apakah Anda yakin ingin mengembalikan alat ini?')">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                                </svg>
                                                Kembalikan
                                            </button>
                                        </form>
                                    @elseif($loan->status == 'kembali' && $loan->denda > 0 && $loan->midtrans_status !== 'settlement')
                                        <a href="{{ route('peminjam.payDenda', $loan->id) }}" class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                            </svg>
                                            Bayar Denda
                                        </a>
                                    @elseif($loan->midtrans_status === 'settlement')
                                        <span class="inline-flex items-center px-3 py-1.5 bg-green-100 text-green-800 text-xs font-medium rounded-lg">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                            Denda Lunas
                                        </span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>


@endsection



        <script>
        document.addEventListener('DOMContentLoaded', function () {
            // ===== QRIS Modal Scripts =====
            const qrisModal = document.getElementById('qrisModal');
            const qrisBackdrop = document.getElementById('qrisModalBackdrop');
            const closeBtn = document.getElementById('closeQrisModalBtn');
            const closeBtnFooter = document.getElementById('closeQrisModalBtnFooter');
            const triggers = document.querySelectorAll('[data-open-qris-modal="true"]');
            const kirimbuktiLink = document.getElementById('kirimbuktiLink');
            let currentLoanId = null;

            if (!qrisModal) return;

            function openQrisModal(button) {
                currentLoanId = button.getAttribute('data-loan-id');
                const amount = button.getAttribute('data-amount');
                const tf = button.getAttribute('data-tf');
                const qrisSrc = button.getAttribute('data-qris-src');

                const amountSpan = qrisModal.querySelector('#qrisAmount');
                const tfSpan = qrisModal.querySelector('#qrisTf');
                const qrisImage = qrisModal.querySelector('#qrisImage');

                if (amountSpan) amountSpan.textContent = amount || '0';
                if (tfSpan) tfSpan.textContent = tf || '-';
                if (qrisImage) qrisImage.setAttribute('src', qrisSrc || '');

                // Set the Kirim bukti link dengan loanId
                if (kirimbuktiLink && currentLoanId) {
                    kirimbuktiLink.href = '/peminjam/bukti-denda/' + currentLoanId;
                }

                qrisModal.classList.remove('hidden');
                qrisModal.classList.add('flex');
                document.body.style.overflow = 'hidden';
            }

            function closeQrisModal() {
                qrisModal.classList.add('hidden');
                qrisModal.classList.remove('flex');
                document.body.style.overflow = '';
                const qrisImage = qrisModal.querySelector('#qrisImage');
                if (qrisImage) qrisImage.setAttribute('src', '');
            }

            triggers.forEach(function (button) {
                button.addEventListener('click', function () {
                    openQrisModal(button);
                });
            });

            if (qrisBackdrop) qrisBackdrop.addEventListener('click', closeQrisModal);
            if (closeBtn) closeBtn.addEventListener('click', closeQrisModal);
            if (closeBtnFooter) closeBtnFooter.addEventListener('click', closeQrisModal);

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !qrisModal.classList.contains('hidden')) {
                    closeQrisModal();
                }
            });

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

            viewProofTriggers.forEach(function (button) {
                button.addEventListener('click', function () {
                    openViewProofModal(button);
                });
            });

            if (viewProofBackdrop) viewProofBackdrop.addEventListener('click', closeViewProofModal);
            if (closeViewProofBtn) closeViewProofBtn.addEventListener('click', closeViewProofModal);
            if (closeViewProofBtnFooter) closeViewProofBtnFooter.addEventListener('click', closeViewProofModal);

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !viewProofModal.classList.contains('hidden')) {
                    closeViewProofModal();
                }
            });
        });
        </script>