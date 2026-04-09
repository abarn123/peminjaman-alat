@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Edit User</h1>
        <p class="text-gray-500 mt-1">Ubah informasi data pengguna: {{ $user->name }}</p>
    </div>

    <!-- Form Card -->
    <div class="max-w-2xl mx-auto">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white text-sm font-medium shadow-sm">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800">Form Edit User</h3>
                        <p class="text-xs text-gray-500">Ubah data pengguna dengan role yang sesuai</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Nama Lengkap -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                        <input type="text" 
                               name="name" 
                               class="w-full px-4 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                               value="{{ old('name', $user->name) }}" 
                               placeholder="Masukkan nama lengkap" 
                               required>
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
                                   value="{{ old('email', $user->email) }}" 
                                   placeholder="user@example.com" 
                                   required>
                        </div>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Role <span class="text-red-500">*</span></label>
                        <select name="role" 
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 appearance-none bg-white" 
                                required>
                            <option value="peminjam" {{ $user->role == 'peminjam' ? 'selected' : '' }}>📋 Peminjam</option>
                            <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>🔧 Petugas</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>🛡️ Administrator</option>
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Role menentukan akses dan fitur yang tersedia untuk pengguna.</p>
                    </div>

                    <!-- Divider -->
                    <div class="relative my-6">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-gray-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-3 bg-white text-gray-500">Keamanan Akun</span>
                        </div>
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Password Baru</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                            <input type="password" 
                                   name="password" 
                                   class="w-full pl-10 pr-4 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                   placeholder="Kosongkan jika tidak ingin mengganti"
                                   minlength="6">
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @else
                            <p class="mt-1 text-xs text-gray-500">Minimal 6 karakter. Kosongkan jika tidak ingin mengubah password.</p>
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
                            Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-yellow-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-semibold text-yellow-800">Informasi Role</h4>
                    <ul class="text-xs text-yellow-700 mt-1 space-y-1">
                        <li>• <span class="font-medium">Administrator:</span> Akses penuh ke semua fitur termasuk manajemen user</li>
                        <li>• <span class="font-medium">Petugas:</span> Dapat memvalidasi peminjaman dan pengembalian alat</li>
                        <li>• <span class="font-medium">Peminjam:</span> Hanya dapat meminjam dan melihat riwayat peminjaman</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection