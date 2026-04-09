<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Loan;
use App\Models\Tool;
use App\Models\ActivityLog;

class AdminReturnController extends Controller
{
    /**
     * READ: Menampilkan Riwayat Pengembalian (History)
     */
    public function index()
    {
        // Ambil hanya yang statusnya 'kembali'
        $returns = Loan::with(['user', 'tool', 'petugas'])
            ->where('status', 'kembali')
            ->latest('tanggal_kembali_aktual')
            ->paginate(10);

        return view('admin.returns.index', compact('returns'));
    }

    //menampilkan data alat
    public function create()
    {
        // Ambil data yang statusnya 'disetujui' (Sedang di luar)
        $activeLoans = Loan::with(['user', 'tool'])
            ->where('status', 'disetujui')
            ->latest()
            ->get();

        return view('admin.returns.create', compact('activeLoans'));
    }

    //simpan pengembalian
   public function store(Request $request)
{
    $request->validate([
        'loan_id' => 'required|exists:loans,id',
    ]);

    $loan = Loan::findOrFail($request->loan_id);

    if ($loan->status != 'disetujui') {
        return back()->with('error', 'Data tidak valid atau sudah dikembalikan.');
    }

    $returnedAt = now();
    $isLate = $returnedAt->gt(Carbon::parse($loan->tanggal_kembali_rencana));

    $loan->tanggal_kembali_aktual = $returnedAt;
    $denda = $isLate ? $loan->calculateFine() : 0;

    $loan->update([
        'status'                 => 'kembali',
        'tanggal_kembali_aktual' => $returnedAt,
        'terlambat'              => $isLate,
        'denda'                  => $denda,
    ]);

    $tool = Tool::findOrFail($loan->tool_id);
    $tool->increment('stok');

    ActivityLog::record('Pengembalian (Admin)', 'Memproses pengembalian alat: ' . $tool->nama_alat);

    return redirect()->route('admin.returns.index')->with('success', 'Alat berhasil dikembalikan.');
}


        public function showFineForm($id)
    {
        $loan = Loan::with(['user', 'tool'])->findOrFail($id);

        if (!$loan->terlambat && !$loan->isLate()) {
            return redirect()->route('admin.returns.index')->with('error', 'Loan tidak terlambat.');
        }

        $calculatedFine = $loan->calculateFine();

        return view('admin.returns.denda', compact('loan', 'calculatedFine'));
    }

    public function storeFine(Request $request, $id)
    {
        $request->validate([
            'denda' => 'required|integer|min:0',
        ]);

        $loan = Loan::findOrFail($id);
        $loan->update(['denda' => $request->denda]);

        ActivityLog::record('Denda Ditambahkan', 'Denda Rp ' . number_format($request->denda) . ' untuk loan ID ' . $loan->id);

        return redirect()->route('admin.returns.index')->with('success', 'Denda berhasil disimpan.');
    }

    /**
     * EDIT: Edit data pengembalian (Misal salah tanggal)
     */
    public function edit($id)
    {
        $loan = Loan::findOrFail($id);

        // Pastikan hanya bisa edit yang statusnya sudah kembali
        if ($loan->status != 'kembali') {
            return redirect()->route('admin.returns.index');
        }

        return view('admin.returns.edit', compact('loan'));
    }

    /**
     * UPDATE: Simpan perubahan data pengembalian
     */
    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);

        $request->validate([
            'tanggal_kembali_aktual' => 'required|date'
        ]);

        $loan->update([
            'tanggal_kembali_aktual' => $request->tanggal_kembali_aktual
        ]);

        return redirect()->route('admin.returns.index')->with('success', 'Data pengembalian diperbarui.');
    }

    /**
     * DESTROY: Hapus riwayat pengembalian
     */
    public function destroy($id)
    {
        $loan = Loan::findOrFail($id);

        // Jika data dihapus, apakah stok mau dikurangi lagi?
        // Biasanya hapus riwayat tidak mempengaruhi stok fisik saat ini, tapi tergantung kebijakan.
        // Di sini kita asumsikan hanya hapus arsip.
        $loan->delete();

        return redirect()->route('admin.returns.index')->with('success', 'Riwayat dihapus.');
    }
}