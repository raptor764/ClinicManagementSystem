@extends('layouts.app')


<div class="container">
    <h1>Pending Appointment Requests</h1>
    @if ($appointments->isEmpty())
        <p>No pending appointments found.</p>
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
                            <!-- Form to respond to the appointment -->
                            <form action="{{ route('receptionists.respond', ['appointmentId'=>$appointment->AppointmentID]) }}" method="POST" style="display: inline;">
                                @csrf
                                <select name="status" required>
                                    <option value="" disabled selected>Respond</option>
                                    <option value="approved">Approve</option>
                                    <option value="rejected">Reject</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>



