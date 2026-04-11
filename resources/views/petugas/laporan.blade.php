<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Peminjaman CampTools</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', 'Roboto', 'Helvetica Neue', Arial, sans-serif;
            background: white;
            padding: 20px;
            font-size: 12px;
        }
        
        /* Container Laporan */
        .report-container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
        }
        
        /* Header Laporan */
        .report-header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #1e3a5f;
        }
        
        .report-title {
            font-size: 24px;
            font-weight: bold;
            color: #1e3a5f;
            margin-bottom: 8px;
        }
        
        .report-subtitle {
            font-size: 14px;
            color: #555;
            margin-bottom: 5px;
        }
        
        .report-date {
            font-size: 12px;
            color: #777;
            margin-top: 10px;
        }
        
        /* Informasi Ringkasan */
        .summary-info {
            background: #f0f4f8;
            padding: 12px 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }
        
        .summary-item {
            font-size: 12px;
        }
        
        .summary-label {
            font-weight: 600;
            color: #1e3a5f;
        }
        
        .summary-value {
            color: #333;
            margin-left: 5px;
        }
        
        /* Tabel */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
            font-size: 11px;
        }
        
        .report-table th {
            background: #1e3a5f;
            color: white;
            padding: 10px 8px;
            text-align: center;
            font-weight: 600;
            border: 1px solid #2c4a7a;
        }
        
        .report-table td {
            padding: 8px;
            border: 1px solid #ddd;
            vertical-align: top;
        }
        
        .report-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        
        /* Status Badge untuk Print */
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 600;
            text-align: center;
            min-width: 100px;
        }
        
        .status-pending {
            background: #fef3c7;
            color: #92400e;
            border: 1px solid #fcd34d;
        }
        
        .status-disetujui {
            background: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
        }
        
        .status-kembali {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #6ee7b7;
        }
        
        .status-ditolak {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fca5a5;
        }
        
        /* Footer Laporan */
        .report-footer {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
        }
        
        .signature-box {
            text-align: center;
            width: 250px;
        }
        
        .signature-line {
            margin-top: 50px;
            padding-top: 5px;
            border-top: 1px solid #333;
            font-size: 11px;
        }
        
        /* Watermark untuk draft (opsional) */
        .watermark {
            display: none;
        }
        
        /* Tombol Print */
        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #1e3a5f;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
            z-index: 1000;
            transition: all 0.3s;
        }
        
        .print-button:hover {
            background: #0f2b4a;
            transform: scale(1.02);
        }
        
        /* Media Print - Untuk Cetak PDF */
        @media print {
            body {
                padding: 0;
                margin: 0;
                background: white;
            }
            
            .print-button {
                display: none;
            }
            
            .report-container {
                padding: 15px;
                max-width: 100%;
            }
            
            .report-table th {
                background: #1e3a5f !important;
                color: white !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .status-badge {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            
            .summary-info {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
                border: 1px solid #ddd;
            }
            
            .report-table td, 
            .report-table th {
                border: 1px solid #000 !important;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <!-- Header Laporan -->
        <div class="report-header">
            <div class="report-title">LAPORAN PEMINJAMAN ALAT</div>
            <div class="report-date">Pencatatan lebih sistematis dan efisien.</div>
        </div>
        
        <!-- Informasi Ringkasan -->
        <div class="summary-info">
            <div class="summary-item">
                <span class="summary-label">Total Peminjaman:</span>
                <span class="summary-value">{{ $loans->count() }} Transaksi</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Sedang Dipinjam:</span>
                <span class="summary-value">{{ $loans->where('status', 'disetujui')->count() }} Alat</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Sudah Kembali:</span>
                <span class="summary-value">{{ $loans->where('status', 'kembali')->count() }} Alat</span>
            </div>
            <div class="summary-item">
                <span class="summary-label">Pending:</span>
                <span class="summary-value">{{ $loans->where('status', 'pending')->count() }} Permintaan</span>
            </div>
        </div>
        
        <!-- Tabel Data Peminjaman -->
        <table class="report-table">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="20%">Peminjam</th>
                    <th width="25%">Alat</th>
                    <th width="15%">Tgl Pinjam</th>
                    <th width="15%">Tgl Kembali</th>
                    <th width="20%">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                    <tr>
                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                        <td>{{ $loan->user->name }}</td>
                        <td>{{ $loan->tool->nama_alat }}</td>
                        <td style="text-align: center;">{{ \Carbon\Carbon::parse($loan->tanggal_pinjam)->format('d/m/Y') }}</td>
                        <td style="text-align: center;">
                            {{ $loan->tanggal_kembali_aktual ? \Carbon\Carbon::parse($loan->tanggal_kembali_aktual)->format('d/m/Y') : '-' }}
                        </td>
                        <td style="text-align: center;">
                            @if($loan->status == 'pending')
                                <span class="status-badge status-pending">⏳ Menunggu Persetujuan</span>
                            @elseif($loan->status == 'disetujui')
                                <span class="status-badge status-disetujui">✓ Sedang Dipinjam</span>
                            @elseif($loan->status == 'kembali')
                                <span class="status-badge status-kembali">✔ Sudah Dikembalikan</span>
                            @elseif($loan->status == 'ditolak')
                                <span class="status-badge status-ditolak">✗ Ditolak</span>
                            @else
                                <span>{{ ucfirst($loan->status) }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px;">
                            <span style="color: #999;">Tidak ada data peminjaman</span>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- Footer Laporan dengan Tanda Tangan -->
        <div class="report-footer">
            <div class="signature-box">
                <div>{{ \Carbon\Carbon::now()->format('d F Y') }}</div>
                <div>Mengetahui,</div>
                <div class="signature-line">{{ auth()->user()->name ?? auth()->user()->username ?? 'Petugas' }}</div>
                <div style="margin-top: 5px; font-size: 11px; color: #666;">( _____________________ )</div>
            </div>
        </div>
        
        <!-- Footer Tambahan -->
        <div style="margin-top: 20px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 10px;">
            Laporan ini dibuat secara otomatis oleh sistem | CampTools
        </div>
    </div>
    
    <!-- Tombol Print (hanya tampil di layar, tidak saat print) -->
    <button onclick="window.print();" class="print-button no-print">
        🖨️ Cetak / Simpan PDF
    </button>
    
    <script>
        // Otomatis membuka dialog print jika parameter ?print ada di URL
        if (window.location.search.includes('print')) {
            window.print();
        }
    </script>
</body>
</html>