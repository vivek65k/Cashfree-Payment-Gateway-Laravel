<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentGateWay;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/pay',[PaymentGateWay::class,'InitialPayment'])->name('payment.pay');
Route::get('/success/{orderId}',[PaymentGateWay::class,'PaymentSuccess'])->name('payment.success');
