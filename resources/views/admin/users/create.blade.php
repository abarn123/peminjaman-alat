@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Tambah User Baru</h1>
        <p class="text-gray-500 mt-1">Buat akun pengguna baru untuk mengakses sistem</p>
    </div>

    <!-- Form Card -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-700 rounded-full flex items-center justify-center text-white text-sm font-medium shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800">Form Tambah User</h3>
                        <p class="text-xs text-gray-500">Isi data pengguna dengan lengkap dan benar</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <form action="{{ route('users.store') }}" method="POST">
                    @csrf

                    <!-- Nama Lengkap -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <input type="text" 
                                   name="name" 
                                   class="w-full pl-10 pr-4 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                   value="{{ old('name') }}" 
                                   placeholder="Masukkan nama lengkap" 
                                   required>
                        </div>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Email Address <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path>
                            </svg>
                            <input type="email" 
                                   name="email" 
                                   class="w-full pl-10 pr-4 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                   value="{{ old('email') }}" 
                                   placeholder="user@example.com" 
                                   required>
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role (Hak Akses) -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role (Hak Akses) <span class="text-red-500">*</span></label>
                        <select name="role" 
                                class="w-full px-4 py-2 border @error('role') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 appearance-none bg-white" 
                                required>
                            <option value="">-- Pilih Role --</option>
                            <option value="peminjam" {{ old('role') == 'peminjam' ? 'selected' : '' }}>📋 Peminjam</option>
                            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>🔧 Petugas Lab</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>🛡️ Administrator</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @else
                            <p class="mt-1 text-xs text-gray-500">Role menentukan akses dan fitur yang tersedia untuk pengguna.</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <input type="password" 
                                   name="password" 
                                   class="w-full pl-10 pr-4 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                   placeholder="Minimal 6 karakter" 
                                   required 
                                   minlength="6">
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @else
                            <p class="mt-1 text-xs text-gray-500">Password harus terdiri dari minimal 6 karakter.</p>
                        @enderror
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <a href="{{ route('users.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Batal
                        </a>
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan User
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
                    <h4 class="text-sm font-semibold text-blue-800">Informasi Role</h4>
                    <ul class="text-xs text-blue-600 mt-1 space-y-1">
                        <li>• <span class="font-medium">Administrator:</span> Akses penuh ke semua fitur termasuk manajemen user</li>
                        <li>• <span class="font-medium">Petugas Lab:</span> Dapat memvalidasi peminjaman dan pengembalian alat</li>
                        <li>• <span class="font-medium">Peminjam:</span> Hanya dapat meminjam dan melihat riwayat peminjaman</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Security Note -->
        <div class="mt-4 bg-gray-50 border border-gray-200 rounded-lg p-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span class="text-xs text-gray-600">Password akan dienkripsi sebelum disimpan ke database</span>
                </div>
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                </svg>
            </div>
        </div>
    </div>
@endsection