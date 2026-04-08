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
        $loan = loan::findOrFail($id);

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
}