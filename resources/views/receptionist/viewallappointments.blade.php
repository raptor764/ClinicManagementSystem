@extends('layouts.app')


<div class="container">
    <h1>Appointments List</h1>
    @if ($appointments->isEmpty())
        <p>No appointments found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($appointments as $appointment)
                    <tr>
                        <td>{{ $appointment->Date }}</td>
                        <td>{{ $appointment->Time }}</td>
                        <td>{{ $appointment->patient->Name ?? 'Unknown' }}</td> <!-- Assumes a patient relationship -->
                        <td>{{ $appointment->doctor->Name ?? 'Unknown' }}</td> <!-- Assumes a doctor relationship -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

