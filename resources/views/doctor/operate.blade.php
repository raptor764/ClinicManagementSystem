@extends('layouts.app')


<div class="container">
    <h1>Conduct a Session</h1>
    <form action="{{ route('doctor.operate') }}" method="POST">
        @csrf

        <!-- Patient Dropdown -->
        <div class="mb-3">
            <label for="patient_id" class="form-label">Patient</label>
            <select id="patient_id" name="patient_id" class="form-select" required>
                <option value="" disabled selected>Select a Patient</option>
                @foreach ($patients as $patient)
                    <option value="{{ $patient->PatientID }}">{{ $patient->Name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Session Date -->
        <div class="mb-3">
            <label for="session_date" class="form-label">Session Date</label>
            <input type="date" id="session_date" name="session_date" class="form-control" required>
        </div>

        <!-- Session Time -->
        <div class="mb-3">
            <label for="session_time" class="form-label">Session Time</label>
            <input type="time" id="session_time" name="session_time" class="form-control" required>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="btn btn-primary">Schedule Session</button>
        </div>
    </form>
</div>
