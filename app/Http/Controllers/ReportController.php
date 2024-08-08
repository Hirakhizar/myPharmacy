<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function purchaseReport(){
        $user=Auth::user();
        if ($user->usertype == 'admin') {
            $purchase = Order::get();
        return view('admin.puchase_report',compact('user','purchase'));
        }
    }
    public function stockReport(){
        $user=Auth::user();
        if ($user->usertype == 'admin') {
            $medicine = Medicine::get();
        return view('admin.stock-report',compact('user','medicine'));
        }
    }
    public function report(){
        $user=Auth::user();
        if ($user->usertype == 'admin') {
            $medicine = OrderItem::with('medicine.manufacturer')->get();
        return view('admin.purchaseByStock',compact('user','medicine'));
        }
    }
}
