@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Financial Treasury</h2>
            <p class="text-muted mb-0">Monitor laboratory revenue, collections, and outstanding receivables.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-sm" style="border-radius: 12px; height: 48px;" data-bs-toggle="modal" data-bs-target="#addPaymentModal">
                <i class="fa-solid fa-file-invoice-dollar"></i> New Settlement
            </button>
        </div>
    </div>

    <!-- Financial Metrics Grid -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-white bg-opacity-25 rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-vault"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-1">₹{{ number_format($totalRevenue ?? 0, 2) }}</h3>
                    <p class="mb-0 text-white-50 small text-uppercase fw-bold letter-spacing-1">Total Collections</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 24px; background: #fff;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-soft-warning text-warning rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-hourglass-half"></i>
                        </div>
                        <span class="text-warning small fw-bold">Receivable</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">₹{{ number_format($totalPending ?? 0, 2) }}</h3>
                    <p class="mb-0 text-muted small text-uppercase fw-bold letter-spacing-1">Pending Invoices</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 24px; background: #fff;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-soft-info text-info rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">{{ $totalPayments ?? 0 }}</h3>
                    <p class="mb-0 text-muted small text-uppercase fw-bold letter-spacing-1">Transaction Count</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 24px; background: #fff;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-soft-primary text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-scale-balanced"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">₹{{ number_format($totalCollections ?? 0, 2) }}</h3>
                    <p class="mb-0 text-muted small text-uppercase fw-bold letter-spacing-1">Gross Billing</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Treasury Table -->
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <form method="GET" class="row g-3 align-items-center">
                <div class="col-md-4">
                    <div class="input-group bg-light border-0 rounded-pill px-3 py-1">
                        <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-transparent border-0 shadow-none py-2" placeholder="Lookup patient name...">
                    </div>
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select bg-light border-0 rounded-pill py-2 px-4 shadow-none">
                        <option value="">Status: All</option>
                        <option value="Paid" @if(request('status')=='Paid') selected @endif>Paid</option>
                        <option value="Pending" @if(request('status')=='Pending') selected @endif>Pending</option>
                        <option value="Failed" @if(request('status')=='Failed') selected @endif>Failed</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <div class="input-group bg-light border-0 rounded-pill px-3 py-1">
                        <input type="date" name="from" value="{{ request('from') }}" class="form-control bg-transparent border-0 shadow-none py-2 small">
                        <span class="input-group-text bg-transparent border-0 small text-muted">to</span>
                        <input type="date" name="to" value="{{ request('to') }}" class="form-control bg-transparent border-0 shadow-none py-2 small">
                    </div>
                </div>
                <div class="col-md-2 text-end">
                    <button type="submit" class="btn btn-dark rounded-pill px-4 shadow-sm w-100">Audit</button>
                </div>
            </form>
        </div>
        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 border-0">Audit Ref</th>
                            <th class="border-0">Patient Account</th>
                            <th class="border-0">Billing Amount</th>
                            <th class="border-0">Gateway</th>
                            <th class="border-0 text-center">Status</th>
                            <th class="pe-4 border-0 text-end">Operations</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-muted small">#{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-muted" style="font-size: 10px;">{{ $payment->created_at->format('M d, Y') }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 32px; height: 32px; font-size: 11px;">
                                        {{ strtoupper(substr($payment->patient->name ?? 'N', 0, 1)) }}
                                    </div>
                                    <div class="fw-bold text-dark small">{{ $payment->patient->name ?? 'N/A' }}</div>
                                </div>
                            </td>
                            <td class="fw-bold text-dark">₹{{ number_format($payment->amount, 2) }}</td>
                            <td>
                                <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 10px;">
                                    @if(strtolower($payment->payment_method) == 'cash')
                                        <i class="fa-solid fa-money-bill-1-wave me-1"></i>
                                    @elseif(strtolower($payment->payment_method) == 'card')
                                        <i class="fa-solid fa-credit-card me-1"></i>
                                    @else
                                        <i class="fa-solid fa-building-columns me-1"></i>
                                    @endif
                                    {{ $payment->payment_method }}
                                </span>
                            </td>
                            <td class="text-center">
                                @if($payment->payment_status == 'Paid')
                                    <span class="badge bg-soft-success text-success rounded-pill px-3">Cleared</span>
                                @elseif($payment->payment_status == 'Pending')
                                    <span class="badge bg-soft-warning text-warning rounded-pill px-3">Awaiting</span>
                                @else
                                    <span class="badge bg-soft-danger text-danger rounded-pill px-3">Declined</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-white border shadow-none text-primary" data-bs-toggle="modal" data-bs-target="#viewPaymentModal{{ $payment->id }}"><i class="fa-solid fa-receipt"></i></button>
                                    <button class="btn btn-sm btn-white border shadow-none text-warning" data-bs-toggle="modal" data-bs-target="#editPaymentModal{{ $payment->id }}"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <form action="{{ route('admin.payments.destroy', $payment) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this financial record?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-white border shadow-none text-danger" type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="fa-solid fa-file-invoice-dollar text-muted opacity-25 fs-1 mb-3"></i>
                                <p class="text-muted mb-0">No financial activity recorded in this ledger.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($payments->hasPages())
        <div class="card-footer bg-white border-0 p-4">
            {{ $payments->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="addPaymentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
            <div class="modal-header border-0 px-4 pt-4 pb-0">
                <h5 class="modal-title fw-bold" style="color: #1e3a8a;">New Settlement Entry</h5>
                <button type="button" class="btn-close shadow-none p-3 bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.payments.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Select Patient</label>
                            <select name="patient_id" class="form-select bg-light border-0 py-2 shadow-none rounded-4" required>
                                <option value="">Choose...</option>
                                @foreach($patientsList as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Reference Booking</label>
                            <select name="booking_id" class="form-select bg-light border-0 py-2 shadow-none rounded-4">
                                <option value="">Independent Payment</option>
                                @foreach($bookingsList as $b)
                                    <option value="{{ $b->id }}">#{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Amount (₹)</label>
                        <input type="number" step="0.01" name="amount" class="form-control bg-light border-0 py-2 shadow-none rounded-4 fw-bold text-primary fs-4" placeholder="0.00" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Gateway</label>
                            <select name="payment_method" class="form-select bg-light border-0 py-2 shadow-none rounded-4">
                                <option value="Cash">Cash Liquidity</option>
                                <option value="Card">Terminal/Card</option>
                                <option value="Bank Transfer">Digital Transfer</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Ledger Status</label>
                            <select name="payment_status" class="form-select bg-light border-0 py-2 shadow-none rounded-4">
                                <option value="Paid">Paid/Cleared</option>
                                <option value="Pending">Awaiting/Pending</option>
                                <option value="Failed">Declined/Void</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 gap-2">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none px-4" data-bs-dismiss="modal">Discard</button>
                    <button type="submit" class="btn btn-primary px-5 fw-bold shadow-lg" style="border-radius: 12px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border: none;">Record Settlement</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($payments as $payment)
<div class="modal fade" id="viewPaymentModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
            <div class="modal-header border-0 px-4 pt-4 pb-0">
                <h5 class="modal-title fw-bold" style="color: #1e3a8a;">Financial Receipt Preview</h5>
                <button type="button" class="btn-close shadow-none p-3 bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="avatar bg-soft-success text-success rounded-4 d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px; font-size: 32px;">
                    <i class="fa-solid fa-file-invoice-dollar"></i>
                </div>
                <h2 class="fw-bold mb-1">₹{{ number_format($payment->amount, 2) }}</h2>
                <p class="text-muted small mb-4">Transaction Reference: <strong>#{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</strong></p>
                
                <div class="bg-light rounded-4 p-4 text-start">
                    <div class="row g-3">
                        <div class="col-6"><span class="text-muted d-block small text-uppercase fw-bold">Client</span> <span class="fw-bold">{{ $payment->patient->name ?? 'N/A' }}</span></div>
                        <div class="col-6"><span class="text-muted d-block small text-uppercase fw-bold">Gateway</span> <span class="fw-bold">{{ $payment->payment_method }}</span></div>
                        <div class="col-6"><span class="text-muted d-block small text-uppercase fw-bold">Lifecycle</span> <span class="badge bg-soft-success text-success rounded-pill px-2">{{ $payment->payment_status }}</span></div>
                        <div class="col-6"><span class="text-muted d-block small text-uppercase fw-bold">Issued On</span> <span class="fw-bold">{{ $payment->created_at->format('M d, Y') }}</span></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button" class="btn btn-dark w-100 rounded-4 py-2 fw-bold" onclick="window.print()"><i class="fa-solid fa-print me-2"></i> Print Official Receipt</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editPaymentModal{{ $payment->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
            <div class="modal-header border-0 px-4 pt-4 pb-0">
                <h5 class="modal-title fw-bold" style="color: #1e3a8a;">Modify Settlement Record</h5>
                <button type="button" class="btn-close shadow-none p-3 bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.payments.update', $payment) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Patient Account</label>
                            <select name="patient_id" class="form-select bg-light border-0 py-2 shadow-none rounded-4" required>
                                @foreach($patientsList as $p)
                                    <option value="{{ $p->id }}" {{ $payment->patient_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Booking Link</label>
                            <select name="booking_id" class="form-select bg-light border-0 py-2 shadow-none rounded-4">
                                <option value="">Independent</option>
                                @foreach($bookingsList as $b)
                                    <option value="{{ $b->id }}" {{ $payment->booking_id == $b->id ? 'selected' : '' }}>#{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Settlement Value (₹)</label>
                        <input type="number" step="0.01" name="amount" class="form-control bg-light border-0 py-2 shadow-none rounded-4 fw-bold" value="{{ $payment->amount }}" required>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Gateway</label>
                            <select name="payment_method" class="form-select bg-light border-0 py-2 shadow-none rounded-4">
                                <option value="Cash" {{ $payment->payment_method == 'Cash' ? 'selected' : '' }}>Cash Liquidity</option>
                                <option value="Card" {{ $payment->payment_method == 'Card' ? 'selected' : '' }}>Terminal/Card</option>
                                <option value="Bank Transfer" {{ $payment->payment_method == 'Bank Transfer' ? 'selected' : '' }}>Digital Transfer</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Status</label>
                            <select name="payment_status" class="form-select bg-light border-0 py-2 shadow-none rounded-4">
                                <option value="Paid" {{ $payment->payment_status == 'Paid' ? 'selected' : '' }}>Paid/Cleared</option>
                                <option value="Pending" {{ $payment->payment_status == 'Pending' ? 'selected' : '' }}>Awaiting/Pending</option>
                                <option value="Failed" {{ $payment->payment_status == 'Failed' ? 'selected' : '' }}>Declined/Void</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 gap-2">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-5 fw-bold shadow-lg" style="border-radius: 12px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border: none;">Commit Settlement</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<style>
    .bg-soft-primary { background: rgba(37, 99, 235, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
    .bg-soft-danger { background: rgba(239, 68, 68, 0.1); }
    .bg-soft-info { background: rgba(14, 165, 233, 0.1); }
    .letter-spacing-1 { letter-spacing: 1px; }
    .btn-white { background: #fff; border-color: #e2e8f0; color: #475569; }
    .btn-white:hover { background: #f8fafc; color: #1e293b; }
    .table thead th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 15px 10px; color: #64748b; }
    .table tbody td { padding: 15px 10px; }
</style>
@endsection
