<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MedicineController extends Controller
{
    public function addformmedicine()
    {
        $user = Auth::user();
        if ($user->usertype == 'admin') {
            return view('admin.medicine', compact('user'));
        }

        // Return some response if user is not admin
        return redirect()->route('home'); // Adjust route as necessary
    }

}
