<?php

namespace App\Http\Controllers;

use App\Models\PaymentInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LedgerController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();
        if($user->usertype == 'admin'){
            $perPage = $request->input('per_page', 10); // Default to 10 if not specified
            $payments = PaymentInfo::with('order')->paginate($perPage);;
            return view('admin.ledger',compact('payments','user','perPage'));
        }

    }
}
