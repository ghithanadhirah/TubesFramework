<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController; // Atau controller otentikasi Anda
use App\Http\Controllers\KeranjangController;

Route::get('/galeri', [KeranjangController::class, 'daftarbarang'])->name('galeri');
Route::post('/login', [AuthController::class, 'authenticate'])->name('login');

Route::get('/', function () {
    // return view('welcome');
    // diarahkan ke login customer
    return view('login');
});


// login customer
Route::get('/depan', [App\Http\Controllers\KeranjangController::class, 'daftarbarang'])
     ->middleware(\App\Http\Middleware\CustomerMiddleware::class)
     ->name('depan');
Route::get('/login', function () {
    return view('login');
});

// tambahan route untuk proses login
use Illuminate\Http\Request;
Route::post('/login', [App\Http\Controllers\AuthController::class, 'login']);

Route::get('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

// untuk ubah password
Route::get('/ubahpassword', [App\Http\Controllers\AuthController::class, 'ubahpassword'])
    ->middleware(\App\Http\Middleware\CustomerMiddleware::class)
    ->name('ubahpassword');
Route::post('/prosesubahpassword', [App\Http\Controllers\AuthController::class, 'prosesubahpassword'])
    ->middleware(\App\Http\Middleware\CustomerMiddleware::class)
;
// prosesubahpassword
// tambah keranjang
Route::post('/tambah', [App\Http\Controllers\KeranjangController::class, 'tambahKeranjang'])->middleware(\App\Http\Middleware\CustomerMiddleware::class);
Route::get('/lihatkeranjang', [App\Http\Controllers\KeranjangController::class, 'lihatkeranjang'])->middleware(\App\Http\Middleware\CustomerMiddleware::class);
Route::delete('/hapus/{barang_id}', [App\Http\Controllers\KeranjangController::class, 'hapus'])->middleware(\App\Http\Middleware\CustomerMiddleware::class);
Route::get('/lihatriwayat', [App\Http\Controllers\KeranjangController::class, 'lihatriwayat'])->middleware(\App\Http\Middleware\CustomerMiddleware::class);
// untuk autorefresh
Route::get('/cek_status_pembayaran_pg', [App\Http\Controllers\KeranjangController::class, 'cek_status_pembayaran_pg']);
Route::get('/login', function () {
    return view('login');
});

// contoh sampel midtrans
use App\Http\Controllers\MidtransController;
Route::get('/cekmidtrans', [MidtransController::class, 'cekmidtrans']);

Route::get('filament.resources.adminresource.pages.clusteringvisual');

Route::get('/keranjang', [KeranjangController::class, 'index'])->name('keranjang.index');
Route::post('/keranjang/tambah/{id}', [KeranjangController::class, 'tambah'])->name('keranjang.tambah');
Route::post('/keranjang/hapus/{id}', [KeranjangController::class, 'hapus'])->name('keranjang.hapus');
Route::post('/keranjang/kurang/{id}', [KeranjangController::class, 'kurang'])->name('keranjang.kurang');
Route::post('/keranjang/bayar', [KeranjangController::class, 'bayar'])->name('keranjang.bayar');
Route::get('/konfirmasi', [KeranjangController::class, 'konfirmasi'])->name('keranjang.konfirmasi');
Route::post('/keranjang/bayar-cash', [KeranjangController::class, 'bayarCash'])->name('keranjang.bayarCash');
