<?php

use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\StockTransactionController;

Route::get('/', function () {
    return view('home', [
        'title' => 'home'
    ]);
})->name('home');

Route::get('/register', function () {
    return view('register', [
        'title' => 'register'
    ]);
})->name('register');

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth')->group(function(){
    Route::get('/dashboard', function () {
        return view('dashboard', [
            'title' => 'Dashboard'
        ]);
    })->name('dashboard');

    Route::resource('product', ProductController::class);
    Route::resource('category', CategoryController::class);
    Route::resource('supplier', SupplierController::class);
    Route::resource('productAttribute', ProductAttributeController::class);
    Route::resource('stockTransaction', StockTransactionController::class);
    Route::patch('stockTransaction/{stockTransaction}/approve',[
        StockTransactionController::class, 'approve'
        ])->name('stockTransaction.approve');
    Route::patch('stockTransaction/{stockTransaction}/reject',[
        StockTransactionController::class, 'reject'
        ])->name('stockTransaction.reject');

    Route::resource('user', UserController::class);

});






