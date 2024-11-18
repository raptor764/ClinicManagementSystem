<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class AssistantController extends Controller
{
        //Assistant Delete Account Function
        public function assistantDeleteAccount(): RedirectResponse
        {  
            $assistant = Auth::guard('assistant')->user();
    
            if ($assistant) {
    
                $assistant->delete();
                Auth::guard('assistant')->logout();
    
                return redirect()->route('login')->with('success', 'Your account has been deleted successfully.');
            }
            return redirect()->route('login')->with('error', 'Unable to delete the account. Please try again.');
        }
}
