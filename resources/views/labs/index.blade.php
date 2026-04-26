@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
        <div>
            <h2 class="fw-extrabold mb-1" style="color: #1e3a8a; letter-spacing: -0.5px;">Facility Network</h2>
            <p class="text-muted mb-0">Browse and manage active laboratory spaces and specialized clinical units.</p>
        </div>
        @if(auth()->user()->role == 'admin')
        <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center gap-2 px-4 shadow-md hover-scale w-100 w-md-auto" style="border-radius: 14px; height: 52px; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border: none;" data-bs-toggle="modal" data-bs-target="#addLabModal">
            <i class="fa-solid fa-plus-circle fs-5"></i> 
            <span class="fw-bold">Provision Lab Space</span>
        </button>
        @endif
    </div>

    <!-- Labs Grid Layout -->
    <div class="row g-4">
        @forelse($labs as $lab)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: 24px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4">
                    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-center align-items-sm-start mb-4 gap-3">
                        <div class="avatar-lg bg-soft-primary text-primary rounded-4 d-flex align-items-center justify-content-center fw-bold" style="width: 56px; height: 56px; font-size: 20px;">
                            {{ strtoupper(substr($lab->lab_name, 0, 1)) }}
                        </div>
                        <div class="badge bg-soft-success text-success rounded-pill px-3 py-1">Operational</div>
                    </div>
                    
                    <div class="text-center text-sm-start">
                        <h5 class="fw-bold mb-1" style="color: #1e293b;">{{ $lab->lab_name }}</h5>
                        <p class="text-muted small mb-4" style="height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                            {{ $lab->description ?? 'No detailed configuration profile provided for this facility node.' }}
                        </p>
                    </div>

                    <div class="d-flex flex-column flex-sm-row align-items-center justify-content-between pt-3 border-top gap-3">
                        <div class="text-muted small fw-bold order-2 order-sm-1">ID: #L{{ str_pad($lab->id, 3, '0', STR_PAD_LEFT) }}</div>
                        @if(auth()->user()->role == 'admin')
                        <div class="d-flex gap-2 w-100 w-sm-auto justify-content-center justify-content-sm-end order-1 order-sm-2">
                            <a href="{{ route('admin.labs.edit', $lab->id) }}" class="btn btn-white border shadow-sm text-primary rounded-3 px-3" style="height: 40px; display: flex; align-items: center; gap: 8px;" title="Configure">
                                <i class="fa-solid fa-sliders"></i>
                                <span class="d-sm-none fw-bold small">Configure</span>
                            </a>
                            <form action="{{ route('admin.labs.destroy', $lab->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Deactivate this laboratory space?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-white border shadow-sm text-danger rounded-3 px-3" type="submit" style="height: 40px; display: flex; align-items: center; gap: 8px;" title="Deactivate">
                                    <i class="fa-solid fa-power-off"></i>
                                    <span class="d-sm-none fw-bold small">Deactivate</span>
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="card border-0 shadow-sm p-5" style="border-radius: 24px;">
                <i class="fa-solid fa-building-circle-exclamation text-muted opacity-25 fs-1 mb-3"></i>
                <h5 class="text-muted">No laboratory spaces defined.</h5>
                <p class="text-muted small">Provision a new facility space to begin operations.</p>
                @if(auth()->user()->role == 'admin')
                <div class="mt-3">
                    <button type="button" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm" data-bs-toggle="modal" data-bs-target="#addLabModal">Provision First Space</button>
                </div>
                @endif
            </div>
        </div>
        @endforelse
    </div>
</div>

<style>
    .bg-soft-primary { background: rgba(37, 99, 235, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .btn-white { background: #fff; border-color: #e2e8f0; color: #475569; }
    .btn-white:hover { background: #f8fafc; color: #1e293b; }
    .fw-extrabold { font-weight: 800; }
    .hover-scale { transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .hover-scale:hover { transform: translateY(-2px) scale(1.02); }
    .shadow-md { box-shadow: 0 4px 12px rgba(30, 58, 138, 0.15); }
</style>

<!-- Provision Lab Modal -->
<div class="modal fade" id="addLabModal" tabindex="-1" aria-labelledby="addLabModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 24px; overflow: hidden;">
            <div class="modal-header border-0 p-4 pb-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-soft-primary text-primary rounded-4 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                        <i class="fa-solid fa-plus-circle fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-extrabold" id="addLabModalLabel" style="color: #1e3a8a; letter-spacing: -0.2px;">Provision Lab Space</h5>
                        <p class="text-muted small mb-0">Initialize a new node in the facility network.</p>
                    </div>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form action="{{ route('admin.labs.store') }}" method="POST" id="addLabForm">
                    @csrf
                    <div class="mb-4">
                        <label for="lab_name" class="form-label fw-bold small text-muted">Laboratory Identifier / Name</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0 px-3" style="border-radius: 12px 0 0 12px;">
                                <i class="fa-solid fa-flask text-primary"></i>
                            </span>
                            <input type="text" class="form-control bg-light border-0 px-3" id="lab_name" name="lab_name" placeholder="e.g. Molecular Pathology Unit" style="border-radius: 0 12px 12px 0; height: 50px;" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold small text-muted">Facility Configuration / Description</label>
                        <textarea class="form-control bg-light border-0 px-3 pt-3" id="description" name="description" rows="3" placeholder="Define clinical focus, equipment profile, or node location..." style="border-radius: 12px;"></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light w-100 fw-bold py-3" data-bs-dismiss="modal" style="border-radius: 14px; background: #f1f5f9; color: #475569; border: none;">Cancel</button>
                        <button type="submit" class="btn btn-primary w-100 fw-bold py-3 shadow-sm hover-scale" style="border-radius: 14px; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border: none;">Initialize Space</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
