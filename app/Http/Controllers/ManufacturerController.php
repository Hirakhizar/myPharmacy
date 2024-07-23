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
            $total = Manufacturer::count();
           return view('admin.manufacture_list', compact('manufacturers','user','total'));
        }
        return redirect()->route('home');

    }
    public function edit($id){
        $user = Auth::user();
        if ($user->usertype == 'admin') {
            $manufacturer = Manufacturer::find($id);
           return view('admin.editmanufacture', compact('manufacturer','user'));
        }
    }
    public function update(Request $request, $id){

        $user = Auth::user();
        if ($user->usertype == 'admin') {
            $manufacturer= Manufacturer::find($id);
            $manufacturer->company_name = $request->company_name;
            $manufacturer->email = $request->email;
            $manufacturer->phone = $request->phone;
            $manufacturer->city = $request->city;
            $manufacturer->state = $request->state;
            $manufacturer->balance = $request->balance;
            $manufacturer->country = $request->country;
            $manufacturer->save();
            return response()->json(['success' => true, 'message' => 'Customer Updated successfully']);
        }

    }
    public function delete($id){
        $user = Auth::user();
        if ($user->usertype == 'admin') {
            $manufacturer= Manufacturer::find($id);
            $manufacturer->delete();
            return redirect('/manufacturers/list');
        }

    }
}
