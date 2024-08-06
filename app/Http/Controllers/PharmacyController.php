<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Expense;
use App\Models\Medicine;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use App\Models\SalesPayment_info;
use Illuminate\Support\Facades\Auth;

class PharmacyController extends Controller
{
    public function redirect(){
        $user=Auth::user();
        if($user->usertype=='admin'){
            $order = SalesOrder::count();
            $purchase = Order::count();
            $sale = SalesOrder::sum('total');
            $expense = Expense::sum('amount');
            $customer = SalesOrder::get();
            $payment = SalesPayment_info::get();
            $medicine = Medicine::get();
            return view('admin.dashboard',compact('user','order','purchase','sale','expense','customer','payment','medicine'));

        }
    }

}
