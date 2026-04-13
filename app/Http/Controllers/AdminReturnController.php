<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Models\Loan;
use App\Models\Tool;
use App\Models\ActivityLog;

class AdminReturnController extends Controller
{
    //menampilkan data pengembalian
    public function index(Request $request)
    {
        // ambil data yang statusnya kembali doang
        $query = Loan::with(['user', 'tool', 'petugas'])
            ->where('status', 'kembali');

        // logika fitur search
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('user', function($userQuery) use ($search) {
                    $userQuery->where('name', 'like', '%' . $search . '%')
                             ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhereHas('tool', function($toolQuery) use ($search) {
                    $toolQuery->where('nama_alat', 'like', '%' . $search . '%');
                })
                ->orWhere('status', 'like', '%' . $search . '%');
            });
        }

        $returns = $query->latest('tanggal_kembali_aktual')
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

        $planned = Carbon::parse($loan->tanggal_kembali_rencana)->startOfDay();
        $actual = Carbon::parse($loan->tanggal_kembali_aktual)->startOfDay();
        $lateDays = $actual->gt($planned) ? $planned->diffInDays($actual) : 0;

        return view('admin.returns.denda', compact('loan', 'calculatedFine', 'lateDays'));
    }

    public function storeFine(Request $request, $id)
    {
        $request->validate([
            'denda_per_hari' => 'required|integer|min:0',
            'denda_tf' => 'required|string|max:255',
            'qris_image' => 'nullable|image|max:4096',
        ]);

        $loan = Loan::findOrFail($id);

        $planned = Carbon::parse($loan->tanggal_kembali_rencana)->startOfDay();
        $actual = Carbon::parse($loan->tanggal_kembali_aktual)->startOfDay();
        $lateDays = $actual->gt($planned) ? $planned->diffInDays($actual) : 0;

        $dendaTotal = (int) $request->denda_per_hari * (int) $lateDays;

        $dataToUpdate = [
            'denda' => $dendaTotal,
            'denda_tf' => $request->denda_tf,
        ];

        // Wajib upload QRIS kalau denda > 0 dan belum ada QR sebelumnya
        if ($dendaTotal > 0 && !$loan->denda_qris_image_path && !$request->hasFile('qris_image')) {
            return back()->withErrors(['qris_image' => 'Upload QRIS wajib diisi untuk denda > 0.'])->withInput();
        }

        if ($request->hasFile('qris_image')) {
            // Hapus file lama jika ada
            if ($loan->denda_qris_image_path) {
                Storage::disk('public')->delete($loan->denda_qris_image_path);
            }

            $path = $request->file('qris_image')->store('qris/denda', 'public');
            $dataToUpdate['denda_qris_image_path'] = $path;
        }

        $loan->update($dataToUpdate);

        ActivityLog::record('Denda Ditambahkan', 'Denda Rp ' . number_format($dendaTotal) . ' untuk loan ID ' . $loan->id);

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