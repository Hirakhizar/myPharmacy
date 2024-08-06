<?php

namespace App\Http\Controllers;

use App\Models\Order;

use App\Models\Medicine;
use App\Models\OrderItem;
use App\Models\PaymentInfo;
use App\Models\Manufacturer;
use Illuminate\Http\Request;
use App\Models\ManufacturerPayment;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class LedgerController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user->usertype == 'admin') {
            $perPage = $request->input('per_page', 10); // Default to 10 if not specified
            $page = $request->input('page', 1); // Default to the first page

            // Fetch all orders (debit transactions)
            $orders = Order::with('items.medicine.manufacturer')->get();

            // Fetch all credits
            $credits = PaymentInfo::with('order.items.medicine.manufacturer')->get();

            // Combine and sort debits and credits by order ID
            $transactions = collect();

            foreach ($orders as $order) {
                if ($order->items->isNotEmpty()) {
                    $firstItem = $order->items->first();
                    $manufacturer = $firstItem->medicine->manufacturer->company_name ?? 'Unknown'; // Fetch manufacturer name from the first item
                    $transactions->push([
                        'type' => 'debit',
                        'manufacturer' => $manufacturer,
                        'manufacturer_id' => $firstItem->medicine->manufacturer_id,
                        'date' => $order->created_at,
                        'amount' => $order->total_amount,
                        'order_id' => $order->id
                    ]);
                }
            }

            foreach ($credits as $credit) {
                if ($credit->order && $credit->order->items->isNotEmpty()) {
                    $firstItem = $credit->order->items->first();
                    $manufacturer = $firstItem->medicine->manufacturer->company_name ?? 'Unknown'; // Fetch manufacturer name from the first item
                    $transactions->push([
                        'type' => 'credit',
                        'manufacturer' => $manufacturer,
                        'manufacturer_id' => $firstItem->medicine->manufacturer_id,
                        'date' => $credit->created_at,
                        'amount' => $credit->amount,
                        'order_id' => $credit->order_id
                    ]);
                }
            }

            $transactions = $transactions->sortBy('order_id');

            // Manual pagination
            $total = $transactions->count();
            $transactions = $transactions->slice(($page - 1) * $perPage, $perPage)->values();
            $transactions = new LengthAwarePaginator($transactions, $total, $perPage, $page, [
                'path' => Paginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]);

            return view('admin.ledger', compact('transactions', 'user', 'perPage'));
        }
    }







}
