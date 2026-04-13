@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Log Aktivitas</h1>
        <p class="text-gray-500 mt-1">Riwayat lengkap aktivitas sistem dan pengguna</p>
    </div>

    <!-- Tabel Log Aktivitas -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-sm font-semibold text-gray-800">Semua Aktivitas</h3>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500">Total: {{ $logs->total() }} aktivitas</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            @if($logs->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Tidak ada aktivitas yang tercatat.</p>
                </div>
            @else
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
                        @forelse($logs as $log)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-sm text-gray-500">
                                    <div class="flex flex-col">
                                        <span>{{ $log->created_at->format('d/m/Y') }}</span>
                                        <span class="text-xs text-gray-400">{{ $log->created_at->format('H:i:s') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white text-xs font-medium shadow-sm">
                                            {{ strtoupper(substr($log->user->name ?? 'S', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $log->user->name ?? 'Sistem' }}</p>
                                            <span class="text-xs px-2 py-0.5 bg-gray-100 text-gray-600 rounded-full">
                                                {{ ucfirst($log->user->role ?? 'sistem') }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    @php
                                        $actionColors = [
                                            'create' => 'bg-green-100 text-green-800',
                                            'update' => 'bg-yellow-100 text-yellow-800',
                                            'delete' => 'bg-red-100 text-red-800',
                                            'login' => 'bg-blue-100 text-blue-800',
                                            'logout' => 'bg-gray-100 text-gray-800',
                                            'Registrasi' => 'bg-purple-100 text-purple-800',
                                            'Tambah User' => 'bg-green-100 text-green-800',
                                            'Update User' => 'bg-yellow-100 text-yellow-800',
                                            'Hapus User' => 'bg-red-100 text-red-800',
                                        ];
                                        $colorClass = $actionColors[$log->action] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $colorClass }}">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-500">
                                    <div class="truncate max-w-md" title="{{ $log->description ?? '-' }}">
                                        {{ Str::limit($log->description ?? '-', 50) }}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                                    Tidak ada aktivitas yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Pagination -->
        @if($logs->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-500">
                        Menampilkan 
                        <span class="font-medium text-gray-700">{{ $logs->firstItem() }}</span> 
                        sampai 
                        <span class="font-medium text-gray-700">{{ $logs->lastItem() }}</span> 
                        dari 
                        <span class="font-medium text-gray-700">{{ $logs->total() }}</span> 
                        data
                    </div>
                    
                    <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                        {{-- Previous --}}
                        @if ($logs->onFirstPage())
                            <span class="relative inline-flex items-center rounded-l-md px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 cursor-not-allowed">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                <span class="ml-1 hidden sm:inline">Sebelumnya</span>
                            </span>
                        @else
                            <a href="{{ $logs->previousPageUrl() }}" class="relative inline-flex items-center rounded-l-md px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 hover:text-blue-600 transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                                <span class="ml-1 hidden sm:inline">Sebelumnya</span>
                            </a>
                        @endif

                        {{-- Numbers --}}
                        @foreach ($logs->getUrlRange(max(1, $logs->currentPage() - 2), min($logs->lastPage(), $logs->currentPage() + 2)) as $page => $url)
                            @if ($page == $logs->currentPage())
                                <span class="relative inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-blue-600 border border-blue-600">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 hover:text-blue-600 transition">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if ($logs->hasMorePages())
                            <a href="{{ $logs->nextPageUrl() }}" class="relative inline-flex items-center rounded-r-md px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-gray-200 hover:bg-gray-50 hover:text-blue-600 transition">
                                <span class="mr-1 hidden sm:inline">Selanjutnya</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @else
                            <span class="relative inline-flex items-center rounded-r-md px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-200 cursor-not-allowed">
                                <span class="mr-1 hidden sm:inline">Selanjutnya</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        @endif
                    </nav>
                </div>
            </div>
        @endif
    </div>
@endsection