<?php

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductDetailController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class,'index']);
Route::get('/product/{id}',[ProductDetailController::class,'show'])->name('product.show');
Route::get('/contact', function () {
    return view('client.pages.contact');
});
Route::get('/shop', function () {
    return view('client.pages.shop');
});
