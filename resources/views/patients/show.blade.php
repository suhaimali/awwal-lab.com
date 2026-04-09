@extends('layouts.app')
@section('content')
<div class="container mx-auto p-4 max-w-lg">
    <div class="mb-3">
        <a href="{{ route('patients.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i> Back</a>
    </div>
    <h1 class="text-2xl font-bold mb-4">Patient Details</h1>
    <div class="bg-white rounded shadow p-4 mb-4">
        <h5 class="fw-bold mb-3 text-primary">Basic Information</h5>
        <table class="table table-bordered mb-0">
            <tr><th>Full Name</th><td>{{ $patient->name }}</td></tr>
            <tr><th>Email Address</th><td>{{ $patient->email ?? 'Not provided' }}</td></tr>
            <tr><th>Phone Number</th><td>{{ $patient->phone }}</td></tr>
            <tr><th>Gender</th><td>{{ $patient->gender }}</td></tr>
            <tr><th>Age</th><td>{{ $patient->age }} years</td></tr>
            <tr><th>Date of Birth</th><td>{{ $patient->dob ?? 'Not provided' }}</td></tr>
        </table>
    </div>
    <div class="bg-white rounded shadow p-4 mb-4">
        <h5 class="fw-bold mb-3 text-secondary">System Information</h5>
        <table class="table table-bordered mb-0">
            <tr><th>Visit Date</th><td>{{ $patient->visit_date }}</td></tr>
        </table>
    </div>


</div>
@endsection