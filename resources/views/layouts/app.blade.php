<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Peminjaman Alat</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">

    <!-- NAVBAR / HEADER -->
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50" x-data="{ mobileMenuOpen: false }" @keydown.escape.window="mobileMenuOpen = false">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
               <!-- Logo / Brand -->
                <div class="flex items-center space-x-2">
                    <a href="#" class="flex items-center space-x-2">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo CampTools" class="w-8 h-8 w-auto object-contain">
                        <span class="text-xl font-bold text-gray-800 hover:text-blue-600 transition">CampTools</span>
                    </a>
                </div>

                <!-- Menu navbar (Desktop) -->
                <div class="hidden md:flex items-center space-x-1 ml-auto mr-6">
                    <ul class="flex space-x-1">
                        @auth
                            <!-- MENU UNTUK ROLE ADMIN -->
                            @if(auth()->user()->role == 'admin')
                                <li>
                                    <a class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition 
                                        {{ request()->is('admin/dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-100' }}" 
                                       href="/admin/dashboard">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                        </svg>
                                        Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition 
                                        {{ request()->routeIs('categories.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-100' }}" 
                                       href="{{ route('categories.index') }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l5 5a2 2 0 01.586 1.414V19a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"></path>
                                        </svg>
                                        Kategori
                                    </a>
                                </li>
                                <li>
                                    <a class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition 
                                        {{ request()->routeIs('tools.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-100' }}" 
                                       href="{{ route('tools.index') }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        Alat
                                    </a>
                                </li>
                                <li>
                                    <a class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition 
                                        {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-100' }}" 
                                       href="{{ route('users.index') }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                        </svg>
                                        User
                                    </a>
                                </li>
                                <li>
                                    <a class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition 
                                        {{ request()->routeIs('admin.loans.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-100' }}" 
                                       href="{{ route('admin.loans.index') }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                        </svg>
                                        Peminjaman
                                    </a>
                                </li>
                                <li>
                                    <a class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition 
                                        {{ request()->routeIs('admin.returns.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-100' }}" 
                                       href="{{ route('admin.returns.index') }}">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Pengembalian
                                    </a>
                                </li>

                            <!-- MENU UNTUK ROLE PETUGAS -->
                            @elseif(auth()->user()->role == 'petugas')
                                <li>
                                    <a class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition 
                                        {{ request()->is('petugas/dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-100' }}" 
                                       href="/petugas/dashboard">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Validasi Peminjaman
                                    </a>
                                </li>
                                <li>
                                    <a class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition 
                                        {{ request()->is('petugas/laporan') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-100' }}" 
                                       href="/petugas/laporan">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                        </svg>
                                        Laporan
                                    </a>
                                </li>

                            <!-- MENU UNTUK ROLE PEMINJAM -->
                            @elseif(auth()->user()->role == 'peminjam')
                                <li>
                                    <a class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition 
                                        {{ request()->is('peminjam/dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-100' }}" 
                                       href="/peminjam/dashboard">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        Daftar Alat
                                    </a>
                                </li>
                                <li>
                                    <a class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition 
                                        {{ request()->is('peminjam/riwayat') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:text-blue-600 hover:bg-gray-100' }}" 
                                       href="/peminjam/riwayat">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        Riwayat Saya
                                    </a>
                                </li>
                            @endif
                        @endauth
                    </ul>
                </div>

                <!-- Menu Kanan (Profil & Logout) dengan Avatar -->
                <div class="flex items-center space-x-3">
                    <button type="button"
                            class="md:hidden inline-flex items-center justify-center w-9 h-9 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-100"
                            @click="mobileMenuOpen = !mobileMenuOpen"
                            aria-label="Buka menu navigasi">
                        <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    @auth
                        <!-- Dropdown User dengan Avatar -->
                        <div class="relative" x-data="{ open: false }" @click.away="open = false">
                            <button @click="open = !open" class="flex items-center space-x-2 focus:outline-none">
                                <!-- Avatar / Logo Profil -->
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-full flex items-center justify-center text-white text-sm font-medium shadow-sm">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <ul x-show="open" x-cloak class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-100 py-1 z-50 overflow-hidden">
                                <!-- Nama dan Email di dalam dropdown -->
                                <li class="px-4 py-3 border-b border-gray-100">
                                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500 mt-0.5">{{ auth()->user()->email }}</p>
                                    <span class="inline-block mt-1.5 px-2 py-0.5 text-xs font-medium rounded-full 
                                        @if(auth()->user()->role == 'admin') bg-blue-100 text-blue-700
                                        @elseif(auth()->user()->role == 'petugas') bg-green-100 text-green-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        {{ ucfirst(auth()->user()->role) }}
                                    </span>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="w-full text-left px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                            </svg>
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @else
                        <!-- Tombol Login -->
                        <a class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition shadow-sm" href="{{ route('login') }}">
                            Login
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Menu navbar (Mobile) -->
        <div class="md:hidden border-t border-gray-100" x-show="mobileMenuOpen" x-cloak>
            <div class="px-4 py-3 space-y-1">
                @auth
                    @if(auth()->user()->role == 'admin')
                        <a href="/admin/dashboard" class="block px-3 py-2 rounded-lg text-sm {{ request()->is('admin/dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">Dashboard</a>
                        <a href="{{ route('categories.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('categories.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">Kategori</a>
                        <a href="{{ route('tools.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('tools.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">Alat</a>
                        <a href="{{ route('users.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('users.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">User</a>
                        <a href="{{ route('admin.loans.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.loans.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">Peminjaman</a>
                        <a href="{{ route('admin.returns.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.returns.*') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">Pengembalian</a>
                    @elseif(auth()->user()->role == 'petugas')
                        <a href="/petugas/dashboard" class="block px-3 py-2 rounded-lg text-sm {{ request()->is('petugas/dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">Validasi Peminjaman</a>
                        <a href="/petugas/laporan" class="block px-3 py-2 rounded-lg text-sm {{ request()->is('petugas/laporan') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">Laporan</a>
                    @elseif(auth()->user()->role == 'peminjam')
                        <a href="/peminjam/dashboard" class="block px-3 py-2 rounded-lg text-sm {{ request()->is('peminjam/dashboard') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">Daftar Alat</a>
                        <a href="/peminjam/riwayat" class="block px-3 py-2 rounded-lg text-sm {{ request()->is('peminjam/riwayat') ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100' }}">Riwayat Saya</a>
                    @endif
                @endauth
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Flash Message Sukses -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 rounded-r-lg">
                <div class="flex items-center">
                    <svg class="w-5 h-5 text-green-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="text-green-700">{{ session('success') }}</span>
                </div>
            </div>
        @endif

        <!-- Flash Message Error -->
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-r-lg">
                <div class="flex items-start">
                    <svg class="w-5 h-5 text-red-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <ul class="text-red-700 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </div>

    <!-- Alpine.js untuk dropdown -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>