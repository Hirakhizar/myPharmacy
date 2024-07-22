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
        if ($user->usertype == 'admin') {
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
            $item->stock=$item->stock-$request->qty;
            $customer->purchaced_qty = $request->qty;
        }

        $customer->amount = $request->amount;
        $customer->status = $request->status;
        $customer->description = $request->description;
        $customer->save();

        return response()->json(['success' => true, 'message' => 'Customer added successfully']);
    }

    return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
}

}
