<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;

class PetugasController extends Controller
{
    public function index()
    {
        // Data yang statusnya pending
        $loans = Loan::where('status', 'pending')->with(['user', 'tool'])->get();

        // Data yang statusnya disetujui (sedang dipinjam)
        $activeLoans = Loan::where('status', 'disetujui')->with(['user', 'tool'])->get();

        $sudahDikembalikan = Loan::where('status', 'kembali')->with(['user', 'tool'])->get();

        return view('petugas.dashboard', compact('loans', 'activeLoans', 'sudahDikembalikan'));
    }

    public function approve($id)
    {
        $loan = Loan::findOrFail($id);

        $loan->update([
            'status'     => 'disetujui',
            'petugas_id' => Auth::id()
        ]);

        // Kurangi stok alat
        $tool = Tool::find($loan->tool_id);
        $tool->decrement('stok');

        return back()->with('success', 'Peminjaman disetujui.');
    }

    public function reject($id)
    {
        $loan = Loan::findOrFail($id);

        $loan->update([
            'status' => 'ditolak',
            'petugas_id' => Auth::id()
        ]);

        //masukan aktivitas penolakan ke log aktivitas
        ActivityLog::record('Tolak peminjaman', 'peminjaman alat' . $loan->tool->nama_alat . 'oleh' . $loan->user->name . 'ditolak.');

        return back()->with('success', 'peminjaman ditolak');
        
    }

    public function processReturn($id)
    {
        $loan = Loan::findOrFail($id);

        $loan->update([
            'status'                 => 'kembali',
            'tanggal_kembali_aktual' => now()
        ]);

        // Kembalikan stok
        $tool = Tool::find($loan->tool_id);
        $tool->increment('stok');

        return back()->with('success', 'Alat telah dikembalikan.');
    }

    public function report(Request $request)
    {
        // Bisa tambahkan filter tanggal jika mau
        $loans = Loan::with(['user', 'tool'])->get();

        return view('petugas.laporan', compact('loans'));
    }

    // Halaman denda untuk petugas
    public function dendaIndex(Request $request)
    {
        // Ambil hanya yang statusnya 'kembali'
        $query = Loan::with(['user', 'tool', 'petugas'])
            ->where('status', 'kembali');

        //search functionality
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

        return view('petugas.denda.index', compact('returns'));
    }

    // Form denda
    public function showFormDenda($id)
    {
        $loan = Loan::with(['user', 'tool'])->findOrFail($id);

        if (!$loan->terlambat && !$loan->isLate()) {
            return redirect()->route('petugas.denda.index')->with('error', 'Loan tidak terlambat.');
        }

        $calculatedFine = $loan->calculateFine();

        $planned = \Carbon\Carbon::parse($loan->tanggal_kembali_rencana)->startOfDay();
        $actual = \Carbon\Carbon::parse($loan->tanggal_kembali_aktual)->startOfDay();
        $lateDays = $actual->gt($planned) ? $planned->diffInDays($actual) : 0;

        return view('petugas.denda.formDenda', compact('loan', 'calculatedFine', 'lateDays'));
    }

    // Simpan denda
    public function storeFormDenda(Request $request, $id)
    {
        $request->validate([
            'denda_per_hari' => 'required|integer|min:0',
            'denda_tf' => 'required|string|max:255',
            'qris_image' => 'nullable|image|max:4096',
        ]);

        $loan = Loan::findOrFail($id);

        $planned = \Carbon\Carbon::parse($loan->tanggal_kembali_rencana)->startOfDay();
        $actual = \Carbon\Carbon::parse($loan->tanggal_kembali_aktual)->startOfDay();
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
                \Illuminate\Support\Facades\Storage::disk('public')->delete($loan->denda_qris_image_path);
            }

            $path = $request->file('qris_image')->store('qris/denda', 'public');
            $dataToUpdate['denda_qris_image_path'] = $path;
        }

        $loan->update($dataToUpdate);

        ActivityLog::record('Denda Ditambahkan (Petugas)', 'Denda Rp ' . number_format($dendaTotal) . ' untuk loan ID ' . $loan->id);

        return redirect()->route('petugas.denda.index')->with('success', 'Denda berhasil disimpan.');
    }
}