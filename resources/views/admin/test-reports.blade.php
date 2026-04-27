@extends('layouts.app')

@push('styles')
<style>
    .letter-spacing-1 { letter-spacing: 1px; }
    .bg-soft-primary { background: rgba(37, 99, 235, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
    .animate-in { animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1); }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    
    .report-table-row { transition: all 0.3s ease; border-left: 4px solid transparent; }
    .report-table-row:hover { background: #f8fafc; border-left-color: #3b82f6; }
    
    .btn-action { width: 38px; height: 38px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; transition: all 0.2s; background: #fff; border: 1px solid #e2e8f0; color: #64748b; }
    .btn-action:hover { transform: scale(1.08); color: #1e40af; border-color: #3b82f6; box-shadow: 0 5px 15px rgba(59, 130, 246, 0.1); }
    
    .status-dot { width: 8px; height: 8px; border-radius: 50%; display: inline-block; margin-right: 6px; }
    .dot-success { background: #10b981; box-shadow: 0 0 10px rgba(16, 185, 129, 0.5); }
    .dot-warning { background: #f59e0b; box-shadow: 0 0 10px rgba(245, 158, 11, 0.5); }

    /* Update Modal Styling */
    .modal-update { border-radius: 30px; border: none; overflow: hidden; }
    .modal-update .modal-header { background: #1e3a8a; color: white; border: none; padding: 25px; }
    .modal-update .modal-body { padding: 40px; text-align: center; }
</style>
@endpush

@section('content')
<div class="container-fluid p-0 animate-in">
    <!-- Premium Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 px-3">
        <div>
            <h2 class="fw-bold mb-1" style="color: #0f172a;">Diagnostic <span class="text-primary">Reports</span></h2>
            <p class="text-muted mb-0">Monitor investigation lifecycles and finalize clinical outcomes.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary shadow-primary px-4 fw-bold" style="border-radius: 14px; height: 48px;" data-bs-toggle="modal" data-bs-target="#newReportModal">
                <i class="fa-solid fa-plus-circle me-2"></i> Initialize Analysis
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 mx-3 animate-in" style="border-radius: 16px; background: #dcfce7; color: #166534;">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-4 me-3"></i>
                <div class="fw-bold">{{ session('success') }}</div>
            </div>
        </div>
    @endif

    <!-- Data Insights Grid -->
    <div class="row g-4 mb-5 px-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 28px; background: #fff;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                            <i class="fa-solid fa-folder-open fs-4"></i>
                        </div>
                        <span class="badge bg-light text-muted rounded-pill px-3">Global Pool</span>
                    </div>
                    <h2 class="fw-black mb-1" style="color: #1e293b;">{{ $totalReports }}</h2>
                    <p class="text-muted small fw-bold text-uppercase mb-0 letter-spacing-1">Total Diagnostics</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 28px; background: #fff;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(16, 185, 129, 0.1); color: #10b981;">
                            <i class="fa-solid fa-square-check fs-4"></i>
                        </div>
                        <span class="badge bg-soft-success text-success rounded-pill px-3">Verification OK</span>
                    </div>
                    <h2 class="fw-black mb-1" style="color: #1e293b;">{{ $completedReports }}</h2>
                    <p class="text-muted small fw-bold text-uppercase mb-0 letter-spacing-1">Finalized Modules</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 28px; background: #fff;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div class="rounded-4 d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                            <i class="fa-solid fa-vial-circle-check fs-4"></i>
                        </div>
                        <span class="badge bg-soft-warning text-warning rounded-pill px-3">In Progress</span>
                    </div>
                    <h2 class="fw-black mb-1" style="color: #1e293b;">{{ $pendingReports }}</h2>
                    <p class="text-muted small fw-bold text-uppercase mb-0 letter-spacing-1">Pending Analysis</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filters -->
    <div class="card border-0 shadow-sm mx-3 mb-4" style="border-radius: 24px;">
        <div class="card-body p-3">
            <form action="{{ route('admin.test-reports') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group bg-light border-0 rounded-pill px-3">
                        <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-search text-muted"></i></span>
                        <input type="text" name="patient" class="form-control border-0 bg-transparent shadow-none py-2" placeholder="Search patient name..." value="{{ request('patient') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select border-0 bg-light rounded-pill px-4 shadow-none">
                        <option value="">All Status</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" name="from_date" class="form-control border-0 bg-light rounded-pill px-3 shadow-none" value="{{ request('from_date') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-dark rounded-pill w-100 fw-bold">Apply Filter</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Data Table -->
    <div class="mx-3">
        <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 28px;">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead style="background: #f8fafc;">
                        <tr>
                            <th class="ps-4 py-4 text-muted small fw-bold text-uppercase letter-spacing-1 border-0">Diagnostic ID</th>
                            <th class="py-4 text-muted small fw-bold text-uppercase letter-spacing-1 border-0">Patient Identity</th>
                            <th class="py-4 text-muted small fw-bold text-uppercase letter-spacing-1 border-0">Investigation Unit</th>
                            <th class="py-4 text-muted small fw-bold text-uppercase letter-spacing-1 border-0 text-center">Lifecycle</th>
                            <th class="py-4 text-muted small fw-bold text-uppercase letter-spacing-1 border-0 text-end pe-4">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                        <tr class="report-table-row border-bottom">
                            <td class="ps-4">
                                <div class="fw-bold text-primary mb-0">#REP-{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-muted small" style="font-size: 11px;">{{ $report->created_at->format('M d, Y') }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 38px; height: 38px; font-size: 13px;">
                                        {{ strtoupper(substr($report->booking->patient->name ?? 'P', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0" style="font-size: 14px;">{{ $report->booking->patient->name ?? 'N/A' }}</div>
                                        <div class="text-muted small" style="font-size: 11px;">{{ $report->booking->patient->phone ?? 'N/A' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @php 
                                    $testIds = $report->booking->tests ?: [];
                                    $displayTests = $testTypes->whereIn('id', $testIds)->pluck('name')->toArray();
                                @endphp
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach(array_slice($displayTests, 0, 2) as $tName)
                                        <span class="badge bg-light text-muted border px-2 py-1" style="font-size: 10px; border-radius: 6px;">{{ $tName }}</span>
                                    @endforeach
                                    @if(count($displayTests) > 2)
                                        <span class="badge bg-white text-primary border px-2 py-1" style="font-size: 10px; border-radius: 6px;">+{{ count($displayTests) - 2 }}</span>
                                    @endif
                                </div>
                            </td>
                            <td class="text-center">
                                @if($report->status == 'Completed')
                                    <span class="badge bg-soft-success text-success rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center" style="font-size: 11px;">
                                        <span class="status-dot dot-success"></span> FINALIZED
                                    </span>
                                @else
                                    <span class="badge bg-soft-warning text-warning rounded-pill px-3 py-2 fw-bold d-inline-flex align-items-center" style="font-size: 11px;">
                                        <span class="status-dot dot-warning"></span> PROCESSING
                                    </span>
                                @endif
                            </td>
                            <td class="pe-4 text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.reports.edit', $report->id) }}" class="btn-action" title="Enter Results">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this diagnostic record permanently?');">
                                        @csrf @method('DELETE')
                                        <button class="btn-action text-danger" type="submit" title="Delete">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="py-5 animate-in">
                                    <div class="rounded-circle bg-soft-primary d-inline-flex align-items-center justify-content-center mb-4" style="width: 100px; height: 100px; background: rgba(37, 99, 235, 0.1);">
                                        <i class="fa-solid fa-vials fs-1 text-primary"></i>
                                    </div>
                                    <h4 class="fw-bold" style="color: #0f172a;">Queue is Empty</h4>
                                    <p class="text-muted mb-4 mx-auto" style="max-width: 400px;">No diagnostic reports have been initialized yet. Start by selecting an active booking from the clinical pool.</p>
                                    <button type="button" class="btn btn-primary px-4 py-3 fw-bold rounded-pill shadow-primary" style="border-radius: 14px;" data-bs-toggle="modal" data-bs-target="#newReportModal">
                                        <i class="fa-solid fa-plus-circle me-2"></i> Initialize First Analysis
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>@include('admin.partials.report-modals')

<style>
    .fw-black { font-weight: 900; }
</style>
@endsection