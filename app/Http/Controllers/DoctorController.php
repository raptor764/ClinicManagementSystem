<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class DoctorController extends Controller
{
    
    //Doctor Delete Account Function
    public function doctorDeleteAccount(): RedirectResponse
    {  
        $doctor = Auth::guard('doctor')->user();

        if ($doctor) {

            $doctor->delete();
            Auth::guard('doctor')->logout();

            return redirect()->route('login')->with('success', 'Your account has been deleted successfully.');
        }
        return redirect()->route('login')->with('error', 'Unable to delete the account. Please try again.');
    }
}

