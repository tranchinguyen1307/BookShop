<?php

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductDetailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\client\AuthController;
use App\Http\Controllers\client\UserController;
use App\Http\Controllers\client\ForgotPasswordController;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\client\AddressController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [ProductDetailController::class, 'show'])->name('product.show');
Route::get('/contact', function () {
    return view('client.pages.contact');
})->name('contact');
Route::get('/shop', function () {
    return view('client.pages.shop');
})->name('shop');
Route::middleware('auth')->prefix('cart')->name('cart.')->controller(CartController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/add', 'addToCart')->name('add');
    Route::post('/update', 'updateCart')->name('update');
    Route::post('/remove', 'removeFromCart')->name('remove');
});

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {
    Route::get('/account', [UserController::class, 'index'])->name('account');
    Route::put('/account/update', [UserController::class, 'update'])->name('account.update');
    Route::put('/account/changePassword', [UserController::class, 'changePassword'])->name('account.changePassword');
    Route::delete('/account/delete', [UserController::class, 'destroy'])->name('account.destroy');
    Route::get('/account/confirm-delete', [UserController::class, 'confirmDelete'])->name('account.confirmDelete');
    Route::resource('addresses', AddressController::class)->except(['show']);
});


Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot-password.form');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendOtp'])->name('forgot-password.sendOtp');

Route::get('/forgot-password/otp', [ForgotPasswordController::class, 'showOtpForm'])->name('forgot-password.otpForm');
Route::post('/forgot-password/otp', [ForgotPasswordController::class, 'verifyOtp'])->name('forgot-password.verifyOtp');

Route::get('/reset-password', [ForgotPasswordController::class, 'showResetPasswordForm'])->name('reset-password.form');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->name('reset-password');


