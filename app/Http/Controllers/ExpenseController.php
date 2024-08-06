<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\ExpenseSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function showcategory(){
        $user=Auth::user();
        $categories=ExpenseCategory::get();
        $subcategories=ExpenseSubCategory::with('category')->get();
        if($user){
            return view('admin.expnsesCategory',compact('user','categories','subcategories'));
        }
    }
    public function addcategory(Request $request){
        $user=Auth::user();
        if($user){
            $category=new ExpenseCategory();
            $category->name=$request->name;
            $category->save();
            return redirect()->back();
        }

    }
    
    public function addsubcategory(Request $request){
        $user=Auth::user();
        if($user){
            $category=new ExpenseSubCategory();
            $category->name=$request->name;
            $category->category_id=$request->category_id;
            $category->save();
            return redirect()->back();
        } 
    }
    public function removesubcategory($id){
        $user=Auth::user();
        if($user){
           $id=ExpenseSubCategory::find($id);
           $id->save();
           return redirect()->back();
        }
    }  
   
    public function showExpenses(Request $request)
    {
        $user = Auth::user();
        if($user) {
            $query = Expense::with('category', 'subcategory');
    
            if ($request->has('category_id') && !empty($request->category_id)) {
                $query->where('category_id', $request->category_id);
            }
    
            if ($request->has('subcategory_id') && !empty($request->subcategory_id)) {
                $query->where('subcategory_id', $request->subcategory_id);
            }
    
            if ($request->has('order_date') && !empty($request->order_date)) {
                $query->whereDate('date', $request->order_date);
            }
    
            $expenses = $query->get();
            $categories = ExpenseCategory::all();
            $subcategories = ExpenseSubCategory::all();
    
            return view('admin.expenses', compact('user', 'expenses', 'categories', 'subcategories'));
        }
    }
    

   public function showExpencesForm(){
        $user=Auth::user();
        if($user){
            $categories=ExpenseCategory::get();
            $subcategories=ExpenseSubCategory::get();
            return view('admin.addExpenses',compact('user','subcategories','categories'));
        }
    }
    public function addExpences(Request $request){
        $user=Auth::user();
        if($user){
            $expense=new Expense();
            $expense->amount=$request->amount;
            $expense->category_id=$request->category;
            $expense->subcategory_id=$request->subCategory;
            $expense->date=$request->date;
            $expense->description=$request->head;
            $expense->save();
            
            return redirect()->back()->with('message','Expense added successfully!');;
        }
    }
    public function deleteExpences($id){
        
        $id=Expense::find($id);
        $id->delete();
      
            return redirect()->back()->with('message', 'Expense deleted successfully!');
        }
        public function editExpences($id){
            $user=Auth::user();
            if($user){
                $expense=Expense::with('category','subcategory')->find($id);
                
                $categories=ExpenseCategory::get();
                $subcategories=ExpenseSubCategory::get();
                return view('admin.editExpenses',compact('user','subcategories','categories','expense'));
            }

        }
        public function updateExpences(Request $request, $id){
            $user=Auth::user();
            if($user){
                $expense=Expense::find($id);
                $expense->amount=$request->amount;
                $expense->category_id=$request->category;
                $expense->subcategory_id=$request->subCategory;
                $expense->date=$request->date;
                $expense->description=$request->head;
                $expense->save();
                
                return redirect()->back()->with('message','Expense Updated successfully!');;
            }

        }
    }
   
