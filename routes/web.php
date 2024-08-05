<?php

use App\Http\Controllers\BalanceSheet;
use App\Http\Controllers\BalanceSheetController;
use App\Http\Controllers\MemberController;
use App\Models\Medicine;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SalesOrderController;
use App\Models\Expense;

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
///cart
Route::post('cart/add/{id}',[SalesOrderController::class,'addToCart']);
Route::get('/cart/view',[SalesOrderController::class,'viewCart']);
Route::get('cart/remove/{id}',[SalesOrderController::class,'deleteCart']);
Route::post('order/confirm', [SalesOrderController::class, 'ConfirmOrder']);
Route::get('order/itemsDetails/{id}',[SalesOrderController::class,'itemsDetails']);
Route::get('order/recipte/{id}',[SalesOrderController::class,'recipte']);
Route::get('order/showOrders',[SalesOrderController::class,'showOrders']);
/////payment
Route::get('order/payment/show/{id}', [SalesOrderController::class, 'showpayment']);
Route::post('order/payment/add/{id}', [SalesOrderController::class, 'addpayment']);
Route::get('order/payment/edit/{id}',[SalesOrderController::class,'editPayment']);
Route::post('order/payment/update/{id}',[SalesOrderController::class,'updatePayment']);
////Refund
Route::get('order/refund',[SalesOrderController::class,'showRefund']);
Route::get('order/refund/showform/{id}',[SalesOrderController::class,'refundForm']);
Route::get('order/refund/item/{id}',[SalesOrderController::class,'refundItem']);
Route::get('order/refund/confirm/{id}',[SalesOrderController::class,'refundConfirm']);
/////////Expenses Categories////////

Route::get('expenses/category',[ExpenseController::class,'showcategory']);
Route::post('expenses/category/add',[ExpenseController::class,'addcategory']);
Route::post('expenses/subCategory/add',[ExpenseController::class,'addsubcategory']);
Route::get('expenses/subCategory/remove/{id}',[ExpenseController::class,'removesubcategory']);
Route::get('expenses/show',[ExpenseController::class,'showExpenses']);
Route::get('expenses', [ExpenseController::class, 'showExpenses']);
/////////Expenses////////
Route::get('expenses/add',[ExpenseController::class,'showExpencesForm']);
Route::post('expenses/add',[ExpenseController::class,'addExpences']);
Route::get('expenses/delete/{id}',[ExpenseController::class,'deleteExpences']);
Route::get('expenses/edit/{id}',[ExpenseController::class,'editExpences']);
Route::post('expenses/update/{id}',[ExpenseController::class,'updateExpences']);
/////////Balance Sheet////////
RoutE::get('balanceSheet',[BalanceSheetController::class,'balanceSheet']);






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
//////attendence
Route::get('member/attendence',[MemberController::class,'attendenceMember']);
Route::post('member/attendece/add',[MemberController::class,'addAttendence']);
Route::get('/member/attendece/delete/{id}',[MemberController::class,'deleteAttendence']);
Route::get('member/attendece/edit/{id}',[MemberController::class,'editAttendece']);
Route::post('member/attendece/update/{id}',[MemberController::class,'updateAttendence']);
/////Salary
Route::get('member/salary',[MemberController::class,'salaryMember']);
Route::post('member/salary/add',[MemberController::class,'addSalary']);




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



