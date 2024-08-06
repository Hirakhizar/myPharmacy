<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function salesReport(){
        $user=Auth::user();
        return view('admin.SalesReport',compact('user'));
    }
}
