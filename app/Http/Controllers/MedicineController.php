<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Medicine;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicineController extends Controller
{
    public function addformmedicine()
    {
        $user = Auth::user();
        if ($user) {
            $categorys = Category::get();
            $manufactures = Manufacturer::get();
            return view('admin.medicine', compact('user','categorys','manufactures'));
        }

        // Return some response if user is not admin
        return redirect()->route('home'); // Adjust route as necessary
    }

    public function create(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'generic_name' => 'required|string|max:255',
        'sku' => 'required|string|max:255',
        'weight' => 'required|numeric',
        'category_id' => 'required|integer',
        'manufacturer_id' => 'required|integer',
        'price' => 'required|numeric',
        'manufacturer_price' => 'required|numeric',
        'stock' => 'required|integer',
        'expire_date' => 'required|date',
        'status' => 'required|string|in:low,avaliable,out of stock',

    ]);

    Medicine::create($validated);
    return response()->json(['success' => true, 'message' => 'Medicine added successfully!'
    ]);
}

    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $medicines = Medicine::all();
            $total =Medicine::count();
           return view('admin.medicine_list', compact('medicines','user','total'));
        }
        return redirect()->route('home');

    }
    public function edit($id){
        $user = Auth::user();
        if ($user) {
            $medicine = Medicine::find($id);
            $categorys = Category::get();
            $manufactures = Manufacturer::get();
           return view('admin.editmedicine', compact('medicine','user','categorys','manufactures'));
        }
    }
    public function update(Request $request, $id)
{
    $user = Auth::user();
    if ($user){
        $medicine = Medicine::find($id);
        if (!$medicine) {
            return response()->json(['success' => false, 'message' => 'Medicine not found'], 404);
        }
        $medicine->name = $request->name;
        $medicine->generic_name = $request->generic_name;
        $medicine->sku = $request->sku;
        $medicine->weight = $request->weight;
        $medicine->category_id = $request->category_id;
        $medicine->manufacturer_id = $request->manufacturer_id;
        $medicine->price = $request->price;
        $medicine->manufacturer_price = $request->manufacturer_price;
        $medicine->stock = $request->stock;
        $medicine->status = $request->status;
        $medicine->expire_date = $request->expire_date;
        $medicine->save();

        return response()->json(['success' => true, 'message' => 'Medicine updated successfully']);
    }

    return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
}
    public function delete($id){
        $user = Auth::user();
        if ($user){
            $medicine= Medicine::find($id);
            $medicine->delete();
            return redirect('/medicine/list');
        }

    }

    public function deleteMultiple(Request $request)
{
    $ids = $request->ids;
    Medicine::whereIn('id', $ids)->delete();
    return redirect()->back()->with('success', 'Selected medicines have been deleted successfully.');
}


}
