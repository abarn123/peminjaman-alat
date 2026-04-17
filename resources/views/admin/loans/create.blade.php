@extends('layouts.app')

@section('content')
    <div class="min-h-[60vh] flex items-center justify-center">
        <div class="text-center max-w-md mx-auto">
            <!-- Icon -->
            
            
            <!-- Pesan -->
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Halaman Dihapus</h1>
            <p class="text-lg text-gray-500 mb-4">
                Halaman yang Anda cari telah dihapus.
            </p>
            <p class="text-sm text-gray-400 mb-8">
                Mungkin halaman ini sudah tidak tersedia atau URL-nya berubah.
            </p>
            
            <!-- Tombol -->
            <div class="flex gap-3 justify-center">
                <a href="{{ url()->previous() }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition">
                    Kembali
                </a>
            </div>
        </div>
    </div>
@endsection