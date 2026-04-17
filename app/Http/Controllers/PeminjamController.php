<?php

namespace App\Http\Controllers;
use App\Models\ActivityLog;
use App\Models\Loan;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class PeminjamController extends Controller
{
    public function index()
    {
        $tools = Tool::with('category')->get();

        return view('peminjam.dashboard', compact('tools'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tool_id'          => 'required|exists:tools,id',
            'tanggal_kembali'  => 'required|date|after_or_equal:today',
        ]);

        // Cek stok dulu
        $tool = Tool::findOrFail($request->tool_id);

        if ($tool->stok > 0) {
            Loan::create([
                'user_id'                  => Auth::id(),
                'tool_id'                  => $request->tool_id,
                'tanggal_pinjam'           => now(),
                'tanggal_kembali_rencana'  => $request->tanggal_kembali,
                'status'                   => 'pending'
            ]);

            ActivityLog::record('Ajukan Peminjaman', 'Mengajukan peminjaman alat: ' . $tool->nama_alat);

            return back()->with('success', 'Pengajuan berhasil, menunggu persetujuan.');
        } else {
            return back()->with('error', 'Stok alat sedang kosong.');
        }
    }

    public function history()
    {
        $loans = Loan::where('user_id', Auth::id())
            ->with('tool')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('peminjam.riwayat', compact('loans'));
    }

    public function returnLoan($id)
    {
        // Cari loan berdasarkan ID dan pastikan milik user yang login
        $loan = Loan::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Pastikan status masih 'disetujui' (sedang dipinjam)
        if ($loan->status !== 'disetujui') {
            return back()->with('error', 'Peminjaman ini tidak dapat dikembalikan.');
        }

        // Set tanggal kembali aktual ke hari ini
        $returnedAt = now();

        // Cek apakah terlambat berdasarkan tanggal (tidak termasuk jam)
        $isLate = $returnedAt->startOfDay()->gt(
            Carbon::parse($loan->tanggal_kembali_rencana)->startOfDay()
        );

        // Hitung denda jika terlambat
        $denda = $isLate ? $loan->calculateFine() : 0;

        // Update loan
        $loan->update([
            'status'                 => 'kembali',
            'tanggal_kembali_aktual' => $returnedAt,
            'terlambat'              => $isLate,
            'denda'                  => $denda,
        ]);

        // Kembalikan stok alat
        $tool = Tool::findOrFail($loan->tool_id);
        $tool->increment('stok');

        // Catat log aktivitas
        ActivityLog::record('Pengembalian (Peminjam)', 'Peminjam mengembalikan alat: ' . $tool->nama_alat);

        return back()->with('success', 'Alat berhasil dikembalikan. Terima kasih!');
    }

    //fungsi upload bukti
    public function payDenda($id)
{
    $loan = Loan::findOrFail($id);

    if ($loan->denda <= 0 || $loan->midtrans_status === 'settlement') {
        return redirect('/peminjam/riwayat')->with('error', 'Denda sudah dibayar atau tidak ada.');
    }

    $snapToken = $loan->createMidtransTransaction();

    return view('peminjam.payDenda', compact('loan', 'snapToken'));
}
}