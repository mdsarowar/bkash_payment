<?php

use Illuminate\Support\Facades\Route;
use Sarowar\Bkash\Controllers\PaymentController;

Route::get('index', [PaymentController::class, 'index']);
Route::post('bkash/payment', [PaymentController::class, 'createPayment'])->name('payment');
Route::match(['GET', 'POST'], 'success', [PaymentController::class, 'success'])->name('success');
