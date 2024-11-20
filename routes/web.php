<?php

use App\Http\Controllers\MedicineController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;

Route::middleware(['IsGuest'])->group(function () {
    Route::get('/', [AccountController::class, 'login'])->name('login');
    Route::post('/login', [AccountController::class, 'loginAuth'])->name('login.auth');
});

Route::middleware(['IsLogin'])->group(function () {
    route::get('/logout', [AccountController::class, 'logout'])->name('logout');
    Route::get('/home', function () {
        return view('home');
    })->name('home.page');

    Route::get('/home', [AccountController::class, 'home'])->name('home');
    Route::get('/logout', [AccountController::class, 'logout'])->name('logout');
    Route::get('/download/{id}', [OrderController::class, 'show'])->name('orders.print');

    Route::middleware(['IsAdmin'])->group(function () {

        // Medicine Routes
        Route::prefix('/medicine')->name('medicine.')->group(function () {
            Route::get('/create', [MedicineController::class, 'create'])->name('create');
            Route::post('/store', [MedicineController::class, 'store'])->name('store');
            Route::get('/', [MedicineController::class, 'index'])->name('home');
            Route::get('/{id}', [MedicineController::class, 'edit'])->name('edit');
            Route::patch('/{id}', [MedicineController::class, 'update'])->name('update');
            Route::delete('/{id}', [MedicineController::class, 'destroy'])->name('delete');
            Route::get('/data/stock', [MedicineController::class, 'stock'])->name('stock');
            Route::get('/data/stock/{id}', [MedicineController::class, 'stockEdit'])->name('stock.edit');
            Route::patch('/data/stock/{id}', [MedicineController::class, 'stockUpdate'])->name('stock.update');
        });
        
        // User Routes
        Route::prefix('/user')->name('user.')->group(function () {
            Route::get('/create', [AccountController::class, 'create'])->name('create');
            Route::get('/', [AccountController::class, 'index'])->name('index');
            Route::get('/{id}', [AccountController::class, 'edit'])->name('edit');
            Route::patch('/{id}', [AccountController::class, 'update'])->name('update');
            Route::delete('/{id}', [AccountController::class, 'destroy'])->name('delete');
            Route::post('/store', [AccountController::class, 'store'])->name('store');
        });
        Route::prefix('/order')->name('order.')->group(function() {
            Route::get('/data', [OrderController::class , 'data'])->name('data');
            Route::get('/export-excel', [OrderController::class, 'exportExcel'])->name('export-excel');
        });
    });

    // Order Routes
    Route::prefix('/pembelian')->name('pembelian.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/create', [OrderController::class, 'create'])->name('create');
        Route::post('/store', [OrderController::class, 'store'])->name('store');
    });
});

Route::middleware(['IsLogin'])->group(function () {
    Route::prefix('/kasir')->name('kasir.')->group(function () {
        Route::prefix('/order')->name('order.')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('index');
            Route::get('/create', [OrderController::class, 'create'])->name('create');
            Route::post('/store', [OrderController::class, 'store'])->name('store');
            Route::get('/print/{id}', [OrderController::class, 'show'])->name('print');
            Route::get('/download/{id}', [OrderController::class, 'downloadPDF'])->name('download');
        });
    });
});