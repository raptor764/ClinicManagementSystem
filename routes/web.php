<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReceptionistController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\PatientController;


// Home route
Route::get('/', function () {
    return view('welcome');
});

// Dashboard route with authentication middleware
Route::get('/receptionistdashboard', function () {
    return view('dashboard');
})->middleware(['auth:receptionist', 'verified'])->name('receptionist.dashboard');

Route::get('/doctordashboard', function () {
    return view('dashboard');
})->middleware(['auth:doctor', 'verified'])->name('doctor.dashboard');

Route::get('/patientdashboard', function () {
    return view('dashboard');
})->middleware(['auth:patient', 'verified'])->name('patient.dashboard');

Route::get('/assistantdashboard', function () {
    return view('dashboard');
})->middleware(['auth:assistant', 'verified'])->name('assistant.dashboard');

//Dashboard
Route::get('/dashboard', [DashboardController::class, 'view'])->name('dashboard');

// Profile management routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Authentication routes
Route::get('/login', [AuthenticatedSessionController::class, 'create'])
    ->middleware(['not_authed'])
    ->name('login');

Route::post('/login', [AuthenticatedSessionController::class, 'store']);

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store']);

// Route for logout
Route::get('/logout', [AuthenticatedSessionController::class, 'destroy'])
->middleware(['any_authed'])->name('logout');
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
->middleware(['any_authed'])->name('logout');
//Delete Account Routes

Route::get('/receptionist/deleteaccount', [ReceptionistController::class, 'receptionistDeleteAccount'])->name('receptionist.deleteAccount');
Route::get('/doctor/deleteaccount', [DoctorController::class, 'doctorDeleteAccount'])->name('doctor.deleteAccount');
Route::get('/assistant/deleteaccount', [AssistantController::class, 'assistantDeleteAccount'])->name('assistant.deleteAccount');
Route::get('/patient/deleteaccount', [PatientController::class, 'patientDeleteAccount'])->name('patient.deleteAccount');

//Patient Request Appointment Route
//Route::post('/patient/requestappointment', [PatientController::class, 'requestAppointment'])->name('patient.requestAppointment');


Route::middleware('auth:patient')->group(function () {
    Route::get('/patient/requestappointment', [PatientController::class, 'showRequestAppointmentForm'])->name('patient.requestAppointmentForm');
    Route::post('/patient/requestappointment', [PatientController::class, 'requestAppointment'])->name('patient.requestAppointment');
});
