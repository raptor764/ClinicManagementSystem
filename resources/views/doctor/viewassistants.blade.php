@extends('layouts.app')


<div class="container">
    <h1>Assistants Who Work For You</h1>
    
    @if ($assistants->isEmpty())
        <p>No Assistants Work For You</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Section</th>
                    <th>Supervising Doctor</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($assistants as $assistant)
                    <tr>
                        <td>{{ $assistant->Name }}</td>
                        <td>{{ $assistant->Phone ?? 'Unknown' }}</td>
                        <td>{{ $assistant->email ?? 'Unknown' }}</td> 
                        <td>{{ $assistant->Section->Name }}</td>
                        <td>{{ $assistant->Doctor->Name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

