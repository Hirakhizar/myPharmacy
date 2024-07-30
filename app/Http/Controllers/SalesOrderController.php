<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Medicine;
use App\Models\Sales_Order;
use App\Models\Sales_OrderItem;
use App\Models\SalesOrder;
use App\Models\SalesOrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalesOrderController extends Controller
{
    public function showMedicine(){
        $user=Auth::user();
        if($user->usertype=="admin"){
            $medicines=Medicine::get();
            return view('admin.placeOrder', compact('user','medicines'));
        }
    }

    public function addToCart(Request $request,$id){
        $user=Auth::user();
        if($user->usertype=="admin"){
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
        if($user->usertype=="admin"){
            $carts=Cart::with('medicine')->get();
            return view('admin.cartView', compact('user','carts'));
        }
    }
    public function ConfirmOrder(Request $request)
    {
        $user = Auth::user();
        if ($user->usertype == "admin") {
            $order = new SalesOrder();
            $cart=Cart::get();
            $order->customer = $request->input('customer');
            $order->phone = $request->input('phone');
            $order->order_status = 'confirmed';
            $total=0;
            foreach($cart as $cart){
                $order->total=$cart->total;
               
            }
            $order->save();
    
            // Get the created order ID
            $orderId = $order->id;
    
            $cart = Cart::get();
            foreach ($cart as $item) {
               
               
                    $orderItem = new SalesOrderItem();
                    $orderItem->order_id = $orderId;
                    $orderItem->item_id = $item->item_id;
                    $orderItem->save();
                    $item->delete(); 
                                  
            }
            
            
            return redirect()->back()->with('success', 'Order confirmed successfully.');
        } else {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }
    }
public function showOrders(){
   
        $user=Auth::user();
        if($user->usertype=='admin'){
            $orders=SalesOrder::get();
            $orderitems=SalesOrderItem::get();
            
            return view('admin.allOrders',compact('user','orders','orderitems'));
        }
    
        
    
   
}

public function itemsDetails($id){
    $user=Auth::user();
    if($user->usertype=='admin'){
       
        $orderitems=SalesOrderItem::where('order_id','id')->get();
        
        return view('admin.itemsDetails',compact('user','orderitems'));
    }
}
}
