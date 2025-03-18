<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.pages.home');
});
Route::get('/contact', function () {
    return view('client.pages.contact');
    return view('admin.layouts.master');
});
Route::get('/product-add', function () {
    return view('admin.pages.product.add');
});
Route::get('/shop', function () {
    return view('client.pages.shop');
});
