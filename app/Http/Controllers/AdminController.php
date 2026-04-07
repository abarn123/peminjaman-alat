<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tool;
use App\Models\Category;
use App\Models\Loan;
use App\Models\ActivityLog;

class AdminController extends Controller
{
    
    public function index()
    {

    //mengambil data statistik untuk kartu dashboard
    $totalUser      = User::count();
    $totalAlat      = Tool::count();
    $totalStok      = Tool::sum ('stok');
    $totalKategori  = Category::count();

    //hitung peminjaman yang sedang berlangsung (status disetujui)
    $sedangDipinjam = Loan::where('status','disetujui')->count();
    $sudahDikembalikan = Loan::where('status','kembali')->count();

    //mengambil 5 log aktivitas terbaru
    $recentLogs = ActivityLog::with('user')->latest()->take(5)->get();
    return view('admin.dashboard', compact(
        'totalUser',
        'totalAlat',
        'totalStok',
        'totalKategori',
        'sedangDipinjam',
        'sudahDikembalikan',
        'recentLogs'
    ));
    }
}