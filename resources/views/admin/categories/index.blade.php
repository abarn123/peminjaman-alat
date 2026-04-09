@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Kelola Kategori Alat</h1>
        <p class="text-gray-500 mt-1">Kelola data kategori alat yang tersedia.</p>
    </div>

    <!-- Tombol Tambah Kategori -->
    <div class="mb-6 flex justify-end">
        <a href="{{ route('categories.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Kategori
        </a>
    </div>

    <!-- Tabel Kategori -->
    <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <h3 class="text-sm font-semibold text-gray-800">Daftar Kategori</h3>
                <div class="flex items-center gap-2">
                    <span class="text-xs text-gray-500">Total: {{ $categories->total() }} kategori</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            @if($categories->isEmpty())
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                    </svg>
                    <p class="mt-2 text-sm text-gray-500">Belum ada kategori. Silakan tambah kategori baru.</p>
                </div>
            @else
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-16">No</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-32">Jumlah Alat</th>
                            <th class="text-left px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider w-36">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($categories as $key => $cat)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-sm text-gray-500">
                                    {{ ($categories->currentPage() - 1) * $categories->perPage() + $key + 1 }}
                                </td>
                                <td class="px-6 py-3">
                                    <span class="font-medium text-gray-800">{{ $cat->nama_kategori }}</span>
                                </td>
                                <td class="px-6 py-3">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $cat->tools_count }} Item
                                    </span>
                                </td>
                                <td class="px-6 py-3">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('categories.edit', $cat->id) }}" class="inline-flex items-center px-3 py-1.5 bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-medium rounded-lg transition duration-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                            Edit
                                        </a>
                                        <form action="{{ route('categories.destroy', $cat->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini? Data alat dengan kategori ini juga akan terpengaruh.');">
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
        @if($categories->hasPages())
            <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-gray-500">
                        Menampilkan <span class="font-medium">{{ $categories->firstItem() }}</span> 
                        sampai <span class="font-medium">{{ $categories->lastItem() }}</span> 
                        dari <span class="font-medium">{{ $categories->total() }}</span> data
                    </div>
                    <div>
                        {{ $categories->links('pagination::tailwind') }}
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection