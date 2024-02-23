<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\SPVController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    $user = auth()->user();

    if ($user->role === 'admin') {
        return redirect()->route('staff.dashboard');
    } elseif ($user->role === 'spv') {
        return redirect()->route('spv.dashboard');
    } elseif ($user->role === 'user') {
        return redirect()->route('user.dashboard');
    }

    return redirect()->route('login');
});

// Route::get('/dashboard', function () {
//     return view('welcome');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','role:user'])->group(function () {
    Route::get('/user', [UserController::class, 'index'])->name('user.dashboard');
});
Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/staff', [AdminController::class, 'index'])->name('staff.dashboard');
    Route::post('/qr-generate', [QrCodeController::class, 'generate'])->name('qr.generate');
    Route::post('/qr-download', [QrCodeController::class, 'download'])->name('qr.download');
    Route::get('/qr-download-batch', [QrCodeController::class, 'downloadBatch'])->name('download-zip');
    Route::get('/pdf', [QrCodeController::class, 'generatePdfWithQrCodes'])->name('download-pdf');
    Route::get('staff/pesanan', [AdminController::class, 'pesanan'])->name('staff.pesanan');
    Route::get('staff/barang', [BarangController::class, 'index'])->name('staff.barang');
    Route::get('staff/update-stok', [AdminController::class, 'updateStok'])->name('staff.update-stok');
    Route::resource('barang', BarangController::class);
    Route::get('staff/data-barang', [DataBarangController::class, 'index'])->name('staff.data-barang');
});

Route::middleware(['auth','role:spv'])->group(function () {
    Route::get('/spv', [SPVController::class, 'index'])->name('spv.dashboard');
});

require __DIR__.'/auth.php';
