@extends('layouts.app')


<div class="container">
    <h1>Request an Appointment</h1>
    <form action="{{ route('patient.requestAppointment') }}" method="POST">
        @csrf

        <!-- Appointment Date -->
        <div class="mb-3">
            <label for="appointment_date" class="form-label">Appointment Date</label>
            <input type="date" id="appointment_date" name="appointment_date" class="form-control" required>
        </div>

        <!-- Appointment Time -->
        <div class="mb-3">
            <label for="appointment_time" class="form-label">Appointment Time</label>
            <input type="time" id="appointment_time" name="appointment_time" class="form-control" required>
        </div>

        <!-- Receptionist Dropdown -->
        <div class="mb-3">
            <label for="receptionist_id" class="form-label">Receptionist</label>
            <select id="receptionist_id" name="receptionist_id" class="form-select" required>
                <option value="" disabled selected>Select a Receptionist</option>
                @foreach ($receptionists as $receptionist)
                    <option value="{{ $receptionist->ReceptionistID }}">{{ $receptionist->Name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Doctor Dropdown -->
        <div class="mb-3">
            <label for="doctor_id" class="form-label">Doctor</label>
            <select id="doctor_id" name="doctor_id" class="form-select" required>
                <option value="" disabled selected>Select a Doctor</option>
                @foreach ($doctors as $doctor)
                    <option value="{{ $doctor->DoctorID }}">{{ $doctor->Name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="btn btn-primary">Request Appointment</button>
        </div>
    </form>
</div>

