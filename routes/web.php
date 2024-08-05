<?php

use App\Models\Medicine;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesOrderController;
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
Route::get('members/add',[MemberController::class,'addMember']);


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
// <.............. Purchase Route................>
Route::get('/purchase',[PurchaseController::class,'indexpurchase']);
Route::post('addToCart/{id}',[PurchaseController::class,'addtocart']);
Route::get('/cart/view',[PurchaseController::class,'view']);
Route::get('remove/{id}',[PurchaseController::class,'del']);
Route::get('confirm',[PurchaseController::class,'confirm']);
Route::get('/order',[PurchaseController::class,'list'])->name('order');

Route::get('orders/detail/{id}', [PurchaseController::class, 'detail'])->name('detail');

Route::get('/payment/{id}',[OrderController::class,'index'])->name('payment');
Route::post('/orders/{order_id}/payment',[OrderController::class,'store'])->name('payment.store');
Route::get('/order/payment/list',[OrderController::class,'show'])->name('payment_list');
Route::get('/payment/edit/{order_id}',[OrderController::class,'edit'])->name('payment.edit');
Route::post('/payment/edit/{order_id}',[OrderController::class,'update'])->name('payment.update');
// ..........................Manufacturer ledger...............................
Route::get('/manufacture/ledger',[LedgerController::class,'index'])->name('manufacturers.ledger');
Route::get('/manufacture/ledger/{id}',[LedgerController::class,'payment'])->name('manufacture.payment');
Route::post('/manufacture/ledger/{id}',[LedgerController::class,'store'])->name('manufacturer.store');
