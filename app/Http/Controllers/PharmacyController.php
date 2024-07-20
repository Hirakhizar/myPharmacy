<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PharmacyController extends Controller
{
    public function redirect(){
        $user=Auth::user();
        if($user->usertype=='admin'){
            return view('admin.dashboard',compact('user'));

        }
    }
}
