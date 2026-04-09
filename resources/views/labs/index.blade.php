@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: #1f1140;">Lab Network Explorer</h2>
            <p class="text-muted mb-0">Browse and manage active laboratory spaces.</p>
        </div>
        @if(auth()->user()->role == 'admin')
        <a href="{{ route('admin.labs.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            + Provision New Lab Space
        </a>
        @endif
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead style="background: rgba(240, 244, 248, 0.5);">
                        <tr>
                            <th class="border-top-0 ps-4">Lab ID</th>
                            <th class="border-top-0">Designation</th>
                            <th class="border-top-0">Research Parameters / Details</th>
                            @if(auth()->user()->role == 'admin')
                            <th class="border-top-0 text-end pe-4">Controls</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($labs as $lab)
                        <tr>
                            <td class="ps-4 fw-bold" style="color: #6366f1;">#L{{ str_pad($lab->id, 3, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="stat-icon me-3" style="width: 40px; height: 40px; font-size: 16px; background: rgba(59, 130, 246, 0.1); color: #3b82f6;">
                                        L
                                    </div>
                                    <div class="fw-bold text-dark">{{ $lab->lab_name }}</div>
                                </div>
                            </td>
                            <td class="text-muted" style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ $lab->description ?? 'No specific parameters assigned.' }}
                            </td>
                            @if(auth()->user()->role == 'admin')
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.labs.edit', $lab->id) }}" class="btn btn-sm btn-warning text-white px-3 me-2" style="border-radius: 8px;">Reconfigure</a>
                                <form action="{{ route('admin.labs.destroy', $lab->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger px-3 shadow-none" style="border-radius: 8px;">Deactivate</button>
                                </form>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($labs->isEmpty())
            <div class="text-center p-5 text-muted">
                No active laboratory spaces found in the directory.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
