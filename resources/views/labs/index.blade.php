@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Facility Network</h2>
            <p class="text-muted mb-0">Browse and manage active laboratory spaces and specialized clinical units.</p>
        </div>
        @if(auth()->user()->role == 'admin')
        <div class="d-flex gap-2">
            <a href="{{ route('admin.labs.create') }}" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-sm" style="border-radius: 12px; height: 48px;">
                <i class="fa-solid fa-plus-circle"></i> Provision Lab Space
            </a>
        </div>
        @endif
    </div>

    <!-- Labs Grid Layout -->
    <div class="row g-4">
        @forelse($labs as $lab)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: 24px; transition: transform 0.3s;" onmouseover="this.style.transform='translateY(-5px)'" onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div class="avatar-lg bg-soft-primary text-primary rounded-4 d-flex align-items-center justify-content-center fw-bold" style="width: 56px; height: 56px; font-size: 20px;">
                            {{ strtoupper(substr($lab->lab_name, 0, 1)) }}
                        </div>
                        <div class="badge bg-soft-success text-success rounded-pill px-3 py-1">Operational</div>
                    </div>
                    
                    <h5 class="fw-bold mb-1" style="color: #1e293b;">{{ $lab->lab_name }}</h5>
                    <p class="text-muted small mb-4" style="height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                        {{ $lab->description ?? 'No detailed configuration profile provided for this facility node.' }}
                    </p>

                    <div class="d-flex align-items-center justify-content-between pt-3 border-top">
                        <div class="text-muted small fw-bold">ID: #L{{ str_pad($lab->id, 3, '0', STR_PAD_LEFT) }}</div>
                        @if(auth()->user()->role == 'admin')
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.labs.edit', $lab->id) }}" class="btn btn-sm btn-white border shadow-none text-primary rounded-3" title="Configure"><i class="fa-solid fa-sliders"></i></a>
                            <form action="{{ route('admin.labs.destroy', $lab->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Deactivate this laboratory space?');">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-white border shadow-none text-danger rounded-3" type="submit" title="Deactivate"><i class="fa-solid fa-power-off"></i></button>
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
                    <a href="{{ route('admin.labs.create') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">Provision First Space</a>
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
</style>
@endsection
