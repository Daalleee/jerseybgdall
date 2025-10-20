<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JerseyController;
use App\Http\Controllers\TransactionController;

// Rute publik
Route::get('/', function () {
    return view('welcome');
});

// Rute auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute untuk pelanggan yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/customer/dashboard', [DashboardController::class, 'customerDashboard'])->name('customer.dashboard');
    
    // Rute untuk jersey pelanggan (jual jersey)
    Route::get('/jerseys/sell', [JerseyController::class, 'showSellForm'])->name('jerseys.sell.form');
    Route::post('/jerseys/sell', [JerseyController::class, 'sellJersey'])->name('jerseys.sell');
    
    // Rute untuk transaksi pembelian
    Route::get('/transactions/buy/{jersey}', [TransactionController::class, 'showBuyForm'])->name('transactions.buy.form');
    Route::post('/transactions/buy/{jersey}', [TransactionController::class, 'buyJersey'])->name('transactions.buy');
    
    // Rute untuk riwayat transaksi pelanggan
    Route::get('/transactions', [TransactionController::class, 'customerTransactions'])->name('transactions.customer');
    
    // Rute untuk jersey yang tersedia untuk dibeli (publik untuk yang sudah login sebagai pelanggan)
    Route::get('/available-jerseys', [JerseyController::class, 'availableJerseys'])->name('jerseys.available');
});

// Rute hanya untuk admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    
    // Rute untuk manajemen jersey oleh admin
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/jerseys', [JerseyController::class, 'adminIndex'])->name('jerseys.index');
        Route::get('/jerseys/system', [JerseyController::class, 'systemJerseys'])->name('jerseys.system');
        Route::get('/jerseys/create', [JerseyController::class, 'adminCreate'])->name('jerseys.create');
        Route::post('/jerseys', [JerseyController::class, 'adminStore'])->name('jerseys.store');
        Route::get('/jerseys/{jersey}/edit', [JerseyController::class, 'adminEdit'])->name('jerseys.edit');
        Route::put('/jerseys/{jersey}', [JerseyController::class, 'adminUpdate'])->name('jerseys.update');
        Route::delete('/jerseys/{jersey}', [JerseyController::class, 'adminDestroy'])->name('jerseys.destroy');
        
        // Rute untuk menyetujui/menolak jersey dari pelanggan
        Route::put('/jerseys/{jersey}/approve', [JerseyController::class, 'approveJersey'])->name('jerseys.approve');
        Route::put('/jerseys/{jersey}/reject', [JerseyController::class, 'rejectJersey'])->name('jerseys.reject');
        
        // Rute untuk manajemen transaksi
        Route::get('/transactions', [TransactionController::class, 'adminIndex'])->name('transactions.index');
        Route::put('/transactions/{transaction}/approve', [TransactionController::class, 'approveTransaction'])->name('transactions.approve');
        Route::put('/transactions/{transaction}/reject', [TransactionController::class, 'rejectTransaction'])->name('transactions.reject');
    });
});
