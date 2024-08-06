<?php

namespace App\Http\Controllers;

use session;
use App\Models\Order;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Medicine;
use App\Models\Purchase;
use App\Models\OrderItem;
use App\Models\Manufacturer;
use App\Models\PaymentInfo;
use App\Models\PurchaseCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function indexpurchase()
    {
        $user = Auth::user();
        if ($user->usertype == 'admin') {

            $medicines = Medicine::all();

            return view('admin.purchase', compact('user', 'medicines'));
        }
    }
    public function addtocart(Request $request, $medicineId)
{
    if (Auth::check()) {
        $user = Auth::user();
        $quantity = $request->input('quantity');

        // Check if the item already exists in the cart for the user
        $existingCartItem = PurchaseCart::where('user_id', $user->id)
                                        ->where('medicine_id', $medicineId)
                                        ->first();

        if ($existingCartItem) {
            // If the item exists, update the quantity
            $existingCartItem->quantity += $quantity;
            $existingCartItem->save();
        } else {
            // If the item doesn't exist, create a new cart entry
            $cartItem = new PurchaseCart();
            $cartItem->user_id = $user->id;
            $cartItem->medicine_id = $medicineId;
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }

        return redirect()->back()->with('success', 'Medicine added to cart successfully.');
    } else {
        return redirect('login');
    }
}

public function view(){
    $user = Auth::user();

    if ($user->usertype == 'admin') {
        $purchases = PurchaseCart::where('user_id', $user->id)->get();
        $medicineIds = $purchases->pluck('medicine_id');
        $medicines = Medicine::whereIn('id', $medicineIds)->get();
        return view('admin.purchaselist', compact('purchases', 'user', 'medicines'));
    }
}
public function del($id){
    $user = Auth::user();
    if($user->usertype == 'admin'){
        $pur = PurchaseCart::find($id);
        $pur->delete();
        return redirect()->back();
    }

}
public function confirm()
{
    $user = Auth::user();
    if ($user->usertype == 'admin') {
        $userid = $user->id;
        $data = PurchaseCart::where('user_id', '=', $userid)->get();

        $orderItems = [];
        $totalAmount = 0;

        // Create and save the order
        $order = new Order();
        $order->user_id = $userid;
        $order->total_amount = 0; // We'll update this later
        $order->status = "processed";
        $order->manufacturer = ''; // Initialize or set a default value if needed
        $order->save();

        foreach ($data as $item) {
            // Create and save each order item
            $orderItem = new OrderItem();
            $orderItem->order_id = $order->id;
            $orderItem->medicine_id = $item->medicine_id;
            $orderItem->user_id = $item->user_id;
            $orderItem->quantity = $item->quantity;
            $orderItem->status = "processed";
            $orderItem->save();

            // Update stock and status in the medicine table
            $medicine = $item->medicine;
            $medicine->stock -= $item->quantity;

            if ($medicine->stock <= 0 ) {
                $medicine->status = 'out of stock';
            } elseif ($medicine->stock < 10) {
                $medicine->status = 'low';
            } else {
                $medicine->status = 'avaliable'; // Corrected spelling to match ENUM definition
            }
            $medicine->save();

            // Add item details to the orderItems array
            $orderItems[] = [
                'name' => $medicine->name,
                'quantity' => $item->quantity,
                'price' => $medicine->price,
                'total_price' => $item->quantity * $medicine->price,
            ];

            // Update total amount
            $totalAmount += $item->quantity * $medicine->price;

            // Optionally, set the manufacturer if required (for example, set from a specific item or average value)
            $order->manufacturer = $medicine->manufacturer->company_name; // Ensure this logic is valid for your application

            // Delete item from cart
            $item->delete();
        }

        // Update the total amount and save the order
        $order->total_amount = $totalAmount;
        $order->save();

        // Prepare order details for the receipt view
        $orderDetails = [
            'id' => $order->id,
            'purchaser_name' => $user->name,
            'purchaser_email' => $user->email,
            'purchaser_address' => $user->address,
            'purchaser_phone' => $user->phone,
            'total_amount' => $totalAmount,
            'items' => $orderItems,
        ];

        return view('admin.receipt', compact('orderDetails', 'user'));
    }
}



public function list(){
    $user = Auth::user();
    if ($user->usertype == 'admin') {
        $orders = Order::where('user_id', $user->id)->with('medicine', 'medicine.manufacturer', 'medicine.category')->get();
        return view('admin.order',compact('user','orders'));
    }

}
public function detail($id)
{
    $user = Auth::user();
    if ($user->usertype == 'admin') {
    $order = Order::with('items.medicine.category', 'items.medicine.manufacturer')->find($id);
    $payments = PaymentInfo::where('order_id',$id)->get();

    return view('admin.detail', compact('order','user','payments'));
}
}

}









