<?php

use App\Http\Controllers\POSController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StockInController;
use App\Http\Controllers\StockOutController;
use Illuminate\Support\Facades\Route;


// Landing Page
Route::get('/', function () {
    return view('landingpage.welcome');
});

Route::get('/kontak', function () {
    return view('landingpage.kontak');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [POSController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/create', [ProductController::class, 'create']);
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id}/edit', [ProductController::class, 'edit']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'delete']);

    // StockIns
    Route::resource('stock-ins', StockInController::class);

    //StockOuts
    Route::resource('/stock-outs', StockOutController::class);

    //Pos Fungsi
    Route::get('/pos', [POSController::class, 'index']);
    Route::post('/pos/add', [POSController::class, 'add']);
    Route::post('/pos/remove', [POSController::class, 'remove']);
    Route::post('/pos/clear', [POSController::class, 'clear']);
    Route::post('/pos/checkout', [POSController::class, 'checkout']);
    Route::get('/pos/invoice/{id}', [POSController::class, 'invoice']);
    // Route::get('/transactions/items/export', [POSController::class, 'exportHistoryItems']);

    //Riwayat Transaksi
    Route::get('/transactions', [POSController::class, 'history']);
    Route::get('/transactions/items', [POSController::class, 'historyItems']);
});

require __DIR__.'/auth.php';
