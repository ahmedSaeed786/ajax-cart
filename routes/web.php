<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CutomerController;
use App\Http\Controllers\ItemController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('customer', [CutomerController::class, 'store'])->name('customer');
Route::post('/customer/validate', [CutomerController::class, 'validateField'])->name('customer.validate');
Route::post('items', [CutomerController::class, 'add'])->name('items');
