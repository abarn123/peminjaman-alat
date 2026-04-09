@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Edit Data Alat</h1>
        <p class="text-gray-500 mt-1">Ubah informasi alat </p>
    </div>

    <!-- Form Card -->
    <div class="max-w-4xl mx-auto">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-800">Form Edit Alat</h3>
            </div>

            <div class="p-6">
                <form action="{{ route('tools.update', $tool->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <!-- Nama Alat -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Alat <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="nama_alat" 
                               class="w-full px-4 py-2 border @error('nama_alat') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               value="{{ old('nama_alat', $tool->nama_alat) }}" 
                               placeholder="Contoh: Multimeter Digital, Oscilloscope, dll" 
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
                                <option value="{{ $cat->id }}" {{ old('category_id', $tool->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stok dan Gambar (2 kolom) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah Stok <span class="text-red-500">*</span></label>
                            <input type="number" 
                                   name="stok" 
                                   class="w-full px-4 py-2 border @error('stok') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                   value="{{ old('stok', $tool->stok) }}" 
                                   min="0" 
                                   required>
                            @error('stok')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Ganti Gambar <span class="text-gray-400 text-xs">(Opsional)</span></label>
                            <input type="file" 
                                   name="gambar" 
                                   class="w-full px-3 py-2 border @error('gambar') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" 
                                   accept="image/*">
                            @error('gambar')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Preview Gambar Saat Ini -->
                    @if($tool->gambar)
                        <div class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . $tool->gambar) }}" alt="Current Image" class="w-20 h-20 object-cover rounded-lg shadow-sm border border-gray-200">
                                <div class="text-sm text-gray-500">
                                    <p>File: {{ basename($tool->gambar) }}</p>
                                    <p class="text-xs mt-1">Kosongkan pilihan file jika tidak ingin mengganti gambar.</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Deskripsi -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                        <textarea name="deskripsi" 
                                  rows="4" 
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                  placeholder="Deskripsikan fungsi dan spesifikasi alat...">{{ old('deskripsi', $tool->deskripsi) }}</textarea>
                        <p class="mt-1 text-xs text-gray-500">Deskripsi opsional, namun disarankan untuk memberikan informasi lengkap tentang alat.</p>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <a href="{{ route('tools.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-semibold text-blue-800">Informasi</h4>
                    <p class="text-xs text-blue-600 mt-1">Perubahan data alat akan langsung berlaku untuk semua transaksi peminjaman yang sedang berlangsung.</p>
                </div>
            </div>
        </div>
    </div>
@endsection