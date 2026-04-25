@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Report Dispatch Center</h2>
            <p class="text-muted mb-0">Verified diagnostic records ready for clinical release and delivery.</p>
        </div>
        <div class="d-flex gap-2">
            <div class="card border-0 shadow-sm px-3 py-2 bg-white" style="border-radius: 12px;">
                <div class="small text-muted fw-bold text-uppercase" style="font-size: 10px;">Ready for Dispatch</div>
                <div class="h5 fw-bold mb-0 text-success">{{ $reports->total() }}</div>
            </div>
        </div>
    </div>

    <!-- Search & Quick Filter -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
        <div class="card-body p-3">
            <form action="{{ route('admin.reports.dispatch') }}" method="GET" class="row g-2">
                <div class="col-md-10">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-magnifying-glass text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-light border-0 py-2 shadow-none" placeholder="Search by Patient Name, ID, or Phone..." style="border-radius: 0 12px 12px 0;">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold" style="border-radius: 12px;">Search Queue</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Dispatch Table -->
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 border-0">Report ID</th>
                            <th class="border-0">Patient Identity</th>
                            <th class="border-0">Financial Summary</th>
                            <th class="border-0">Verified At</th>
                            <th class="pe-4 border-0 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-dark">#REP-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-muted small" style="font-size: 11px;">Ref: {{ $report->booking->bill_no }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-success bg-opacity-10 text-success rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 38px; height: 38px;">
                                        {{ strtoupper(substr($report->booking->patient->name ?? 'P', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $report->booking->patient->name }}</div>
                                        <div class="text-muted small">{{ $report->booking->patient->phone }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php 
                                    $total = $report->booking->total_amount;
                                    $paid = $report->booking->advance_amount;
                                    $percentage = $total > 0 ? ($paid / $total) * 100 : 0;
                                @endphp
                                <div style="min-width: 140px;">
                                    <div class="h5 fw-bold text-dark mb-1">₹{{ number_format($total, 2) }}</div>
                                    <div class="progress" style="height: 4px; background: #f1f5f9; border-radius: 2px;">
                                        <div class="progress-bar bg-{{ $percentage >= 100 ? 'success' : ($percentage > 0 ? 'info' : 'secondary') }}" role="progressbar" style="width: {{ $percentage }}%;"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-1" style="font-size: 9px;">
                                        <span class="text-muted fw-bold">{{ $percentage >= 100 ? 'FULLY PAID' : 'PARTIAL' }}</span>
                                        <span class="text-primary fw-bold">{{ number_format($percentage, 0) }}%</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="text-dark small fw-bold">{{ $report->updated_at->format('d M, Y') }}</div>
                                <div class="text-muted small" style="font-size: 11px;">{{ $report->updated_at->format('h:i A') }}</div>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.reports.edit', $report->id) }}" class="btn btn-primary btn-sm px-3 py-2 fw-bold" style="border-radius: 10px;" title="Edit Results">
                                        <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Archive this dispatched report permanently?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-danger btn-sm px-3 py-2 fw-bold" type="submit" style="border-radius: 10px;">
                                            <i class="fa-solid fa-trash-can me-1"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-5">
                                    <i class="fa-solid fa-box-open text-muted opacity-25 fs-1 mb-3"></i>
                                    <p class="text-muted">No reports are currently pending dispatch.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($reports->hasPages())
        <div class="card-footer bg-white border-0 p-4">
            {{ $reports->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-danger { background: rgba(239, 68, 68, 0.1); }
    .table thead th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 15px 10px; color: #64748b; }
    .table tbody td { padding: 15px 10px; font-size: 13px; }
</style>
@endsection
