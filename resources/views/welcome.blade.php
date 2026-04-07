<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peminjaman Alat</title>
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
<body class="bg-white antialiased">

    <!-- Navbar -->
    <nav class="bg-white border-b border-gray-200 shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a class="text-xl font-bold text-blue-600" href="#">SIPINJAM</a>
                <div>
                    <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition duration-200 shadow-sm">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gray-900 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Peminjaman Alat Jadi Lebih Mudah</h1>
            <p class="text-lg md:text-xl text-gray-300 max-w-3xl mx-auto mb-8">
                Sistem manajemen peminjaman alat laboratorium dan bengkel sekolah yang terintegrasi, cepat, dan transparan.
            </p>
            <a href="{{ route('login') }}" class="inline-block px-8 py-3 text-base font-semibold text-gray-900 bg-yellow-400 hover:bg-yellow-500 rounded-lg transition duration-200 shadow-md">
                Mulai Peminjaman
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 text-center hover:shadow-lg transition duration-200">
                    <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-800 mb-2">Cari Alat</h4>
                    <p class="text-gray-500 leading-relaxed">
                        Cek ketersediaan stok alat secara real-time tanpa perlu bolak-balik ke ruang penyimpanan.
                    </p>
                </div>

                <!-- Card 2 -->
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 text-center hover:shadow-lg transition duration-200">
                    <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-800 mb-2">Ajukan Pinjaman</h4>
                    <p class="text-gray-500 leading-relaxed">
                        Proses pengajuan peminjaman yang praktis melalui sistem dan persetujuan petugas yang cepat.
                    </p>
                </div>

                <!-- Card 3 -->
                <div class="bg-white rounded-xl shadow-md border border-gray-100 p-6 text-center hover:shadow-lg transition duration-200">
                    <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold text-gray-800 mb-2">Pengembalian</h4>
                    <p class="text-gray-500 leading-relaxed">
                        Sistem monitoring pengembalian alat yang terstruktur untuk menghindari kehilangan aset.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400 text-sm">
                &copy; {{ date('Y') }} Sistem Peminjaman Alat. Dibuat dengan Laravel.
            </p>
        </div>
    </footer>

</body>
</html>