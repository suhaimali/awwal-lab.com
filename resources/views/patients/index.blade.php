@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color: #1e3a8a;">Registration Desk</h2>
            <p class="text-muted mb-0">Manage clinical registrations, billing, and patient records.</p>
        </div>
        <div class="d-flex gap-2">
            <button type="button" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-sm" style="border-radius: 12px; height: 48px;" data-bs-toggle="modal" data-bs-target="#addRegistrationModal">
                <i class="fa-solid fa-user-plus"></i> New Intake
            </button>
        </div>
    </div>

    <!-- Premium Metrics Grid -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-white bg-opacity-25 rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-file-invoice-dollar"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-0">₹{{ number_format($summary['total_bill'] ?? 0, 0) }}</h4>
                    <p class="mb-0 text-white-50 small text-uppercase fw-bold">Total Bill</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 24px; background: #fff;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-soft-danger text-danger rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-tag"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-0 text-dark">₹{{ number_format($summary['total_discount'] ?? 0, 0) }}</h4>
                    <p class="mb-0 text-muted small text-uppercase fw-bold">Discount</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 24px; background: #fff;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-soft-success text-success rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-hand-holding-dollar"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-0 text-dark">₹{{ number_format($summary['total_advance'] ?? 0, 0) }}</h4>
                    <p class="mb-0 text-muted small text-uppercase fw-bold">Advance</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="border-radius: 24px; background: #fff;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="icon-box bg-soft-warning text-warning rounded-3 d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="fa-solid fa-wallet"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-0 text-dark">₹{{ number_format($summary['total_balance'] ?? 0, 0) }}</h4>
                    <p class="mb-0 text-muted small text-uppercase fw-bold">Balance Due</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Premium Search Filters -->
    <div class="card border-0 shadow-sm mb-4" style="border-radius: 24px; background: #fff;">
        <div class="card-body p-4">
            <form method="GET" action="{{ route('admin.patients.index') }}" class="row g-3 align-items-end">
                <div class="col-md-5">
                    <label class="form-label small fw-bold text-uppercase text-primary" style="font-size: 10px; letter-spacing: 1px;">Patient Lookup</label>
                    <div class="input-group bg-light border-0 rounded-4 px-2">
                        <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-magnifying-glass text-primary"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control bg-transparent border-0 shadow-none py-2 px-1" placeholder="Name, phone, or bill ID...">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold text-uppercase text-primary" style="font-size: 10px; letter-spacing: 1px;">Registration Date</label>
                    <input type="date" name="date" value="{{ request('date') }}" class="form-control bg-light border-0 rounded-4 py-2 px-4 shadow-none fw-bold" style="color: #1e3a8a;">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary rounded-4 py-2 fw-bold w-100 shadow-sm" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border: none; height: 44px;">
                        <i class="fa-solid fa-filter me-2"></i> Filter
                    </button>
                </div>
                <div class="col-md-2">
                    <a href="{{ route('admin.patients.index') }}" class="btn btn-white border rounded-4 py-2 fw-bold w-100" style="height: 44px;">
                        <i class="fa-solid fa-rotate-left me-2"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-soft-success border-0 shadow-sm mb-4 d-flex align-items-center" style="border-radius: 16px;">
            <i class="fa-solid fa-circle-check fs-5 me-3"></i>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- Registration Table -->
    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 24px;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 border-0">Patient Profile</th>
                        <th class="border-0">Reference</th>
                        <th class="border-0">Investigations</th>
                        <th class="border-0">Financial Summary</th>
                        <th class="border-0 text-center">Status</th>
                        <th class="pe-4 border-0 text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center">
                                @if($patient->photo)
                                    <img src="{{ Storage::url($patient->photo) }}"
                                         class="rounded-circle shadow-sm border me-3"
                                         style="width:45px;height:45px;object-fit:cover;">
                                @else
                                    <div class="avatar-sm bg-soft-primary text-primary rounded-circle d-flex align-items-center justify-content-center me-3 fw-bold" style="width:45px;height:45px;">
                                        {{ strtoupper(substr($patient->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div class="fw-bold text-dark mb-0">{{ $patient->name }}</div>
                                    <div class="text-muted small" style="font-size:10px;">{{ $patient->age }}Y / {{ $patient->gender }} · <i class="fa-solid fa-phone-volume ms-1"></i> {{ $patient->phone }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="small fw-bold text-dark mb-0">{{ $patient->reference_dr_name ?: 'Self Referral' }}</div>
                            <div class="text-muted small">Dr. Reference</div>
                        </td>
                        <td>
                            @if($patient->latestBooking)
                                <div class="text-dark small fw-bold mb-1">{{ $patient->latestBooking->bill_no }}</div>
                                <div class="badge bg-soft-primary text-primary border-0 px-2" style="font-size: 10px;">
                                    <i class="fa-solid fa-vial me-1"></i> {{ count($patient->latestBooking->tests ?? []) }} Investigations
                                </div>
                            @else
                                <span class="text-muted small">No active tests</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex flex-column gap-1">
                                <div class="small fw-bold text-dark">₹{{ number_format($patient->latestBooking->total_amount ?? 0, 2) }}</div>
                                <div class="progress" style="height: 4px; width: 80px;">
                                    @php 
                                        $paid = $patient->latestBooking->advance_amount ?? 0;
                                        $total = $patient->latestBooking->total_amount ?? 1;
                                        $perc = ($paid / $total) * 100;
                                    @endphp
                                    <div class="progress-bar bg-success" style="width: {{ $perc }}%"></div>
                                </div>
                            </div>
                        </td>
                        <td class="text-center">
                            @php $bal = $patient->latestBooking->balance_amount ?? 0; @endphp
                            @if($bal <= 0)
                                <span class="badge bg-soft-success text-success rounded-pill px-3">Cleared</span>
                            @else
                                <span class="badge bg-soft-warning text-warning rounded-pill px-3">Pending ₹{{ number_format($bal, 0) }}</span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-white border shadow-none text-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editRegistrationModal{{ $patient->id }}"
                                        title="Edit">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <a href="{{ route('admin.patients.invoice', $patient->id) }}"
                                   class="btn btn-sm btn-white border shadow-none text-success" title="Print Invoice">
                                    <i class="fa-solid fa-file-pdf"></i>
                                </a>
                                <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST"
                                      onsubmit="return confirm('Delete this patient record?');" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm btn-white border shadow-none text-danger" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fa-solid fa-user-clock text-muted opacity-25 fs-1 mb-3"></i>
                            <p class="text-muted mb-0">No patient registrations detected in the network.</p>
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
    .letter-spacing-1 { letter-spacing: 1px; }
    .bg-soft-primary { background-color: rgba(37, 99, 235, 0.1); }
    .bg-soft-success { background-color: rgba(16, 185, 129, 0.1); }
    .bg-soft-danger { background-color: rgba(239, 68, 68, 0.1); }
    .bg-soft-warning { background-color: rgba(245, 158, 11, 0.1); }
    .alert-soft-success { background-color: #dcfce7; color: #166534; }
    .table thead th { font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px; padding: 15px 10px; color: #64748b; }
    .table tbody td { padding: 15px 10px; }
    .btn-white { background: #fff; border-color: #e2e8f0; color: #475569; }
    .btn-white:hover { background: #f8fafc; color: #1e293b; }
    
    /* Premium Lab Test Checkbox Styling */
    .lab-test-container {
        border: 1px solid #e2e8f0;
        border-radius: 16px;
        background: #fff;
        padding: 15px;
        max-height: 220px;
        overflow-y: auto;
    }
    .lab-test-item {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 10px;
        transition: all 0.2s;
        cursor: pointer;
        margin-bottom: 4px;
    }
    .lab-test-item:hover {
        background: #f8fafc;
    }
    .lab-test-item input[type="checkbox"] {
        width: 22px;
        height: 22px;
        border-radius: 6px;
        border: 2px solid #cbd5e1;
        cursor: pointer;
        margin-right: 15px;
    }
    .lab-test-label {
        font-weight: 700;
        color: #334155;
        font-size: 15px;
        margin-bottom: 0;
        flex: 1;
    }
    .lab-test-price {
        color: #64748b;
        font-weight: 500;
        margin-left: 8px;
    }
    .btn-soft-primary {
        background: #eff6ff;
        color: #3b82f6;
        border: none;
    }
    .btn-soft-primary:hover {
        background: #dbeafe;
        color: #1e40af;
    }
    .lab-test-item-wrapper:hover .test-action-btns {
        opacity: 1;
    }
    .test-action-btns {
        opacity: 0.3;
        transition: opacity 0.2s;
    }
    .lab-test-container::-webkit-scrollbar {
        width: 6px;
    }
    .lab-test-container::-webkit-scrollbar-thumb {
        background: #e2e8f0;
        border-radius: 10px;
    }
</style>

@push('scripts')
<script>
function updateTotalBill(id) {
    const container = document.getElementById('testContainer' + (id === 'New' ? 'New' : id));
    const checkboxes = container.querySelectorAll('input[type="checkbox"]:checked');
    let total = 0;
    checkboxes.forEach(cb => {
        total += parseFloat(cb.dataset.price);
    });
    document.getElementById('totalBill' + id).value = total;
    calculateBalance(id);
}

function calculateBalance(id) {
    const total = parseFloat(document.getElementById('totalBill' + id).value) || 0;
    const discount = parseFloat(document.getElementById('discountAmount' + id).value) || 0;
    const advance = parseFloat(document.getElementById('advancePaid' + id).value) || 0;
    document.getElementById('balanceDue' + id).value = Math.max(0, total - discount - advance);
}
</script>
@endpush

@include('patients.partials.modals')

@endsection