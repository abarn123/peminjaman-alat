<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminLoanController;
use App\Controllers\AdminReturnController;
use App\Controllers\CategoryController;
use App\Controllers\PetugasController;
use App\Controllers\PeminjamController;
use App\Controllers\ToolContoller;
use App\Controllers\UserController;
use App\Models\ActivityLog;
use Illuminate\support\facades\Auth;

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
route::post('/logout', [AuthController::class,'logout'])->name('logout');

//group admin (CRUD user, alat, kategori, log)
Route::middleware(['auth', 'role:admin'])->group(function(){
    Route::get('/admin/dashboard', [AdminController::class, 'index']);
    Route::resource('users', UserController::class); //CRUD user
    Route::resource('tools', ToolController::class); //CRUD alat
    Route::resource('categories', CategoryController::class); //CRUD kategori
    Route::resource('admin/loans', AdminLoanController::class)->names('admin.loans');
    Route::resource('admin/returns', AdminReturnController::class)->names('admin.returns');
    Route::get('/admin/logs', function(){
        $logs = ActivityLog::with('user')->latest()->get();
        return view('admin.logs', compact('logs'));
    });
    //CRUD peminjaman (admin bisa full akses)
}); 

//group petugas(approve, memantau, laporan)

