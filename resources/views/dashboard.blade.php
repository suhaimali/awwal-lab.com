@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Control Center</h2>
            <p class="text-muted mb-0">Welcome back, <span class="fw-bold text-primary">{{ auth()->user()->name }}</span>. System integrity is 100%.</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-white shadow-sm border" style="border-radius: 12px;"><i class="fa-solid fa-calendar-day me-2 text-primary"></i> {{ date('D, M d Y') }}</button>
            <button class="btn btn-primary shadow-sm" style="border-radius: 12px;"><i class="fa-solid fa-download me-2"></i> Report Summary</button>
        </div>
    </div>

    <!-- Primary Metrics Grid -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card metric-card border-0 shadow-sm" style="background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%); border-radius: 24px; color: white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-white bg-opacity-25 rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-user-injured fs-4"></i>
                        </div>
                        <span class="badge bg-white bg-opacity-25 rounded-pill">+12%</span>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $totalPatients ?? 0 }}</h4>
                    <p class="mb-0 text-white-50 small text-uppercase fw-bold letter-spacing-1">Total Patients</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card metric-card border-0 shadow-sm" style="background: linear-gradient(135deg, #10b981 0%, #34d399 100%); border-radius: 24px; color: white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-white bg-opacity-25 rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-vials fs-4"></i>
                        </div>
                        <span class="badge bg-white bg-opacity-25 rounded-pill">+5%</span>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $testsCompleted ?? 0 }}</h4>
                    <p class="mb-0 text-white-50 small text-uppercase fw-bold letter-spacing-1">Tests Completed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card metric-card border-0 shadow-sm" style="background: linear-gradient(135deg, #8b5cf6 0%, #a78bfa 100%); border-radius: 24px; color: white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-white bg-opacity-25 rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-flask-vial fs-4"></i>
                        </div>
                        <span class="badge bg-white bg-opacity-25 rounded-pill">A+</span>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $totalLabs ?? 0 }}</h4>
                    <p class="mb-0 text-white-50 small text-uppercase fw-bold letter-spacing-1">Active Labs</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card metric-card border-0 shadow-sm" style="background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); border-radius: 24px; color: white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-white bg-opacity-25 rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-money-bill-transfer fs-4"></i>
                        </div>
                        <span class="badge bg-white bg-opacity-25 rounded-pill text-white">Pending</span>
                    </div>
                    <h4 class="fw-bold mb-1">₹{{ number_format((float)($pendingPayments ?? 0), 2) }}</h4>
                    <p class="mb-0 text-white-50 small text-uppercase fw-bold letter-spacing-1">Outstanding Revenue</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Activity Feed -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 24px;">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0" style="color: #1e293b;">Recent Laboratory Activity</h5>
                    <a href="{{ route('admin.patients.index') }}" class="btn btn-light btn-sm rounded-pill px-3">View All</a>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-0 ps-3">Patient</th>
                                    <th class="border-0">Tests</th>
                                    <th class="border-0">Visit Date</th>
                                    <th class="border-0">Status</th>
                                    <th class="border-0 text-end pe-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentPatients ?? [] as $patient)
                                    <tr>
                                        <td class="ps-3">
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 38px; height: 38px;">
                                                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                                                </div>
                                                <div class="fw-bold text-dark">{{ $patient->name }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            @php $tests = $patient->latestBooking->tests ?? []; @endphp
                                            <span class="badge bg-light text-muted border">{{ count($tests) }} Test(s)</span>
                                        </td>
                                        <td class="text-muted small">{{ \Carbon\Carbon::parse($patient->visit_date)->format('M d, Y') }}</td>
                                        <td>
                                            <span class="badge bg-soft-success text-success rounded-pill px-3">Active</span>
                                        </td>
                                        <td class="text-end pe-3">
                                            <a href="{{ route('admin.patients.show', $patient) }}" class="btn btn-sm btn-white border rounded-pill shadow-none"><i class="fa-solid fa-arrow-right"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="fa-solid fa-folder-open text-muted opacity-25 fs-1 mb-3"></i>
                                            <p class="text-muted mb-0">No recent network activity detected.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Access & Insights -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 24px; background: #fff;">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-4" style="color: #1e293b;">Quick Protocol</h5>
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.patients.create') }}" class="btn btn-primary d-flex align-items-center justify-content-between p-3" style="border-radius: 16px;">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-user-plus me-3 fs-5"></i>
                                <div class="text-start">
                                    <div class="fw-bold">New Registration</div>
                                    <div class="small opacity-75">Register a new patient</div>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right small"></i>
                        </a>
                        <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-primary d-flex align-items-center justify-content-between p-3" style="border-radius: 16px;">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-calendar-check me-3 fs-5"></i>
                                <div class="text-start">
                                    <div class="fw-bold">Laboratory Bookings</div>
                                    <div class="small opacity-75">Manage appointments</div>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right small"></i>
                        </a>
                        <a href="{{ route('admin.test-reports') }}" class="btn btn-outline-dark d-flex align-items-center justify-content-between p-3" style="border-radius: 16px;">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-file-waveform me-3 fs-5"></i>
                                <div class="text-start">
                                    <div class="fw-bold">Analysis Reports</div>
                                    <div class="small opacity-75">Generate clinical data</div>
                                </div>
                            </div>
                            <i class="fa-solid fa-chevron-right small"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Performance Insight -->
            <div class="card border-0 shadow-sm" style="border-radius: 24px; background: #1e293b; color: white;">
                <div class="card-body p-4 text-center">
                    <div class="avatar bg-white bg-opacity-10 text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px; border-radius: 20px;">
                        <i class="fa-solid fa-chart-line fs-3"></i>
                    </div>
                    <h5 class="fw-bold mb-1">System Efficiency</h5>
                    <p class="text-white-50 small mb-4">Your lab is performing 24% better than last month.</p>
                    <div class="progress mb-3" style="height: 8px; border-radius: 4px; background: rgba(255,255,255,0.1);">
                        <div class="progress-bar bg-success" role="progressbar" style="width: 84%; border-radius: 4px;"></div>
                    </div>
                    <div class="d-flex justify-content-between small fw-bold">
                        <span>84% Capacity</span>
                        <span class="text-success">Optimal</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .metric-card { transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s; cursor: pointer; }
    .metric-card:hover { transform: translateY(-8px); box-shadow: 0 20px 40px rgba(0,0,0,0.1); }
    .letter-spacing-1 { letter-spacing: 1px; }
    .bg-soft-primary { background: rgba(37, 99, 235, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .btn-white { background: #fff; border-color: #e2e8f0; color: #475569; }
    .btn-white:hover { background: #f8fafc; color: #1e293b; }
</style>
@endsection
