<?php

use App\Models\Medicine;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ManufacturerController;

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

// <.............. Medicine Route................>
Route::get('medicine',[MedicineController::class,'addformmedicine'])->name('medicine-form');


// <.............. Manufacture Route................>
Route::get('manufacture',[ManufacturerController::class,'addformmanufacture'])->name('manufacture-form');
Route::post('/add/manufacture', [ManufacturerController::class, 'create']);
Route::get('/manufacturers/list', [ManufacturerController::class, 'index'])->name('manufacturers.index');



