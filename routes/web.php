<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::match(["GET", "POST"], "/register", function(){
    return redirect("/login");
})->name("register");

Route::resource('products', ProductController::class);

Route::resource('orders', OrderController::class);

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');