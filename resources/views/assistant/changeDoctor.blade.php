@extends('layouts.app')


<div class="container">
    <h1>Change Supervising Doctor</h1>
    <form action="{{ route('assistant.changeDoctor') }}" method="POST">
        @csrf

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
            <button type="submit" class="btn btn-primary">Change Doctor</button>
        </div>
    </form>
</div>

