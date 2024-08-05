<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Ledger;
use App\Models\SalesOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BalanceSheetController extends Controller
{
    
    public function balanceSheet()
    {
        $user = Auth::user();
        
        if ($user && $user->usertype == 'admin') {
            // Fetch all sales and expenses
            $sales = SalesOrder::with('salesInfo')->orderBy('date')->get();
            $expenses = Expense::with('subcategory')->orderBy('date')->get();
    
            // Initialize a collection for the ledger
            $ledger = collect();
            $balance = 0;
    
            // Process sales (as credits)
            foreach ($sales as $sale) {
                $balance += $sale->amount;
                $ledger->push([
                    'date' => $sale->date,
                    'description' => $sale->description,
                    'debit' => null,
                    'credit' => $sale->total,
                    'balance' => $balance
                ]);
            }
    
            // Process expenses (as debits)
            foreach ($expenses as $expense) {
                $balance -= $expense->amount;
                $ledger->push([
                    'date' => $expense->date,
                    'description' => $expense->subcategory->name,
                    'debit' => $expense->amount,
                    'credit' => null,
                    'balance' => $balance
                ]);
            }
    
            // Sort the ledger by date (since sales and expenses were processed separately)
            $ledger = $ledger->sortBy('date');
          
            return view('admin.balanceSheet', compact('user', 'ledger'));
        }
    
        return redirect()->route('login')->with('error', 'You must be logged in as an admin to access this page.');
    }
    
}