<?php

use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductDetailController;
use App\Http\Controllers\Client\ReviewController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\client\AuthController;
use App\Http\Controllers\client\UserController;
use App\Http\Controllers\client\ForgotPasswordController;
use App\Http\Controllers\client\CartController;
use App\Http\Controllers\client\AddressController;
use App\Http\Controllers\Client\ShopController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\BlogController;
use App\Http\Controllers\Auth\SocialLoginController;
use App\View\Components\client\navbar;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\BlogDetailController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product/{id}', [ProductDetailController::class, 'show'])->name('product.show');
Route::get('/contact', function () {
    return view('client.pages.contact');
})->name('contact');
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/search', [navbar::class, 'search'])->name('search');
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{id}', [BlogDetailController::class, 'show'])->name('blog.show');
Route::middleware('auth')->prefix('cart')->name('cart.')->controller(CartController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::post('/add', 'addToCart')->name('add');
    Route::post('/update', 'updateCart')->name('update');
    Route::post('/remove', 'removeFromCart')->name('remove');
});
Route::middleware('auth')->prefix('checkout')->name('checkout.')->controller(CheckoutController::class)->group(function () {
    Route::get('/', 'process')->name('index');
    Route::post('/', 'process')->name('process');
    Route::post('/store', 'storeOrder')->name('store');
    Route::get('/thanks', 'thanks');

});
Route::post('checkout/payment-ipn', [CheckoutController::class, 'handleIPN']);

Route::middleware('auth')->prefix('review')->name('review.')->controller(ReviewController::class)->group(function () {
    Route::post('/add', 'store')->name('store');
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

Route::get('auth/google', [SocialLoginController::class, 'redirectToGoogle'])->name('google.login');
Route::get('auth/google/callback', [SocialLoginController::class, 'handleGoogleCallback']);

Route::middleware('auth')->prefix('orders')->name('orders.')->group(function () {
    Route::get('/history', [OrderController::class, 'history'])->name('history');
    Route::get('/{id}', [OrderController::class, 'show'])->name('show');

});
Route::put('/orders/{order}/cancel', [OrderController::class, 'cancel'])->name('orders.cancel');
Route::put('/orders/{order}/receive', [OrderController::class, 'markAsReceived'])->name('orders.receive');
