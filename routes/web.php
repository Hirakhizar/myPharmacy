<?php

use App\Http\Controllers\BalanceSheetController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\LedgerController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\ManufacturerController;
use App\Http\Controllers\ReportController;
use App\Http\Middleware\EnsureUserIsAdmin;
use App\Http\Middleware\EnsureUserIsSalesman;

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

Route::get('/cart/view2',[SalesOrderController::class,'viewCart']);

Route::get('cart/remove/{id}',[SalesOrderController::class,'deleteCart']);

Route::post('order/confirm', [SalesOrderController::class, 'ConfirmOrder']);
Route::get('order/itemsDetails/{id}',[SalesOrderController::class,'itemsDetails']);
Route::get('order/recipte/{id}',[SalesOrderController::class,'recipte']);
Route::get('order/showOrders',[SalesOrderController::class,'showOrders']);

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

Route::get('expenses/add',[ExpenseController::class,'showExpencesForm']);
Route::post('expenses/add',[ExpenseController::class,'addExpences']);
Route::get('expenses/delete/{id}',[ExpenseController::class,'deleteExpences']);
Route::get('expenses/edit/{id}',[ExpenseController::class,'editExpences']);
Route::post('expenses/update/{id}',[ExpenseController::class,'updateExpences']);

RoutE::get('balanceSheet',[BalanceSheetController::class,'balanceSheet']);






Route::get('/redirect',[PharmacyController::class,'redirect']);
////////////////Admin Routes///////////////
Route::middleware([EnsureUserIsAdmin::class])->group(function () {
   
        Route::get('order/show',[SalesOrderController::class,'showMedicine']);
        ///cart
        Route::post('cart/add/{id}',[SalesOrderController::class,'addToCart']);
        Route::get('/cart/view2',[SalesOrderController::class,'viewCart']);
        Route::get('cart/remove/{id}',[SalesOrderController::class,'deleteCart']);
        Route::post('order/confirm', [SalesOrderController::class, 'ConfirmOrder']);
        Route::get('sales/itemsDetails/{id}',[SalesOrderController::class,'itemsDetails']);
        Route::get('order/recipte/{id}',[SalesOrderController::class,'recipte']);
        Route::get('order/showOrders',[SalesOrderController::class,'showOrders']);
        /////payment
        Route::get('sales/payment/show/{id}', [SalesOrderController::class, 'showpayment']);
        Route::post('sales/payment/add/{id}', [SalesOrderController::class, 'addpayment']);
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
Route::get('/member/salary/delete/{id}',[MemberController::class,'deleteSalary']);
Route::get('member/salary/edit/{id}',[MemberController::class,'editSalary']);
Route::post('member/salary/update/{id}',[MemberController::class,'updateSalary']);
///////////////Reports////////////////
Route::get('reports/sales',[ReportController::class,'salesReport']);

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

     
    });



//////////////////////Salesman Routes////////////////////
    Route::middleware([EnsureUserIsSalesman::class])->group(function () {
    });
        
        Route::get('order/show',[SalesOrderController::class,'showMedicine']);
        ///cart
        Route::post('cart/add/{id}',[SalesOrderController::class,'addToCart']);
        Route::get('/cart/view2',[SalesOrderController::class,'viewCart']);
        Route::get('cart/remove/{id}',[SalesOrderController::class,'deleteCart']);
        Route::post('order/confirm', [SalesOrderController::class, 'ConfirmOrder']);
        Route::get('sales/itemsDetails/{id}',[SalesOrderController::class,'itemsDetails']);
        Route::get('order/recipte/{id}',[SalesOrderController::class,'recipte']);
        Route::get('order/showOrders',[SalesOrderController::class,'showOrders']);
        /////payment
        Route::get('sales/payment/show/{id}', [SalesOrderController::class, 'showpayment']);
        Route::post('sales/payment/add/{id}', [SalesOrderController::class, 'addpayment']);
        Route::get('order/payment/edit/{id}',[SalesOrderController::class,'editPayment']);
        Route::post('order/payment/update/{id}',[SalesOrderController::class,'updatePayment']);
        ////Refund
        Route::get('order/refund',[SalesOrderController::class,'showRefund']);
        Route::get('order/refund/showform/{id}',[SalesOrderController::class,'refundForm']);
        Route::get('order/refund/item/{id}',[SalesOrderController::class,'refundItem']);
        Route::get('order/refund/confirm/{id}',[SalesOrderController::class,'refundConfirm']);
    
        
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
   

