<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Doctor;
use App\Models\Receptionist;

class PatientController extends Controller
{
    //Patient Delete Account Function
    public function patientDeleteAccount(): RedirectResponse
        {  
            $patient = Auth::guard('patient')->user();
        
            if ($patient) {
        
                $patient->delete();
                Auth::guard('patient')->logout();
        
                return redirect()->route('login')->with('success', 'Your account has been deleted successfully.');
                }
                return redirect()->route('login')->with('error', 'Unable to delete the account. Please try again.');
        }


    //Request Appointment Function
    public function requestAppointment(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'Date' => 'required|date|after_or_equal:today',
            'Time' => 'required|date_format:H:i',
            'receptionist_id' => 'required|integer|exists:receptionists,ReceptionistID',
            'doctor_id' => 'required|integer|exists:doctors,DoctorID',
        ]);

        // Get the authenticated patient
        $patient = Auth::guard('patient')->user();

        if (!$patient) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }


        // Create the appointment entry
        Appointment::create([
            'PatientID' => $patient->id,
            'ReceptionistID' => $request()->receptionist_id,
            'DoctorID' => $request()->doctor_id,
            'Date' => $validatedData['Date'],
            'Time' => $validatedData['Time'],
            'Status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Appointment request submitted successfully.');
    }
    
//Show Appointment Request
    public function showRequestAppointmentForm()
{

    $doctors = Doctor::all(); 
    $receptionists = Receptionist::all();

  //  return view('request-appointment', compact('doctors', 'receptionists'));
    return view('patient.requestAppointment', compact('doctors', 'receptionists'));
}  
}

