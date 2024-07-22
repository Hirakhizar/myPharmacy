<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\If_;

class MemberController extends Controller
{
    public function showMember(){
        $user=Auth::user();

        if($user->usertype=='admin'){
            $users=Member::get();
            $totalmember=member::count();
            return view('admin.member',compact('user','users','totalmember'));
        }

    }

    public function addMember(){
        $user=Auth::user();
        if ($user->usertype=='admin') {
            return view('admin.addMember',compact('user'));
        }

    }
}
