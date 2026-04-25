@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Investigation Classes</h2>
            <p class="text-muted mb-0">Organize laboratory tests into logical diagnostic categories.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-sm" style="border-radius: 12px; height: 48px;" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fa-solid fa-plus-circle"></i> New Class
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-soft-success border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 16px; background: #dcfce7; color: #166534;">
            <i class="fa-solid fa-circle-check fs-5 me-3"></i> 
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- Category Grid -->
    <div class="row g-4 mb-4">
        @foreach($categories as $category)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 24px; transition: transform 0.2s;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-soft-primary text-primary rounded-3 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-layer-group fs-5"></i>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-link text-muted p-0 shadow-none" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis-vertical"></i></button>
                            <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg" style="border-radius: 12px;">
                                <li><a class="dropdown-item py-2" href="#" data-bs-toggle="modal" data-bs-target="#editModal{{ $category->id }}"><i class="fa-solid fa-pen me-2 text-warning"></i> Edit</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('admin.test-categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Delete this category?');">
                                        @csrf @method('DELETE')
                                        <button class="dropdown-item py-2 text-danger"><i class="fa-solid fa-trash-can me-2"></i> Delete</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">{{ $category->name }}</h5>
                    <p class="text-muted small mb-3" style="min-height: 40px;">{{ $category->description ?: 'No operational description provided.' }}</p>
                    <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                        <span class="badge {{ $category->status == 'Active' ? 'bg-soft-success text-success' : 'bg-soft-danger text-danger' }} rounded-pill px-3">
                            {{ $category->status }}
                        </span>
                        <div class="text-muted small fw-bold">#{{ $category->id }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @if($categories->isEmpty())
        <div class="col-12 text-center py-5">
            <i class="fa-solid fa-folder-open text-muted opacity-25 fs-1 mb-3"></i>
            <p class="text-muted mb-0">No classes defined in the current registry.</p>
        </div>
        @endif
    </div>
</div>

<!-- Modals -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
            <div class="modal-header border-0 px-4 pt-4 pb-0">
                <h5 class="modal-title fw-bold" style="color: #1e3a8a;">New Class Definition</h5>
                <button type="button" class="btn-close shadow-none p-3 bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.test-categories.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Class Identity</label>
                        <input type="text" name="name" class="form-control bg-light border-0 py-2 shadow-none rounded-4" required placeholder="e.g., Hematology, Biochemistry">
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Operational Scope</label>
                        <textarea name="description" class="form-control bg-light border-0 py-3 shadow-none rounded-4" rows="3" placeholder="Define the scope of this category..."></textarea>
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
                    <button type="submit" class="btn btn-primary px-5 fw-bold shadow-lg" style="border-radius: 12px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border: none;">Save Definition</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($categories as $category)
<div class="modal fade" id="editModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
            <div class="modal-header border-0 px-4 pt-4 pb-0">
                <h5 class="modal-title fw-bold" style="color: #1e3a8a;">Modify Definition</h5>
                <button type="button" class="btn-close shadow-none p-3 bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.test-categories.update', $category) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Class Identity</label>
                        <input type="text" name="name" class="form-control bg-light border-0 py-2 shadow-none rounded-4" value="{{ $category->name }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase">Operational Scope</label>
                        <textarea name="description" class="form-control bg-light border-0 py-3 shadow-none rounded-4" rows="3">{{ $category->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Status</label>
                        <select name="status" class="form-select bg-light border-0 py-2 shadow-none rounded-4">
                            <option value="Active" {{ $category->status == 'Active' ? 'selected' : '' }}>Operational (Active)</option>
                            <option value="Inactive" {{ $category->status == 'Inactive' ? 'selected' : '' }}>Suspended (Inactive)</option>
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
    .dropdown-item:hover { background-color: #f8fafc; color: #1e40af; }
</style>
@endsection
