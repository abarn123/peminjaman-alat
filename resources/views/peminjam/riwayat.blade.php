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
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Bayar Denda</th>
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
                                        <span class="text-xs text-green-600">Diterima tanggal {{ $loan->tanggal_kembali_aktual }}</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    @php
                                        $canPayFine = ($loan->status === 'kembali')
                                            && ((int) $loan->denda > 0)
                                            && !empty($loan->denda_qris_image_path);
                                    @endphp

                                    @if($canPayFine)
                                        <button type="button"
                                            class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-lg transition duration-200"
                                            data-open-qris-modal="true"
                                            data-amount="{{ number_format($loan->denda, 0, ',', '.') }}"
                                            data-qris-src="{{ asset('storage/' . $loan->denda_qris_image_path) }}"
                                            data-tf="{{ $loan->denda_tf }}">
                                            Bayar Denda
                                        </button>
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


   <!-- modal pembayaran denda -->
<div id="qrisModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 overflow-y-auto">
    <!-- Backdrop / Overlay gelap di belakang modal -->
    <div id="qrisModalBackdrop" class="fixed inset-0 bg-black/50 backdrop-blur-sm"></div>
    
    <!-- Container Modal - dengan max height agar tidak terpotong -->
    <div class="relative w-full max-w-md bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden transform transition-all duration-300 scale-100 my-8 mx-auto max-h-[90vh] flex flex-col">
        
        <!-- Header Modal dengan gradien -->
        <div class="bg-red-600 px-5 py-4 flex-shrink-0">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h5 class="text-lg font-bold text-white">Pembayaran Denda</h5>
                        <p class="text-xs text-red-100">Silakan selesaikan pembayaran Anda</p>
                    </div>
                </div>
                <button id="closeQrisModalBtn" type="button" class="w-8 h-8 flex items-center justify-center bg-white/10 hover:bg-white/20 rounded-full text-white transition-colors text-xl" aria-label="Tutup">
                    &times;
                </button>
            </div>
        </div>

        <!-- Body Modal - Informasi Pembayaran (bisa di-scroll) -->
        <div class="px-5 py-5 bg-gray-50 overflow-y-auto flex-1" style="max-height: 60vh;">
            <!-- Card Informasi Denda -->
            <div class="bg-white rounded-xl p-4 mb-4 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between mb-2">
                    <span class="text-sm text-gray-500">Jumlah Denda</span>
                    <span class="text-xs px-2 py-0.5 bg-red-100 text-red-700 rounded-full">Harus Dibayar</span>
                </div>
                <p class="text-2xl font-bold text-red-600">Rp <span id="qrisAmount" class="text-3xl">0</span></p>
            </div>

            <!-- Card Informasi Transfer -->
            <div class="bg-white rounded-xl p-4 mb-4 shadow-sm border border-gray-100">
                <div class="flex items-center gap-2 mb-3">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                    </svg>
                    <span class="text-sm font-semibold text-gray-700">Transfer Ke</span>
                </div>
                <div class="bg-blue-50 rounded-lg p-3 border border-blue-100">
                    <p class="text-sm font-mono text-blue-800 break-all" id="qrisTf">-</p>
                </div>
            </div>

            <!-- Card QRIS -->
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 text-center">
                <div class="flex items-center justify-center gap-2 mb-3">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 1.79 4 4 4h8c2.21 0 4-1.79 4-4V7c0-2.21-1.79-4-4-4H8c-2.21 0-4 1.79-4 4z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v.01M17 4v.01M7 4h10"></path>
                    </svg>
                    <span class="text-sm font-semibold text-gray-700">Scan QRIS untuk Membayar</span>
                </div>
                
                <!-- Container QRIS dengan border dan background -->
                <div class="bg-white p-4 rounded-xl border-2 border-dashed border-gray-200 inline-block w-full">
                    <img id="qrisImage" src="" class="w-40 h-40 object-contain mx-auto" alt="QRIS Pembayaran">
                </div>
                
                <p class="text-xs text-gray-500 mt-3">Gunakan aplikasi mobile banking atau e-wallet untuk scan QR code di atas</p>
            </div>
        </div>

        <!-- Footer Modal - Tombol (fixed di bawah) -->
        <div class="px-5 py-4 bg-white border-t border-gray-100 flex-shrink-0">
            <div class="flex gap-3">
                <button id="closeQrisModalBtnFooter" type="button" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-xl transition duration-200">
                    Tutup
                </button>
                <button type="button" class="flex-1 inline-flex items-center justify-center px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-xl transition duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Kirim bukti
                </button>
            </div>
        </div>
    </div>
</div>
@endsection



        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const qrisModal = document.getElementById('qrisModal');
            const qrisBackdrop = document.getElementById('qrisModalBackdrop');
            const closeBtn = document.getElementById('closeQrisModalBtn');
            const closeBtnFooter = document.getElementById('closeQrisModalBtnFooter');
            const triggers = document.querySelectorAll('[data-open-qris-modal="true"]');

            // Jika modal tidak ditemukan, hentikan eksekusi
            if (!qrisModal) return;

            function openModal(button) {
                // Ambil data dari attribute tombol
                const amount = button.getAttribute('data-amount');
                const tf = button.getAttribute('data-tf');
                const qrisSrc = button.getAttribute('data-qris-src');

                // Isi data ke dalam modal
                const amountSpan = qrisModal.querySelector('#qrisAmount');
                const tfSpan = qrisModal.querySelector('#qrisTf');
                const qrisImage = qrisModal.querySelector('#qrisImage');

                if (amountSpan) amountSpan.textContent = amount || '0';
                if (tfSpan) tfSpan.textContent = tf || '-';
                if (qrisImage) qrisImage.setAttribute('src', qrisSrc || '');

                // Tampilkan modal (hilangkan class hidden, tambahkan class flex)
                qrisModal.classList.remove('hidden');
                qrisModal.classList.add('flex');
                
                // Mencegah scroll pada body saat modal terbuka
                document.body.style.overflow = 'hidden';
            }

            function closeModal() {
                qrisModal.classList.add('hidden');
                qrisModal.classList.remove('flex');
                
                // Kembalikan scroll body
                document.body.style.overflow = '';
                
                // Kosongkan gambar QRIS agar tidak tersimpan saat modal ditutup
                const qrisImage = qrisModal.querySelector('#qrisImage');
                if (qrisImage) qrisImage.setAttribute('src', '');
            }

            triggers.forEach(function (button) {
                button.addEventListener('click', function () {
                    openModal(button);
                });
            });

            if (qrisBackdrop) qrisBackdrop.addEventListener('click', closeModal);
            if (closeBtn) closeBtn.addEventListener('click', closeModal);
            if (closeBtnFooter) closeBtnFooter.addEventListener('click', closeModal);

            // Tutup modal dengan tombol ESC
            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape' && !qrisModal.classList.contains('hidden')) {
                    closeModal();
                }
            });
        });
        </script>