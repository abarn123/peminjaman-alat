@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Alat Baru</h1>
        <p class="text-gray-500 mt-1">Tambahkan alat baru ke inventaris </p>
    </div>

    <!-- Form Card -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-800">Form Tambah Alat</h3>
            </div>

            <div class="p-6">
                <form action="{{ route('tools.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Nama Alat -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Alat <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="nama_alat" 
                               class="w-full px-4 py-2 border @error('nama_alat') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               value="{{ old('nama_alat') }}" 
                               placeholder="Contoh: Multimeter Digital, Oscilloscope, Tang Ampere" 
                               required>
                        @error('nama_alat')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kategori -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" 
                                class="w-full px-4 py-2 border @error('category_id') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 appearance-none bg-white" 
                                required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Tidak menemukan kategori? <a href="{{ route('categories.create') }}" class="text-blue-600 hover:underline">Buat kategori baru</a></p>
                    </div>

                    <!-- Stok dan Gambar (2 kolom) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Stok <span class="text-red-500">*</span></label>
                            <input type="number" 
                                   name="stok" 
                                   class="w-full px-4 py-2 border @error('stok') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                   value="{{ old('stok', 1) }}" 
                                   min="0" 
                                   required>
                            @error('stok')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Alat <span class="text-gray-400 text-xs">(Opsional)</span></label>
                            <input type="file" 
                                   name="gambar" 
                                   class="w-full px-3 py-2 border @error('gambar') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" 
                                   accept="image/*">
                            @error('gambar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @else
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, JPEG. Maksimal ukuran: 2MB</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi / Spesifikasi</label>
                        <textarea name="deskripsi" 
                                  rows="4" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                  placeholder="Deskripsikan fungsi, spesifikasi teknis, dan informasi penting lainnya tentang alat ini...">{{ old('deskripsi') }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Deskripsi opsional, namun disarankan untuk memberikan informasi lengkap tentang alat.</p>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <a href="{{ route('tools.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Kembali
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Alat
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-green-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-semibold text-green-800">Informasi</h4>
                    <p class="text-xs text-green-600 mt-1">Setelah menambahkan alat, alat akan tersedia untuk dipinjam oleh pengguna. Pastikan data yang dimasukkan akurat.</p>
                </div>
            </div>
        </div>
    </div>
@endsection