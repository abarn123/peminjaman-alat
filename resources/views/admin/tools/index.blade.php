@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Kelola Data Alat</h1>
        <p class="text-gray-500 mt-1">Kelola daftar alat yang tersedia di </p>
    </div>

    <!-- Tombol Tambah Alat -->
    <div class="mb-6 flex justify-end">
        <a href="{{ route('tools.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Alat Baru
        </a>
    </div>

    <!-- Tabel Alat -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Daftar Alat</h3>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500">Total: {{ $tools->total() }} alat</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            @if($tools->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Belum ada data alat. Silakan tambah alat baru.</p>
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Gambar</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Alat</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Kategori</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-24">Stok</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($tools as $key => $tool)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-sm text-gray-500">
                                    {{ ($tools->currentPage() - 1) * $tools->perPage() + $key + 1 }}
                                </td>
                                <td class="px-6 py-3">
                                    @if($tool->gambar)
                                        <img src="{{ asset('storage/' . $tool->gambar) }}" alt="{{ $tool->nama_alat }}" class="max-w-12 max-h-12 object-cover rounded-lg shadow-sm">
                                    @else
                                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <div class="font-medium text-gray-800">{{ $tool->nama_alat }}</div>
                                    @if($tool->deskripsi)
                                        <div class="text-xs text-gray-500 mt-1 max-w-xs truncate">{{ $tool->deskripsi }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $tool->category->nama_kategori }}
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-1">
                                        <span class="text-sm font-semibold text-gray-800">{{ $tool->stok }}</span>
                                        <span class="text-xs text-gray-500">unit</span>
                                    </div>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('tools.edit', $tool->id) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-medium rounded-lg transition duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('tools.destroy', $tool->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus alat ini? Data peminjaman terkait mungkin akan error.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-red-500 hover:bg-red-600 text-white text-xs font-medium rounded-lg transition duration-200">
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Pagination -->
        @if($tools->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-500">
                        Menampilkan <span class="font-medium">{{ $tools->firstItem() }}</span> 
                        sampai <span class="font-medium">{{ $tools->lastItem() }}</span> 
                        dari <span class="font-medium">{{ $tools->total() }}</span> data
                    </div>
                    <div>
                        {{ $tools->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection