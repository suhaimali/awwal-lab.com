@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <!-- Header Section -->
    <div class="d-flex justify-content-between align-items-center mb-4 ba-animate">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Registration Desk</h2>
            <p class="text-muted mb-0">Clinical Registrations, Billing, and Patient Records</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-sm" 
                    style="border-radius: 14px; height: 50px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border: none;" 
                    data-bs-toggle="modal" data-bs-target="#addRegistrationModal">
                <i class="fa-solid fa-user-plus"></i> <span class="fw-bold">Advanced Registration</span>
            </button>
        </div>
    </div>

    <!-- Clinical Activity Bar -->
    <div class="row g-4 mb-5 ba-animate d1">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden h-100" style="border-radius: 20px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%); color: white;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-white bg-opacity-10 p-3 rounded-4">
                            <i class="fa-solid fa-users text-white fs-4"></i>
                        </div>
                        <h6 class="fw-bold text-white-50 small text-uppercase mb-0 letter-spacing-1">Total Patients</h6>
                    </div>
                    <div class="d-flex align-items-baseline gap-2">
                        <h2 class="fw-black mb-0 text-white">{{ number_format($summary['total_patients'] ?? 0) }}</h2>
                        <span class="text-white-50 small fw-bold">Records</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden h-100" style="border-radius: 20px; background: #fff;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-soft-success p-3 rounded-4">
                            <i class="fa-solid fa-calendar-day text-success fs-4"></i>
                        </div>
                        <h6 class="fw-black text-muted small text-uppercase mb-0 letter-spacing-1">Today's Intake</h6>
                    </div>
                    <div class="d-flex align-items-baseline gap-2">
                        <h2 class="fw-black mb-0 text-dark">{{ number_format($summary['today_appointments'] ?? 0) }}</h2>
                        <span class="text-success small fw-bold">Active Today</span>
                    </div>
                </div>
                <div class="bg-success" style="height: 4px; opacity: 0.1;"></div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm overflow-hidden h-100" style="border-radius: 20px; background: #fff;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="bg-soft-primary p-3 rounded-4">
                            <i class="fa-solid fa-calendar-check text-primary fs-4"></i>
                        </div>
                        <h6 class="fw-black text-muted small text-uppercase mb-0 letter-spacing-1">Upcoming Sessions</h6>
                    </div>
                    <div class="d-flex align-items-baseline gap-2">
                        <h2 class="fw-black mb-0 text-dark">{{ number_format($summary['upcoming_appointments'] ?? 0) }}</h2>
                        <span class="text-primary small fw-bold">Scheduled</span>
                    </div>
                </div>
                <div class="bg-primary" style="height: 4px; opacity: 0.1;"></div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card border-0 shadow-sm mb-4 ba-animate d2" style="border-radius: 24px; background: #fff;">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('admin.patients.index') }}" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <div class="input-group bg-light border-0 rounded-4 px-3">
                        <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-magnifying-glass text-primary"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-transparent border-0 shadow-none py-3" placeholder="Search by name, phone, or bill ID...">
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="date" name="date" value="{{ request('date') }}" class="form-control bg-light border-0 rounded-4 py-3 shadow-none fw-bold text-primary">
                </div>
                <div class="col-md-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary rounded-4 py-3 fw-bold w-100 shadow-sm" style="background: #1e3a8a; border: none;">
                            <i class="fa-solid fa-filter me-2"></i> Sync
                        </button>
                        <a href="{{ route('admin.patients.index') }}" class="btn btn-white border rounded-4 py-3 fw-bold w-50">
                            <i class="fa-solid fa-rotate"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-soft-success border-0 shadow-sm mb-4 d-flex align-items-center ba-animate" style="border-radius: 16px;">
            <i class="fa-solid fa-circle-check fs-5 me-3"></i>
            <div class="fw-bold">{{ session('success') }}</div>
        </div>
    @endif

    <!-- Registration Master Table -->
    <div class="card border-0 shadow-sm overflow-hidden ba-animate d3" style="border-radius: 28px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background: #f8fafc;">
                    <tr>
                        <th class="ps-4 border-0 py-4 text-uppercase small fw-black text-muted" style="letter-spacing: 1px;">Patient Identity</th>
                        <th class="border-0 py-4 text-uppercase small fw-black text-muted" style="letter-spacing: 1px;">Clinical Info</th>
                        <th class="border-0 py-4 text-center text-uppercase small fw-black text-muted" style="letter-spacing: 1px;">Status</th>
                        <th class="pe-4 border-0 py-4 text-end text-uppercase small fw-black text-muted" style="letter-spacing: 1px;">Desk Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                    <tr class="border-top">
                        <td class="ps-4 py-4">
                            <div class="d-flex align-items-center">
                                <div class="avatar-box me-3">
                                    @if($patient->photo)
                                        <img src="{{ Storage::url($patient->photo) }}" class="rounded-circle shadow-sm" style="width:50px;height:50px;object-fit:cover;border:2px solid #fff;">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center fw-black text-white" 
                                             style="width:50px;height:50px;background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%); font-size: 18px;">
                                            {{ strtoupper(substr($patient->name, 0, 1)) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 15px;">{{ $patient->name }}</h6>
                                    <p class="text-muted small mb-0">{{ $patient->age }}Y · {{ $patient->gender }} · <span class="fw-bold text-primary">{{ $patient->phone }}</span></p>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="mb-1 fw-bold text-dark small">{{ $patient->reference_dr_name ?: 'Direct/Self' }}</div>
                            <div class="badge bg-soft-primary text-primary border-0 rounded-pill px-3" style="font-size: 10px;">
                                <i class="fa-solid fa-stethoscope me-1"></i> Reference
                            </div>
                        </td>
                        <td class="text-center">
                            @if($patient->latestBooking)
                                <span class="badge rounded-pill px-3 py-2 fw-bold 
                                    @if($patient->latestBooking->status == 'Pending') bg-soft-warning text-warning @else bg-soft-success text-success @endif">
                                    {{ $patient->latestBooking->status }}
                                </span>
                            @else
                                <span class="badge bg-soft-secondary text-secondary rounded-pill px-3 py-2 fw-bold">Inactive</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <div class="d-flex justify-content-end gap-2">
                                <button class="btn btn-icon-premium text-primary" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editRegistrationModal{{ $patient->id }}"
                                        title="Modify Details">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button class="btn btn-icon-premium text-danger" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#deletePatientModal{{ $patient->id }}"
                                        title="Remove Record">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5">
                            <div class="opacity-25 mb-3">
                                <i class="fa-solid fa-user-clock fs-1"></i>
                            </div>
                            <h5 class="fw-bold text-muted">No clinical records found</h5>
                            <p class="text-muted small">Try adjusting your filters or initiate a new registration.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($patients->hasPages())
        <div class="card-footer bg-white p-4 border-0">
            {{ $patients->links() }}
        </div>
        @endif
    </div>
</div>

<style>
    .ba-animate { animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) both; }
    .d1 { animation-delay: 0.1s; }
    .d2 { animation-delay: 0.2s; }
    .d3 { animation-delay: 0.3s; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }

    .fw-black { font-weight: 900; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .extra-small { font-size: 10px; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px; }
    
    .bg-soft-primary { background: rgba(37, 99, 235, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    .bg-soft-warning { background: rgba(245, 158, 11, 0.1); }
    .bg-soft-danger  { background: rgba(239, 68, 68, 0.1); }
    .bg-soft-secondary { background: rgba(100, 116, 139, 0.1); }

    .btn-icon-premium {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        border: 1px solid #e2e8f0;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02);
    }
    .btn-icon-premium:hover {
        background: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    
    .btn-white { background: #fff; color: #1e3a8a; }
    .btn-white:hover { background: #f1f5f9; color: #1e3a8a; }

    .lab-test-container {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: #fff;
        padding: 15px;
        max-height: 250px;
        overflow-y: auto;
    }
    .lab-test-item {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        border-radius: 12px;
        transition: all 0.2s;
        cursor: pointer;
        margin-bottom: 6px;
        border: 1px solid transparent;
    }
    .lab-test-item:hover {
        background: #eff6ff;
        border-color: #dbeafe;
    }
    .lab-test-item input[type="checkbox"] {
        width: 20px;
        height: 20px;
        margin-right: 15px;
        cursor: pointer;
    }
    .lab-test-label {
        font-weight: 700;
        color: #1e293b;
        font-size: 14px;
        margin-bottom: 0;
        flex: 1;
    }
    .lab-test-price {
        color: #3b82f6;
        font-weight: 800;
        font-size: 14px;
    }

    /* Custom Scrollbar */
    .lab-test-container::-webkit-scrollbar { width: 6px; }
    .lab-test-container::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>

@push('scripts')
<script>
    function updateTotalBill(id) {
        const container = document.getElementById('testContainer' + (id === 'New' ? 'New' : id));
        if (!container) return;
        const checkboxes = container.querySelectorAll('input[type="checkbox"]:checked');
        let total = 0;
        checkboxes.forEach(cb => { total += parseFloat(cb.dataset.price); });
        
        const totalInput = document.getElementById('totalBill' + id);
        if (totalInput) {
            totalInput.value = total.toFixed(2);
            calculateBalance(id);
        }
    }

    function calculateBalance(id) {
        const total = parseFloat(document.getElementById('totalBill' + id).value) || 0;
        const discount = parseFloat(document.getElementById('discountAmount' + id).value) || 0;
        const advance = parseFloat(document.getElementById('advancePaid' + id).value) || 0;
        const balanceInput = document.getElementById('balanceDue' + id);
        if (balanceInput) {
            balanceInput.value = Math.max(0, total - discount - advance).toFixed(2);
        }
    }
</script>
@endpush

@include('patients.partials.modals')

@endsection