@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Kategori</h1>
        <p class="text-gray-500 mt-1">Buat kategori baru untuk mengelompokkan alat-alat </p>
    </div>

    <!-- Form Card -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <h3 class="text-sm font-semibold text-gray-800">Form Tambah Kategori</h3>
            </div>

            <div class="p-6">
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Kategori</label>
                        <input type="text" 
                               name="nama_kategori" 
                               class="w-full px-4 py-2 border @error('nama_kategori') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               value="{{ old('nama_kategori') }}" 
                               placeholder="Contoh: Elektronik, Furniture, Alat Ukur, dll" 
                               required>
                        @error('nama_kategori')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Nama kategori akan digunakan untuk mengelompokkan alat-alat yang sejenis.</p>
                    </div>

                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Kategori
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
                    <p class="text-xs text-blue-600 mt-1">Kategori yang sudah dibuat dapat digunakan saat menambahkan alat baru. Kategori yang memiliki alat tidak dapat dihapus.</p>
                </div>
            </div>
        </div>
    </div>
@endsection