<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\Doctor;
use App\Models\Receptionist;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'receptionist_id' => 'required|integer|exists:receptionists,ReceptionistID',
            'doctor_id' => 'required|integer|exists:doctors,DoctorID',
        ]);

        if ($validator->fails()) {
            return redirect()->route('patient.requestAppointmentForm')
                ->withErrors($validator)
                ->withInput();
        }


        // Get the authenticated patient
        $patient = Auth::guard('patient')->user();
        if (!$patient) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        // Create the appointment entry
        Appointment::create([
            'PatientID' => $patient->PatientID,
            'ReceptionistID' => $request->receptionist_id,
            'DoctorID' => $request->doctor_id,
            'Date' => $request->appointment_date,
            'Time' => $request->appointment_time,
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

