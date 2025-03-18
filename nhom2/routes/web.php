<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('client.pages.home');
});
Route::get('/contact', function () {
    return view('client.pages.contact');
});
Route::get('/shop', function () {
    return view('client.pages.shop');
});