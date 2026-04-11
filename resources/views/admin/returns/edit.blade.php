@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Edit Data Pengembalian</h1>
        <p class="text-gray-500 mt-1">Ubah informasi tanggal pengembalian alat</p>
    </div>

    <!-- Form Card -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white text-sm font-medium shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800">Form Edit Pengembalian</h3>
                        <p class="text-xs text-gray-500">Ubah tanggal pengembalian jika terjadi kesalahan input</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.returns.update', $loan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Peminjam (Disabled - Readonly) -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Peminjam</label>
                        <div class="relative">
                            <div class="absolute left-3 top-1/2 transform -translate-y-1/2 w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white text-xs font-medium shadow-sm">
                                {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                            </div>
                            <input type="text" 
                                   class="w-full pl-14 pr-4 py-2 bg-gray-100 border border-gray-200 rounded-lg text-gray-700 cursor-not-allowed" 
                                   value="{{ $loan->user->name }}" 
                                   disabled>
                        </div>
                    </div>

                    <!-- Alat (Disabled - Readonly) -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alat</label>
                        <div class="relative flex items-center">
                            @if($loan->tool->gambar)
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2">
                                    <img src="{{ asset('storage/' . $loan->tool->gambar) }}" alt="{{ $loan->tool->nama_alat }}" class="w-6 h-6 object-cover rounded">
                                </div>
                            @endif
                            <input type="text" 
                                   class="w-full pl-14 pr-4 py-2 bg-gray-100 border border-gray-200 rounded-lg text-gray-700 cursor-not-allowed" 
                                   value="{{ $loan->tool->nama_alat }} ({{ $loan->tool->category->nama_kategori }})" 
                                   disabled>
                        </div>
                    </div>

                    <!-- Tanggal Kembali Aktual -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Kembali Aktual <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <input type="date" 
                                   name="tanggal_kembali_aktual" 
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                   value="{{ old('tanggal_kembali_aktual', $loan->tanggal_kembali_aktual) }}" 
                                   required>
                        </div>
                        <div class="flex items-start gap-2 mt-2">
                            <svg class="w-4 h-4 text-yellow-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <p class="text-xs text-gray-500">Ubah tanggal ini jika admin salah input waktu pengembalian.</p>
                        </div>
                    </div>

                    <!-- Informasi Tambahan (Ringkasan Status) -->
                    @php
                        $rencana = strtotime($loan->tanggal_kembali_rencana);
                        $aktual = strtotime($loan->tanggal_kembali_aktual);
                        $isLate = $aktual > $rencana;
                    @endphp
                    
                    <div class="mb-6 p-4 rounded-lg {{ $isLate ? 'bg-red-50 border border-red-200' : 'bg-green-50 border border-green-200' }}">
                        <div class="flex items-start gap-2">
                            @if($isLate)
                                <svg class="w-5 h-5 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-red-700">Status Saat Ini: Terlambat</p>
                                    <p class="text-xs text-red-600 mt-1">Rencana Kembali: {{ $loan->tanggal_kembali_rencana }} | Aktual: {{ $loan->tanggal_kembali_aktual }}</p>
                                </div>
                            @else
                                <svg class="w-5 h-5 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-green-700">Status Saat Ini: Tepat Waktu</p>
                                    <p class="text-xs text-green-600 mt-1">Rencana Kembali: {{ $loan->tanggal_kembali_rencana }} | Aktual: {{ $loan->tanggal_kembali_aktual }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.returns.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-semibold text-yellow-800">Perhatian</h4>
                    <ul class="text-xs text-yellow-700 mt-1 space-y-1">
                        <li>• Mengubah tanggal kembali akan mempengaruhi status keterlambatan</li>
                        <li>• Jika status berubah menjadi telat, sistem akan menghitung ulang denda</li>
                        <li>• Pastikan tanggal yang dimasukkan sesuai dengan bukti pengembalian</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection