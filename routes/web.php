<?php

use App\Http\Controllers\MedicineController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Models\User;

// Route::get('/', function () {
//     return view('login');
// })->name('login');

Route::get('/',[AccountController::class, 'home'])->name('home');
Route::get('/login', [AccountController::class, 'login'])->name('login');
Route::post('/login', [AccountController::class, 'loginAuth'])->name('login.auth');
Route::get('/logout', [AccountController::class, 'logout'])->name('logout');

Route::prefix('/medicine')->name('medicine.')->group(function() { 
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

Route::prefix('/user')->name('user.')->group(function() { 
    Route::get('/create', [AccountController::class, 'create'])->name('create');
    Route::get('/', [AccountController::class, 'index'])->name('index');
    Route::get('/{id}', [AccountController::class, 'edit'])->name('edit');
    Route::patch('/{id}', [AccountController::class, 'update'])->name('update');
    Route::delete('/{id}', [AccountController::class, 'destroy'])->name('delete');
    Route::post('/store', [AccountController::class, 'store'])->name('store');
});


?>