@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: #1f1140;">Operators Management</h2>
            <p class="text-muted mb-0">Control network access and roles.</p>
        </div>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary d-flex align-items-center gap-2">
            + Provision New Operator
        </a>
    </div>

    <div class="card">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead style="background: rgba(240, 244, 248, 0.5);">
                        <tr>
                            <th class="border-top-0 ps-4">ID</th>
                            <th class="border-top-0">Operator Name</th>
                            <th class="border-top-0">Email / Link</th>
                            <th class="border-top-0 text-center">Clearance Status</th>
                            <th class="border-top-0 text-end pe-4">System Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#{{ str_pad($user->id, 4, '0', STR_PAD_LEFT) }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px; border-radius: 8px; font-size: 14px; font-weight: bold; background: linear-gradient(135deg, #7c3aed 0%, #d946ef 100%) !important; box-shadow: none; border: none;">
                                        {{ substr($user->name, 0, 1) }}
                                    </div>
                                    <div class="fw-bold">{{ $user->name }}</div>
                                </div>
                            </td>
                            <td class="text-muted">{{ $user->email }}</td>
                            <td class="text-center">
                                @if($user->role == 'admin')
                                    <span class="badge bg-danger text-uppercase">Admin</span>
                                @elseif($user->role == 'staff')
                                    <span class="badge bg-warning text-uppercase">Staff</span>
                                @else
                                    <span class="badge bg-info text-uppercase">Student</span>
                                @endif
                            </td>
                            <td class="text-end pe-4">
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-warning text-white px-3 me-2" style="border-radius: 8px;">Modify</a>
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger px-3 shadow-none" style="border-radius: 8px;">Revoke</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if($users->isEmpty())
            <div class="text-center p-5 text-muted">
                No operators found in the system grid.
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
