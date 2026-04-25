@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Financial & Sales Analysis Hub</h2>
            <p class="text-muted mb-0">Cross-reference diagnostic data with financial performance across the network.</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-white shadow-sm border" style="border-radius: 12px;">
                <i class="fa-solid fa-print me-2 text-primary"></i> Export Audit
            </button>
        </div>
    </div>

    <!-- Statistical Overview -->
    <div class="row g-4 mb-4">
        <div class="col-md-2">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; background: #f8fafc;">
                <div class="card-body p-3">
                    <p class="text-muted small text-uppercase fw-bold mb-1" style="font-size: 10px;">Gross Billing</p>
                    <h5 class="fw-bold mb-0 text-primary">₹{{ number_format($totals['bill_amount'], 0) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; background: #f8fafc;">
                <div class="card-body p-3">
                    <p class="text-muted small text-uppercase fw-bold mb-1" style="font-size: 10px;">Total Discounts</p>
                    <h5 class="fw-bold mb-0 text-danger">₹{{ number_format($totals['discount'], 0) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; background: #f8fafc;">
                <div class="card-body p-3">
                    <p class="text-muted small text-uppercase fw-bold mb-1" style="font-size: 10px;">Advance Rcd</p>
                    <h5 class="fw-bold mb-0 text-success">₹{{ number_format($totals['advance'], 0) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-2">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; background: #f8fafc;">
                <div class="card-body p-3">
                    <p class="text-muted small text-uppercase fw-bold mb-1" style="font-size: 10px;">Pending Balance</p>
                    <h5 class="fw-bold mb-0 text-warning">₹{{ number_format($totals['balance'], 0) }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 20px; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white;">
                <div class="card-body p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <p class="text-white-50 small text-uppercase fw-bold mb-1" style="font-size: 10px;">Net Realized Revenue</p>
                        <h5 class="fw-bold mb-0">₹{{ number_format($totals['received'], 0) }}</h5>
                    </div>
                    <i class="fa-solid fa-vault fs-3 opacity-25"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Advanced Filters -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 24px;">
        <div class="card-body p-4">
            <form action="{{ route('admin.analysis.index') }}" method="GET" class="row g-3">
                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted">Bill No</label>
                    <input type="text" name="bill_no" value="{{ request('bill_no') }}" class="form-control bg-light border-0 py-2 shadow-none" style="border-radius: 12px;" placeholder="REF-XXXX">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Patient Name / Phone</label>
                    <div class="input-group">
                        <input type="text" name="patient_name" value="{{ request('patient_name') }}" class="form-control bg-light border-0 py-2 shadow-none" style="border-radius: 12px 0 0 12px;" placeholder="Name">
                        <input type="text" name="phone" value="{{ request('phone') }}" class="form-control bg-light border-0 py-2 shadow-none border-start" style="border-radius: 0 12px 12px 0;" placeholder="Phone">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold text-muted">Referring Doctor</label>
                    <input type="text" name="doctor" value="{{ request('doctor') }}" class="form-control bg-light border-0 py-2 shadow-none" style="border-radius: 12px;" placeholder="Dr. Name">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-muted">Date Range</label>
                    <div class="input-group">
                        <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control bg-light border-0 py-2 shadow-none" style="border-radius: 12px 0 0 12px;">
                        <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control bg-light border-0 py-2 shadow-none border-start" style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="border-radius: 12px;">Analyze</button>
                    <a href="{{ route('admin.analysis.index') }}" class="btn btn-light py-2" style="border-radius: 12px;"><i class="fa-solid fa-rotate-left"></i></a>
                </div>
            </form>
        </div>
    </div>

    <!-- Analysis Table -->
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 border-0">Reference</th>
                            <th class="border-0">Patient & Doctor</th>
                            <th class="border-0">Billing Amount</th>
                            <th class="border-0">Disc.</th>
                            <th class="border-0">Advance</th>
                            <th class="border-0">Balance</th>
                            <th class="border-0 text-center">Status</th>
                            <th class="pe-4 border-0 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">{{ $booking->bill_no }}</div>
                                <div class="text-muted small">{{ $booking->booking_date ? $booking->booking_date->format('d M, Y') : 'N/A' }}</div>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $booking->patient->name }}</div>
                                <div class="text-muted small" style="font-size: 11px;">Ref: {{ $booking->patient->reference_dr_name ?: 'Self' }}</div>
                            </td>
                            <td class="fw-bold">₹{{ number_format($booking->total_amount, 2) }}</td>
                            <td class="text-danger small">₹{{ number_format($booking->discount, 0) }}</td>
                            <td class="text-success small">₹{{ number_format($booking->advance_amount, 2) }}</td>
                            <td class="text-warning fw-bold">₹{{ number_format($booking->balance_amount, 2) }}</td>
                            <td class="text-center">
                                @if($booking->status == 'Completed')
                                    <span class="badge bg-soft-success text-success rounded-pill px-3">Completed</span>
                                @else
                                    <span class="badge bg-soft-warning text-warning rounded-pill px-3">Pending</span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group">
                                    <a href="{{ route('admin.analysis.sales-slip', $booking) }}" class="btn btn-sm btn-white border shadow-none text-primary" title="View Sales Slip">
                                        <i class="fa-solid fa-file-invoice"></i>
                                    </a>
                                    <a href="{{ route('admin.bookings.edit', $booking) }}" class="btn btn-sm btn-white border shadow-none text-dark">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <i class="fa-solid fa-magnifying-glass-chart text-muted opacity-25 fs-1 mb-3"></i>
                                <p class="text-muted mb-0">No diagnostic records match your filtered criteria.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($bookings->hasPages())
        <div class="card-footer bg-white border-0 p-4">
            {{ $bookings->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
    .btn-white { background: #fff; border-color: #e2e8f0; color: #475569; }
    .table thead th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 15px 10px; color: #64748b; }
    .table tbody td { padding: 15px 10px; font-size: 13px; }
</style>
@endsection
