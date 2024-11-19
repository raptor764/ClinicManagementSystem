<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUser; // Import the RegisterUser request
use App\Models\Doctor;
use App\Models\Assistant;
use App\Models\Receptionist;
use App\Models\Patient;
use App\Models\Section;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $sections = Section::distinct()->get(['SectionID', 'Name']);
        $doctors = Doctor::distinct()->get(['DoctorID', 'Name']);
        return view('auth.register', compact('sections', 'doctors'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUser $request)
    {
        //Validate Request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|confirmed|min:8',
            'role' => 'required|string',

            'phone' => 'string|min:10',
            'specialization' => 'string',
            'section_name' => 'exists:sections,SectionID',
        ]);

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }
        return redirect()->route('login');

        // Determine which model to use based on the role
        $userModel = $this->getModelClass($request->role);

//        if ($request->role == 'doctor' && (!$request->has('specialization') || !$request->has('section_id') || !$request->has('phone'))){
        if ($request->role == 'doctor' && (!$request->has('specialization') || !$request->has('phone'))){
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }

       // Create the user
       $user = $userModel::create([
        'Name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        ]);

        // Additional fields based on role
        switch ($request->role) {
            case 'doctor':
                $user->specialization = $request->specialization;
                $user->phone = $request->phone;
                $user->section_name = $request->section_name;
                break;

            case 'patient':
                $user->date_of_birth = $request->date_of_birth;
                $user->address = $request->address;
                $user->phone = $request->phone;
                break;

            case 'assistant':
                $user->phone = $request->phone;
                $user->section_name = $request->section_name;
                $user->doctor_name = $request->doctor_name; // Ensure this is a valid field in your Assistant model
                break;

            case 'receptionist':
                $user->phone = $request->phone;
                break;
        }

        // Save additional fields to the database
        $user->save();

        event(new Registered($user));

        Auth::login($user);

        if ($request->role =='doctor'){
            return redirect()->intended('/doctordashboard');
        }
        else if($request->role =='patient'){
            return redirect()->intended('/patientdashboard');
        }
        else if($request->role =='receptionist'){
            return redirect()->intended('/receptionistdashboard');
        }
        else{
            return redirect()->intended('/assistantdashboard');
        }

    }

    /**
     * Get the model class based on the role.
     *
     * @param string $role
     * @return string
     */
    private function getModelClass(string $role): string
    {
        switch ($role) {
            case 'doctor':
                return Doctor::class;
            case 'assistant':
                return Assistant::class;
            case 'receptionist':
                return Receptionist::class;
            case 'patient':
                return Patient::class;
            default:
                throw new \InvalidArgumentException("Invalid role: $role");
        }
    }
}
