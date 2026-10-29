<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

use App\Models\Product;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/test-product', function () {
    return Product::all();
});

Route::get('/produk', [ProductController::class, 'index'])->name('produk.index');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('produk.show');

Route::resource('products', ProductController::class);
