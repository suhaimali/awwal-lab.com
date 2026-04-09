@extends('layouts.app')
@section('content')
<div class="container py-4" style="max-width: 700px;">
    <div class="mb-3">
        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i> Back</a>
    </div>
    <h1 class="fw-bold text-primary mb-4">Edit Payment</h1>
    <form method="POST" action="{{ route('payments.update', $payment) }}" class="row g-3 bg-white p-4 rounded shadow">
        @csrf
        @method('PUT')
        <div class="col-md-6">
            <label class="form-label">Patient</label>
            <select name="patient_id" class="form-select border-primary" required>
                <option value="">Select Patient</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}" @if($payment->patient_id == $patient->id) selected @endif>{{ $patient->name }} (ID: {{ $patient->id }})</option>
                @endforeach
            </select>
            @error('patient_id')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-6">
            <label class="form-label">Appointment (optional)</label>
            <select name="appointment_id" class="form-select border-info">
                <option value="">None</option>
                @foreach($appointments as $appointment)
                    <option value="{{ $appointment->id }}" @if($payment->appointment_id == $appointment->id) selected @endif>#{{ $appointment->id }} - {{ $appointment->appointment_date }}</option>
                @endforeach
            </select>
            @error('appointment_id')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control border-info" value="{{ $payment->amount }}" required />
            @error('amount')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">Payment Method</label>
            <select name="payment_method" class="form-select border-success" required>
                <option value="UPI" @if($payment->payment_method=='UPI') selected @endif>UPI</option>
                <option value="Cash" @if($payment->payment_method=='Cash') selected @endif>Cash</option>
                <option value="Card" @if($payment->payment_method=='Card') selected @endif>Card</option>
                <option value="QR" @if($payment->payment_method=='QR') selected @endif>QR</option>
            </select>
            @error('payment_method')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">Payment Status</label>
            <select name="payment_status" class="form-select border-warning" required>
                <option value="Paid" @if($payment->payment_status=='Paid') selected @endif>Paid</option>
                <option value="Pending" @if($payment->payment_status=='Pending') selected @endif>Pending</option>
                <option value="Failed" @if($payment->payment_status=='Failed') selected @endif>Failed</option>
            </select>
            @error('payment_status')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <label class="form-label">Notes</label>
            <textarea name="notes" class="form-control" rows="2">{{ $payment->notes }}</textarea>
            @error('notes')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <button class="btn btn-gradient-primary w-100" type="submit"><i class="fa fa-save me-1"></i> Update Payment</button>
        </div>
    </form>
</div>
@endsection
