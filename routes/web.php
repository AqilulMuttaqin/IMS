<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\SPVController;
use App\Http\Controllers\UserController;
use App\Models\SPV;
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

Route::get('/tester', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth','role:user'])->group(function () {
    // Route::get('/user', [UserController::class, 'index'])->name('user.home');
    Route::get('/user', [DataBarangController::class, 'index'])->name('user.home');
    Route::get('user/pesanan', function () {
        return view('user.pesanan', ['title' => 'Pesanan']);
    })->name('user.pesanan');
    Route::get('user/data-barang', function () {
        return view('user.data-barang', ['title' => 'Data Barang']);
    })->name('user.barang');
    Route::get('/user/keranjang', [KeranjangController::class, 'index'])->name('user.keranjang');
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
    Route::get('staff/detail-pesanan', [PesananController::class, 'detail'])->name('staff.detail-pesanan');
});

Route::middleware(['auth','role:spv'])->group(function () {
    Route::get('/spv', [SPVController::class, 'index'])->name('spv.dashboard');
    Route::get('spv/master-barang', [BarangController::class, 'index'])->name('spv.master-barang');
    Route::post('spv/add-barang', [BarangController::class, 'store'])->name('spv.tambah-barang');
    Route::put('spv/update-barang/{barang}', [BarangController::class, 'update'])->name('spv.update-barang');
    Route::delete('spv/delete-barang/{barang}', [BarangController::class, 'destroy'])->name('spv.hapus-barang');
    Route::get('spv/detail-barang', [DataBarangController::class, 'index'])->name('spv.detail-barang');
    Route::get('spv/lokasi', [LokasiController::class, 'index'])->name('spv.lokasi');
    Route::post('spv/add-lokasi', [LokasiController::class, 'store'])->name('spv.tambah-lokasi');
    Route::put('spv/update-lokasi/{id}', [LokasiController::class, 'update'])->name('spv.update-lokasi');
    Route::delete('spv/delete-lokasi/{lokasi}', [LokasiController::class, 'destroy'])->name('spv.hapus-lokasi');
    Route::get('spv/export-barang', [BarangController::class, 'export'])->name('spv.export-barang');
    Route::post('spv/import-barang', [BarangController::class, 'import'])->name('spv.import-barang');
    Route::get('spv/user', [SPVController::class, 'show_user'])->name('spv.user');
    Route::post('spv/user-add', [SPVController::class, 'add_user'])->name('spv.tambah-user');
    Route::put('spv/user-update/{user}', [SPVController::class, 'update_user'])->name('spv.update-user');
    Route::delete('spv/user-del/{user}', [SPVController::class, 'delete_user'])->name('spv.hapus-user');
    // Route::get('/spv/lokasi', function () {
    //     return view('spv.lokasi', ['title' => 'Data Lokasi']);
    // })->name('spv.lokasi');
    // Route::get('/spv/detail-barang', function () {
    //     return view('spv.detail-barang', ['title' => 'Data Detail Barang']);
    // })->name('spv.detail-barang');
});

Route::middleware(['auth','role:spv,admin'])->group(function () {
    Route::get('tes', [DataBarangController::class, 'tes'])->name('tes');
    Route::post('/qr-generate', [QrCodeController::class, 'generate'])->name('qr.generate');
    Route::post('/qr-download', [QrCodeController::class, 'download'])->name('qr.download');
    Route::get('/qr-download-batch', [QrCodeController::class, 'downloadBatch'])->name('download-zip');
    Route::get('/pdf', [QrCodeController::class, 'generatePdfWithQrCodes'])->name('download-pdf');
});

require __DIR__.'/auth.php';
