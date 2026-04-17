@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ url('/peminjam/riwayat') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-4">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Kembali ke Riwayat
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Upload Bukti Pembayaran Denda</h1>
            <p class="text-gray-500 mt-2">Kirimkan bukti pembayaran denda Anda untuk verifikasi petugas</p>
        </div>

        <!-- Card Info Peminjaman -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Peminjaman</h2>
            
            <div class="grid grid-cols-2 gap-6">
                <div>
                    <p class="text-sm text-gray-500">Nama Alat</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $loan->tool->nama_alat }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Jumlah Denda</p>
                    <p class="text-lg font-semibold text-red-600">Rp {{ number_format($loan->denda, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Pinjam</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $loan->tanggal_pinjam }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Kembali (Rencana)</p>
                    <p class="text-lg font-semibold text-gray-800">{{ $loan->tanggal_kembali_rencana }}</p>
                </div>
            </div>
        </div>

        <!-- Card QRIS Info -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 mb-8">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pembayaran</h2>
            
            <div class="mb-6">
                <p class="text-sm text-gray-500 mb-2">Transfer ke Nomor Rekening</p>
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-200 text-center">
                    <p class="text-sm font-mono text-blue-800 break-all">{{ $loan->denda_tf ?? 'Data tidak tersedia' }}</p>
                </div>
            </div>

            <div>
                <p class="text-sm text-gray-500 mb-2">Scan QRIS untuk Membayar</p>
                <div class="bg-gray-50 rounded-lg p-6 border border-dashed border-gray-200 text-center">
                    @if($loan->denda_qris_image_path)
                        <img src="{{ asset('storage/' . $loan->denda_qris_image_path) }}" alt="QRIS" class="w-48 h-48 object-contain mx-auto">
                    @else
                        <div class="text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-sm">QRIS tidak tersedia</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Form Upload Bukti -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Upload Bukti Pembayaran</h2>
            
            <form action="{{ route('peminjam.bukti-denda', $loan->id) }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf
                
                <div class="mb-6">
                    <label for="payment_proof" class="block text-sm font-medium text-gray-700 mb-3">
                        Pilih Foto Bukti Pembayaran
                    </label>
                    
                    <div class="relative">
                        <input type="file" 
                               name="payment_proof" 
                               id="payment_proof"
                               class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 cursor-pointer"
                               accept="image/*"
                               required>
                    </div>
                    
                    <div class="mt-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <p class="text-xs text-gray-500">Format: PNG, JPG, JPEG (Maksimal 4MB)</p>
                    </div>

                    @error('payment_proof')
                        <div class="mt-2 p-3 bg-red-50 border border-red-200 rounded-lg text-sm text-red-700">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Preview Container -->
                <div id="previewContainer" class="hidden mb-6">
                    <p class="text-sm font-medium text-gray-700 mb-3">Preview</p>
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 text-center">
                        <img id="previewImage" src="" alt="Preview" class="max-h-96 max-w-full object-contain mx-auto">
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3">
                    <a href="{{ url('/peminjam/riwayat') }}" class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-lg transition duration-200">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 inline-flex items-center justify-center px-4 py-3 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Upload Bukti
                    </button>
                </div>
            </form>
        </div>

        <!-- Informasi Tambahan -->
        <div class="bg-blue-50 rounded-xl border border-blue-200 p-6 mt-8">
            <div class="flex gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-sm font-semibold text-blue-900 mb-1">Tips Pengiriman Bukti</h3>
                    <ul class="text-sm text-blue-800 space-y-1 list-disc list-inside">
                        <li>Pastikan bukti pembayaran jelas dan terbaca</li>
                        <li>Sertakan nama penerima dan jumlah transfer</li>
                        <li>Gunakan foto atau screenshot dengan kualitas baik</li>
                        <li>Petugas akan memverifikasi dalam 1-2 hari kerja</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const fileInput = document.getElementById('payment_proof');
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    previewImage.src = event.target.result;
                    previewContainer.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }
        });
    });
    </script>
@endsection
