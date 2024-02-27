<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\PesananController;
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
    Route::get('/user', [UserController::class, 'index'])->name('user.home');
    Route::get('user/pesanan', function () {
        return view('user.pesanan', ['title' => 'Pesanan']);
    })->name('user.pesanan');
    Route::get('user/data-barang', function () {
        return view('user.data-barang', ['title' => 'Data Barang']);
    })->name('user.barang');
});
Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/staff', [AdminController::class, 'index'])->name('staff.dashboard');
    Route::post('/qr-generate', [QrCodeController::class, 'generate'])->name('qr.generate');
    Route::post('/qr-download', [QrCodeController::class, 'download'])->name('qr.download');
    Route::get('/qr-download-batch', [QrCodeController::class, 'downloadBatch'])->name('download-zip');
    Route::get('/pdf', [QrCodeController::class, 'generatePdfWithQrCodes'])->name('download-pdf');
    Route::get('staff/pesanan', [PesananController::class, 'index'])->name('staff.pesanan');
    Route::get('staff/barang', [BarangController::class, 'index'])->name('staff.barang');
    Route::get('staff/update-stok', [AdminController::class, 'updateStok'])->name('staff.update-stok');
    Route::get('staff/data-barang', [DataBarangController::class, 'index'])->name('staff.data-barang');
    Route::post('staff/add-barang', [BarangController::class, 'store'])->name('staff.tambah-barang');
    Route::delete('staff/delete-barang/{barang}', [BarangController::class, 'destroy'])->name('staff.hapus-barang');
    Route::get('tes', [DataBarangController::class, 'tes'])->name('tes');
});

Route::middleware(['auth','role:spv'])->group(function () {
    Route::get('/spv', [SPVController::class, 'index'])->name('spv.dashboard');
    Route::post('/qr-generate', [QrCodeController::class, 'generate'])->name('qr.generate');
    Route::post('/qr-download', [QrCodeController::class, 'download'])->name('qr.download');
    Route::get('/qr-download-batch', [QrCodeController::class, 'downloadBatch'])->name('download-zip');
    Route::get('/pdf', [QrCodeController::class, 'generatePdfWithQrCodes'])->name('download-pdf');
    Route::get('spv/master-barang', [BarangController::class, 'index'])->name('spv.master-barang');
    Route::post('spv/add-barang', [BarangController::class, 'store'])->name('spv.tambah-barang');
    Route::delete('spv/delete-barang/{barang}', [BarangController::class, 'destroy'])->name('spv.hapus-barang');
    Route::get('spv/detail-barang', [DataBarangController::class, 'index'])->name('spv.detail-barang');
    Route::put('spv/update-barang/{barang}', [BarangController::class, 'update'])->name('spv.update-barang');
    // Route::get('/spv/master-barang', function () {
    //     return view('spv.master-barang', ['title' => 'Data Master Barang']);
    // })->name('spv.master-barang');
    // Route::get('/spv/detail-barang', function () {
    //     return view('spv.detail-barang', ['title' => 'Data Detail Barang']);
    // })->name('spv.detail-barang');
});

require __DIR__.'/auth.php';
