@extends('layouts.app')


<div class="container">
    <h1>Your Sessions List</h1>
    @if ($sessions->isEmpty())
        <p>No Sessions Found for You.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Session ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Doctor Name</th>
                    <th>Patient Name</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($sessions as $session)
                    <tr>
                        <td>{{ $session->SessionID }}</td>
                        <td>{{ $session->SessionDate }}</td>
                        <td>{{ $session->SessionTime }}</td>
                        <td>{{ $session->doctor->Name ?? 'Unknown' }}</td>
                        <td>{{ $session->patient->Name ?? 'Unknown' }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>