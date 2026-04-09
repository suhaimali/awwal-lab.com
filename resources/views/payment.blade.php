@extends('layouts.app')

@section('content')
<div class="container py-4" style="max-width: 700px;">
    <h1 class="fw-bold text-primary mb-4">Payment Management</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" action="{{ route('payments.store') }}" class="row g-3 bg-white p-4 rounded shadow mb-4">
        @csrf
        <div class="col-md-6">
            <label class="form-label">Patient</label>
            <select name="patient_id" class="form-select border-primary" required>
                <option value="">Select Patient</option>
                @foreach(App\Models\Patient::all() as $patient)
                    <option value="{{ $patient->id }}">{{ $patient->name }} (ID: {{ $patient->id }})</option>
                @endforeach
            </select>
            @error('patient_id')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-3">
            <label class="form-label">Amount</label>
            <input type="number" step="0.01" name="amount" class="form-control border-info" required />
            @error('amount')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-3">
            <label class="form-label">Payment Date</label>
            <input type="date" name="payment_date" class="form-control border-success" required />
            @error('payment_date')<div class="text-danger small">{{ $message }}</div>@enderror
        </div>
        <div class="col-12">
            <button class="btn btn-gradient-primary w-100" type="submit"><i class="fa fa-credit-card me-1"></i> Record Payment</button>
        </div>
    </form>

    <div class="table-responsive rounded shadow">
        <table class="table table-hover align-middle bg-white">
            <thead class="bg-gradient-primary text-white">
                <tr>
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ optional($payment->patient)->name ?? 'N/A' }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->payment_date }}</td>
                    <td>{{ $payment->created_at }}</td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-2">No payments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="/js/payment-popup.js"></script>
@endpush
