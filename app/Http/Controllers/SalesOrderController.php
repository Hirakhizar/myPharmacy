<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Medicine;
use App\Models\Sales_Order;
use App\Models\Sales_OrderItem;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use App\Models\SalesPayment_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesOrderController extends Controller
{
    public function showMedicine(){
        $user=Auth::user();
        if($user){
            $medicines=Medicine::get();
            return view('admin.placeOrder', compact('user','medicines'));
        }
    }

    public function addToCart(Request $request,$id){
        $user=Auth::user();
        if($user){
            $medicines=Medicine::get();
            $medicenPrice=Medicine::find($id);
            $cart=new Cart();
            $cart->item_id=$id;
            $cart->qty=$request->quantity;
            $cart->total=$request->quantity*$medicenPrice->price;
            $cart->save();
            return redirect()->back()->with(compact('user','medicines'));
        }
    }

    public function viewCart(){
        $user=Auth::user();
         if($user){
            $carts=Cart::with('medicine')->get();
            return view('admin.cartView', compact('user','carts'));
        }
    }
    public function deleteCart($id){
        $user=Auth::user();
        if($user){
            $cart=Cart::find($id);
            $cart->delete();
            return redirect()->back();

        }
    }
    public function ConfirmOrder(Request $request)
    {
        $user = Auth::user();
        if($user) {
            $order = new SalesOrder();


            $cartItems = Cart::get(); // Retrieve cart items
            $order->customer = $request->input('customer');
            $order->phone = $request->input('phone');
            $order->date=
           
           
    
            $total = 0;
            foreach ($cartItems as $item) {
                $total += $item->total; // Accumulate total
            }
            $order->total = $total;
            $order->remaining = $order->total;
            // $order->paid = 0;
            if($order->total<$request->amount){
              
                return redirect()->back()->with('error', 'You are trying to exceed the total amount.');;
            }
            $order->paid = $order->paid + $request->amount;
            $order->remaining = $order->remaining - $request->amount;
            $order->date=$request->date;
            $order->description=$request->method;
         
                   if($order->remaining==0){
                    $order->payment_status = 'completed';
                   } else{
                    $order->payment_status = 'incomplete';
                   }
            $order->save();

            // Get the created order ID
            $orderId = $order->id;

            foreach ($cartItems as $item) {
                $orderItem = new SalesOrderItem();
                $medicine = Medicine::where('id', $item->item_id)->first();
                if ($medicine) {
                    $medicine->stock -= $item->qty;
                    $medicine->save();
                }
                $orderItem->order_id = $orderId;
                $orderItem->item_id = $item->item_id;

                $orderItem->qty=$item->qty;
                $orderItem->total=$item->total;
             
                $orderItem->save();
                $item->delete(); // Assuming $item has a delete method
            }
            $info=new SalesPayment_info();
            $info->order_id = $orderId;
            $info->amount = $request->amount;
            $info->payment_method = $request->method;
            $info->date = $request->date;
            
            if ($order->remaining==0) {
                $info->payment_status = "completed";
               
            } else {
                $info->payment_status = "incomplete";
            }
            $info->save();
    $orderitems=SalesOrderItem::where('order_id',$orderId)->get();
            return view('admin.orderRecipte',compact('user','order','orderitems'))->with('message', 'Payment added successfully!');
        } else {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
    }

    public function showOrders(Request $request){
        $user = Auth::user();
        if($user){
          
            $customer = $request->input('customer');
            $orderDate = $request->input('order_date');

            $ordersQuery = SalesOrder::query();
            $orderItemsQuery = SalesOrderItem::query();

            // Apply filters if provided
            if($customer){
                $ordersQuery->where('customer', 'like', '%'.$customer.'%');
                $orderItemsQuery->whereHas('order', function($query) use ($customer) {
                    $query->where('customer', 'like', '%'.$customer.'%');
                });
            }

            if($orderDate){
                $ordersQuery->whereDate('created_at', $orderDate);
                $orderItemsQuery->whereHas('order', function($query) use ($orderDate) {
                    $query->whereDate('created_at', $orderDate);
                });
            }


            $orders = $ordersQuery->paginate(5);
            $orderitems = $orderItemsQuery->get();
           

            $orderitems=SalesOrderItem::with('medicineItems')->get();
 

            $info=SalesPayment_info::get();
           
            return view('admin.allOrders', compact('user', 'orders','orderitems','info'));
        }

        return redirect()->back();
    }

    public function itemsDetails($id){
        $user=Auth::user();
        if($user){
           $order=SalesOrder::find($id);
           $info=SalesPayment_info::where('order_id',$id)->paginate(3);
            $orderitems=SalesOrderItem::where('order_id',$id)->with('medicineItems')->get();

            return view('admin.itemsDetails',compact('user','order','orderitems','info'));
        }

}


public function showpayment($id){

        $user=Auth::user();
        if($user){
           $order=SalesOrder::find($id);
            return view('admin.paymentForm',compact('user','order'));
        }
}



public function addpayment(Request $request, $id) {
    $user=Auth::user();
    $order = SalesOrder::find($id);
    if ( $request->amount> $order->remaining) {
       
        return redirect()->back()->with('error', 'You are trying to exceed the total amount.');
    } 
    $order->paid = $order->paid + $request->amount;
    $order->remaining = $order->total - $order->paid;

    if ($order->remaining==0 ) {
        $order->payment_status = 'completed';
    } else {
        $order->payment_status = 'incomplete';
    }
    $order->save();

    $info = new SalesPayment_info();
    $info->order_id = $id;
    $info->amount = $request->amount;
    $info->payment_method = $request->method;
    $info->date = $request->date;

    if ($order->remaining==0) {
        $info->payment_status = "completed";
    } else {
        $info->payment_status = "incomplete";
    }
    $info->save();
    $payment=SalesPayment_info::where('invoice',  $info->invoice )->first();
    return view('admin.salesPaymentRecipte',compact('user','order','payment'));
}

public function editPayment($id){
    $user=Auth::user();
    if($user){
    
       $info=SalesPayment_info::where('id',$id)->first();

        return view('admin.paymentEdit',compact('user','info'));
    }

}
public function updatePayment(Request $request,$id)
{    $payment =SalesPayment_info::find($id);
    $order = SalesOrder::where('id',$payment->order_id)->first();
    if($request->amount==$payment->amount){
        $payment->date=$request->date;
        $payment->payment_method=$request->method;
        $payment->save();
        return redirect()->back()->with('message', 'Payment Updated successfully!');

    }else{
        if ( $request->amount> $order->total) {
          
            return redirect()->back()->with('error', 'You are trying to exceed the total amount.');;
        } 
      $order->paid=($order->paid-$payment->amount)+$request->amount;
      $order->remaining=$order->total-$order->paid;
      $payment->amount=$request->amount;
      $payment->date=$request->date;
      $payment->payment_method=$request->method;
      $order->save();
      $payment->save();
      return redirect()->back()->with('message', 'Payment Updated successfully!');

    }


}
public function recipte($id){

$user=Auth::user();
if($user){
   $order=SalesOrder::find($id);
   $info=SalesPayment_info::where('order_id',$id)->get();
    $orderitems=SalesOrderItem::where('order_id',$id)->with('medicineItems')->get();

    return view('admin.orderRecipte',compact('user','order','orderitems','info'));
}
}

///////Refund
public function showRefund(){
    $user=Auth::user();
    if($user){
        $orders=SalesOrder::paginate(4);
         return view('admin.refundView',compact('user','orders'));
     }
}


public function refundForm($id){
    $user=Auth::user();
    if($user){
        $order=SalesOrder::find($id);

        $orderItems=SalesOrderItem::where('order_id',$id)->with('medicineItems')->get();
         return view('admin.refundRequest',compact('user','order','orderItems'));
     }
}

public function refundItem($id)
{
    $user = Auth::user();
    if($user) {
        $item = SalesOrderItem::find($id);

        if (!$item) {
          
            return redirect()->back() ->with('error', 'Item not found.');;
        }

        $order = SalesOrder::where('id', $item->order_id)->first();

        if (!$order) {
       
            return redirect()->back()->with('error', 'Order not found.');;
        }

        if ($item->total > $order->paid) {
          
            return redirect()->back() ->with('error', 'You are trying to exceed the total amount.');;
        }

        $order->total -= $item->total;
        $order->paid -= $item->total;
        $order->remaining = $order->total - $order->paid;
        $order->save(); // Save the order model instance

        $medicine = Medicine::where('id', $item->item_id)->first();
        if ($medicine) {
            $medicine->stock += $item->qty;
            $medicine->save();
        }

        $item->refund_status = 'Approved';
        $item->save();

        $orderItems = SalesOrderItem::where('order_id', $order->id)->get();
        $allRefunded = true;

        foreach ($orderItems as $orderItem) {
            if ($orderItem->refund_status == 'noRequest') {
                $allRefunded = false;
                break;
            }
        }

        $order->refund_status = $allRefunded ? 'Approved' : 'Partial';
        $order->save();

        return redirect()->back()->with('success', 'Refunded.');;
    }

   
    return redirect()->back() ->with('error', 'Unauthorized action.');
}


}
