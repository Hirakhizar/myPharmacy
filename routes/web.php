<?php

use App\Http\Controllers\MemberController;
use App\Models\Medicine;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SalesOrderController;

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

Route::get('order/show',[SalesOrderController::class,'showMedicine']);
Route::post('cart/add/{id}',[SalesOrderController::class,'addToCart']);
Route::get('/cart/view',[SalesOrderController::class,'viewCart']);
Route::post('order/confirm', [SalesOrderController::class, 'ConfirmOrder']);

Route::get('order/itemsDetails/{id}',[SalesOrderController::class,'itemsDetails']);
Route::get('order/showOrders',[SalesOrderController::class,'showOrders']);

Route::get('/redirect',[PharmacyController::class,'redirect']);
Route::get('customer/add',[CustomerController::class,'addformCustomer']);
Route::post('add/customer',[CustomerController::class,'addCustomer']);
Route::get('customer/show',[CustomerController::class,'showCustomer']);
Route::get('customer/edit/{id}',[CustomerController::class,'editCustomer']);
Route::post('customer/update/{id}',[CustomerController::class,'updateCustomer']);
Route::get('/customer/delete/{id}',[CustomerController::class,'deleteCustomer']);
Route::get('members/show',[MemberController::class,'showMember']);
Route::get('members/add',[MemberController::class,'addFormMember']);
Route::post('add/member',[MemberController::class,'addMember']);
Route::get('member/edit/{id}',[MemberController::class,'editmember']);
Route::post('member/update/{id}',[MemberController::class,'updatemember']);
Route::get('/member/delete/{id}',[MemberController::class,'deletemember']);
Route::get('member/attendence',[MemberController::class,'attendenceMember']);
Route::post('member/attendece/add',[MemberController::class,'addAttendence']);
Route::get('/member/attendece/delete/{id}',[MemberController::class,'deleteAttendence']);
Route::get('member/attendece/edit/{id}',[MemberController::class,'editAttendece']);

Route::post('member/attendece/update/{id}',[MemberController::class,'updateAttendence']);
/////
Route::get('member/salary',[MemberController::class,'salaryMember']);



// <.............. Medicine Route................>
Route::get('medicine',[MedicineController::class,'addformmedicine'])->name('medicine-form');
Route::post('add/medicine', [MedicineController::class, 'create'])->name('create');
Route::get('/medicine/list', [MedicineController::class, 'index'])->name('index');
Route::get('medicine/edit/{id}',[MedicineController::class,'edit']);
Route::post('medicine/update/{id}',[MedicineController::class,'update']);
Route::get('/medicine/delete/{id}',[MedicineController::class,'delete']);

// <.............. Manufacture Route................>
Route::get('manufacture',[ManufacturerController::class,'addformmanufacture'])->name('manufacture-form');
Route::post('/add/manufacture', [ManufacturerController::class, 'create'])->name('create');
Route::get('/manufacturers/list', [ManufacturerController::class, 'index'])->name('manufacturers.index');
Route::get('manufacturer/edit/{id}',[ManufacturerController::class,'edit']);
Route::post('manufacturer/update/{id}',[ManufacturerController::class,'update']);
Route::get('/manufacturer/delete/{id}',[ManufacturerController::class,'delete']);



