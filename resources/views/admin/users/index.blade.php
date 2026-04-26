@extends('layouts.app')

@section('content')
<style>
/* ── Operators Management — Premium Blue & White ── */
@keyframes fadeUp {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.op-animate { animation: fadeUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }
.d1 { animation-delay: 0.1s; }
.d2 { animation-delay: 0.2s; }
.d3 { animation-delay: 0.3s; }

/* Hero Section */
.op-hero {
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
    border-radius: 30px;
    padding: 2.5rem;
    color: white;
    position: relative;
    overflow: hidden;
    box-shadow: 0 15px 35px rgba(30, 58, 138, 0.2);
    margin-bottom: 2rem;
}
.op-hero::after {
    content: '';
    position: absolute;
    top: -50px;
    right: -50px;
    width: 200px;
    height: 200px;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 50%;
}

/* Metric Cards */
.op-metric {
    background: #fff;
    border-radius: 24px;
    padding: 1.5rem;
    border: 1px solid #e2e8f0;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
}
.op-metric:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

/* Table Design */
.op-table-card {
    background: #fff;
    border-radius: 30px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    overflow: hidden;
}
.op-table thead th {
    background: #f8fafc;
    color: #64748b;
    font-size: 11px;
    text-transform: uppercase;
    letter-spacing: 1px;
    font-weight: 800;
    padding: 1.25rem 1rem;
    border: none;
}
.op-table tbody tr {
    transition: all 0.2s;
    border-bottom: 1px solid #f1f5f9;
}
.op-table tbody tr:hover {
    background: #f1f5f9;
}
.op-table td {
    padding: 1.25rem 1rem;
    vertical-align: middle;
    border: none;
}

/* Status Pill */
.status-pill {
    padding: 6px 12px;
    border-radius: 50px;
    font-size: 11px;
    font-weight: 800;
    text-transform: uppercase;
}
.status-pill-active { background: #dcfce7; color: #166534; }

/* Role Badge */
.role-badge {
    padding: 4px 10px;
    border-radius: 8px;
    font-size: 10px;
    font-weight: 700;
}
.role-admin { background: #eff6ff; color: #1e40af; }
.role-staff { background: #f0fdf4; color: #166534; }

/* Modals */
.op-modal .modal-content {
    border-radius: 35px;
    border: none;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
}
.op-modal .modal-header {
    border-bottom: none;
    padding: 2.5rem 2.5rem 1rem;
}
.op-modal .modal-body {
    padding: 1rem 2.5rem 2rem;
}
.op-modal .modal-footer {
    border-top: none;
    padding: 0 2.5rem 2.5rem;
}
.op-input {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 15px;
    padding: 0.75rem 1rem;
    transition: all 0.2s;
}
.op-input:focus {
    background: #fff;
    border-color: #3b82f6;
    box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
}

.perm-item {
    background: #f8fafc;
    border: 1.5px solid #e2e8f0;
    border-radius: 12px;
    padding: 10px;
    transition: all 0.2s;
    cursor: pointer;
    display: flex;
    align-items: center;
}
.perm-item:hover {
    border-color: #3b82f6;
    background: #eff6ff;
}
.perm-item .form-check-input {
    margin: 0;
    cursor: pointer;
}
.perm-item .form-check-label {
    margin-left: 10px;
    cursor: pointer;
    font-size: 11px;
    font-weight: 700;
}

/* User Avatar */
.user-avatar {
    width: 45px;
    height: 45px;
    border-radius: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 900;
    font-size: 18px;
    background: #eff6ff;
    color: #3b82f6;
    border: 1px solid #dbeafe;
}
</style>

<div class="container-fluid p-0">
    <!-- Hero Section -->
    <div class="op-hero op-animate">
        <div class="row align-items-center">
            <div class="col-md-7">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <a href="{{ route('dashboard') }}" class="btn btn-light rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                        <i class="fa-solid fa-arrow-left text-primary"></i>
                    </a>
                    <h2 class="fw-black mb-0">Operators Network</h2>
                </div>
                <p class="text-white-50 mb-0">Configure laboratory security tiers and operator access protocols.</p>
            </div>
            <div class="col-md-5 text-md-end mt-3 mt-md-0">
                <button type="button" class="btn btn-white fw-bold px-4 py-2 shadow-sm" style="border-radius: 15px; color: #1e3a8a;" data-bs-toggle="modal" data-bs-target="#addUserModal">
                    <i class="fa-solid fa-plus-circle me-2"></i> Register New Operator
                </button>
            </div>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm op-animate d1" style="border-radius: 15px; background: #dcfce7; color: #166534;">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 shadow-sm op-animate d1" style="border-radius: 15px; background: #fee2e2; color: #991b1b;">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger border-0 shadow-sm op-animate d1" style="border-radius: 15px; background: #fee2e2; color: #991b1b;">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li class="small">{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Metrics Row -->
    <div class="row g-4 mb-4 op-animate d1">
        <div class="col-md-6">
            <div class="op-metric d-flex align-items-center">
                <div class="rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; background: #eff6ff; color: #3b82f6;">
                    <i class="fa-solid fa-shield-halved fs-3"></i>
                </div>
                <div>
                    <h4 class="fw-black mb-0" style="color: #0f172a;">{{ $users->where('role', 'admin')->count() }}</h4>
                    <p class="text-muted small mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">Security Administrators</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="op-metric d-flex align-items-center">
                <div class="rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 60px; height: 60px; background: #f0fdf4; color: #10b981;">
                    <i class="fa-solid fa-user-doctor fs-3"></i>
                </div>
                <div>
                    <h4 class="fw-black mb-0" style="color: #0f172a;">{{ $users->where('role', 'staff')->count() }}</h4>
                    <p class="text-muted small mb-0 fw-bold text-uppercase" style="letter-spacing: 1px;">Laboratory Staff</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Table -->
    <div class="op-table-card op-animate d2">
        <div class="table-responsive">
            <table class="table op-table mb-0 align-middle">
                <thead>
                    <tr>
                        <th class="ps-4">Operator Identity</th>
                        <th>Network Designation</th>
                        <th>Clearance Role</th>
                        <th class="text-center">Protocol Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="user-avatar me-3">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark mb-0">{{ $user->name }}</div>
                                    <div class="text-muted small">ID: OPS-{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="text-dark small fw-bold">{{ $user->email }}</div>
                            <div class="text-muted" style="font-size: 10px;">{{ count($user->permissions ?? []) }} active protocols</div>
                        </td>
                        <td>
                            @if($user->role == 'admin')
                                <span class="role-badge role-admin">ADMINISTRATOR</span>
                            @else
                                <span class="role-badge role-staff">STAFF OPERATOR</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="status-pill status-pill-active">
                                <i class="fa-solid fa-circle me-1" style="font-size: 8px;"></i> Online
                            </span>
                        </td>
                        <td class="text-end pe-4">
                            <div class="d-flex justify-content-end gap-2">
                                <button type="button" class="btn btn-light text-primary" style="border-radius: 12px; width: 38px; height: 38px; border: 1px solid #e2e8f0;" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Archive this operator from the network?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-light text-danger" type="submit" style="border-radius: 12px; width: 38px; height: 38px; border: 1px solid #e2e8f0;">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center p-5 text-muted">
                            <i class="fa-solid fa-users-slash mb-3 fs-1 opacity-25"></i>
                            <p class="mb-0 fw-bold">No active operators detected in the network.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div class="modal fade op-modal" id="addUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-start">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-soft-success text-success" style="width: 50px; height: 50px; background: #f0fdf4;">
                        <i class="fa-solid fa-user-plus fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-black mb-0" style="color: #1e3a8a;">New Operator</h5>
                        <p class="text-muted mb-0 small">Access Protocol Initialization</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="fw-bold text-muted text-uppercase mb-2" style="font-size: 10px; letter-spacing: 1px;">Identity Configuration</label>
                        <div class="row g-3">
                            <div class="col-12">
                                <input type="text" name="name" class="form-control op-input" required placeholder="Full Operator Name">
                            </div>
                            <div class="col-12">
                                <input type="email" name="email" class="form-control op-input" required placeholder="Network Designation (Email)">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold text-muted text-uppercase mb-2" style="font-size: 10px; letter-spacing: 1px;">Initial Authorization</label>
                        <div class="row g-3">
                            <div class="col-md-7">
                                <input type="password" name="password" class="form-control op-input" required placeholder="Initial Security Key">
                            </div>
                            <div class="col-md-5">
                                <select name="role" class="form-select op-input">
                                    <option value="staff" selected>Staff Operator</option>
                                    <option value="admin">Admin Clearance</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="fw-bold text-muted text-uppercase mb-2 d-block" style="font-size: 10px; letter-spacing: 1px;">
                            <i class="fa-solid fa-shield-halved me-1 text-primary"></i> Privilege Assignment
                        </label>
                        <div class="row g-2">
                            @php
                                $perms = [
                                    'Control Center' => 'dashboard',
                                    'Registration Desk' => 'registration_desk',
                                    'Investigation Library' => 'investigation_library',
                                    'Reference Network' => 'reference_network',
                                    'Lab Bookings' => 'lab_bookings',
                                    'Test Reports' => 'diagnostic_reports',
                                    'Report Dispatch' => 'report_dispatch',
                                    'Financial & Sales Analysis' => 'financial_analysis',
                                    'Operational Tasks' => 'operational_tasks',
                                    'Infrastructure' => 'infrastructure',
                                    'Hardware Matrix' => 'hardware_matrix',
                                    'Facility Network' => 'facility_network',
                                    'Financial Treasury' => 'financial_treasury',
                                    'Payment Terminal' => 'payment_terminal',
                                    'Network Operators' => 'network_operators',
                                    'System Protocol' => 'system_protocol'
                                ];
                            @endphp
                            @foreach($perms as $label => $val)
                            <div class="col-6">
                                <div class="form-check form-switch perm-item">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $val }}" id="perm_add_{{ $val }}">
                                    <label class="form-check-label" for="perm_add_{{ $val }}">{{ $label }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-lg border-0" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">Initialize Access</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- ── Edit Modals (Moved Outside Table) ── --}}
@foreach($users as $user)
<div class="modal fade op-modal" id="editUserModal{{ $user->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-start">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center bg-soft-primary text-primary" style="width: 50px; height: 50px; background: #eff6ff;">
                        <i class="fa-solid fa-user-gear fs-4"></i>
                    </div>
                    <div>
                        <h5 class="fw-black mb-0" style="color: #1e3a8a;">Modify Operator</h5>
                        <p class="text-muted mb-0 small">Updating access protocol for {{ $user->name }}</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-4">
                        <label class="fw-bold text-muted text-uppercase mb-2" style="font-size: 10px; letter-spacing: 1px;">Identity Configuration</label>
                        <div class="row g-3">
                            <div class="col-12">
                                <input type="text" name="name" class="form-control op-input" value="{{ $user->name }}" required placeholder="Operator Name">
                            </div>
                            <div class="col-12">
                                <input type="email" name="email" class="form-control op-input" value="{{ $user->email }}" required placeholder="Network Designation (Email)">
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="fw-bold text-muted text-uppercase mb-2" style="font-size: 10px; letter-spacing: 1px;">Security Keys & Clearances</label>
                        <div class="row g-3">
                            <div class="col-md-7">
                                <input type="password" name="password" class="form-control op-input" placeholder="•••••••• (Leave blank to keep current)">
                            </div>
                            <div class="col-md-5">
                                <select name="role" class="form-select op-input">
                                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin Clearance</option>
                                    <option value="staff" {{ $user->role == 'staff' ? 'selected' : '' }}>Staff Operator</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="fw-bold text-muted text-uppercase mb-2 d-block" style="font-size: 10px; letter-spacing: 1px;">
                            <i class="fa-solid fa-shield-halved me-1 text-primary"></i> Access Matrix
                        </label>
                        <div class="row g-2">
                            @php
                                $perms = [
                                    'Control Center' => 'dashboard',
                                    'Registration Desk' => 'registration_desk',
                                    'Investigation Library' => 'investigation_library',
                                    'Reference Network' => 'reference_network',
                                    'Lab Bookings' => 'lab_bookings',
                                    'Test Reports' => 'diagnostic_reports',
                                    'Report Dispatch' => 'report_dispatch',
                                    'Financial & Sales Analysis' => 'financial_analysis',
                                    'Operational Tasks' => 'operational_tasks',
                                    'Infrastructure' => 'infrastructure',
                                    'Hardware Matrix' => 'hardware_matrix',
                                    'Facility Network' => 'facility_network',
                                    'Financial Treasury' => 'financial_treasury',
                                    'Payment Terminal' => 'payment_terminal',
                                    'Network Operators' => 'network_operators',
                                    'System Protocol' => 'system_protocol'
                                ];
                                $userPerms = $user->permissions ?? [];
                            @endphp
                            @foreach($perms as $label => $val)
                            <div class="col-6">
                                <div class="form-check form-switch perm-item">
                                    <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $val }}" id="perm_edit_{{ $user->id }}_{{ $val }}" {{ in_array($val, $userPerms) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="perm_edit_{{ $user->id }}_{{ $val }}">{{ $label }}</label>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Decline</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-5 fw-bold shadow-lg border-0" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">Update DB</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection
