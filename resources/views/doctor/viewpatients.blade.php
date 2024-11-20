@extends('layouts.app')


<div class="container">
    <h1>Your Patients</h1>
    
    @if ($patients->isEmpty())
        <p>No Patient Found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Date of Birth</th>
                    <th>Address</th>
                    <th>Phone</th>
                    <th>Email</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($patients as $patient)
                    <tr>
                        <td>{{ $patient->Name }}</td>
                        <td>{{ $patient->DateOfBirth ?? 'Unknown' }}</td> 
                        <td>{{ $patient->Address ?? 'Unknown' }}</td> 
                        <td>{{ $patient->Phone }}</td>
                        <td>{{ $patient->email }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

