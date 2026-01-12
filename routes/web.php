<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminMenuController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\StockController;

// Halaman QR Menu untuk Customer
Route::get('/', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{category?}', [MenuController::class, 'byCategory'])->name('menu.category');
Route::post('/order', [OrderController::class, 'store'])->name('order.store');
Route::get('/order/{order}', [OrderController::class, 'show'])->name('order.show');
Route::get('/track/{orderCode}', [OrderController::class, 'track'])->name('order.track');

// API untuk check order status (public)
Route::get('/api/check-order-status/{orderCode}', [OrderController::class, 'checkStatus']);

// Auth Routes (with rate limiting)
Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::post('/login', [UserController::class, 'login'])->middleware('throttle:10,5'); // Max 10 attempts per 5 minutes
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

// Admin Routes (Protected by auth middleware)
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Order Management
    Route::get('/orders', [AdminController::class, 'index'])->name('orders.index');
    Route::put('/orders/{id}/status', [AdminController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::put('/orders/{id}/payment', [AdminController::class, 'confirmPayment'])->name('orders.confirmPayment');
    Route::get('/orders/{id}/print', [AdminController::class, 'printOrder'])->name('orders.print');
    
    // Menu Management
    Route::get('/menu', [AdminMenuController::class, 'index'])->name('menu.index');
    Route::get('/menu/create', [AdminMenuController::class, 'create'])->name('menu.create');
    Route::post('/menu', [AdminMenuController::class, 'store'])->name('menu.store');
    Route::get('/menu/{menu}/edit', [AdminMenuController::class, 'edit'])->name('menu.edit');
    Route::put('/menu/{menu}', [AdminMenuController::class, 'update'])->name('menu.update');
    Route::delete('/menu/{menu}', [AdminMenuController::class, 'destroy'])->name('menu.destroy');
    
    // Category Management
    Route::get('/categories', [AdminMenuController::class, 'categoryIndex'])->name('categories.index');
    Route::post('/categories', [AdminMenuController::class, 'categoryStore'])->name('categories.store');
    Route::put('/categories/{category}', [AdminMenuController::class, 'categoryUpdate'])->name('categories.update');
    Route::delete('/categories/{category}', [AdminMenuController::class, 'categoryDestroy'])->name('categories.destroy');
    
    // Stock Management
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::post('/stock/{menu}/toggle', [StockController::class, 'toggleStock'])->name('stock.toggle');
    Route::post('/stock/{menu}/update', [StockController::class, 'updateStock'])->name('stock.update');
    Route::get('/stock/logs', [StockController::class, 'logs'])->name('stock.logs');
    
    // Sales Report
    Route::get('/reports/sales', [ReportController::class, 'index'])->name('reports.sales');
    Route::get('/reports/sales/excel', [ReportController::class, 'exportExcel'])->name('reports.excel');
    Route::get('/reports/sales/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');
    
    // QR Code Generation
    Route::get('/qr-code', [AdminController::class, 'qrCode'])->name('qrcode');
});
