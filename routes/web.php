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
Route::get('/customer/delete', [CutomerController::class, 'destroy'])->name('destroy');
Route::delete('/customer/{id}', [CutomerController::class, 'destroy'])->name('customer.destroy');
Route::get('/customer/{id}', [CutomerController::class, 'show'])->name('customer.show');;
Route::post('items', [CutomerController::class, 'add'])->name('items');


Route::get('/customers/{id}/edit', [cutomerController::class, 'edit'])
    ->name('customers.edit');


Route::put('/customers/{id}', [cutomerController::class, 'update'])
    ->name('customers.update');
