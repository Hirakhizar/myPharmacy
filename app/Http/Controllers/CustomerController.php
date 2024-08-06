<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function addformCustomer()
    {
        $user = Auth::user();
        if ($user) {
            return view('admin.customerAdd', compact('user'));
        }

        // Return some response if user is not admin
        return redirect()->route('home'); // Adjust route as necessary
    }


    public function addCustomer(Request $request)
{
    $user = Auth::user();

    if ($user->usertype == 'admin') {
        $item = Medicine::where('name', $request->purchased_item)->first();

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Medicine not found']);
        }

        $customer = new Customer();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->item_id = $item->id;
        if($request->qty){
            $quantity=24-$request->qty;
            if($quantity==0){
                $item->stock=$item->stock-1;
                $item->save();
            }elseif($quantity<24){
                $item->stock=$item->stock-$quantity;
            }
            $customer->purchaced_qty = $request->qty;
        }

        $customer->amount = $request->amount;
        $customer->status = $request->status;
        $customer->description = $request->description;
        $customer->save();

        return response()->json(['success' => true, 'message' => 'Customer added successfully']);
    }

    return redirect('login')->json(['success' => false, 'message' => 'Unauthorized'], 401);
}

public function showCustomer(){
    $user = Auth::user();
    if ($user->usertype == 'admin') {
        $customers = Customer::with('medicine')->get();
        $totalCustomers=Customer::count();

        return view('admin.customerShow', compact('customers', 'user','totalCustomers'));
        }else{
            return redirect('login')->json(['success' => false, 'message' => 'Unauthorized'],401);
        }


}
public function editCustomer($id){
    $user = Auth::user();
    if ($user->usertype == 'admin') {
        $customer = Customer::with('medicine')->find($id);
        return view('admin.editCustomer',compact('customer','user'));
    }
    

}
public function updateCustomer(Request $request, $id){
    $user = Auth::user();
    if ($user->usertype == 'admin') {
        $item = Medicine::where('name', $request->purchased_item)->first();

        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Medicine not found']);
        }

        $customer = Customer::find($id);
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->item_id = $item->id;
        if($request->qty){
            $quantity=24-$request->qty;
            if($quantity==0){
                $item->stock=$item->stock-1;
                $item->save();
            }elseif($quantity<24){
                $item->stock=$item->stock-$quantity;
            }
            $customer->purchaced_qty = $request->qty;
        }

        $customer->amount = $request->amount;
        $customer->status = $request->status;
        $customer->description = $request->description;
        $customer->save();
        return response()->json(['success' => true, 'message' => 'Customer Updated successfully']);
    }

    return redirect('login')->json(['success' => false, 'message' => 'Unauthorized'], 401);

}

public function deleteCustomer($id){
  
    $user = Auth::user();
    if ($user->usertype == 'admin') {
          $customer = Customer::find($id);
        $customer->delete();
        return redirect()->back()->with(compact('user'));
        }else{
            return redirect('login')->json(['success' => false, 'message' => 'Unauthorized'],
            401);
            }
}
}
