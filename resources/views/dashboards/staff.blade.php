@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: #1f1140;">Staff Dashboard</h2>
            <p class="text-muted mb-0">Welcome back to the operations center, {{ auth()->user()->name }}.</p>
        </div>
        <button class="btn btn-primary d-none d-md-flex align-items-center gap-2">
            + Schedule Maintenance
        </button>
    </div>

    <div class="row g-4">
        <!-- Labs Supervised -->
        <div class="col-md-6">
            <div class="card stat-card" style="border-left-color: #10b981;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 1px;">Labs Under Supervision</p>
                            <h2 class="fw-bold text-dark mb-0">{{ $totalLabs ?? '0' }}</h2>
                        </div>
                        <div class="stat-icon" style="background: rgba(16, 185, 129, 0.1); color: #10b981;">
                            L
                        </div>
                    </div>
                    <div class="mt-3 text-success" style="font-size: 13px; font-weight: 600;">
                        ↑ Optimal status
                    </div>
                </div>
            </div>
        </div>

        <!-- Equipment Regulated -->
        <div class="col-md-6">
            <div class="card stat-card" style="border-left-color: #3b82f6;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted text-uppercase fw-bold mb-1" style="font-size: 11px; letter-spacing: 1px;">Equipment Regulated</p>
                            <h2 class="fw-bold text-dark mb-0">{{ $totalEquipment ?? '0' }}</h2>
                        </div>
                        <div class="stat-icon" style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                            E
                        </div>
                    </div>
                    <div class="mt-3 text-info" style="font-size: 13px; font-weight: 600;">
                        → Verify inventory
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert / System status -->
    <div class="row mt-4">
            <!-- System Overview Section (Same as Admin) -->
            <div class="row mt-5">
                <div class="col-12">
                    <h4 class="fw-bold mb-3" style="color:#7c3aed;">System Overview</h4>
                    <div class="dashboard-cards" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(260px,1fr));gap:2rem;">
                        <div class="dashboard-card">
                            <span class="icon" style="color:#10b981;background:rgba(16,185,129,0.08);"><i class="fa-solid fa-chart-line"></i></span>
                            <span class="label">Performance Mgmt</span>
                            <span class="value">{{ $performanceScore ?? 'A+' }}</span>
                            <span class="desc">System efficiency</span>
                        </div>
                        <div class="dashboard-card">
                            <span class="icon" style="color:#f52988;background:rgba(245,41,136,0.08);"><i class="fa-solid fa-sack-dollar"></i></span>
                            <span class="label">System Income</span>
                            <span class="value">${{ $systemIncome ?? '0.00' }}</span>
                            <span class="desc">This month</span>
                        </div>
                        <div class="dashboard-card">
                            <span class="icon" style="color:#3b82f6;background:rgba(59,130,246,0.08);"><i class="fa-solid fa-vials"></i></span>
                            <span class="label">Tests Completed</span>
                            <span class="value">{{ $testsCompleted ?? '0' }}</span>
                            <span class="desc">All time</span>
                        </div>
                        <div class="dashboard-card">
                            <span class="icon" style="color:#7c3aed;background:rgba(124,58,237,0.08);"><i class="fa-solid fa-user-injured"></i></span>
                            <span class="label">Total Patients</span>
                            <span class="value">{{ $totalPatients ?? '0' }}</span>
                            <span class="desc">Registered</span>
                        </div>
                        <div class="dashboard-card">
                            <span class="icon" style="color:#f59e42;background:rgba(245,158,66,0.08);"><i class="fa-solid fa-money-check-dollar"></i></span>
                            <span class="label">Pending Payments</span>
                            <span class="value">${{ $pendingPayments ?? '0.00' }}</span>
                            <span class="desc">Awaiting action</span>
                        </div>
                    </div>
                </div>
            </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Task List</span>
                    <span class="badge bg-warning">2 Alerts</span>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between border-0 ps-0">
                            <span>Check calibration on microscope A-12</span>
                            <span class="text-muted" style="font-size: 12px;">Pending</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between border-0 ps-0">
                            <span>Approve student chemistry lab reservation</span>
                            <span class="text-muted" style="font-size: 12px;">Action Needed</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
