<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class ReceptionistController extends Controller
{

    //Receptionist Delete Account Function
    public function receptionistDeleteAccount(): RedirectResponse
    {  
        $receptionist = Auth::guard('receptionist')->user();

        if ($receptionist) {

            $receptionist->delete();
            Auth::guard('receptionist')->logout();

            return redirect()->route('login')->with('success', 'Your account has been deleted successfully.');
        }
        return redirect()->route('login')->with('error', 'Unable to delete the account. Please try again.');
    }
}
