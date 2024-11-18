<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

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
            'receptionist_name' => 'required|string|max:255',
            'doctor_name' => 'required|string|max:255',
        ]);

        // Get the authenticated patient
        $patient = Auth::guard('patient')->user();

        if (!$patient) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Fetch the doctor's ID based on the entered name
        $doctor = Doctor::where('Name', $validatedData['doctor_name'])->first();
        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor not found.');
        }

        // Fetch the receptionist's ID based on the entered name
        $receptionist = Receptionist::where('Name', $validatedData['receptionist_name'])->first();
        if (!$receptionist) {
            return redirect()->back()->with('error', 'Receptionist not found.');
        }

        // Create the appointment entry
        Appointment::create([
            'PatientID' => $patient->id,
            'ReceptionistID' => $receptionist->id,
            'DoctorID' => $doctor->id,
            'Date' => $validatedData['Date'],
            'Time' => $validatedData['Time'],
            'Status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Appointment request submitted successfully.');
    }
    
//Show Appointment Request
    public function showRequestAppointmentForm()
{
    return view('patient.requestAppointment');
}  
}

