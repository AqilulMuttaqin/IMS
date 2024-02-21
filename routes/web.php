<?php

use App\Http\Controllers\AdminController;
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
        return redirect()->route('admin.dashboard');
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
    Route::get('/qr', [QrCodeController::class, 'show']);
    Route::get('/qr-download', [QrCodeController::class, 'download']);
    Route::get('/qr-download-batch', [QrCodeController::class, 'downloadBatch']);
    Route::get('staff/pesanan', [AdminController::class, 'pesanan'])->name('staff.pesanan');
    Route::get('staff/barang', [AdminController::class, 'barang'])->name('staff.barang');
    Route::get('staff/update-stok', [AdminController::class, 'updateStok'])->name('staff.update-stok');
});

Route::middleware(['auth','role:spv'])->group(function () {
    Route::get('/spv', [SPVController::class, 'index'])->name('spv.dashboard');
});

require __DIR__.'/auth.php';
