<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AuthController;
use App\Models\User;

Route::get('/jadikan-admin', function () {
    User::where('name', 'Admin Laundry')->update(['role' => 'admin']);
    return '<h3>Perbaikan Sukses!</h3><p>Hak akses telah diubah menjadi Admin. Silakan <a href="/logout">klik di sini untuk Logout</a>, lalu coba Login kembali.</p>';
});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/logout', [AuthController::class, 'logout']);

// Area Publik
Route::middleware(['guest', 'throttle:60,1'])->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    Route::get('/register', [AuthController::class, 'register']);
    Route::post('/register', [AuthController::class, 'storeRegister']);
    
    Route::get('/lupa-password', [AuthController::class, 'lupaPassword']);
    Route::post('/lupa-password', [AuthController::class, 'resetPassword']);
    Route::get('/lupa-email', [AuthController::class, 'lupaEmail']);
    Route::post('/lupa-email', [AuthController::class, 'cariEmail']);
});

// Area Terkunci
Route::middleware('auth')->group(function () {
    // Jalur Admin
    Route::get('/kasir', [TransaksiController::class, 'create']);
    Route::post('/kasir', [TransaksiController::class, 'store']);
    Route::put('/kasir/{id}/status', [TransaksiController::class, 'updateStatus']);
    Route::delete('/kasir/{id}', [TransaksiController::class, 'destroy']);
    Route::get('/kasir/{id}/struk', [TransaksiController::class, 'cetakStruk']);
    Route::put('/kasir/{id}/timbang', [TransaksiController::class, 'updateTimbang']);
    
    // Kelola Akun & Ulasan oleh Admin
    Route::put('/admin/profile', [AuthController::class, 'updateProfile']);
    Route::put('/admin/pelanggan/{id}', [AuthController::class, 'updatePelanggan']);
    Route::delete('/admin/pelanggan/{id}', [AuthController::class, 'destroyPelanggan']);
    
    Route::put('/admin/rating/{id}/balas', [TransaksiController::class, 'balasRating']);
    Route::delete('/admin/rating/{id}', [TransaksiController::class, 'hapusRating']);
    
    // Jalur Pelanggan
    Route::get('/pelanggan', [TransaksiController::class, 'dashboardPelanggan']);
    Route::post('/pelanggan', [TransaksiController::class, 'store']);
    Route::post('/pelanggan/rating', [TransaksiController::class, 'storeRating']);
});

Route::fallback(function () {
    return view('jebakan');
});