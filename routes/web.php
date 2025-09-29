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
use App\Http\Controllers\ProductReportController;
use App\Http\Controllers\StockTransactionController;
use App\Http\Controllers\UserLogController;

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

    Route::get('/report',[ ProductReportController::class, 'index'])->name('report.index');
    Route::get('/report/users',[ UserLogController::class, 'usersReport'])->name('report.users.index');
    Route::get('/report/users/pdf',[ UserLogController::class, 'usersExportPdf'])->name('report.users.pdf');
    Route::get('/report/user/{user}',[ UserLogController::class, 'userReport'])->name('report.user.index');
    Route::get('/report/user/{user}/pdf',[ UserLogController::class, 'userExportPdf'])->name('report.user.pdf');

    Route::prefix('report/products')->name('report.products.')->group(function(){
    Route::get('/', [ProductReportController::class, 'productsReport'])->name('index');
    Route::get('/pdf', [ProductReportController::class, 'exportPdf'])->name('pdf');
    Route::get('/excel', [ProductReportController::class, 'exportExcel'])->name('excel');
    });


    Route::prefix('report/product')->name('report.product.')->group(function () {
    Route::get('/', [ProductReportController::class, 'productList'])->name('index');
    Route::get('{product}', [ProductReportController::class, 'productReport'])->name('show');
    Route::get('{product}/pdf', [ProductReportController::class, 'exportProductPdf'])->name('pdf');
    Route::get('{product}/excel', [ProductReportController::class, 'exportProductExcel'])->name('excel');
    });




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






