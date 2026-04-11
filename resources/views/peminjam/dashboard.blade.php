@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Alat Tersedia</h1>
        <p class="text-gray-500 mt-1">Silakan pilih alat yang ingin dipinjam</p>
    </div>

    <!-- Search & Filter Bar (Opsional) -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center gap-4">
        <div class="relative w-full sm:w-80">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <input type="text" id="searchTool" placeholder="Cari nama alat atau kategori..." class="w-full pl-9 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200">
        </div>
        <div class="text-sm text-gray-500">
            Menampilkan {{ $tools->count() }} alat tersedia
        </div>
    </div>

    <!-- Grid Alat -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="toolsGrid">
        @forelse($tools as $tool)
            <div class="tool-card bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden hover:shadow-lg transition duration-300" data-name="{{ strtolower($tool->nama_alat) }}" data-category="{{ strtolower($tool->category->nama_kategori) }}">
                <!-- Gambar Alat -->
                <div class="relative h-48 bg-white flex items-center justify-center">
                    @if($tool->gambar)
                        <img src="{{ asset('storage/' . $tool->gambar) }}" 
                            alt="{{ $tool->nama_alat }}" 
                            class="w-full h-full object-contain p-2">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                    
                    <!-- Badge Stok -->
                    <div class="absolute top-3 right-3">
                        @if($tool->stok > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Stok: {{ $tool->stok }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Stok Habis
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Konten Card -->
                <div class="p-5">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="text-lg font-bold text-gray-800">{{ $tool->nama_alat }}</h3>
                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                            {{ $tool->category->nama_kategori }}
                        </span>
                    </div>
                    
                    <p class="text-sm text-gray-600 mt-2 line-clamp-2">
                        {{ $tool->deskripsi ?? 'Tidak ada deskripsi untuk alat ini.' }}
                    </p>
                    
                    <div class="mt-4 pt-4 border-t border-gray-100">
                        @if($tool->stok > 0)
                            <form action="{{ url('/peminjam/ajukan') }}" method="POST" class="space-y-3">
                                @csrf
                                <input type="hidden" name="tool_id" value="{{ $tool->id }}">
                                
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Rencana Kembali</label>
                                    <input type="date" 
                                           name="tanggal_kembali" 
                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 text-sm" 
                                           required 
                                           min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                                </div>
                                
                                <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200 shadow-sm">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                    </svg>
                                    Pinjam Alat
                                </button>
                            </form>
                        @else
                            <button disabled class="w-full inline-flex items-center justify-center px-4 py-2 bg-gray-300 text-gray-500 text-sm font-medium rounded-lg cursor-not-allowed">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                                </svg>
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="mt-2 text-sm text-gray-500">Belum ada alat yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if(method_exists($tools, 'hasPages') && $tools->hasPages())
        <div class="mt-8">
            {{ $tools->links('pagination::tailwind') }}
        </div>
    @endif

    <!-- Info Card -->
    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start gap-3">
            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="text-sm font-semibold text-blue-800">Informasi Peminjaman</h4>
                <ul class="text-xs text-blue-600 mt-1 space-y-1">
                    <li>• Pilih tanggal rencana pengembalian alat (minimal H+1 dari hari ini)</li>
                    <li>• Pengembalian yang terlambat akan dikenakan denda sesuai ketentuan</li>
                    <li>• Status peminjaman dapat dilihat di menu "Riwayat Saya"</li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Fungsi pencarian real-time
    const searchInput = document.getElementById('searchTool');
    const toolCards = document.querySelectorAll('.tool-card');
    
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            
            toolCards.forEach(card => {
                const name = card.dataset.name || '';
                const category = card.dataset.category || '';
                
                if (name.includes(searchTerm) || category.includes(searchTerm)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
</script>
@endpush

<style>
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>