@extends('layouts.app')

<div class="container">
    <h1>Issue a Medical Report</h1>
    <form action="{{ route('doctor.createReport') }}" method="POST">
        @csrf

        <!-- Report Date -->
        <div class="mb-3">
            <label for="report_date" class="form-label">Report Date</label>
            <input type="date" id="report_date" name="report_date" class="form-control" required>
        </div>

        <!-- Report Content -->
        <div class="mb-3">
            <label for="content" class="form-label">Report Content</label>
            <textarea id="content" name="content" class="form-control" rows="4" required></textarea>
        </div>

        <!-- Session Dropdown -->
        <div class="mb-3">
            <label for="session_id" class="form-label">Session</label>
            <select id="session_id" name="session_id" class="form-select" required>
                <option value="" disabled selected>Select a Session</option>
                @foreach ($sessions as $session)
                    <!-- Fetch patient's name using relationship or join -->
                    <option value="{{ $session->SessionID }}" data-patient-id="{{ $session->PatientID }}">
                        Session ID: {{ $session->SessionID }} - Patient: {{ $session->patient->Name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Patient ID (hidden) -->
        <input type="hidden" id="patient_id" name="patient_id">

        <!-- Submit Button -->
        <div>
            <button type="submit" class="btn btn-primary">Issue Report</button>
        </div>
    </form>
</div>

<!-- JavaScript to auto-fill the patient_id based on the selected session -->
<script>
    document.getElementById('session_id').addEventListener('change', function() {
        var patientId = this.options[this.selectedIndex].getAttribute('data-patient-id');
        document.getElementById('patient_id').value = patientId;
    });
</script>
