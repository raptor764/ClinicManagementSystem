<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUser; // Import the RegisterUser request
use App\Models\Doctor;
use App\Models\Assistant;
use App\Models\Receptionist;
use App\Models\Patient;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(RegisterUser $request): RedirectResponse
    {
        // Validate the request using RegisterUser rules
        $validatedData = $request->validated();

        // Determine which model to use based on the role
        $userModel = $this->getModelClass($validatedData['role']);
        
       // Create the user
       $user = $userModel::create([
        'Name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['password']),
        ]);

        // Additional fields based on role
        switch ($validatedData['role']) {
            case 'doctor':
                $user->specialization = $validatedData['specialization'];
                $user->phone = $validatedData['phone'];
                $user->section_name = $validatedData['section_name'];
                break;

            case 'patient':
                $user->date_of_birth = $validatedData['date_of_birth'];
                $user->address = $validatedData['address'];
                $user->phone = $validatedData['phone'];
                break;

            case 'assistant':
                $user->phone = $validatedData['phone'];
                $user->section_name = $validatedData['section_name'];
                $user->doctor_name = $validatedData['doctor_name']; // Ensure this is a valid field in your Assistant model
                break;

            case 'receptionist':
                $user->phone = $validatedData['phone'];
                break;
        }

        // Save additional fields to the database
        $user->save();

        event(new Registered($user));

        Auth::login($user);

        if ($validatedData['role']=='doctor'){
            return redirect()->intended('/doctordashboard');
        }
        else if($validatedData['role'] =='patient'){
            return redirect()->intended('/patientdashboard');
        }
        else if($validatedData['role'] =='receptionist'){
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
