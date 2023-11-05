<?php

use App\Http\Controllers\Master\KategoriController;
use App\Http\Controllers\Master\ProdukController;
use App\Http\Controllers\Master\SatuanController;
use App\Http\Controllers\Transaksi\PembelianController;
use App\Http\Controllers\Transaksi\PenjualanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('templates.index');
});

Route::prefix('ajax')->group(function(){
    Route::get('get-produk/{id}', [\App\Http\Controllers\Ajax\ProdukController::class,'getProduct']);
    Route::get('get-produk-by', [\App\Http\Controllers\Ajax\ProdukController::class,'getProductBy']);
    Route::post('create-transaction-purchase', [\App\Http\Controllers\Ajax\PembelianController::class,'buatTransaksi']);
    Route::post('create-transaction-sale', [\App\Http\Controllers\Ajax\PenjualanController::class,'buatTransaksi']);
    // Route::post('create-transaction-detail', [\App\Http\Controllers\Ajax\PembelianController::class,'buatDetailTransaksi']);
});

Route::prefix('transaksi')->group(function(){
    Route::prefix('pembelian')->group(function(){
        Route::get('/', [PembelianController::class, 'index'])->name('transaksi.pembelian');
        Route::get('/{id}', [PembelianController::class, 'show'])->name('transaksi.pembelian.show');
    });
    Route::prefix('penjualan')->group(function(){
        Route::get('/', [PenjualanController::class, 'index'])->name('transaksi.penjualan');
        Route::get('/{id}', [PenjualanController::class, 'show'])->name('transaksi.penjualan.show');
    });
});


Route::prefix('master')->group(function(){
    Route::prefix('kategori')->group(function(){
        Route::get('/', [KategoriController::class, 'index'])->name('master.kategori');
        Route::post('/', [KategoriController::class, 'create'])->name('master.kategori.create');
        Route::put('/{slug}', [KategoriController::class, 'update'])->name('master.kategori.update');
        Route::delete('/{slug}', [KategoriController::class, 'delete'])->name('master.kategori.delete');
    });
    Route::prefix('satuan')->group(function(){
        Route::get('/', [SatuanController::class, 'index'])->name('master.satuan');
        Route::post('/', [SatuanController::class, 'create'])->name('master.satuan.create');
        Route::put('/{slug}', [SatuanController::class, 'update'])->name('master.satuan.update');
        Route::delete('/{slug}', [SatuanController::class, 'delete'])->name('master.satuan.delete');
    });
    Route::prefix('produk')->group(function(){
        Route::get('/', [ProdukController::class, 'index'])->name('master.produk');
        Route::post('/', [ProdukController::class, 'create'])->name('master.produk.create');
        Route::put('/{id}', [ProdukController::class, 'update'])->name('master.produk.update');
        Route::delete('/{id}', [ProdukController::class, 'delete'])->name('master.produk.delete');
    });
});
