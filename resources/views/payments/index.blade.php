@extends('layouts.app')
@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary me-2"><i class="fa fa-arrow-left me-1"></i> Back</a>
        </div>
        <h1 class="fw-bold text-primary mb-0">Payments</h1>
        <div>
            <a href="{{ route('payments.create') }}" class="btn btn-gradient-primary"><i class="fa fa-plus me-1"></i> Add Payment</a>
        </div>
    </div>

    <div class="row mt-2 mb-4 g-3">
        <div class="col-md-3 col-6">
            <div class="card text-white bg-success mb-3 text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Revenue</h5>
                    <p class="card-text fs-4">{{ number_format($totalRevenue ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-white bg-primary mb-3 text-center">
                <div class="card-body">
                    <h5 class="card-title">Paid</h5>
                    <p class="card-text fs-4">{{ number_format($totalRevenue ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-dark bg-warning mb-3 text-center">
                <div class="card-body">
                    <h5 class="card-title">Pending</h5>
                    <p class="card-text fs-4">{{ number_format($totalPending ?? 0, 2) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-white bg-info mb-3 text-center">
                <div class="card-body">
                    <h5 class="card-title">Total Records</h5>
                    <p class="card-text fs-4">{{ $totalPayments ?? 0 }}</p>
                </div>
            </div>
        </div>
    </div>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="GET" class="row g-2 mb-3">
        <div class="col-md-3">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search by patient name">
        </div>
        <div class="col-md-3">
            <label for="from-date" class="form-label">From Date</label>
            <input id="from-date" type="date" name="from" value="{{ request('from') }}" class="form-control" placeholder="From">
        </div>
        <div class="col-md-3">
            <label for="to-date" class="form-label">To Date</label>
            <input id="to-date" type="date" name="to" value="{{ request('to') }}" class="form-control" placeholder="To">
        </div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">All Status</option>
                <option value="Paid" @if(request('status')=='Paid') selected @endif>Paid</option>
                <option value="Pending" @if(request('status')=='Pending') selected @endif>Pending</option>
                <option value="Failed" @if(request('status')=='Failed') selected @endif>Failed</option>
            </select>
        </div>
        <div class="col-md-2">
            <button class="btn btn-info w-100 text-white" type="submit"><i class="fa fa-filter me-1"></i> Filter</button>
        </div>
    </form>
    <div class="table-responsive rounded shadow">
        <table class="table table-hover align-middle bg-white">
            <thead class="bg-gradient-primary text-white">
                <tr>
                    <th>ID</th>
                    <th>Patient</th>
                    <th>Appointment</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                <tr>
                    <td>{{ $payment->id }}</td>
                    <td>{{ $payment->patient->name ?? 'N/A' }}</td>
                    <td>{{ $payment->appointment_id ?? '-' }}</td>
                    <td>{{ $payment->amount }}</td>
                    <td>{{ $payment->payment_method }}</td>
                    <td>
                        <span class="badge 
                            @if($payment->payment_status == 'Paid') bg-success text-white
                            @elseif($payment->payment_status == 'Pending') bg-warning text-dark
                            @else bg-danger text-white
                            @endif
                        ">
                            {{ $payment->payment_status }}
                        </span>
                    </td>
                    <td>{{ $payment->created_at->format('Y-m-d') }}</td>
                    <td>
                        <a href="{{ route('payments.show', $payment) }}" class="btn btn-sm btn-outline-primary me-1"><i class="fa fa-eye"></i></a>
                        <a href="{{ route('payments.edit', $payment) }}" class="btn btn-sm btn-outline-warning me-1"><i class="fa fa-edit"></i></a>
                        <form action="{{ route('payments.destroy', $payment) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this payment for {{ $payment->patient->name ?? 'N/A' }}?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-2">No payments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $payments->links() }}</div>
</div>
@endsection
