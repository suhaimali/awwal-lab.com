@extends('layouts.app')
@section('content')

<div class="container py-4" id="mainContainer">
    </style>

    <div class="d-flex justify-content-between align-items-center mb-2">
        <div>
            <h1 class="fw-bold text-primary mb-0">Patient Management</h1>
            <div class="text-muted" style="font-size:1.1rem;">Manage and view all patient records</div>
        </div>
        <a href="{{ route('patients.create') }}" class="btn btn-gradient-primary shadow"><i class="fa fa-user-plus me-2"></i> Add Patient</a>
    </div>
    <div class="mb-3">
        <span class="badge bg-gradient-primary" style="font-size:1rem; padding:10px 18px;">Total Patients: <b>{{ $patients->count() }}</b></span>
    </div>
    <form method="GET" class="mb-4 row g-2" id="filterForm">
        <div class="col-md-5">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or phone" class="form-control border-primary" />
        </div>
        <div class="col-md-3">
            <input type="date" name="date" value="{{ request('date') }}" class="form-control border-info" />
        </div>
        <div class="col-md-2">
            <button class="btn btn-info w-100 text-white" type="submit"><i class="fa fa-filter me-1"></i> Filter</button>
        </div>
    </style>

    </style>
    <script>
    function showLoadingAndDelay(e) {
        e.preventDefault();
        document.getElementById('filterBtn').style.display = 'none';
        document.getElementById('loadingSpinner').style.display = 'flex';
        setTimeout(function() {
            document.getElementById('filterForm').submit();
        }, 2000);
        return false;
    }
    </script>
    </form>
    <div class="table-responsive rounded shadow">
        <table class="table table-hover align-middle bg-white">
            <thead class="bg-gradient-primary text-white">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                <tr>
                    <td>{{ $patient->id }}</td>
                    <td class="fw-semibold">{{ $patient->name }}</td>
                    <td>{{ $patient->age }}</td>
                    <td><span class="badge bg-gradient-info text-white">{{ $patient->visit_date }}</span></td>
                    <td>
                        <a href="{{ route('patients.show', $patient) }}" class="btn btn-sm btn-outline-primary me-1"><i class="fa fa-eye"></i></a>
                        <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-outline-warning me-1"><i class="fa fa-edit"></i></a>
                        <form action="{{ route('patients.destroy', $patient) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete patient {{ $patient->name }}?');">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger" type="submit"><i class="fa fa-trash"></i></button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-2">No patients found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <!-- No pagination: showing all patients -->
</div>
<style>
.btn-gradient-primary {
    background: linear-gradient(90deg,#a78bfa,#f472b6);
    color: #fff;
    border: none;
}
.btn-gradient-primary:hover {
    background: linear-gradient(90deg,#f472b6,#a78bfa);
    color: #fff;
}
.bg-gradient-primary {
    background: linear-gradient(90deg,#a78bfa,#f472b6)!important;
    color: #fff!important;
}
.bg-gradient-info {
    background: linear-gradient(90deg,#60a5fa,#fbbf24)!important;
    color: #fff!important;
}
</style>
@endsection