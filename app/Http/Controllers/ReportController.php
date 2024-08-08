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
    public function salesReport(Request $request)
    {
        $user = Auth::user();
        $query = SalesOrder::query();


        if ($request->has('orderId')) {
            $query->where('id', 'like', '%' . $request->orderId . '%');
        }

        if ($request->has('customer')) {
            $query->where('customer', 'like', '%' . $request->customer . '%');
        }

        if ($request->has('startDate') && $request->has('endDate')) {
            if($request->startDate==$request->endDate){
                $query->whereDate('date','=',$request->startDate);
            }else{
                $query->whereBetween('date', [ $request->startDate, $request->endDate]);
            }

        }
        $orders = $query->paginate(5);  
          return view('admin.SalesReport', compact('user', 'orders'));
    }
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
