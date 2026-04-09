@extends('layouts.app')

@section('content')
<style>
    .dashboard-hero {
        background: linear-gradient(90deg, #d946ef 0%, #7c3aed 100%);
        color: #fff;
        border-radius: 24px;
        padding: 2.5rem 2rem 2rem 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 8px 32px rgba(124,58,237,0.08);
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .dashboard-hero h2 {
        font-weight: 800;
        font-size: 2.2rem;
        margin-bottom: 0.5rem;
    }
    .dashboard-hero p {
        font-size: 1.1rem;
        opacity: 0.95;
    }
    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }
    .dashboard-card {
        background: #fff;
        border-radius: 18px;
        box-shadow: 0 4px 24px rgba(217,70,239,0.08);
        padding: 2rem 1.5rem 1.5rem 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        position: relative;
        overflow: hidden;
        min-height: 170px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .dashboard-card:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 8px 32px rgba(217,70,239,0.13);
    }
    .dashboard-card .icon {
        font-size: 2.5rem;
        margin-bottom: 1rem;
        color: #d946ef;
        background: rgba(217,70,239,0.08);
        border-radius: 12px;
        padding: 0.5rem 0.8rem;
        display: inline-block;
    }
    .dashboard-card .label {
        font-size: 0.9rem;
        font-weight: 700;
        color: #7c3aed;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 0.2rem;
    }
    .dashboard-card .value {
        font-size: 2.1rem;
        font-weight: 800;
        color: #1f1140;
        margin-bottom: 0.3rem;
    }
    .dashboard-card .desc {
        font-size: 1rem;
        color: #10b981;
        font-weight: 600;
    }
    @media (max-width: 768px) {
        .dashboard-hero {
            padding: 1.5rem 1rem 1rem 1rem;
        }
        .dashboard-cards {
            gap: 1rem;
        }
        .dashboard-card {
            padding: 1.2rem 1rem 1rem 1rem;
        }
    }
</style>
<div class="container-fluid p-0">
    <div class="dashboard-hero">
        <h2>Admin Dashboard</h2>
        <p>Welcome back to the Suhaim Soft Lab control center, <b>{{ auth()->user()->name }}</b>.</p>
        <button class="btn btn-light mt-2 align-self-start" style="color:#7c3aed;font-weight:700;"><i class="fa fa-file-alt me-2"></i>Generate Report</button>
    </div>
    <div class="dashboard-cards">
        <div class="dashboard-card">
            <span class="icon"><i class="fa-solid fa-users"></i></span>
            <span class="label">Total Operators</span>
            <span class="value">{{ $totalUsers ?? '0' }}</span>
            <span class="desc">↑ Active in network</span>
        </div>
        <div class="dashboard-card">
            <span class="icon"><i class="fa-solid fa-flask"></i></span>
            <span class="label">Research Labs</span>
            <span class="value">{{ $totalLabs ?? '0' }}</span>
            <span class="desc">↑ Fully operational</span>
        </div>
        <div class="dashboard-card">
            <span class="icon"><i class="fa-solid fa-microscope"></i></span>
            <span class="label">Lab Assets</span>
            <span class="value">{{ $totalEquipment ?? '0' }}</span>
            <span class="desc" style="color:#f59e42;">→ Monitoring assets</span>
        </div>
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
    <div class="card" style="border-radius:18px;box-shadow:0 4px 24px rgba(16,185,129,0.08);">
        <div class="card-header d-flex justify-content-between align-items-center" style="background:linear-gradient(90deg,#10b981 0%,#7c3aed 100%);color:#fff;border-radius:18px 18px 0 0;">
            <span>Recent Network Activity</span>
            <span class="badge bg-light text-success">Live</span>
        </div>
        <div class="card-body">
            <p class="text-muted mb-0">No recent anomalies detected in the lab grid. Systems are optimal.</p>
        </div>
    </div>
</div>
@endsection
