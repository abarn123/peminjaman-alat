@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Bukti Pembayaran Denda</h1>
        <p class="text-gray-500 mt-1">Detail informasi pembayaran denda peminjaman</p>
    </div>

    <div class="max-w-4xl mx-auto">
        <!-- Status Card -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gradient-to-r 
                @if($loan->midtrans_status == 'settlement') from-green-500 to-green-600
                @elseif($loan->midtrans_status == 'pending') from-yellow-500 to-yellow-600
                @elseif($loan->midtrans_status == 'expire') from-red-500 to-red-600
                @else from-gray-500 to-gray-600
                @endif">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        @if($loan->midtrans_status == 'settlement')
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @elseif($loan->midtrans_status == 'pending')
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @else
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                        <h3 class="text-lg font-semibold text-white">
                            Status: 
                            @if($loan->midtrans_status == 'settlement') LUNAS
                            @elseif($loan->midtrans_status == 'pending') MENUNGGU PEMBAYARAN
                            @elseif($loan->midtrans_status == 'expire') KADALUARSA
                            @else {{ strtoupper($loan->midtrans_status) }}
                            @endif
                        </h3>
                    </div>
                    <span class="text-xs text-white/80">Order ID: {{ $loan->midtrans_order_id }}</span>
                </div>
            </div>
        </div>

        <!-- Informasi Peminjaman -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                    <h3 class="text-sm font-semibold text-gray-800">Informasi Peminjaman</h3>
                </div>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white text-sm font-medium shadow-sm">
                            {{ strtoupper(substr($loan->user->name, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Peminjam</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $loan->user->name }}</p>
                            <p class="text-xs text-gray-500">{{ $loan->user->email }}</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        @if($loan->tool->gambar)
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                <img src="{{ asset('storage/' . $loan->tool->gambar) }}" alt="{{ $loan->tool->nama_alat }}" class="w-full h-full object-cover">
                            </div>
                        @else
                            <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                </svg>
                            </div>
                        @endif
                        <div>
                            <p class="text-xs text-gray-500">Alat</p>
                            <p class="text-sm font-semibold text-gray-800">{{ $loan->tool->nama_alat }}</p>
                            <p class="text-xs text-gray-500">{{ $loan->tool->category->nama_kategori }}</p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-100">
                    <div>
                        <p class="text-xs text-gray-500">ID Peminjaman</p>
                        <p class="text-sm font-semibold text-gray-800">#{{ $loan->id }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500">Order ID</p>
                        <p class="text-sm font-semibold text-gray-800 font-mono">{{ $loan->midtrans_order_id }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detail Pembayaran -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden mb-6">
    <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
        <div class="flex items-center gap-2">
            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-sm font-semibold text-gray-800">Detail Pembayaran</h3>
        </div>
    </div>
    <div class="p-6">
        <div class="bg-yellow-50 rounded-lg p-4 mb-4">
            <div class="flex items-center justify-between">
                <span class="text-sm text-gray-600">Total Denda</span>
                <span class="text-2xl font-bold text-red-600">Rp {{ number_format($loan->denda, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- Status Pembayaran - Full width center -->
        <div class="flex justify-center">
            <div class="p-3 bg-gray-50 rounded-lg text-center w-full max-w-md">
                <p class="text-xs text-gray-500">Status Pembayaran</p>
                <p class="text-sm font-medium">
                    @if($loan->midtrans_status == 'settlement')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            LUNAS
                        </span>
                    @elseif($loan->midtrans_status == 'pending')
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            MENUNGGU
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            {{ strtoupper($loan->midtrans_status) }}
                        </span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

    

        <!-- Tombol Aksi -->
        <div class="flex justify-between items-center">
            <a href="{{ route('petugas.denda.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
            @if($loan->midtrans_status == 'pending')
            <a href="#" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition duration-200 shadow-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                </svg>
                Cek Status Pembayaran
            </a>
            @endif
        </div>
    </div>
@endsection