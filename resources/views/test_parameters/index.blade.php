@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Investigation Parameters</h2>
            <p class="text-muted mb-0">Define clinical metrics, units, and reference ranges for diagnostic accuracy.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-sm" style="border-radius: 12px; height: 48px;" data-bs-toggle="modal" data-bs-target="#addParameterModal">
                <i class="fa-solid fa-microscope"></i> New Parameter
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-soft-success border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 16px; background: #dcfce7; color: #166534;">
            <i class="fa-solid fa-circle-check fs-5 me-3"></i> 
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- Parameter Table Card -->
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 border-0">Clinical Parameter</th>
                        <th class="border-0">Reference Unit</th>
                        <th class="border-0">Normal Range</th>
                        <th class="border-0 text-center">Lifecycle</th>
                        <th class="pe-4 border-0 text-end">Operations</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($parameters as $parameter)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-soft-primary text-primary rounded-3 d-flex align-items-center justify-content-center me-3 fw-bold" style="width: 40px; height: 40px;">
                                    {{ strtoupper(substr($parameter->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark mb-0">{{ $parameter->name }}</div>
                                    <div class="text-muted small">System ID: #{{ $parameter->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-light text-muted border px-3 py-1" style="border-radius: 8px;">{{ $parameter->unit ?: 'No Unit' }}</span>
                        </td>
                        <td>
                            <code class="bg-soft-info text-info px-2 py-1 rounded" style="font-size: 13px;">{{ $parameter->normal_range ?: 'Not Defined' }}</code>
                        </td>
                        <td class="text-center">
                            @if($parameter->status == 'Active')
                                <span class="badge bg-soft-success text-success rounded-pill px-3">Active</span>
                            @else
                                <span class="badge bg-soft-danger text-danger rounded-pill px-3">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-white border shadow-none text-primary" data-bs-toggle="modal" data-bs-target="#editModal{{ $parameter->id }}"><i class="fa-solid fa-pen-to-square"></i></button>
                                <form action="{{ route('admin.test-parameters.destroy', $parameter) }}" method="POST" class="d-inline" onsubmit="return confirm('Archive this parameter?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-white border shadow-none text-danger" type="submit"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fa-solid fa-list-check text-muted opacity-25 fs-1 mb-3"></i>
                            <p class="text-muted mb-0">No parameters defined in the clinical library.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="addParameterModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
            <div class="modal-header border-0 px-4 pt-4 pb-0">
                <h5 class="modal-title fw-bold" style="color: #1e3a8a;">New Clinical Metric</h5>
                <button type="button" class="btn-close shadow-none p-3 bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.test-parameters.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Parameter Name</label>
                        <input type="text" name="name" class="form-control bg-light border-0 py-2 shadow-none rounded-4" required placeholder="e.g., Hemoglobin, Glucose">
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Measurement Unit</label>
                            <input type="text" name="unit" class="form-control bg-light border-0 py-2 shadow-none rounded-4" placeholder="mg/dL, g/L...">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Normal Range</label>
                            <input type="text" name="normal_range" class="form-control bg-light border-0 py-2 shadow-none rounded-4" placeholder="70 - 110...">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Status</label>
                        <select name="status" class="form-select bg-light border-0 py-2 shadow-none rounded-4">
                            <option value="Active">Operational (Active)</option>
                            <option value="Inactive">Suspended (Inactive)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 gap-2">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none px-4" data-bs-dismiss="modal">Discard</button>
                    <button type="submit" class="btn btn-primary px-5 fw-bold shadow-lg" style="border-radius: 12px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border: none;">Save Metric</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($parameters as $parameter)
<div class="modal fade" id="editModal{{ $parameter->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
            <div class="modal-header border-0 px-4 pt-4 pb-0">
                <h5 class="modal-title fw-bold" style="color: #1e3a8a;">Modify Metric</h5>
                <button type="button" class="btn-close shadow-none p-3 bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.test-parameters.update', $parameter) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Parameter Name</label>
                        <input type="text" name="name" class="form-control bg-light border-0 py-2 shadow-none rounded-4" value="{{ $parameter->name }}" required>
                    </div>
                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Measurement Unit</label>
                            <input type="text" name="unit" class="form-control bg-light border-0 py-2 shadow-none rounded-4" value="{{ $parameter->unit }}">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Normal Range</label>
                            <input type="text" name="normal_range" class="form-control bg-light border-0 py-2 shadow-none rounded-4" value="{{ $parameter->normal_range }}">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Status</label>
                        <select name="status" class="form-select bg-light border-0 py-2 shadow-none rounded-4">
                            <option value="Active" {{ $parameter->status == 'Active' ? 'selected' : '' }}>Operational (Active)</option>
                            <option value="Inactive" {{ $parameter->status == 'Inactive' ? 'selected' : '' }}>Suspended (Inactive)</option>
                        </select>
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
@endforeach

<style>
    .bg-soft-primary { background: rgba(37, 99, 235, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-danger { background: rgba(239, 68, 68, 0.1); }
    .bg-soft-info { background: rgba(14, 165, 233, 0.1); }
    .btn-white { background: #fff; border-color: #e2e8f0; color: #475569; }
    .btn-white:hover { background: #f8fafc; color: #1e293b; }
    .table thead th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 15px 10px; color: #64748b; }
    .table tbody td { padding: 15px 10px; }
</style>
@endsection
