@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Hardware Matrix</h2>
            <p class="text-muted mb-0">Track physical assets and hardware status across all laboratory facilities.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-sm" style="border-radius: 12px; height: 48px;" data-bs-toggle="modal" data-bs-target="#addEquipmentModal">
                <i class="fa-solid fa-plus-circle"></i> Register Asset
            </button>
        </div>
    </div>

    <!-- Premium Metrics Grid -->
    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); color: white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-white bg-opacity-25 rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-microscope"></i>
                        </div>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $equipment->count() }}</h3>
                    <p class="mb-0 text-white-50 small text-uppercase fw-bold letter-spacing-1">Registry Total</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 24px; background: #fff;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-soft-success text-success rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-circle-check"></i>
                        </div>
                        <span class="text-success small fw-bold">Active</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">{{ $equipment->whereIn('status', ['Available', 'Operational', 'Active'])->count() }}</h3>
                    <p class="mb-0 text-muted small text-uppercase fw-bold letter-spacing-1">Operational Units</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm" style="border-radius: 24px; background: #fff;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-soft-warning text-warning rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-screwdriver-wrench"></i>
                        </div>
                        <span class="text-warning small fw-bold">Critical</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark">{{ $equipment->whereIn('status', ['Maintenance', 'Repair'])->count() }}</h3>
                    <p class="mb-0 text-muted small text-uppercase fw-bold letter-spacing-1">Maintenance Queue</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Inventory Table Card -->
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
        <div class="card-header bg-white border-0 pt-4 px-4">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark">Hardware Inventory</h5>
                <div class="input-group bg-light border-0 rounded-pill px-3 py-1" style="width: 300px;">
                    <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-search text-muted"></i></span>
                    <input type="text" class="form-control bg-transparent border-0 shadow-none py-1 small" placeholder="Search assets...">
                </div>
            </div>
        </div>
        <div class="card-body p-0 mt-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 border-0">Asset Identity</th>
                            <th class="border-0">Hardware Module</th>
                            <th class="border-0">Facility Node</th>
                            <th class="border-0 text-center">Operational Status</th>
                            <th class="pe-4 border-0 text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($equipment as $item)
                        <tr>
                            <td class="ps-4">
                                <div class="fw-bold text-primary mb-0">#EQ-{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-muted small">Registered: {{ $item->created_at->format('M d, Y') }}</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar-xs bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 32px; height: 32px; font-size: 11px;">
                                        {{ strtoupper(substr($item->name, 0, 1)) }}
                                    </div>
                                    <div class="fw-bold text-dark">{{ $item->name }}</div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-muted border px-2 py-1" style="border-radius: 8px;">
                                    <i class="fa-solid fa-server me-1 text-primary"></i> {{ optional($item->lab)->lab_name ?? 'Standalone' }}
                                </span>
                            </td>
                            <td class="text-center">
                                @php
                                    $status = strtolower($item->status);
                                    $badgeClass = 'bg-soft-success text-success';
                                    if(in_array($status, ['maintenance', 'repair'])) $badgeClass = 'bg-soft-warning text-warning';
                                    if($status == 'inactive') $badgeClass = 'bg-soft-danger text-danger';
                                @endphp
                                <span class="badge {{ $badgeClass }} rounded-pill px-3">
                                    {{ strtoupper($item->status) }}
                                </span>
                            </td>
                            <td class="pe-4 text-end">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-white border shadow-none text-primary" data-bs-toggle="modal" data-bs-target="#editEquipmentModal{{ $item->id }}"><i class="fa-solid fa-pen-nib"></i></button>
                                    @if(auth()->user()->role == 'admin')
                                    <form action="{{ route('admin.equipment.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Archive asset from matrix?');">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-white border shadow-none text-danger" type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editEquipmentModal{{ $item->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
                                    <div class="modal-header border-0 px-4 pt-4 pb-0">
                                        <h5 class="modal-title fw-bold" style="color: #1e3a8a;">Modify Hardware Asset</h5>
                                        <button type="button" class="btn-close shadow-none p-3 bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form action="{{ route('admin.equipment.update', $item->id) }}" method="POST">
                                        @csrf @method('PUT')
                                        <div class="modal-body p-4">
                                            <div class="mb-4">
                                                <label class="form-label small fw-bold text-muted text-uppercase">Asset Name</label>
                                                <input type="text" name="name" value="{{ $item->name }}" class="form-control bg-light border-0 py-2 shadow-none rounded-4" required {{ auth()->user()->role == 'admin' ? '' : 'readonly' }}>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-bold text-muted text-uppercase">Facility Node</label>
                                                    <select name="lab_id" class="form-select bg-light border-0 py-2 shadow-none rounded-4" {{ auth()->user()->role == 'admin' ? '' : 'disabled' }}>
                                                        @foreach(\App\Models\Lab::all() as $lab)
                                                            <option value="{{ $lab->id }}" {{ $item->lab_id == $lab->id ? 'selected' : '' }}>{{ $lab->lab_name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-bold text-muted text-uppercase">Operational Status</label>
                                                    <select name="status" class="form-select bg-light border-0 py-2 shadow-none rounded-4">
                                                        <option value="Operational" {{ $item->status == 'Operational' ? 'selected' : '' }}>Operational</option>
                                                        <option value="Maintenance" {{ $item->status == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                                                        <option value="Repair" {{ $item->status == 'Repair' ? 'selected' : '' }}>Repair Required</option>
                                                        <option value="Available" {{ $item->status == 'Available' ? 'selected' : '' }}>Standby</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer border-0 px-4 pb-4 gap-2">
                                            <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none px-4" data-bs-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-primary px-5 fw-bold shadow-lg" style="border-radius: 12px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border: none;">Commit Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fa-solid fa-server text-muted opacity-25 fs-1 mb-3"></i>
                                <p class="text-muted mb-0">No hardware assets detected in the current node.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addEquipmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
            <div class="modal-header border-0 px-4 pt-4 pb-0">
                <h5 class="modal-title fw-bold" style="color: #1e3a8a;">New Asset Registration</h5>
                <button type="button" class="btn-close shadow-none p-3 bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.equipment.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Asset Name</label>
                        <input type="text" name="name" class="form-control bg-light border-0 py-2 shadow-none rounded-4" required placeholder="e.g., Centrifuge X1">
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Assign to Facility</label>
                            <select name="lab_id" class="form-select bg-light border-0 py-2 shadow-none rounded-4" required>
                                <option value="">Select Lab...</option>
                                @foreach(\App\Models\Lab::all() as $lab)
                                    <option value="{{ $lab->id }}">{{ $lab->lab_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Initial Status</label>
                            <select name="status" class="form-select bg-light border-0 py-2 shadow-none rounded-4" required>
                                <option value="Operational">Operational</option>
                                <option value="Available">Standby</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 gap-2">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none px-4" data-bs-dismiss="modal">Discard</button>
                    <button type="submit" class="btn btn-primary px-5 fw-bold shadow-lg" style="border-radius: 12px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border: none;">Register Asset</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background: rgba(37, 99, 235, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
    .bg-soft-danger { background: rgba(239, 68, 68, 0.1); }
    .letter-spacing-1 { letter-spacing: 1px; }
    .btn-white { background: #fff; border-color: #e2e8f0; color: #475569; }
    .btn-white:hover { background: #f8fafc; color: #1e293b; }
    .table thead th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 15px 10px; color: #64748b; }
    .table tbody td { padding: 15px 10px; }
</style>
@endsection
