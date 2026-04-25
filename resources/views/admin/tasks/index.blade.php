@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-black mb-1" style="color: #1e3a8a;">Operational Tasks</h2>
            <p class="text-muted mb-0">Manage clinical registrations, billing, and patient records.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-sm" style="border-radius: 12px; height: 48px;" data-bs-toggle="modal" data-bs-target="#addTaskModal">
                <i class="fa-solid fa-plus-circle"></i> New Task
            </button>
        </div>
    </div>

    <!-- Stats Summary Row -->
    <div class="row g-4 mb-4">
        @php
            $summaries = [
                ['label' => 'Awaiting', 'status' => 'Pending', 'color' => '#f59e0b', 'icon' => 'fa-clock'],
                ['label' => 'Active', 'status' => 'In Progress', 'color' => '#3b82f6', 'icon' => 'fa-spinner'],
                ['label' => 'Resolved', 'status' => 'Completed', 'color' => '#10b981', 'icon' => 'fa-circle-check'],
                ['label' => 'Critical', 'status' => 'Action Needed', 'color' => '#ef4444', 'icon' => 'fa-bolt']
            ];
        @endphp
        @foreach($summaries as $sum)
        <div class="col-md-3">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px; background: #fff;">
                <div class="card-body p-4 border-start border-4" style="border-color: {{ $sum['color'] }} !important;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small fw-bold text-uppercase letter-spacing-1 mb-1">{{ $sum['label'] }}</p>
                            <h3 class="fw-bold mb-0 text-dark">{{ $tasks->where('status', $sum['status'])->count() }}</h3>
                        </div>
                        <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 45px; height: 45px; background: {{ $sum['color'] }}15; color: {{ $sum['color'] }};">
                            <i class="fa-solid {{ $sum['icon'] }} fs-5"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Restored Table UI -->
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 border-0">Directive Information</th>
                        <th class="border-0">Category</th>
                        <th class="border-0">Assigned Operator</th>
                        <th class="border-0 text-center">Lifecycle</th>
                        <th class="border-0">Creation</th>
                        <th class="pe-4 border-0 text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tasks as $task)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark mb-0">{{ $task->title }}</div>
                            <div class="text-muted small" style="max-width: 400px; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden;">
                                {{ $task->description ?: 'No details provided.' }}
                            </div>
                        </td>
                        <td>
                            @if($task->type == 'Bug')
                                <span class="badge bg-soft-danger text-danger border-0 rounded-pill px-2" style="font-size: 10px;"><i class="fa-solid fa-bug me-1"></i> BUG</span>
                            @elseif($task->type == 'Maintenance')
                                <span class="badge bg-soft-info text-info border-0 rounded-pill px-2" style="font-size: 10px;"><i class="fa-solid fa-wrench me-1"></i> SERVICE</span>
                            @else
                                <span class="badge bg-soft-primary text-primary border-0 rounded-pill px-2" style="font-size: 10px;"><i class="fa-solid fa-thumbtack me-1"></i> DIRECTIVE</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center me-2 fw-bold" style="width: 32px; height: 32px; font-size: 11px;">
                                    {{ strtoupper(substr($task->assignedUser->name ?? 'U', 0, 1)) }}
                                </div>
                                <div class="fw-bold text-dark small">{{ $task->assignedUser->name ?? 'Unassigned' }}</div>
                            </div>
                        </td>
                        <td class="text-center">
                            @php
                                $status = $task->status;
                                $badgeClass = 'bg-soft-warning text-warning';
                                if($status == 'In Progress') $badgeClass = 'bg-soft-primary text-primary';
                                if($status == 'Completed') $badgeClass = 'bg-soft-success text-success';
                                if($status == 'Action Needed') $badgeClass = 'bg-soft-danger text-danger';
                            @endphp
                            <span class="badge {{ $badgeClass }} rounded-pill px-3">
                                {{ strtoupper($status) }}
                            </span>
                        </td>
                        <td>
                            <div class="small fw-bold text-dark mb-0">{{ $task->created_at->format('M d, Y') }}</div>
                            <div class="text-muted" style="font-size: 10px;">{{ $task->created_at->diffForHumans() }}</div>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-white border shadow-none text-primary" data-bs-toggle="modal" data-bs-target="#editTaskModal{{ $task->id }}"><i class="fa-solid fa-pen"></i></button>
                                <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Archive record?');" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-white border shadow-none text-danger"><i class="fa-solid fa-trash-can"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No tasks found in the ledger.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modals -->
@foreach($tasks as $task)
<div class="modal fade" id="editTaskModal{{ $task->id }}" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold" style="color: #1e3a8a;">Update Task</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.tasks.update', $task->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">TITLE</label>
                        <input type="text" name="title" value="{{ $task->title }}" class="form-control bg-light border-0 py-2 rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">DESCRIPTION</label>
                        <textarea name="description" class="form-control bg-light border-0 py-2 rounded-3" rows="3">{{ $task->description }}</textarea>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">TYPE</label>
                            <select name="type" class="form-select bg-light border-0 py-2 rounded-3">
                                <option value="Directive" {{ $task->type == 'Directive' ? 'selected' : '' }}>Directive</option>
                                <option value="Bug" {{ $task->type == 'Bug' ? 'selected' : '' }}>Bug</option>
                                <option value="Maintenance" {{ $task->type == 'Maintenance' ? 'selected' : '' }}>Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">STATUS</label>
                            <select name="status" class="form-select bg-light border-0 py-2 rounded-3">
                                <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Awaiting</option>
                                <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>Active</option>
                                <option value="Action Needed" {{ $task->status == 'Action Needed' ? 'selected' : '' }}>Critical</option>
                                <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Resolved</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">OPERATOR</label>
                            <select name="assigned_to" class="form-select bg-light border-0 py-2 rounded-3">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ $task->assigned_to == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">Update Task</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<div class="modal fade" id="addTaskModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="modal-title fw-bold" style="color: #1e3a8a;">New Operational Task</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.tasks.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">TITLE</label>
                        <input type="text" name="title" class="form-control bg-light border-0 py-2 rounded-3" required placeholder="Describe objective...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">DESCRIPTION</label>
                        <textarea name="description" class="form-control bg-light border-0 py-2 rounded-3" rows="3" placeholder="Technical specs..."></textarea>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">TYPE</label>
                            <select name="type" class="form-select bg-light border-0 py-2 rounded-3">
                                <option value="Directive">Directive</option>
                                <option value="Bug">Bug</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">STATUS</label>
                            <select name="status" class="form-select bg-light border-0 py-2 rounded-3">
                                <option value="Pending">Awaiting</option>
                                <option value="In Progress">Active</option>
                                <option value="Action Needed">Critical</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-muted">OPERATOR</label>
                            <select name="assigned_to" class="form-select bg-light border-0 py-2 rounded-3">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">Create Task</button>
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
    .bg-soft-info { background: rgba(6, 182, 212, 0.1); }
    .fw-black { font-weight: 900; }
    .btn-white { background: #fff; border-color: #e2e8f0; }
    .btn-white:hover { background: #f8fafc; }
    .table thead th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 15px 10px; color: #64748b; }
    .table tbody td { padding: 15px 10px; }
</style>
@endsection
