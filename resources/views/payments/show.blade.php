@extends('layouts.app')
@section('content')
<div class="container py-4" style="max-width: 700px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i> Back</a>
        <h1 class="fw-bold text-primary mb-0">Payment Details</h1>
    </div>
    <div class="bg-white rounded shadow p-4 mb-4">
        <table class="table table-bordered mb-0">
            <tr><th>ID</th><td>{{ $payment->id }}</td></tr>
            <tr><th>Patient</th><td>{{ $payment->patient->name ?? 'N/A' }}</td></tr>
            <tr><th>Appointment</th><td>{{ $payment->appointment_id ?? '-' }}</td></tr>
            <tr><th>Amount</th><td>{{ $payment->amount }}</td></tr>
            <tr><th>Method</th><td>{{ $payment->payment_method }}</td></tr>
            <tr><th>Status</th><td>{{ $payment->payment_status }}</td></tr>
            <tr><th>Notes</th><td>{{ $payment->notes }}</td></tr>
            <tr><th>Date</th><td>{{ $payment->created_at->format('Y-m-d H:i') }}</td></tr>
        </table>
    </div>
    <!-- Edit and Delete buttons removed as requested -->
</div>
@endsection
