@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Reference Network</h2>
            <p class="text-muted mb-0">Manage clinical referral partners and laboratory doctors.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary d-flex align-items-center justify-content-center gap-2 px-4 shadow-md hover-scale" style="border-radius: 14px; height: 52px; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border: none;" data-bs-toggle="modal" data-bs-target="#addDoctorModal">
                <i class="fa-solid fa-user-doctor fs-5"></i> 
                <span class="fw-bold">Register Doctor</span>
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-soft-success border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 16px;">
            <i class="fa-solid fa-circle-check fs-5 me-3"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- Doctors Table -->
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 border-0">Doctor Profile</th>
                        <th class="border-0">Specialization</th>
                        <th class="border-0">Contact Info</th>
                        <th class="border-0">Created At</th>
                        <th class="pe-4 border-0 text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($doctors as $doctor)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold" style="width:45px;height:45px;">
                                    {{ strtoupper(substr($doctor->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark mb-0">{{ $doctor->name }}</div>
                                    <div class="text-muted small" style="font-size:10px;">Network Partner</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge bg-soft-info text-info border-0 px-3">{{ $doctor->specialization ?: 'General Practitioner' }}</span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="small fw-bold text-dark"><i class="fa-solid fa-phone-volume me-2 text-primary opacity-50"></i>{{ $doctor->phone ?: 'No Phone' }}</span>
                                <span class="text-muted small" style="font-size: 11px;"><i class="fa-solid fa-envelope me-2 text-primary opacity-50"></i>{{ $doctor->email ?: 'No Email' }}</span>
                            </div>
                        </td>
                        <td>
                            <div class="text-muted small">{{ $doctor->created_at->format('d M, Y') }}</div>
                        </td>
                        <td class="pe-4 text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-white border shadow-none text-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editDoctorModal{{ $doctor->id }}" 
                                        title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <i class="fa-solid fa-user-doctor text-muted opacity-25 fs-1 mb-3"></i>
                            <p class="text-muted mb-0">No reference doctors registered in the network.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addDoctorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold mb-0" style="color: #1e3a8a;">Register New Doctor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.doctors.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Full Name</label>
                            <input type="text" name="name" class="form-control border-0 py-2 shadow-sm px-3" required placeholder="Dr. Enter Name" style="border-radius: 12px; background: #f8fafc;">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Specialization</label>
                            <input type="text" name="specialization" class="form-control border-0 py-2 shadow-sm px-3" placeholder="e.g. Cardiologist" style="border-radius: 12px; background: #f8fafc;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Phone</label>
                            <input type="text" name="phone" class="form-control border-0 py-2 shadow-sm px-3" placeholder="+91 ..." style="border-radius: 12px; background: #f8fafc;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Email</label>
                            <input type="email" name="email" class="form-control border-0 py-2 shadow-sm px-3" placeholder="email@example.com" style="border-radius: 12px; background: #f8fafc;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-md" style="border-radius: 12px; background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border: none;">Add to Network</button>
                </div>
            </form>
        </div>
    </div>
</div>

@foreach($doctors as $doctor)
<!-- Edit Modal -->
<div class="modal fade" id="editDoctorModal{{ $doctor->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-header border-0 p-4 pb-0">
                <h5 class="fw-bold mb-0" style="color: #1e3a8a;">Modify Doctor Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.doctors.update', $doctor->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Full Name</label>
                            <input type="text" name="name" value="{{ $doctor->name }}" class="form-control border-0 py-2 shadow-sm px-3" required style="border-radius: 12px; background: #f8fafc;">
                        </div>
                        <div class="col-12">
                            <label class="form-label small fw-bold text-muted text-uppercase">Specialization</label>
                            <input type="text" name="specialization" value="{{ $doctor->specialization }}" class="form-control border-0 py-2 shadow-sm px-3" placeholder="e.g. Pathologist" style="border-radius: 12px; background: #f8fafc;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Phone</label>
                            <input type="text" name="phone" value="{{ $doctor->phone }}" class="form-control border-0 py-2 shadow-sm px-3" style="border-radius: 12px; background: #f8fafc;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-muted text-uppercase">Email</label>
                            <input type="email" name="email" value="{{ $doctor->email }}" class="form-control border-0 py-2 shadow-sm px-3" style="border-radius: 12px; background: #f8fafc;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 fw-bold py-2 shadow-md" style="border-radius: 12px; background: #1e3a8a; border: none;">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

<style>
    .bg-soft-primary { background: rgba(37, 99, 235, 0.1); }
    .bg-soft-info { background: rgba(14, 165, 233, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .alert-soft-success { background-color: #dcfce7; color: #166534; }
    .btn-white { background: #fff; border-color: #e2e8f0; color: #475569; }
    .btn-white:hover { background: #f8fafc; color: #1e293b; }
    .hover-scale { transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1); }
    .hover-scale:hover { transform: translateY(-2px) scale(1.02); }
    .shadow-md { box-shadow: 0 4px 12px rgba(30, 58, 138, 0.15); }
    .hover-bg-light:hover { background-color: #f1f5f9; cursor: pointer; }
    .btn-soft-primary { background: rgba(30, 58, 138, 0.1); color: #1e3a8a; border: none; width: 28px; height: 28px; display: flex; align-items: center; justify-content: center; }
    .btn-soft-primary:hover { background: #1e3a8a; color: #fff; }
    .table thead th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 15px 10px; color: #64748b; }
    .table tbody td { padding: 15px 10px; }
</style>
@endsection
