<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\DataBarangController;
use App\Http\Controllers\KeranjangController;
use App\Http\Controllers\LokasiController;
use App\Http\Controllers\PerubahanController;
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
        return redirect()->route('user.home');
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
    Route::get('user/pesanan', [PesananController::class, 'index'])->name('user.pesanan');
    Route::get('user/data-barang', [DataBarangController::class, 'show'])->name('user.barang');
    Route::get('/user/keranjang', [KeranjangController::class, 'index'])->name('user.keranjang');
    Route::get('/user/pesan', [PesananController::class, 'create'])->name('user.pesan');
    Route::get('/user/pesan1', [PesananController::class, 'store'])->name('user.pesan1');
    Route::post('user/update-pesanan', [PesananController::class, 'update'])->name('user.update-pesanan');
});

Route::middleware(['auth','role:admin'])->group(function () {
    Route::get('/staff', [AdminController::class, 'index'])->name('staff.dashboard');
    Route::get('staff/pesanan', [PesananController::class, 'index'])->name('staff.pesanan');
    Route::get('staff/barang', [BarangController::class, 'index'])->name('staff.barang');
    Route::get('staff/update-stok', [AdminController::class, 'updateStok'])->name('staff.update-stok');
    Route::get('staff/data-barang', [DataBarangController::class, 'index'])->name('staff.data-barang');
    Route::post('staff/add-barang', [BarangController::class, 'store'])->name('staff.tambah-barang');
    Route::delete('staff/delete-barang/{barang}', [BarangController::class, 'destroy'])->name('staff.hapus-barang');
    Route::get('staff/detail-pesanan', [PesananController::class, 'detail'])->name('staff.detail-pesanan');
    Route::post('staff/update-pesanan', [PesananController::class, 'update'])->name('staff.update-pesanan');
    Route::post('staff/tambah-barang', [DataBarangController::class, 'store'])->name('staff.update-barang');
    Route::get('staff/nama-barang', [AdminController::class, 'barang'])->name('staff.nama-barang');
    Route::get('staff/edit-pesanan', [PesananController::class, 'edit'])->name('staff.edit-pesanan');
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
    Route::post('spv/tambah-barang', [DataBarangController::class, 'add'])->name('spv.input-barang');
    Route::post('spv/mutasi-barang', [DataBarangController::class, 'mutasi'])->name('spv.mutasi-barang');
    Route::get('/spv/control-barang', [SPVController::class, 'update_stok'])->name('spv.control-barang');
    Route::get('/spv/get-lokasi', [SPVController::class, 'get_lokasi'])->name('spv.get-lokasi');
    Route::get('/spv/get-barang', [SPVController::class, 'get_barang'])->name('spv.get-barang');
    Route::get('/spv/get-qty', [SPVController::class, 'get_qty'])->name('spv.get-qty');
    Route::get('/spv/getLokasiQty', [DataBarangController::class, 'getLokasiQty'])->name('spv.getLokasiQty');
    Route::get('/spv/history-pesanan',[PesananController::class, 'historyPesanan'])->name('spv.history-pesanan');
    Route::get('spv/export-history-pesanan', [PesananController::class, 'exportHistory'])->name('spv.export-history-pesanan');
    Route::get('/spv/in-out', [PerubahanController::class, 'index'])->name('spv.in-out');
    Route::get('/spv/export-perubahan', [PerubahanController::class, 'export'])->name('spv.export-perubahan');
    Route::post('spv/import-dataBarang', [DataBarangController::class, 'import'])->name('spv.import-dataBarang');
    // Route::get('/spv/detail-barang', function () {
    //     return view('spv.detail-barang', ['title' => 'Data Detail Barang']);
    // })->name('spv.detail-barang');
});

Route::middleware(['auth','role:spv,admin'])->group(function () {
    Route::get('tes', [DataBarangController::class, 'tes'])->name('tes');
    Route::get('tes-data', [DataBarangController::class, 'tes_data'])->name('tes-data');
    Route::post('/qr-generate', [QrCodeController::class, 'generate'])->name('qr.generate');
    Route::post('/qr-download', [QrCodeController::class, 'download'])->name('qr.download');
    Route::get('/qr-download-batch', [QrCodeController::class, 'downloadBatch'])->name('download-zip');
    Route::get('/pdf', [QrCodeController::class, 'generatePdfWithQrCodes'])->name('download-pdf');
    Route::get('/export-data-barang', [DataBarangController::class, 'export'])->name('export-data-barang');
    Route::get('/auth-user', function () {return auth()->user()->lokasi_id;})->name('get-lokasi');
    Route::get('/format-import-barang', [BarangController::class, 'import_format'])->name('format-import-barang');
    Route::get('/format-import-dataBarang', [DataBarangController::class, 'import_format'])->name('format-import-dataBarang');
    Route::get('/export-lokasi', [LokasiController::class, 'export'])->name('export-lokasi');
});

require __DIR__.'/auth.php';
