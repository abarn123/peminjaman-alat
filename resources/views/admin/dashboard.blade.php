@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Admin Dashboard</h1>
        <p class="text-gray-500 mt-1">Selamat datang, {{ auth()->user()->name }}!</p>
    </div>

    <!-- Statistik Cards - Row 1 -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        <!-- Card Total Pengguna -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition duration-200">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-gray-500">Total Pengguna</h3>
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4">
                <p class="text-3xl font-bold text-gray-800">{{ $totalUser }}</p>
                <p class="text-sm text-gray-500 mt-1">User Terdaftar</p>
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                <a href="{{ route('users.index') }}" class="text-sm text-blue-600 hover:text-blue-700 transition">Lihat Detail</a>
                <span class="text-gray-400">→</span>
            </div>
        </div>

        <!-- Card Data Alat -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition duration-200">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-gray-500">Data Alat</h3>
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4">
                <p class="text-3xl font-bold text-gray-800">{{ $totalAlat }} <span class="text-sm font-normal text-gray-500">(Stok: {{ $totalStok }})</span></p>
                <p class="text-sm text-gray-500 mt-1">Jenis Alat Tersedia</p>
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                <a href="{{ route('tools.index') }}" class="text-sm text-blue-600 hover:text-blue-700 transition">Lihat Detail</a>
                <span class="text-gray-400">→</span>
            </div>
        </div>

        <!-- Card Kategori -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition duration-200">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-gray-500">Kategori</h3>
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4">
                <p class="text-3xl font-bold text-gray-800">{{ $totalKategori }}</p>
                <p class="text-sm text-gray-500 mt-1">Kategori Alat</p>
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                <a href="{{ route('categories.index') }}" class="text-sm text-blue-600 hover:text-blue-700 transition">Lihat Detail</a>
                <span class="text-gray-400">→</span>
            </div>
        </div>
    </div>

    <!-- Statistik Cards - Row 2 -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Card Sedang Dipinjam -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition duration-200">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-gray-500">Sedang Dipinjam</h3>
                    <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4">
                <p class="text-3xl font-bold text-gray-800">{{ $sedangDipinjam }}</p>
                <p class="text-sm text-gray-500 mt-1">Transaksi Aktif</p>
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                <a href="{{ route('admin.loans.index') }}" class="text-sm text-blue-600 hover:text-blue-700 transition">Pantau</a>
                <span class="text-gray-400">→</span>
            </div>
        </div>

        <!-- Card Sudah Dikembalikan -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-lg transition duration-200">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-medium text-gray-500">Sudah Dikembalikan</h3>
                    <div class="w-8 h-8 bg-teal-100 rounded-lg flex items-center justify-center">
                        <svg class="w-4 h-4 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="px-6 py-4">
                <p class="text-3xl font-bold text-gray-800">{{ $sudahDikembalikan }}</p>
                <p class="text-sm text-gray-500 mt-1">Transaksi Selesai</p>
            </div>
            <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 flex justify-between items-center">
                <a href="{{ route('admin.returns.index') }}" class="text-sm text-blue-600 hover:text-blue-700 transition">Pantau</a>
                <span class="text-gray-400">→</span>
            </div>
        </div>
    </div>

    <!-- Aktivitas Sistem -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <h3 class="text-sm font-semibold text-gray-800">Aktivitas Sistem Terakhir</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr class="border-b border-gray-200">
                        <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($recentLogs as $log)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-3 text-sm text-gray-500">{{ $log->created_at->diffForHumans() }}</td>
                            <td class="px-6 py-3">
                                <span class="font-medium text-gray-800">{{ $log->user->name }}</span>
                                <br>
                                <span class="text-xs px-2 py-1 bg-gray-100 text-gray-600 rounded-full">{{ ucfirst($log->user->role) }}</span>
                            </td>
                            <td class="px-6 py-3 text-sm text-gray-700">{{ $log->action }}</td>
                            <td class="px-6 py-3 text-sm text-gray-500">{{ Str::limit($log->description, 50) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-500">Belum ada aktivitas tercatat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-3 bg-gray-50 border-t border-gray-100 text-right">
            <a href="{{ url('/admin/logs') }}" class="text-sm text-blue-600 hover:text-blue-700 transition">Lihat Semua Log →</a>
        </div>
    </div>
@endsection