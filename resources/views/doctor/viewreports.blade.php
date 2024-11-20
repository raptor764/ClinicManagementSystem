@extends('layouts.app')


<div class="container">
    <h1>Medical Reports</h1>
    
    @if ($reports->isEmpty())
        <p>No medical reports found.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Report Date</th>
                    <th>Patient Name</th>
                    <th>Doctor Name</th>
                    <th>Session ID</th>
                    <th>Content</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $report)
                    <tr>
                        <td>{{ $report->ReportDate }}</td>
                        <td>{{ $report->patient->Name ?? 'Unknown' }}</td> <!-- Assumes Patient model has 'Name' -->
                        <td>{{ $report->doctor->Name ?? 'Unknown' }}</td> <!-- Assumes Doctor model has 'Name' -->
                        <td>{{ $report->SessionID }}</td>
                        <td>{{ $report->Content }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

