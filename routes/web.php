<?php

use App\Http\Controllers\HomeController;
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
    return view('auth.login');
});

Route::get('/{locale}/change-language', 'App\Http\Controllers\LocalizationController@changeLanguage')
    ->name('change.language');

Route::middleware('set_locale')->group(function () {

    Auth::routes();

    Route::get('/admin', [\App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.home');

    Route::get('/home', [App\Http\Controllers\ProductController::class, 'index'])->name('home');

//Маршруты корзины: Все товары в корзине, добавление, удаление одного, сохранение в БД, очистка корзины.
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart');
    Route::post('/cart/add/{product}', [\App\Http\Controllers\CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{product}', [\App\Http\Controllers\CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/checkout', [\App\Http\Controllers\CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/cart/checkout-temporary/{checkId}', [\App\Http\Controllers\CartController::class, 'checkoutTemporary'])->name('cart.checkout.temporary');
    Route::post('/cart/clear-cart', [\App\Http\Controllers\CartController::class, 'clear'])->name('cart.clear');
    Route::get('/cart/{checkId}', [\App\Http\Controllers\CartController::class, 'indexDelayed'])->name('cart.indexDelayed');


    Route::middleware('role:admin')->prefix('/admin')->group(function () {
        Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'welcome'])->name('welcome');

        Route::get('/products', [\App\Http\Controllers\HomeController::class, 'products'])->name('admin.product');
        Route::get('/products/edit/{id}', [\App\Http\Controllers\ProductController::class, 'edit'])->name('admin.product.edit');
        Route::post('/product/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('admin.product.update');
        Route::get('/product/create', [App\Http\Controllers\ProductController::class, 'create'])->name('admin.product.create');
        Route::post('/product/store', [App\Http\Controllers\ProductController::class, 'store'])->name('admin.product.store');

        Route::post('/product/update-price/{id}', [App\Http\Controllers\ProductController::class, 'updatePrice'])->name('admin.product.update-price');
        Route::post('/product/delete/{id}', [App\Http\Controllers\ProductController::class, 'delete'])->name('admin.product.delete');


        Route::get('/category/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('admin.category.create');
        Route::post('/category/store', [\App\Http\Controllers\CategoryController::class, 'store'])->name('admin.category.store');

        Route::get('/reports', [\App\Http\Controllers\Admin\ReportController::class, 'todayReport'])->name('admin.reports');
        Route::get('/reports/monthly', [\App\Http\Controllers\Admin\ReportController::class, 'calcMonthlyReport'])->name('admin.reports.monthly');


        Route::get('/stock', [\App\Http\Controllers\Stock\StockController::class, 'index'])->name('admin.stock');
        Route::get('/stock/first-step', [\App\Http\Controllers\Stock\StockController::class, 'firstStep'])->name('admin.stock.first_step');
        Route::get('/stock/first-step-check', [\App\Http\Controllers\Stock\StockController::class, 'firstStepCheck'])->name('admin.stock.first_step_check');

        Route::get('/stock/create', [\App\Http\Controllers\Stock\StockController::class, 'create'])->name('admin.stock.create');
        Route::post('/stock/store', [\App\Http\Controllers\Stock\StockController::class, 'store'])->name('admin.stock.store');
        Route::post('/stock/delete/{id}', [\App\Http\Controllers\Stock\StockController::class, 'delete'])->name('admin.stock.delete');
        Route::get('/stock/single-delivery/{delivery}', [\App\Http\Controllers\Stock\StockController::class, 'singleDelivery'])->name('admin.stock.delivery');
        Route::get('/stock/products/{supplierId}', [\App\Http\Controllers\Stock\StockController::class, 'getProductsBySupplier'])->name('admin.stock.products');


        Route::get('/suppliers', [\App\Http\Controllers\SupplierController::class, 'index'])->name('admin.suppliers');
        Route::get('/suppliers/create', [\App\Http\Controllers\SupplierController::class, 'create'])->name('admin.suppliers.create');
        Route::post('/suppliers/store', [\App\Http\Controllers\SupplierController::class, 'store'])->name('admin.suppliers.store');
        Route::post('/suppliers/delete/{id}', [\App\Http\Controllers\SupplierController::class, 'delete'])->name('admin.suppliers.delete');


    });
});


