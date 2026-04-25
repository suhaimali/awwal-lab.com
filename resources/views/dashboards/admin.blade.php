@extends('layouts.app')

@section('content')
<style>
    /* Premium Dashboard Animations & Styles */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes float {
        0% { transform: translateY(0px); }
        50% { transform: translateY(-5px); }
        100% { transform: translateY(0px); }
    }
    
    @keyframes pulse-glow {
        0% { box-shadow: 0 0 0 0 rgba(217, 70, 239, 0.4); }
        70% { box-shadow: 0 0 0 10px rgba(217, 70, 239, 0); }
        100% { box-shadow: 0 0 0 0 rgba(217, 70, 239, 0); }
    }

    .animate-in {
        animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        opacity: 0;
    }
    
    /* Glassmorphism Hero Section */
    .dashboard-hero {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: #fff;
        border-radius: 28px;
        padding: 3rem 2.5rem;
        margin-bottom: 2.5rem;
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .dashboard-hero::before {
        content: '';
        position: absolute;
        top: -50%; left: -10%;
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }

    .hero-content {
        position: relative;
        z-index: 2;
    }
    
    .dashboard-hero h2 {
        font-weight: 800;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        letter-spacing: -0.5px;
    }
    
    .dashboard-hero p {
        font-size: 1.15rem;
        opacity: 0.9;
        max-width: 600px;
        line-height: 1.6;
    }

    .hero-btn {
        background: rgba(255, 255, 255, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: #fff;
        font-weight: 600;
        padding: 12px 24px;
        border-radius: 50px;
        transition: all 0.3s;
        backdrop-filter: blur(5px);
        position: relative;
        z-index: 2;
    }

    .hero-btn:hover {
        background: #fff;
        color: #1e40af;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }

    /* Modern Grid Layout */
    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }
    
    .dashboard-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.03);
        padding: 2rem;
        display: flex;
        flex-direction: column;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 1;
    }
    
    .dashboard-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(37, 99, 235, 0.12);
        background: #fff;
    }

    .dashboard-card::after {
        content: '';
        position: absolute;
        top: 0; right: 0; bottom: 0; left: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.4) 0%, rgba(255,255,255,0) 100%);
        z-index: -1;
    }

    .card-top {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.5rem;
    }
    
    .dashboard-card .icon-wrapper {
        width: 54px;
        height: 54px;
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        transition: transform 0.3s;
    }

    .dashboard-card:hover .icon-wrapper {
        animation: float 2s infinite ease-in-out;
    }
    
    .dashboard-card .label {
        font-size: 0.85rem;
        font-weight: 700;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 1.2px;
    }
    
    .dashboard-card .value {
        font-size: 2.2rem;
        font-weight: 800;
        color: #0f172a;
        margin-bottom: 0.5rem;
        line-height: 1.2;
    }
    
    .dashboard-card .desc {
        font-size: 0.95rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .trend-up { color: #10b981; background: rgba(16, 185, 129, 0.1); padding: 4px 8px; border-radius: 20px; font-size: 0.8rem; }
    .trend-down { color: #f43f5e; background: rgba(244, 63, 94, 0.1); padding: 4px 8px; border-radius: 20px; font-size: 0.8rem; }
    .trend-neutral { color: #3b82f6; background: rgba(59, 130, 246, 0.1); padding: 4px 8px; border-radius: 20px; font-size: 0.8rem; }

    /* Custom Colors for Cards - ALL BLUE AND WHITE NOW */
    .c-purple .icon-wrapper { background: linear-gradient(135deg, #60a5fa, #2563eb); color: #fff; box-shadow: 0 8px 16px rgba(37, 99, 235, 0.2); }
    .c-blue .icon-wrapper { background: linear-gradient(135deg, #93c5fd, #3b82f6); color: #fff; box-shadow: 0 8px 16px rgba(59, 130, 246, 0.2); }
    .c-green .icon-wrapper { background: linear-gradient(135deg, #bfdbfe, #1d4ed8); color: #fff; box-shadow: 0 8px 16px rgba(29, 78, 216, 0.2); }
    .c-orange .icon-wrapper { background: linear-gradient(135deg, #3b82f6, #1e40af); color: #fff; box-shadow: 0 8px 16px rgba(30, 64, 175, 0.2); }
    .c-pink .icon-wrapper { background: linear-gradient(135deg, #eff6ff, #60a5fa); color: #1e3a8a; box-shadow: 0 8px 16px rgba(96, 165, 250, 0.2); }

    /* Activity Panel */
    .activity-panel {
        background: #fff;
        border-radius: 24px;
        padding: 2rem;
        box-shadow: 0 10px 30px rgba(0,0,0,0.03);
        border: 1px solid #f1f5f9;
    }

    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .panel-title {
        font-size: 1.3rem;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .live-indicator {
        width: 10px; height: 10px;
        background: #10b981;
        border-radius: 50%;
        animation: pulse-glow 2s infinite;
    }

    .activity-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.2s;
    }
    
    .activity-item:last-child { border-bottom: none; }

    .activity-icon {
        width: 40px; height: 40px;
        border-radius: 50%;
        background: #f8fafc;
        display: flex; align-items: center; justify-content: center;
        margin-right: 1rem;
        color: #64748b;
    }

    .activity-details { flex-grow: 1; }
    .activity-title { font-weight: 600; color: #1e293b; margin-bottom: 2px; }
    .activity-time { font-size: 0.85rem; color: #94a3b8; }

    @media (max-width: 992px) {
        .dashboard-hero { flex-direction: column; text-align: center; gap: 1.5rem; }
        .hero-btn { align-self: center; }
    }
</style>

<div class="container-fluid p-0">
    <!-- Hero Section -->
    <div class="dashboard-hero animate-in" style="animation-delay: 0ms;">
        <div class="hero-content">
            <h2>Welcome Back, {{ auth()->user()->name }}</h2>
            <p>Your Suhaim Soft Lab control center is fully operational. Here's a summary of what's happening today.</p>
        </div>
    </div>

    <!-- Metrics Grid -->
    <div class="dashboard-cards">
        
        <!-- Card 1 -->
        <div class="dashboard-card c-purple animate-in" style="animation-delay: 100ms;">
            <div class="card-top">
                <span class="label">Total Operators</span>
                <div class="icon-wrapper"><i class="fa-solid fa-users"></i></div>
            </div>
            <div class="value">{{ $totalUsers ?? '0' }}</div>
            <div class="desc"><span class="trend-up"><i class="fa-solid fa-arrow-up me-1"></i> Active</span> network operators</div>
        </div>

        <!-- Card 2 -->
        <div class="dashboard-card c-blue animate-in" style="animation-delay: 200ms;">
            <div class="card-top">
                <span class="label">Research Labs</span>
                <div class="icon-wrapper"><i class="fa-solid fa-flask"></i></div>
            </div>
            <div class="value">{{ $totalLabs ?? '0' }}</div>
            <div class="desc"><span class="trend-up"><i class="fa-solid fa-check-circle me-1"></i> 100%</span> operational</div>
        </div>

        <!-- Card 3 -->
        <div class="dashboard-card c-orange animate-in" style="animation-delay: 300ms;">
            <div class="card-top">
                <span class="label">Total Patients</span>
                <div class="icon-wrapper"><i class="fa-solid fa-user-injured"></i></div>
            </div>
            <div class="value">{{ $totalPatients ?? '0' }}</div>
            <div class="desc"><span class="trend-neutral"><i class="fa-solid fa-minus me-1"></i> Steady</span> new registrations</div>
        </div>

        <!-- Card 4 -->
        <div class="dashboard-card c-green animate-in" style="animation-delay: 400ms;">
            <div class="card-top">
                <span class="label">System Efficiency</span>
                <div class="icon-wrapper"><i class="fa-solid fa-bolt"></i></div>
            </div>
            <div class="value">{{ $performanceScore ?? 'A+' }}</div>
            <div class="desc"><span class="trend-up"><i class="fa-solid fa-arrow-up me-1"></i> Optimal</span> performance</div>
        </div>

        <!-- Card 5 -->
        <div class="dashboard-card c-pink animate-in" style="animation-delay: 500ms;">
            <div class="card-top">
                <span class="label">System Income</span>
                <div class="icon-wrapper"><i class="fa-solid fa-sack-dollar"></i></div>
            </div>
            <div class="value">₹{{ $systemIncome ?? '0.00' }}</div>
            <div class="desc"><span class="trend-up"><i class="fa-solid fa-arrow-up me-1"></i> 12%</span> vs last month</div>
        </div>

        <!-- Card 6 -->
        <div class="dashboard-card c-blue animate-in" style="animation-delay: 600ms;">
            <div class="card-top">
                <span class="label">Tests Completed</span>
                <div class="icon-wrapper"><i class="fa-solid fa-vials"></i></div>
            </div>
            <div class="value">{{ $testsCompleted ?? '0' }}</div>
            <div class="desc"><span class="trend-up"><i class="fa-solid fa-arrow-up me-1"></i> High</span> testing volume</div>
        </div>
    </div>

    <!-- ═══════════════════════════════════════════════════════════ -->
    <!--  COMMAND CENTER — 3-Column Live Layout                     -->
    <!-- ═══════════════════════════════════════════════════════════ -->
    <div class="row g-4 animate-in" style="animation-delay: 700ms;">

        <!-- ── Col 1: Live Network Activity ─────────────────────── -->
        <div class="col-12 col-xl-5">
            <div class="h-100" style="background:#fff; border-radius:24px; box-shadow:0 8px 32px rgba(30,58,138,0.06); border:1px solid #e8f0fe; overflow:hidden;">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center px-4 pt-4 pb-3" style="border-bottom:1px solid #f1f5f9;">
                    <div class="d-flex align-items-center gap-3">
                        <div style="width:10px;height:10px;background:#10b981;border-radius:50%;box-shadow:0 0 0 4px rgba(16,185,129,.15);animation:pulse-glow 2s infinite;"></div>
                        <span class="fw-black" style="font-size:15px;color:#0f172a;">Live Network Activity</span>
                    </div>
                    <span class="badge rounded-pill px-3 py-2 fw-bold" style="background:#eff6ff;color:#2563eb;font-size:10px;letter-spacing:.5px;">REALTIME</span>
                </div>
                <!-- Activity List -->
                <div class="activity-list px-2 py-2">
                    @forelse($activities ?? [] as $activity)
                    <div class="activity-item d-flex align-items-center px-3 py-3 rounded-3 mx-1 my-1" style="transition:background .2s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <div class="rounded-3 d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                             style="width:40px;height:40px;background:{{ $activity->icon_bg ?? '#eff6ff' }};color:{{ $activity->icon_color ?? '#2563eb' }};">
                            <i class="{{ $activity->icon ?? 'fa-solid fa-circle-dot' }}"></i>
                        </div>
                        <div class="flex-grow-1 min-w-0">
                            <div class="fw-bold text-dark small text-truncate">{{ $activity->title }}</div>
                            <div class="text-muted" style="font-size:11px;">{{ $activity->time->diffForHumans() }}</div>
                        </div>
                        <div class="flex-shrink-0 ms-2">
                            <span class="badge rounded-pill" style="background:#f0fdf4;color:#16a34a;font-size:9px;padding:4px 8px;">New</span>
                        </div>
                    </div>
                    @empty
                    <div class="d-flex flex-column align-items-center justify-content-center py-5 text-muted">
                        <i class="fa-solid fa-satellite-dish fs-2 mb-3 opacity-25"></i>
                        <div class="fw-bold small">No recent activity</div>
                        <div style="font-size:11px;">Waiting for network events...</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- ── Col 2: Backup Manager ─────────────────────────────── -->
        <div class="col-12 col-xl-4">
            <div class="h-100 d-flex flex-column" style="background:linear-gradient(160deg,#1e3a8a 0%,#0f172a 100%);border-radius:24px;box-shadow:0 8px 32px rgba(30,58,138,.25);overflow:hidden;color:#fff;">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center px-4 pt-4 pb-3" style="border-bottom:1px solid rgba(255,255,255,.08);">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:36px;height:36px;background:rgba(99,179,237,.15);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-cloud-arrow-up text-info"></i>
                        </div>
                        <span class="fw-black" style="font-size:15px;">Backup Manager</span>
                    </div>
                    <button class="btn btn-sm fw-bold" style="background:rgba(255,255,255,.1);color:#93c5fd;border:1px solid rgba(255,255,255,.15);border-radius:10px;font-size:11px;" data-bs-toggle="modal" data-bs-target="#backupCenterModal">
                        <i class="fa-solid fa-expand me-1"></i>Full Panel
                    </button>
                </div>

                <!-- Last Backup Status -->
                <div class="px-4 pt-3">
                    <div class="d-flex align-items-center p-3 rounded-3" style="background:rgba(255,255,255,.07);">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0" style="width:40px;height:40px;background:rgba(16,185,129,.2);">
                            <i class="fa-solid fa-check-circle text-success" id="backupStatusIcon"></i>
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold small">Last Backup</div>
                            <div class="text-white-50 small" id="lastBackupTime" style="font-size:11px;">Loading...</div>
                        </div>
                        <span class="badge rounded-pill px-2 py-1 fw-bold" id="backupStatusBadge" style="background:rgba(16,185,129,.2);color:#10b981;font-size:9px;">...</span>
                    </div>
                </div>

                <!-- Stats Rows -->
                <div class="px-4 pt-3 flex-grow-1">
                    <div class="d-flex flex-column gap-2">
                        <div class="d-flex justify-content-between align-items-center px-3 py-2 rounded-3" style="background:rgba(255,255,255,.05);">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-database text-info small"></i>
                                <span class="small fw-bold">Database</span>
                            </div>
                            <span class="text-white-50 small fw-bold" id="dbSizeDisplay">--</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center px-3 py-2 rounded-3" style="background:rgba(255,255,255,.05);">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-folder text-warning small"></i>
                                <span class="small fw-bold">Storage Files</span>
                            </div>
                            <span class="text-white-50 small fw-bold" id="storageSizeDisplay">--</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center px-3 py-2 rounded-3" style="background:rgba(255,255,255,.05);">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-box-archive text-success small"></i>
                                <span class="small fw-bold">Backup Files</span>
                            </div>
                            <span class="text-white-50 small fw-bold" id="backupCountDisplay">--</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="px-4 pb-4 pt-3 d-flex gap-2">
                    <button class="btn flex-fill fw-bold py-2" id="quickBackupBtn"
                            style="background:rgba(59,130,246,.25);color:#93c5fd;border:1px solid rgba(59,130,246,.4);border-radius:12px;font-size:13px;"
                            onclick="createBackup()">
                        <i class="fa-solid fa-cloud-arrow-up me-1"></i> Backup Now
                    </button>
                    <button class="btn flex-fill fw-bold py-2"
                            style="background:rgba(255,255,255,.08);color:#e2e8f0;border:1px solid rgba(255,255,255,.15);border-radius:12px;font-size:13px;"
                            data-bs-toggle="modal" data-bs-target="#backupCenterModal">
                        <i class="fa-solid fa-rotate-left me-1"></i> Restore
                    </button>
                </div>
            </div>
        </div>

        <!-- ── Col 3: Operational Tasks ──────────────────────────── -->
        <div class="col-12 col-xl-3">
            <div class="h-100 d-flex flex-column" style="background:#fff;border-radius:24px;box-shadow:0 8px 32px rgba(30,58,138,.06);border:1px solid #e8f0fe;overflow:hidden;">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center px-4 pt-4 pb-3" style="border-bottom:1px solid #f1f5f9;">
                    <div class="d-flex align-items-center gap-2">
                        <div style="width:36px;height:36px;background:#eff6ff;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                            <i class="fa-solid fa-list-check text-primary"></i>
                        </div>
                        <span class="fw-black" style="font-size:15px;color:#0f172a;">Tasks</span>
                    </div>
                    <a href="{{ route('admin.tasks.index') }}" class="btn btn-sm fw-bold" style="background:#eff6ff;color:#2563eb;border-radius:10px;font-size:11px;border:none;">
                        View All <i class="fa-solid fa-arrow-right ms-1" style="font-size:9px;"></i>
                    </a>
                </div>

                <!-- Task List -->
                <div class="flex-grow-1 px-3 py-3 d-flex flex-column gap-2 overflow-auto" id="dashboardTaskList" style="max-height:340px;">
                    @forelse($tasks ?? [] as $task)
                    <div class="p-3 rounded-3 border-0 position-relative" style="background:#f8fafc;">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <div class="fw-bold text-dark small text-truncate pe-2">{{ $task->title }}</div>
                            <span class="badge rounded-pill flex-shrink-0"
                                  style="font-size:9px;background:{{ $task->status === 'Completed' ? '#f0fdf4' : '#fffbeb' }};color:{{ $task->status === 'Completed' ? '#16a34a' : '#b45309' }};">
                                {{ $task->status }}
                            </span>
                        </div>
                        <p class="mb-0 text-muted text-truncate" style="font-size:11px;">{{ $task->description }}</p>
                    </div>
                    @empty
                    <div class="d-flex flex-column align-items-center justify-content-center py-5 text-muted flex-grow-1">
                        <i class="fa-solid fa-circle-check fs-2 mb-3 opacity-20"></i>
                        <div class="fw-bold small">No active tasks</div>
                        <div style="font-size:11px;">All clear!</div>
                    </div>
                    @endforelse
                </div>

                <!-- Add Task Quick Link -->
                <div class="px-4 pb-4 pt-2">
                    <a href="{{ route('admin.tasks.index') }}" class="btn w-100 fw-bold py-2"
                       style="background:linear-gradient(135deg,#1e40af,#3b82f6);color:#fff;border-radius:12px;border:none;font-size:13px;">
                        <i class="fa-solid fa-plus me-1"></i> Add New Task
                    </a>
                </div>
            </div>
        </div>

    </div>{{-- /row --}}
</div>{{-- /container --}}


<!-- Full Backup Center Modal -->
<div class="modal fade" id="backupCenterModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 30px; overflow: hidden;">
            <div class="modal-header border-0 px-4 pt-4 pb-2" style="background: linear-gradient(135deg, #1e3a8a 0%, #0f172a 100%); color: white;">
                <div>
                    <h4 class="modal-title fw-black mb-1"><i class="fa-solid fa-server me-2 text-info"></i>Backup & Restore Center</h4>
                    <p class="text-white-50 small mb-0">Manage database backups, imports, exports and restorations.</p>
                </div>
                <button type="button" class="btn-close btn-close-white shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4" style="background: #f8fafc;">

                <!-- Action Cards Row -->
                <div class="row g-3 mb-4">
                    <!-- Create Backup -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; cursor: pointer;" onclick="createBackup()">
                            <div class="card-body text-center p-4">
                                <div class="rounded-4 d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px; background: rgba(59, 130, 246, 0.1);">
                                    <i class="fa-solid fa-cloud-arrow-up text-primary fs-4"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">Create Backup</h6>
                                <p class="text-muted small mb-0">Export full database to SQL file</p>
                            </div>
                        </div>
                    </div>
                    <!-- Import SQL -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; cursor: pointer;" onclick="document.getElementById('importSqlInput').click()">
                            <div class="card-body text-center p-4">
                                <div class="rounded-4 d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px; background: rgba(16, 185, 129, 0.1);">
                                    <i class="fa-solid fa-file-import text-success fs-4"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">Import SQL</h6>
                                <p class="text-muted small mb-0">Restore from an external .sql file</p>
                            </div>
                        </div>
                    </div>
                    <!-- Export CSV -->
                    <div class="col-md-4">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 20px; cursor: pointer;" data-bs-toggle="collapse" data-bs-target="#csvExportPanel">
                            <div class="card-body text-center p-4">
                                <div class="rounded-4 d-inline-flex align-items-center justify-content-center mb-3" style="width: 55px; height: 55px; background: rgba(245, 158, 11, 0.1);">
                                    <i class="fa-solid fa-file-csv text-warning fs-4"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-1">Export CSV</h6>
                                <p class="text-muted small mb-0">Download table data as CSV</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Hidden Import Input -->
                <form id="importForm" enctype="multipart/form-data" style="display: none;">
                    @csrf
                    <input type="file" id="importSqlInput" accept=".sql" onchange="importSqlFile(this)">
                </form>

                <!-- CSV Export Panel (Collapsible) -->
                <div class="collapse mb-4" id="csvExportPanel">
                    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                        <div class="card-body p-4">
                            <h6 class="fw-bold text-dark mb-3"><i class="fa-solid fa-table me-2 text-warning"></i>Select Table to Export</h6>
                            <div class="row g-2">
                                @php $tables = ['patients','bookings','reports','report_items','payments','test_types','test_parameters','test_categories','equipment','tasks','users','labs']; @endphp
                                @foreach($tables as $tbl)
                                <div class="col-md-3 col-6">
                                    <button class="btn btn-light btn-sm w-100 fw-bold py-2 border" style="border-radius: 10px;" onclick="exportCsv('{{ $tbl }}')">
                                        <i class="fa-solid fa-download me-1 opacity-50"></i> {{ ucfirst(str_replace('_', ' ', $tbl)) }}
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Message -->
                <div id="backupStatusMsg" class="alert border-0 shadow-sm d-none mb-4" style="border-radius: 16px;"></div>

                <!-- Backup Files List -->
                <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                    <div class="card-header bg-white border-0 p-4 d-flex justify-content-between align-items-center">
                        <h6 class="fw-bold text-dark mb-0"><i class="fa-solid fa-box-archive me-2 text-primary"></i>Backup History</h6>
                        <button class="btn btn-sm btn-light rounded-pill px-3 fw-bold" onclick="loadBackups()">
                            <i class="fa-solid fa-arrows-rotate me-1"></i> Refresh
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead style="background: #f1f5f9;">
                                    <tr>
                                        <th class="ps-4 border-0 small fw-bold text-muted text-uppercase" style="letter-spacing: 0.5px;">Filename</th>
                                        <th class="border-0 small fw-bold text-muted text-uppercase" style="letter-spacing: 0.5px;">Size</th>
                                        <th class="border-0 small fw-bold text-muted text-uppercase" style="letter-spacing: 0.5px;">Created</th>
                                        <th class="pe-4 border-0 small fw-bold text-muted text-uppercase text-end" style="letter-spacing: 0.5px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="backupTableBody">
                                    <tr>
                                        <td colspan="4" class="text-center py-5">
                                            <div class="spinner-border spinner-border-sm text-muted me-2"></div>
                                            <span class="text-muted">Loading backups...</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
const CSRF_TOKEN = '{{ csrf_token() }}';

// Load stats on page load
document.addEventListener('DOMContentLoaded', () => {
    loadStats();
    // Auto-refresh stats every 30 seconds
    setInterval(loadStats, 30000);
    // Auto-refresh activities every 15 seconds for a "Live" feel
    setInterval(loadActivities, 15000);
});

function loadActivities() {
    fetch('/dashboard?api=true') // We'll add this flag in controller
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

// Load backup modal data when opened
document.getElementById('backupCenterModal')?.addEventListener('shown.bs.modal', () => {
    loadBackups();
});

function loadStats() {
    fetch('/admin/backup/stats')
        .then(r => r.json())
        .then(data => {
            document.getElementById('lastBackupTime').textContent = data.last_backup_ago;
            document.getElementById('dbSizeDisplay').textContent = data.db_size;
            document.getElementById('storageSizeDisplay').textContent = data.storage_size;
            document.getElementById('backupCountDisplay').textContent = data.total_backups + ' files (' + data.total_size + ')';

            const badge = document.getElementById('backupStatusBadge');
            if (data.total_backups > 0) {
                badge.textContent = 'OK';
                badge.style.background = 'rgba(16, 185, 129, 0.2)';
                badge.style.color = '#10b981';
            } else {
                badge.textContent = 'NONE';
                badge.style.background = 'rgba(245, 158, 11, 0.2)';
                badge.style.color = '#f59e0b';
            }
        })
        .catch(() => {
            document.getElementById('lastBackupTime').textContent = 'Unable to load';
        });
}

function createBackup() {
    const btn = document.getElementById('quickBackupBtn');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Working...';
    }
    showStatus('Creating backup...', 'info');

    fetch('/admin/backup/create', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            showStatus(data.message, 'success');
            loadStats();
            loadBackups();
        } else {
            showStatus(data.message, 'danger');
        }
    })
    .catch(e => showStatus('Backup failed: ' + e.message, 'danger'))
    .finally(() => {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-download me-1"></i> Backup Now';
        }
    });
}

function importSqlFile(input) {
    if (!input.files.length) return;
    if (!confirm('This will overwrite existing data. Are you sure you want to import this SQL file?')) {
        input.value = '';
        return;
    }

    const formData = new FormData();
    formData.append('sql_file', input.files[0]);
    formData.append('_token', CSRF_TOKEN);

    showStatus('Importing SQL file...', 'info');

    fetch('/admin/backup/import', {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' },
        body: formData
    })
    .then(r => r.json())
    .then(data => {
        showStatus(data.message, data.success ? 'success' : 'danger');
        if (data.success) { loadStats(); loadBackups(); }
    })
    .catch(e => showStatus('Import failed: ' + e.message, 'danger'))
    .finally(() => { input.value = ''; });
}

function restoreBackup(filename) {
    if (!confirm('⚠️ WARNING: This will overwrite all current data with the backup. Continue?')) return;

    showStatus('Restoring from ' + filename + '...', 'info');

    fetch('/admin/backup/restore', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ backup_file: filename })
    })
    .then(r => r.json())
    .then(data => {
        showStatus(data.message, data.success ? 'success' : 'danger');
        if (data.success) loadStats();
    })
    .catch(e => showStatus('Restore failed: ' + e.message, 'danger'));
}

function deleteBackup(filename) {
    if (!confirm('Delete backup "' + filename + '"? This cannot be undone.')) return;

    fetch('/admin/backup/delete/' + encodeURIComponent(filename), {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN, 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        showStatus(data.message, data.success ? 'success' : 'danger');
        loadBackups();
        loadStats();
    })
    .catch(e => showStatus('Delete failed: ' + e.message, 'danger'));
}

function exportCsv(table) {
    window.location.href = '/admin/backup/export-csv?table=' + table;
}

function loadBackups() {
    const tbody = document.getElementById('backupTableBody');
    if (!tbody) return;

    tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4"><div class="spinner-border spinner-border-sm text-muted me-2"></div><span class="text-muted">Loading...</span></td></tr>';

    fetch('/admin/backup')
        .then(r => r.json())
        .then(data => {
            if (!data.backups.length) {
                tbody.innerHTML = `<tr><td colspan="4" class="text-center py-5">
                    <div class="mb-3"><i class="fa-solid fa-box-open text-muted opacity-25 fs-1"></i></div>
                    <p class="text-muted fw-bold mb-1">No Backups Found</p>
                    <p class="text-muted small">Click "Create Backup" to generate your first backup.</p>
                </td></tr>`;
                return;
            }

            tbody.innerHTML = data.backups.map(b => `
                <tr>
                    <td class="ps-4">
                        <div class="d-flex align-items-center">
                            <div class="rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; background: rgba(59, 130, 246, 0.1);">
                                <i class="fa-solid fa-file-code text-primary small"></i>
                            </div>
                            <div>
                                <div class="fw-bold text-dark small">${b.name}</div>
                            </div>
                        </div>
                    </td>
                    <td><span class="badge bg-light text-muted border px-2 py-1">${b.size_formatted}</span></td>
                    <td><span class="text-muted small">${b.date}</span></td>
                    <td class="pe-4 text-end">
                        <div class="d-flex justify-content-end gap-1">
                            <a href="/admin/backup/download/${encodeURIComponent(b.name)}" class="btn btn-sm btn-light border px-2" title="Download" style="border-radius: 8px;">
                                <i class="fa-solid fa-download text-primary small"></i>
                            </a>
                            <button class="btn btn-sm btn-light border px-2" onclick="restoreBackup('${b.name}')" title="Restore" style="border-radius: 8px;">
                                <i class="fa-solid fa-rotate-left text-success small"></i>
                            </button>
                            <button class="btn btn-sm btn-light border px-2" onclick="deleteBackup('${b.name}')" title="Delete" style="border-radius: 8px;">
                                <i class="fa-solid fa-trash-can text-danger small"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `).join('');
        })
        .catch(() => {
            tbody.innerHTML = '<tr><td colspan="4" class="text-center py-4 text-danger">Failed to load backups</td></tr>';
        });
}

function showStatus(msg, type) {
    const el = document.getElementById('backupStatusMsg');
    if (!el) return;
    const icons = { success: 'fa-circle-check', danger: 'fa-circle-exclamation', info: 'fa-spinner fa-spin' };
    const bgs = { success: '#dcfce7', danger: '#fee2e2', info: '#dbeafe' };
    const colors = { success: '#166534', danger: '#991b1b', info: '#1e40af' };

    el.className = 'alert border-0 shadow-sm mb-4';
    el.style.borderRadius = '16px';
    el.style.background = bgs[type] || bgs.info;
    el.style.color = colors[type] || colors.info;
    el.innerHTML = `<div class="d-flex align-items-center"><i class="fa-solid ${icons[type] || icons.info} fs-5 me-3"></i><div class="fw-bold">${msg}</div></div>`;
}
</script>
@endpush
