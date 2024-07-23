<?php
use App\Models\Medicine;


use App\Http\Controllers\MemberController;


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



// <.............. Medicine Route................>
Route::get('medicine',[MedicineController::class,'addformmedicine'])->name('medicine-form');


// <.............. Manufacture Route................>
Route::get('manufacture',[ManufacturerController::class,'addformmanufacture'])->name('manufacture-form');
Route::post('/add/manufacture', [ManufacturerController::class, 'create']);
Route::get('/manufacturers/list', [ManufacturerController::class, 'index'])->name('manufacturers.index');



