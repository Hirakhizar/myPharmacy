<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManufacturerController extends Controller
{
    public function addformmanufacture()
    {
        $user = Auth::user();
        if ($user->usertype == 'admin') {
            return view('admin.manufacture', compact('user'));
        }

        // Return some response if user is not admin
        return redirect()->route('home'); // Adjust route as necessary
    }
    public function create(Request $request){
        $man = new Manufacturer;
        $man->company_name = $request->company_name;
        $man->email = $request->email;
        $man->phone = $request->phone;
        $man->city = $request->city;
        $man->state = $request->state;
        $man->balance = $request->balance;
        $man->country = $request->country;
        $man->save();
        return response()->json(['success' => true, 'message' => 'Manufacturer added successfully.']);
    }
    public function index()
    {
        $user = Auth::user();
        if ($user->usertype == 'admin') {
            $manufacturers = Manufacturer::all();
           return view('admin.manufacture_list', compact('manufacturers','user'));
        }
        return redirect()->route('home');

    }
}
