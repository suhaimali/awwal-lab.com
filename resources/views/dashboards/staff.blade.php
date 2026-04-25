@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Operational Hub</h2>
            <p class="text-muted mb-0">Laboratory Staff Terminal • {{ now()->format('l, d M Y') }}</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.patients.index') }}" class="btn btn-primary px-4 py-2 shadow-sm" style="border-radius: 12px;">
                <i class="fa-solid fa-user-plus me-2"></i> Register Patient
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-soft-primary p-2 me-3">
                            <i class="fa-solid fa-vials text-primary"></i>
                        </div>
                        <span class="text-muted small fw-bold text-uppercase">Pending Tests</span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $pendingReports }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-soft-success p-2 me-3">
                            <i class="fa-solid fa-clipboard-check text-success"></i>
                        </div>
                        <span class="text-muted small fw-bold text-uppercase">Reports Ready</span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $completedReportsToday }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-soft-warning p-2 me-3">
                            <i class="fa-solid fa-calendar-day text-warning"></i>
                        </div>
                        <span class="text-muted small fw-bold text-uppercase">Appointments Today</span>
                    </div>
                    <h3 class="fw-bold mb-0">{{ $todayBookings }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-soft-danger p-2 me-3">
                            <i class="fa-solid fa-microscope text-danger"></i>
                        </div>
                        <span class="text-muted small fw-bold text-uppercase">Session Collection</span>
                    </div>
                    <h3 class="fw-bold mb-0">₹{{ number_format($sessionCollection ?? 0, 0) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Recent Activities -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm" style="border-radius: 24px;">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-0">Recent Diagnostic Activities</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="ps-4 border-0 small text-uppercase">Patient</th>
                                    <th class="border-0 small text-uppercase">Investigation</th>
                                    <th class="border-0 small text-uppercase">Status</th>
                                    <th class="pe-4 border-0 text-end small text-uppercase">Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activities as $activity)
                                <tr>
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark">{{ $activity->title }}</div>
                                    </td>
                                    <td>
                                        <span class="text-muted small">{{ $activity->type == 'patient' ? 'Registration' : 'Transaction' }}</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-soft-primary text-primary rounded-pill px-3">Active</span>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <span class="text-muted small">{{ $activity->time->diffForHumans() }}</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Task List -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 24px;">
                <div class="card-header bg-white border-0 p-4">
                    <h5 class="fw-bold mb-0">Operational Tasks</h5>
                </div>
                <div class="card-body p-4 pt-0">
                    @forelse($tasks as $task)
                    <div class="d-flex align-items-center mb-4">
                        <div class="rounded-3 p-2 me-3" style="background: {{ $task->status == 'Completed' ? '#d1fae5' : '#fff3cd' }};">
                            <i class="fa-solid {{ $task->status == 'Completed' ? 'fa-check text-success' : 'fa-clock text-warning' }}"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark small">{{ $task->title }}</div>
                            <div class="text-muted" style="font-size: 11px;">Due: {{ $task->due_date ? $task->due_date->format('d M') : 'N/A' }}</div>
                        </div>
                    </div>
                    @empty
                    <p class="text-muted small">No pending tasks assigned.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background: rgba(37, 99, 235, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
    .bg-soft-danger { background: rgba(239, 68, 68, 0.1); }
</style>
    <!-- Live Updates Section -->
    <div class="row g-4 mt-2">
        <div class="col-12">
            <div class="card border-0 shadow-sm" style="border-radius: 24px;">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">Live Network Activity</h5>
                    <div class="badge bg-soft-success text-success rounded-pill px-3 py-2" style="font-size: 10px;">
                        <i class="fa-solid fa-circle-dot me-1 pulse-green"></i> LIVE
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="activity-list">
                        @foreach($activities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon" style="color: {{ $activity->icon_color }}; background: {{ $activity->icon_bg }};">
                                <i class="{{ $activity->icon }}"></i>
                            </div>
                            <div class="activity-details">
                                <div class="activity-title">{{ $activity->title }}</div>
                                <div class="activity-time">{{ $activity->time->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function loadActivities() {
    fetch('/dashboard?api=true')
        .then(r => r.json())
        .then(data => {
            const list = document.querySelector('.activity-list');
            if (data.activities && list) {
                list.innerHTML = data.activities.map(a => `
                    <div class="activity-item">
                        <div class="activity-icon" style="color: ${a.icon_color}; background: ${a.icon_bg};"><i class="${a.icon}"></i></div>
                        <div class="activity-details">
                            <div class="activity-title">${a.title}</div>
                            <div class="activity-time">${a.time_ago}</div>
                        </div>
                    </div>
                `).join('');
            }
        });
}

document.addEventListener('DOMContentLoaded', () => {
    setInterval(loadActivities, 45000);
});
</script>
<style>
.activity-list { display: flex; flex-direction: column; gap: 15px; }
.activity-item { display: flex; align-items: center; gap: 15px; padding: 5px; }
.activity-icon { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 16px; }
.activity-details { flex-grow: 1; }
.activity-title { font-weight: 600; color: #1e293b; font-size: 14px; }
.activity-time { font-size: 11px; color: #94a3b8; }
.pulse-green { animation: pulse 2s infinite; }
@keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.5; } 100% { opacity: 1; } }
</style>
@endpush
    <!-- Live Updates & Tasks Section -->
    <div class="row g-4 mt-2">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm" style="border-radius: 24px;">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">Live Network Activity</h5>
                    <div class="badge bg-soft-success text-success rounded-pill px-3 py-2" style="font-size: 10px;">
                        <i class="fa-solid fa-circle-dot me-1 pulse-green"></i> LIVE
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="activity-list">
                        @foreach($activities as $activity)
                        <div class="activity-item">
                            <div class="activity-icon" style="color: {{ $activity->icon_color }}; background: {{ $activity->icon_bg }};">
                                <i class="{{ $activity->icon }}"></i>
                            </div>
                            <div class="activity-details">
                                <div class="activity-title">{{ $activity->title }}</div>
                                <div class="activity-time">{{ $activity->time->diffForHumans() }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm" style="border-radius: 24px;">
                <div class="card-header bg-white border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-dark">Assigned Tasks</h5>
                    <a href="{{ route('admin.tasks.index') }}" class="btn btn-sm btn-light rounded-pill px-3 fw-bold text-primary border-0" style="font-size: 11px;">
                        View All
                    </a>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex flex-column gap-3">
                        @forelse($tasks ?? [] as $task)
                        <div class="p-3 rounded-4 border bg-light">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div class="fw-bold text-dark small">{{ $task->title }}</div>
                                <span class="badge bg-soft-warning text-warning" style="font-size: 9px;">{{ $task->status }}</span>
                            </div>
                            <p class="mb-0 text-muted small" style="font-size: 11px;">{{ $task->description }}</p>
                        </div>
                        @empty
                        <div class="text-center py-4 text-muted small">No active tasks assigned</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function loadActivities() {
    fetch('/dashboard?api=true')
        .then(r => r.json())
        .then(data => {
            const list = document.querySelector('.activity-list');
            if (data.activities && list) {
                list.innerHTML = data.activities.map(a => `
                    <div class="activity-item">
                        <div class="activity-icon" style="color: ${a.icon_color}; background: ${a.icon_bg};"><i class="${a.icon}"></i></div>
                        <div class="activity-details">
                            <div class="activity-title">${a.title}</div>
                            <div class="activity-time">${a.time_ago}</div>
                        </div>
                    </div>
                `).join('');
            }
        });
}

document.addEventListener('DOMContentLoaded', () => {
    setInterval(loadActivities, 15000); // 15s for Live feel
});
</script>
<style>
.activity-list { display: flex; flex-direction: column; gap: 15px; }
.activity-item { display: flex; align-items: center; gap: 15px; padding: 5px; }
.activity-icon { width: 40px; height: 40px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 16px; }
.activity-details { flex-grow: 1; }
.activity-title { font-weight: 600; color: #1e293b; font-size: 14px; }
.activity-time { font-size: 11px; color: #94a3b8; }
.pulse-green { animation: pulse 2s infinite; }
@keyframes pulse { 0% { opacity: 1; } 50% { opacity: 0.5; } 100% { opacity: 1; } }
</style>
@endpush
@endsection
