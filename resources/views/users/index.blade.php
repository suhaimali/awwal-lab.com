@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Network Operators</h2>
            <p class="text-muted mb-0">Manage system access, roles, and administrative clearance.</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-sm" style="border-radius: 12px; height: 48px;">
                <i class="fa-solid fa-user-shield"></i> Provision Operator
            </a>
        </div>
    </div>

    <!-- Operators Table Card -->
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 border-0">Operator Identity</th>
                        <th class="border-0">Communication Link</th>
                        <th class="border-0 text-center">Clearance Status</th>
                        <th class="pe-4 border-0 text-end">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-soft-primary text-primary rounded-3 d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 45px; height: 45px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark mb-0">{{ $user->name }}</div>
                                    <div class="text-muted small">UID: #{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center text-muted small">
                                <i class="fa-solid fa-envelope-open me-2"></i> {{ $user->email }}
                            </div>
                        </td>
                        <td class="text-center">
                            @if($user->role == 'admin')
                                <span class="badge bg-soft-danger text-danger rounded-pill px-3">Master Admin</span>
                            @elseif($user->role == 'staff')
                                <span class="badge bg-soft-warning text-warning rounded-pill px-3">System Staff</span>
                            @else
                                <span class="badge bg-soft-info text-info rounded-pill px-3">Researcher</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-white border shadow-none text-primary" title="Modify Access"><i class="fa-solid fa-user-gear"></i></a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Revoke system access for this operator?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-white border shadow-none text-danger" type="submit" title="Revoke Access"><i class="fa-solid fa-user-xmark"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($users->isEmpty())
        <div class="card-body text-center py-5">
            <i class="fa-solid fa-users-slash text-muted opacity-25 fs-1 mb-3"></i>
            <p class="text-muted mb-0">No operators registered in the current network node.</p>
        </div>
        @endif
    </div>
</div>

<style>
    .bg-soft-primary { background: rgba(37, 99, 235, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-danger { background: rgba(239, 68, 68, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
    .bg-soft-info { background: rgba(14, 165, 233, 0.1); }
    .btn-white { background: #fff; border-color: #e2e8f0; color: #475569; }
    .btn-white:hover { background: #f8fafc; color: #1e293b; }
    .table thead th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 15px 10px; color: #64748b; }
    .table tbody td { padding: 15px 10px; }
</style>
@endsection
