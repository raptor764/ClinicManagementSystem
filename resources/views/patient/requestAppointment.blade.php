
@extends('layouts.app')
    <div class="container">
        <h1>Request an Appointment</h1>
        <form action="{{ route('patient.requestAppointment') }}" method="POST">
            @csrf
            <!-- Appointment Date -->
            <div>
                <label for="appointment_date">Appointment Date</label>
                <input type="date" id="appointment_date" name="appointment_date" required>
            </div>

            <!-- Appointment Time -->
            <div>
                <label for="appointment_time">Appointment Time</label>
                <input type="time" id="appointment_time" name="appointment_time" required>
            </div>

            <!-- Receptionist Name -->
            <div>
                <label for="receptionist_name">Receptionist Name</label>
                <input type="text" id="receptionist_name" name="receptionist_name" required>
            </div>

            <!-- Doctor Name -->
            <div>
                <label for="doctor_name">Doctor Name</label>
                <input type="text" id="doctor_name" name="doctor_name" required>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit">Request Appointment</button>
            </div>
        </form>
    </div>

