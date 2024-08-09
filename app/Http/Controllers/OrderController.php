<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index($id){
        $user =Auth::user();
        if($user){
            $order = Order::find($id);
            return view('admin.order_payment' ,compact('user','order'));
        }

    }
    public function store(Request $request, $order_id)
    {
        $request->validate([
            'method' => 'required|string',
            'amount' => 'required|numeric|min:0',
        ]);

        $user = Auth::user();
          if($user) {
            // Fetch the relevant order
            $order = Order::find($order_id);

            if ($order) {
                // Create a new payment info entry for each payment
                $paymentInfo = new PaymentInfo();
                $paymentInfo->order_id = $order->id;
                $paymentInfo->amount = $request->amount;
                $paymentInfo->method = $request->method;

                // Calculate the total amount paid so far including this payment
                $totalPaidSoFar = PaymentInfo::where('order_id', $order->id)->sum('amount');
                $totalPaidSoFar += $request->amount;

                // Determine the payment status based on the total amount paid so far
                if ($totalPaidSoFar >= $order->total_amount) {
                    $paymentInfo->status = "completed";
                    $order->status = "completed";
                    $remainingAmount = 0;
                } else {
                    $paymentInfo->status = "incomplete";
                    $order->status = "incomplete";
                    $remainingAmount = $order->total_amount - $totalPaidSoFar;
                }
                $paymentInfo->date = $request->date;

                // Save payment info
                $paymentInfo->save();

                // Save order status and remaining amount
                $order->remaining_amount = $remainingAmount;
                $order->save();

                return redirect()->back()->with('message', 'Amount added successfully');
            } else {
                return redirect()->back()->with('error', 'Order not found');
            }
        }

        return redirect()->back()->with('error', 'Unauthorized access');
    }



    public function show(){
    $user = Auth::user();
    if($user) {
        $payments = PaymentInfo::get();
        return view('admin.order_payment_list',compact('payments','user'));
    }
    }
    public function edit($order_id){
        $user = Auth::user();
        if($user){
            $payment = PaymentInfo::with('order.user')->find($order_id);
            return view('admin.edit_payment',compact('user','payment'));
        }
    }
    public function update(Request $request, $order_id)
    {
        $user = Auth::user();
        if($user) {
            $order = Order::find($order_id);

            if ($order) {
                // Check if payment_id is provided in the request
                if (!$request->has('payment_id') || !$request->payment_id) {
                    return redirect()->back()->with('error', 'Payment ID is missing');
                }

                $paymentInfo = PaymentInfo::where('order_id', $order_id)
                                          ->where('id', $request->payment_id)
                                          ->first();

                if ($paymentInfo) {
                    // Update the existing payment info entry
                    $paymentInfo->amount = $request->amount;
                    $paymentInfo->method = $request->method;
                    $paymentInfo->date = $request->date;
                    $paymentInfo->save();

                    // Recalculate the total amount paid so far
                    $totalPaidSoFar = PaymentInfo::where('order_id', $order_id)->sum('amount');
                    if ($totalPaidSoFar >= $order->total_amount) {
                        $order->status = "completed";
                        $remainingAmount = 0;
                    } else {
                        $order->status = "incomplete";
                        $remainingAmount = $order->total_amount - $totalPaidSoFar;
                    }

                    // Update the order with the new remaining amount and status
                    $order->remaining_amount = $remainingAmount;
                    $order->save();

                    return redirect()->back()->with('message', 'Amount updated successfully');
                } else {
                    return redirect()->back()->with('error', 'Payment information not found');
                }
            } else {
                return redirect()->back()->with('error', 'Order not found');
            }
        } else {
            return redirect()->back()->with('error', 'Unauthorized action');
        }
    }




}
