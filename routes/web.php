<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PharmacyController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
Route::get('/redirect',[PharmacyController::class,'redirect']);
Route::get('customer/add',[CustomerController::class,'addformCustomer']);
Route::post('add/customer',[CustomerController::class,'addCustomer']);
Route::get('customer/show',[CustomerController::class,'showCustomer']);
Route::get('customer/edit/{id}',[CustomerController::class,'editCustomer']);
Route::post('customer/update/{id}',[CustomerController::class,'updateCustomer']);
Route::get('/customer/delete/{id}',[CustomerController::class,'deleteCustomer']);

Route::get('members/show',[MemberController::class,'showMember']);
Route::get('members/add',[MemberController::class,'addMember']);


