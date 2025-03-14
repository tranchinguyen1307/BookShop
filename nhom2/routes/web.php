<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('admin.layouts.master');
});
Route::get('/product-add', function () {
    return view('admin.pages.product.add');
});
