@extends('layouts.app')

@section('content')
<div class="container-fluid p-0 pb-5">
    <!-- Operational Hub Header -->
    <div class="d-flex justify-content-between align-items-center mb-5 ba-animate">
        <div>
            <h2 class="fw-black mb-1" style="color: #1e3a8a; letter-spacing: -1px;">Operational Hub</h2>
            <p class="text-muted mb-0 fw-bold small text-uppercase letter-spacing-1">
                Laboratory Staff Terminal • {{ date('l, d M Y') }}
            </p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="p-3 rounded-4 bg-white shadow-sm border-0 d-flex align-items-center gap-2">
                <span class="pulse-green"></span>
                <span class="fw-black text-success small">SYSTEM LIVE</span>
            </div>
        </div>
    </div>

    <!-- Staff Metrics Grid -->
    <div class="row g-4 mb-5 ba-animate d1">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 24px; background: #fff; border-left: 5px solid #3b82f6 !important;">
                <div class="card-body p-4">
                    <p class="small fw-bold text-muted mb-1 text-uppercase">Pending Tests</p>
                    <div class="d-flex justify-content-between align-items-end">
                        <h2 class="fw-black mb-0 text-dark">0</h2>
                        <div class="bg-soft-primary p-2 rounded-3 text-primary">
                            <i class="fa-solid fa-microscope"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 24px; background: #fff; border-left: 5px solid #10b981 !important;">
                <div class="card-body p-4">
                    <p class="small fw-bold text-muted mb-1 text-uppercase">Reports Ready</p>
                    <div class="d-flex justify-content-between align-items-end">
                        <h2 class="fw-black mb-0 text-dark">0</h2>
                        <div class="bg-soft-success p-2 rounded-3 text-success">
                            <i class="fa-solid fa-file-circle-check"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 24px; background: #fff; border-left: 5px solid #f59e0b !important;">
                <div class="card-body p-4">
                    <p class="small fw-bold text-muted mb-1 text-uppercase">Appointments Today</p>
                    <div class="d-flex justify-content-between align-items-end">
                        <h2 class="fw-black mb-0 text-dark">{{ $summary['today_appointments'] ?? 1 }}</h2>
                        <div class="bg-soft-warning p-2 rounded-3 text-warning">
                            <i class="fa-solid fa-calendar-day"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 24px; background: #1e3a8a; color: white;">
                <div class="card-body p-4">
                    <p class="small fw-bold text-white-50 mb-1 text-uppercase">Session Collection</p>
                    <div class="d-flex justify-content-between align-items-end">
                        <h2 class="fw-black mb-0 text-white">₹10</h2>
                        <div class="bg-white bg-opacity-20 p-2 rounded-3 text-white">
                            <i class="fa-solid fa-cash-register"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 ba-animate d2">
        <!-- Diagnostic Activities -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 32px; background: #fff;">
                <div class="card-header bg-white border-0 p-4 pb-0">
                    <h5 class="fw-black text-dark mb-0">Recent Diagnostic Activities</h5>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr class="text-muted extra-small text-uppercase fw-bold letter-spacing-1">
                                    <th class="border-0 ps-3">Patient</th>
                                    <th class="border-0">Investigation</th>
                                    <th class="border-0 text-center">Status</th>
                                    <th class="border-0 text-end pe-3">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPatients ?? [] as $patient)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="avatar-sm bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 32px; height: 32px; font-size: 12px;">
                                                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                                                </div>
                                                <span class="fw-bold text-dark">{{ $patient->name }}</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="text-muted small">Registration</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-soft-success text-success rounded-pill px-3 fw-bold" style="font-size: 10px;">Active</span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <span class="extra-small text-muted">{{ $patient->created_at->diffForHumans() }}</span>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <p class="text-muted mb-0">No active diagnostic activity detected.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Operational Tasks -->
            <div class="card border-0 shadow-sm" style="border-radius: 32px; background: #fff;">
                <div class="card-body p-4">
                    <h5 class="fw-black text-dark mb-3">Operational Tasks</h5>
                    <div class="d-flex align-items-center gap-3 p-3 rounded-4 bg-light text-muted">
                        <i class="fa-solid fa-list-check fs-4"></i>
                        <span class="small fw-bold">No pending tasks assigned.</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar Activity & Tasks -->
        <div class="col-lg-4">
            <!-- Live Network Activity -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 32px; background: #1e293b; color: white;">
                <div class="card-header border-0 bg-transparent p-4 pb-0 d-flex justify-content-between align-items-center">
                    <h5 class="fw-black mb-0">Live Network Activity</h5>
                    <span class="badge bg-success rounded-pill px-2 py-1 extra-small fw-bold shadow-sm">
                        <span class="pulse-white me-1"></span> LIVE
                    </span>
                </div>
                <div class="card-body p-4">
                    @forelse($recentPatients ?? [] as $patient)
                        <div class="p-3 rounded-4 bg-white bg-opacity-10 mb-3 border border-white border-opacity-10">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="fw-bold small text-white">New Patient Registered: {{ $patient->name }}</span>
                            </div>
                            <p class="extra-small text-white-50 mb-0">{{ $patient->created_at->diffForHumans() }}</p>
                        </div>
                    @empty
                        <p class="text-white-50 small text-center py-3">Monitoring network...</p>
                    @endforelse

                    {{-- Duplicate item as per user request --}}
                    @if(count($recentPatients ?? []) > 0)
                        <div class="p-3 rounded-4 bg-white bg-opacity-10 border border-white border-opacity-10 opacity-50">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <span class="fw-bold small text-white">Live Network Activity</span>
                            </div>
                            <p class="extra-small text-white-50 mb-0">Synchronizing nodes...</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Assigned Tasks -->
            <div class="card border-0 shadow-sm" style="border-radius: 32px; background: #fff;">
                <div class="card-body p-5 text-center">
                    <h5 class="fw-black text-dark mb-4">Assigned Tasks</h5>
                    <div class="bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-muted" style="width: 80px; height: 80px;">
                        <i class="fa-solid fa-clipboard-check fs-2"></i>
                    </div>
                    <p class="small fw-bold text-muted mb-0">No active tasks assigned.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 900; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .bg-soft-primary { background: rgba(59, 130, 246, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
    
    .pulse-green {
        display: inline-block; width: 8px; height: 8px;
        background: #10b981; border-radius: 50%;
        box-shadow: 0 0 0 rgba(16, 185, 129, 0.4);
        animation: pulse 2s infinite;
    }
    .pulse-white {
        display: inline-block; width: 6px; height: 6px;
        background: #fff; border-radius: 50%;
        box-shadow: 0 0 0 rgba(255, 255, 255, 0.4);
        animation: pulse-white 2s infinite;
    }
    @keyframes pulse {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }
    @keyframes pulse-white {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(255, 255, 255, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(255, 255, 255, 0); }
    }
</style>
@endsection
