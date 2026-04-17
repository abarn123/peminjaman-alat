<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoanController;
use App\Http\Controllers\AdminReturnController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MidtransController;
use App\Models\ActivityLog;
use Illuminate\Support\facades\Auth;


//Login dan logout (semua role)
Route::get('/', function(){
    
//jika user sudah login, arahkan ke dashboard sesuai role
if (Auth::check()){
    $role = Auth::user()->role;
    if ($role == 'admin') return redirect('/admin/dashboard');
    if ($role == 'petugas') return redirect('/petugas/dashboard');
    return redirect('/peminjam/dashboard');
}

//jika belum login, arahkan kehalaman login
return view ('login');
})->name('home');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class,'logout'])->name('logout');


//group admin (CRUD user, alat, kategori, log)
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
    Route::resource('users', UserController::class); //CRUD user
    Route::resource('tools', ToolController::class); //CRUD alat
    Route::resource('categories', CategoryController::class); //CRUD kategori
    Route::resource('admin/loans', AdminLoanController::class)->names('admin.loans');
    Route::resource('admin/returns', AdminReturnController::class)->names('admin.returns');
    Route::get('/admin/returns/{id}/fine', [AdminReturnController::class, 'showFineForm'])->name('admin.returns.fine');
    Route::post('/admin/returns/{id}/fine', [AdminReturnController::class, 'storeFine']);
    Route::get('/admin/returns/{id}/denda', [AdminReturnController::class, 'showFineForm'])->name('admin.returns.denda');
    Route::post('/admin/returns/{id}/denda', [AdminReturnController::class, 'storeFine']);
    Route::get('/admin/logs', function () {
        $logs = ActivityLog::with('user')->latest()->paginate(15);
        return view('admin.logs.index', compact('logs'));
    })->name('admin.logs.index');
    //CRUD peminjaman (admin bisa full akses)
}); 

//group petugas(approve, memantau, laporan)
Route::middleware(['auth', 'role:petugas'])->group(function(){
    Route::get('/petugas/dashboard', [PetugasController::class, 'index']);
    Route::post('/petugas/approve/{id}', [PetugasController::class, 'approve']); // Menyetujui
    Route::post('/petugas/reject/{id}', [PetugasController::class, 'reject']); //ditolak
    Route::post('/petugas/return/{id}', [PetugasController::class, 'processReturn']); // Pengembalian
    Route::post('/petugas/return-proof/{id}', [PetugasController::class, 'uploadReturnProof']); // Upload bukti foto pengembalian
    Route::get('/petugas/laporan', [PetugasController::class, 'report']); // Cetak Laporan
    Route::get('/petugas/denda', [PetugasController::class, 'dendaIndex'])->name('petugas.denda.index');
    Route::get('/petugas/denda/{id}/formDenda', [PetugasController::class, 'showFormDenda'])->name('petugas.denda.formDenda');
    Route::post('/petugas/denda/{id}/formDenda', [PetugasController::class, 'storeFormDenda']);
    Route::post('/petugas/denda/{id}/generate-link', [PetugasController::class, 'generateMidtransLink'])->name('petugas.denda.generateLink');
    Route::get('/petugas/denda/{id}/bukti', [PetugasController::class, 'showBukti'])->name('petugas.denda.showBukti');
});

//group peminjam (lihat alat, ajukan pinjam)
Route::middleware(['auth', 'role:peminjam'])->group(function () {
    Route::get('/peminjam/dashboard', [PeminjamController::class, 'index']); // Daftar Alat
    Route::post('/peminjam/ajukan', [PeminjamController::class, 'store']); // Mengajukan
    Route::get('/peminjam/riwayat', [PeminjamController::class, 'history']); // Riwayat & Kembalikan
    Route::post('/peminjam/return/{id}', [PeminjamController::class, 'returnLoan'])->name('peminjam.return'); // Pengembalian
    Route::get('/peminjam/pay-denda/{id}', [PeminjamController::class, 'payDenda'])->name('peminjam.payDenda');
});
Route::post('/midtrans/callback', [MidtransController::class, 'callback']);
Route::post('/midtrans/client-notify', [MidtransController::class, 'clientNotify']);
Route::post('/midtrans/test-callback/{orderId}/{status}', [MidtransController::class, 'testCallback']);
