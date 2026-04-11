@extends('layouts.app')

@section('content')
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Edit Peminjaman</h1>
        <p class="text-gray-500 mt-1">Ubah data peminjaman #{{ $loan->id }}</p>
    </div>

    <!-- Form Card -->
    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-xl shadow-md border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-500 to-yellow-700 rounded-full flex items-center justify-center text-white text-sm font-medium shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-gray-800">Form Edit Peminjaman</h3>
                        <p class="text-xs text-gray-500">Ubah data peminjaman dengan hati-hati</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <form action="{{ route('admin.loans.update', $loan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Pilih Peminjam -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Peminjam <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <select name="user_id" 
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 appearance-none bg-white" 
                                    required>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $loan->user_id == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Pilih Alat -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Alat <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                            </svg>
                            <select id="tool_id" name="tool_id" 
                                    data-current-tool-id="{{ (int) $loan->tool_id }}"
                                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 appearance-none bg-white" 
                                    required>
                                @foreach($tools as $tool)
                                    <option value="{{ $tool->id }}"
                                            data-stok="{{ (int) $tool->stok }}"
                                            data-nama="{{ $tool->nama_alat }}"
                                            {{ $loan->tool_id == $tool->id ? 'selected' : '' }}>
                                        {{ $tool->nama_alat }} (Stok: {{ $tool->stok }} unit) - {{ $tool->category->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="tool_stock_alert" class="mt-3 hidden">
                            <div class="p-3 bg-red-50 border border-red-200 rounded-lg">
                                <div class="flex items-start gap-2">
                                    <svg class="w-4 h-4 text-red-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                    </svg>
                                    <p class="text-xs text-red-700">
                                        <span class="font-medium">Stok habis:</span> alat yang dipilih sedang tidak tersedia. Silakan pilih alat lain.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tanggal Pinjam dan Rencana Kembali -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Pinjam <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <input type="date" 
                                       name="tanggal_pinjam" 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                       value="{{ $loan->tanggal_pinjam }}" 
                                       required>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rencana Kembali <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <input type="date" 
                                       name="tanggal_kembali_rencana" 
                                       class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200" 
                                       value="{{ $loan->tanggal_kembali_rencana }}" 
                                       required>
                            </div>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status <span class="text-red-500">*</span></label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                            <label class="relative flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-800">Pending</p>
                                </div>
                                <input type="radio" name="status" value="pending" class="hidden" {{ $loan->status == 'pending' ? 'checked' : '' }}>
                                <div class="w-4 h-4 border-2 border-gray-300 rounded-full radio-check"></div>
                            </label>

                            <label class="relative flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-800">Disetujui</p>
                                </div>
                                <input type="radio" name="status" value="disetujui" class="hidden" {{ $loan->status == 'disetujui' ? 'checked' : '' }}>
                                <div class="w-4 h-4 border-2 border-gray-300 rounded-full radio-check"></div>
                            </label>

                            <label class="relative flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition has-[:checked]:border-blue-500 has-[:checked]:bg-blue-50">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-800">Kembali</p>
                                </div>
                                <input type="radio" name="status" value="kembali" class="hidden" {{ $loan->status == 'kembali' ? 'checked' : '' }}>
                                <div class="w-4 h-4 border-2 border-gray-300 rounded-full radio-check"></div>
                            </label>

                            <label class="relative flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer hover:bg-gray-50 transition has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                                <div class="flex items-center gap-2">
                                    <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-800">Ditolak</p>
                                </div>
                                <input type="radio" name="status" value="ditolak" class="hidden" {{ $loan->status == 'ditolak' ? 'checked' : '' }}>
                                <div class="w-4 h-4 border-2 border-gray-300 rounded-full radio-check"></div>
                            </label>
                        </div>
                        
                        <!-- Warning message -->
                        <div class="mt-3 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <p class="text-xs text-yellow-700">
                                    <span class="font-medium">Perhatian:</span> Mengubah status dari 'Disetujui' ke 'Kembali' akan menambah stok alat secara otomatis.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                        <a href="{{ route('admin.loans.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-700 text-sm font-medium rounded-lg transition duration-200">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Batal
                        </a>
                        <button id="submit_btn" type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition duration-200 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update Data
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Info Card -->
        <div class="mt-6 bg-gray-50 border border-gray-200 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-gray-600 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="text-sm font-semibold text-gray-800">Informasi Status</h4>
                    <ul class="text-xs text-gray-600 mt-1 space-y-1">
                        <li>• <span class="font-medium">Pending:</span> Menunggu persetujuan petugas</li>
                        <li>• <span class="font-medium">Disetujui:</span> Peminjaman aktif, alat sedang dipinjam</li>
                        <li>• <span class="font-medium">Kembali:</span> Alat sudah dikembalikan, stok otomatis bertambah</li>
                        <li>• <span class="font-medium">Ditolak:</span> Peminjaman tidak disetujui</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Custom radio button styling */
        input[type="radio"]:checked + .radio-check {
            @apply border-blue-500 bg-blue-500;
            position: relative;
        }
        input[type="radio"]:checked + .radio-check::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 6px;
            height: 6px;
            background-color: white;
            border-radius: 50%;
        }
        label:has(input:checked) {
            @apply border-blue-500 bg-blue-50;
        }
        label:has(input[value="ditolak"]:checked) {
            @apply border-red-500 bg-red-50;
        }
    </style>


        <!-- script untuk mendisabled tombol submit dan memberikan 
         pesan stok habis jika stok alat sudah 0 -->
    <script>
        (function () {
            const toolSelect = document.getElementById('tool_id');
            const alertBox = document.getElementById('tool_stock_alert');
            const submitBtn = document.getElementById('submit_btn');

            if (!toolSelect || !alertBox || !submitBtn) return;

            const updateStockUI = () => {
                const opt = toolSelect.options[toolSelect.selectedIndex];
                const stok = opt?.dataset?.stok ? parseInt(opt.dataset.stok, 10) : null;
                const selectedToolId = opt?.value ? parseInt(opt.value, 10) : null;

                // Di halaman edit, loan ini bisa saja memang sedang "memegang" alat tsb,
                // jadi stok terlihat 0. Kita hanya blok kalau user mengganti ke alat lain yang stoknya 0.
                const currentToolId = toolSelect.dataset?.currentToolId ? parseInt(toolSelect.dataset.currentToolId, 10) : null;
                const isChangingTool = Number.isFinite(currentToolId) && Number.isFinite(selectedToolId) && selectedToolId !== currentToolId;

                const outOfStock = Number.isFinite(stok) && stok <= 0;
                const shouldBlock = outOfStock && isChangingTool;
                alertBox.classList.toggle('hidden', !outOfStock);
                submitBtn.disabled = shouldBlock;
                submitBtn.classList.toggle('opacity-60', shouldBlock);
                submitBtn.classList.toggle('cursor-not-allowed', shouldBlock);
            };

            toolSelect.addEventListener('change', updateStockUI);
            updateStockUI();
        })();
    </script>
@endsection