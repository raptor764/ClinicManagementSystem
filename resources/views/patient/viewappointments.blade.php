@extends('layouts.app')


<div class="container">
    <h1>Scheduled Appointments List</h1>
    @if ($appointments->isEmpty())
        <p>No Scheduled appointments found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->Date }}</td>
                        <td>{{ $appointment->Time }}</td>
                        <td>{{ $appointment->patient->Name ?? 'Unknown' }}</td>
                        <td>{{ $appointment->doctor->Name ?? 'Unknown' }}</td>
                        <td>
                            <!-- Cancel Button -->
                            <form action="{{ route('patients.cancel', ['appointmentId' => $appointment->AppointmentID]) }}" method="POST" style="display: inline;">
                                @csrf
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn btn-danger btn-sm">Cancel Appointment</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

