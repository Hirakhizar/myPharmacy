<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Ledger;
use App\Models\SalesOrder;
use App\Models\SalesPayment_info;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BalanceSheetController extends Controller
{

    public function balanceSheet(Request $request)
    {
        $user = Auth::user();
        
        if ($user->usertype == 'admin' || $user->usertype == 'salesman') {
            // Get the start and end dates from the request
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
    
            // Fetch all sales and expenses with date range filtering
            $salesQuery = SalesPayment_info::query();
            $expensesQuery = Expense::query();
    
            // Apply date filtering if dates are provided
            if ($startDate) {
                $salesQuery->where('date', '>=', $startDate);
                $expensesQuery->where('date', '>=', $startDate);
            }
            if ($endDate) {
                $salesQuery->where('date', '<=', $endDate);
                $expensesQuery->where('date', '<=', $endDate);
            }
    
            $sales = $salesQuery->orderBy('date')->get();
            $expenses = $expensesQuery->with('subcategory')->orderBy('date')->get();
    
            // Initialize a collection for the ledger
            $ledger = collect();
            $balance = 0;
    
            // Process sales (as credits)
            foreach ($sales as $sale) {
                $balance += $sale->amount;
                $ledger->push([
                    'date' => $sale->date,
                    'description' => $sale->payment_method,
                    'debit' => null,
                    'credit' => $sale->amount,
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
    
            return view('admin.balanceSheet', compact('user', 'ledger', 'startDate', 'endDate'));
        }
    
        return redirect()->route('login')->with('error', 'You must be logged in as an admin to access this page.');
    }
    

}
