@extends('layouts.app')
@section('content')
<div class="container py-4" style="max-width: 700px;">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-primary mb-0">Add Payment</h1>
        <a href="{{ route('payments.index') }}" class="btn btn-outline-secondary"><i class="fa fa-arrow-left me-1"></i> Back</a>
    </div>
    <form method="POST" action="{{ route('payments.store') }}" class="bg-white p-4 rounded shadow">
        @csrf
        <div class="mb-3">
            <label class="form-label">Patient</label>
            <select name="patient_id" class="form-select" required>
                <option value="">Select Patient</option>
                @foreach($patients as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }} (ID: {{ $patient->id }})</option>
                @endforeach
            </select>
            @error('patient_id')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
            @error('amount')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Payment Status</label>
            <select name="payment_status" class="form-select" id="payment_status_select" required onchange="updateStatusBadge()">
                <option value="Paid">Paid</option>
                <option value="Pending">Pending</option>
                <option value="Failed">Failed</option>
            </select>
            <span id="statusBadge" class="badge bg-success ms-2">Paid</span>
            @error('payment_status')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <script>
        function updateStatusBadge() {
            var select = document.getElementById('payment_status_select');
            var badge = document.getElementById('statusBadge');
            var value = select.value;
            badge.textContent = value;
            badge.className = 'badge ms-2 ' +
                (value === 'Paid' ? 'bg-success' : (value === 'Pending' ? 'bg-warning text-dark' : 'bg-danger'));
        }
        document.addEventListener('DOMContentLoaded', updateStatusBadge);
        </script>
        <div class="mb-3">
            <label class="form-label">Payment Method</label>
            <select name="payment_method" class="form-select" required>
                <option value="Cash">Cash</option>
                <option value="UPI">UPI</option>
                <option value="Card">Card</option>
            </select>
            @error('payment_method')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Transaction ID (optional)</label>
            <input type="text" name="transaction_id" class="form-control">
            @error('transaction_id')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <button class="btn btn-gradient-primary w-100" type="submit"><i class="fa fa-credit-card me-1"></i> Save Payment</button>
    </form>
</div>
@endsection
