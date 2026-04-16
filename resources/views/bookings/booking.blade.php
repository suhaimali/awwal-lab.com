@extends('layouts.app')

@section('content')
<!-- Add FontAwesome and Google Fonts -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* 1. Statistics Cards Design */
    .stat-card { border: none; border-radius: 12px; transition: transform 0.2s; height: 100%; }
    .stat-card:hover { transform: translateY(-3px); }
    .bg-gradient-blue { background: linear-gradient(45deg, #0d6efd, #004fb1); color: white; }

    /* 2. Standard Professional Table Layout */
    .standard-table { background: white; border-radius: 10px; overflow: hidden; border: 1px solid #eef0f7; }
    .table thead th { 
        background-color: #f8f9fa; color: #6c757d; font-weight: 700; 
        text-transform: uppercase; font-size: 0.75rem; padding: 12px 15px; border-bottom: 2px solid #dee2e6;
    }
    .table tbody td { padding: 12px 15px; vertical-align: middle; border-bottom: 1px solid #f1f1f1; }

    /* 3. Status & Billing UI */
    .status-pill { padding: 4px 12px; border-radius: 50px; font-weight: 700; font-size: 0.7rem; text-transform: uppercase; }
    .bg-success-soft { background-color: #d1e7dd; color: #0f5132; }
    .bg-warning-soft { background-color: #fff3cd; color: #664d03; }
    .id-badge { background: #f1f5f9; color: #475569; font-weight: 800; font-size: 0.75rem; padding: 3px 8px; border-radius: 6px; }
    
    /* 4. Table Vertical Billing Summary (Requested Fixed Layout) */
    .bill-stack { line-height: 1.4; min-width: 150px; }
    .bill-lbl { font-size: 0.65rem; color: #94a3b8; font-weight: 800; text-transform: uppercase; display: block; }
    .bill-val { font-size: 0.85rem; font-weight: 700; color: #475569; display: block; margin-bottom: 4px; }
    .bill-final-lbl { font-size: 0.7rem; color: #1e293b; font-weight: 800; text-transform: uppercase; display: block; margin-top: 6px; border-top: 1px dashed #dee2e6; padding-top: 4px; }
    .bill-final-val { font-size: 1.1rem; font-weight: 800; color: #0d6efd; display: block; }

    /* 5. Processing Overlay (30 Seconds) */
    #processingOverlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(255, 255, 255, 0.9); z-index: 9999;
        display: none; align-items: center; justify-content: center; flex-direction: column;
    }
    .medical-spinner { width: 50px; height: 50px; border: 5px solid #f3f3f3; border-top: 5px solid #0d6efd; border-radius: 50%; animation: spin 1s linear infinite; }
    @keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }

    /* 6. Full Responsive Mobile Logic */
    @media (max-width: 991.98px) {
        .table thead { display: none; }
        .table tbody tr { display: block; border: 1px solid #eee; margin-bottom: 15px; border-radius: 10px; padding: 10px; background: #fff; }
        .table tbody td { display: flex; justify-content: space-between; align-items: center; text-align: right; border: none; padding: 8px 10px; border-bottom: 1px solid #f8f9fa; }
        .table tbody td::before { content: attr(data-label); font-weight: 800; text-transform: uppercase; font-size: 0.65rem; color: #adb5bd; float: left; }
        .table tbody td:last-child { border-bottom: none; }
    }
</style>

<!-- Processing Loader -->
<div id="processingOverlay">
    <div class="medical-spinner mb-3"></div>
    <h5 class="fw-bold text-primary">Processing...</h5>
    <p class="text-muted small">Please wait while we update lab records.</p>
</div>

<div class="container-fluid py-4" style="background-color: #f4f7f6; min-height: 100vh;">
    
    <!-- Top Header -->
    <div class="d-flex justify-content-between align-items-center mb-4 px-3 flex-wrap gap-3">
        <div>
            <h1 class="fw-bold text-dark mb-0"><i class="fa-solid fa-microscope text-primary me-2"></i>Lab Bookings</h1>
            <p class="text-muted small mb-0">Indian Rupee (₹) enabled Laboratory Management</p>
        </div>
        <div class="d-flex gap-2">
            <!-- SETUP TESTS MODAL TRIGGER -->
            <button class="btn btn-white shadow-sm border fw-bold text-dark" data-bs-toggle="modal" data-bs-target="#setupTestsModal"><i class="fa fa-cog text-secondary"></i> Setup Tests</button>
            <button class="btn btn-primary shadow px-4 fw-bold" data-bs-toggle="modal" data-bs-target="#bookingModal"><i class="fa fa-plus me-1"></i> New Booking</button>
        </div>
    </div>

    <!-- Statistics Section -->
    <div class="row g-3 mb-4 px-2">
        <div class="col-6 col-md-2">
            <div class="card stat-card bg-gradient-blue shadow-sm">
                <div class="card-body p-3">
                    <small class="fw-bold opacity-75">TOTAL</small>
                    <h3 class="mb-0 fw-bold">{{ $bookings->total() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2 text-white">
            <div class="card stat-card bg-success shadow-sm h-100">
                <div class="card-body p-3">
                    <small class="fw-bold opacity-75">CONFIRMED</small>
                    <h3 class="mb-0 fw-bold text-white">{{ $bookings->where('status', 'Confirmed')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-2 text-dark">
            <div class="card stat-card bg-warning shadow-sm h-100">
                <div class="card-body p-3">
                    <small class="fw-bold opacity-75">PENDING</small>
                    <h3 class="mb-0 fw-bold text-dark">{{ $bookings->where('status', 'Pending')->count() }}</h3>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="card border-0 shadow-sm bg-white border-start border-primary border-5 h-100">
                <div class="card-body p-3 d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small fw-bold">ESTIMATED REVENUE</div>
                        <h3 class="mb-0 fw-bold text-primary">₹ {{ number_format($totalRevenue ?? 0, 2) }}</h3>
                    </div>
                    <i class="fa fa-indian-rupee-sign text-primary opacity-25 fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Filter Section -->
    <div class="card border-0 shadow-sm mb-4 mx-2">
        <div class="card-body p-3">
            <form method="GET" class="row g-3 align-items-end">
                <div class="col-12 col-md-3">
                    <label class="bill-lbl">Search Patient</label>
                    <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm bg-light border-0 shadow-none" placeholder="Name or phone...">
                </div>
                <div class="col-12 col-md-4">
                    <label class="bill-lbl">Date Range</label>
                    <div class="input-group input-group-sm">
                        <input type="date" name="from" value="{{ request('from') }}" class="form-control border-0 bg-light">
                        <input type="date" name="to" value="{{ request('to') }}" class="form-control border-0 bg-light ms-1">
                    </div>
                </div>
                <div class="col-12 col-md-2">
                    <label class="bill-lbl">Status</label>
                    <select name="status" class="form-select form-select-sm border-0 bg-light">
                        <option value="">All Status</option>
                        <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="col-12 col-md-3 d-flex gap-2">
                    <button class="btn btn-primary btn-sm w-100 fw-bold shadow-sm" type="submit">Filter Results</button>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-light btn-sm border px-3"><i class="fa fa-sync-alt"></i></a>
                </div>
            </form>
        </div>
    </div>

    <!-- Main Table -->
    <div class="standard-table mx-2 shadow-sm mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="ps-3 text-center">ID</th>
                        <th>Patient Details</th>
                        <th>Schedule</th>
                        <th>Test Type</th>
                        <th>Billing Summary</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @forelse($bookings as $booking)
                    <tr>
                        <td data-label="ID No" class="ps-md-3 text-md-center fw-bold"><span class="id-badge">#{{ $loop->iteration }}</span></td>
                        <td data-label="Patient">
                            <div class="fw-bold text-dark">{{ $booking->patient->name ?? 'Unknown' }}</div>
                            <small class="text-muted">{{ $booking->patient->phone ?? 'N/A' }}</small>
                            @if($booking->notes)
                            <div class="text-muted mt-1" style="font-size: 0.65rem; font-style: italic;">Note: {{ Str::limit($booking->notes, 20) }}</div>
                            @endif
                        </td>
                        <td data-label="Schedule">
                            <div class="small fw-bold text-nowrap"><i class="fa fa-calendar-alt text-primary me-1"></i> {{ $booking->booking_date }}</div>
                            <div class="small text-muted text-nowrap mt-1"><i class="fa fa-clock text-primary me-1"></i> {{ $booking->booking_time }}</div>
                        </td>
                        <td data-label="Test Type">
                            <span class="badge bg-light text-primary border border-primary px-2">{{ $booking->test_type }}</span>
                        </td>
                        <td data-label="Billing Summary">
                            <!-- FIXED VERTICAL BILLING SUMMARY IN TABLE -->
                            <div class="bill-stack">
                                <span class="bill-lbl">Total Amount (₹)</span>
                                <span class="bill-val">₹{{ number_format($booking->amount + $booking->discount, 2) }}</span>
                                
                                <span class="bill-lbl text-danger">Discount (₹)</span>
                                <span class="bill-val text-danger">-₹{{ number_format($booking->discount, 2) }}</span>
                                
                                <span class="bill-final-lbl">FINAL PAYABLE</span>
                                <span class="bill-final-val">₹{{ number_format($booking->amount, 2) }}</span>
                                <small class="text-muted uppercase" style="font-size: 0.6rem;">{{ $booking->payment_method ?? 'Cash' }}</small>
                            </div>
                        </td>
                        <td data-label="Status">
                            <span class="status-pill @if($booking->status == 'Confirmed') bg-success-soft @else bg-warning-soft @endif">
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td data-label="Actions" class="text-end pe-3">
                            <div class="btn-group bg-white border rounded shadow-sm">
                                <button class="btn btn-sm text-primary border-0" data-bs-toggle="modal" data-bs-target="#editModal{{ $booking->id }}"><i class="fa fa-edit"></i></button>
                                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm text-danger border-0 border-start" onclick="return confirm('Delete?')"><i class="fa fa-trash"></i></button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <!-- EDIT MODAL (BLUE THEME) -->
                    <div class="modal fade" id="editModal{{ $booking->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg border-0">
                            <div class="modal-content shadow-lg border-0">
                                <div class="modal-header bg-primary text-white py-3 border-0">
                                    <h5 class="modal-title fw-bold">Edit Booking #{{ $loop->iteration }} - {{ $booking->patient->name }}</h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST" class="formProcessing">
                                    @csrf @method('PUT')
                                    <div class="modal-body p-4 text-start">
                                        <div class="row g-3">
                                            <div class="col-md-12">
                                                <label class="bill-lbl text-dark">Patient</label>
                                                <select name="patient_id" class="form-select border-primary shadow-none" required>
                                                    @foreach($patients as $p)
                                                        <option value="{{ $p->id }}" {{ $booking->patient_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="bill-lbl text-dark">Test Type</label>
                                                <select name="test_type" class="form-select border-primary">
                                                    @foreach($testTypes as $t)
                                                        <option value="{{ $t->name }}" {{ $booking->test_type == $t->name ? 'selected' : '' }}>{{ $t->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="bill-lbl text-dark">Payment Method</label>
                                                <select name="payment_method" class="form-select border-primary">
                                                    <option value="Cash" {{ $booking->payment_method == 'Cash' ? 'selected' : '' }}>Cash</option>
                                                    <option value="UPI" {{ $booking->payment_method == 'UPI' ? 'selected' : '' }}>UPI / Google Pay</option>
                                                    <option value="Card" {{ $booking->payment_method == 'Card' ? 'selected' : '' }}>Card</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="bill-lbl text-dark">Date</label>
                                                <input type="date" name="booking_date" class="form-control border-primary" value="{{ $booking->booking_date }}" required>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="bill-lbl text-dark">Time</label>
                                                <input type="time" name="booking_time" class="form-control border-primary" value="{{ $booking->booking_time }}" required>
                                            </div>
                                            <div class="col-12">
                                                <label class="bill-lbl text-dark">Additional Notes</label>
                                                <textarea name="notes" class="form-control border-primary shadow-none" rows="2">{{ $booking->notes }}</textarea>
                                            </div>
                                            <div class="col-md-12 mt-4">
                                                <div class="card bg-light border-0 p-3 rounded-4 shadow-sm border-start border-primary border-4">
                                                    <h6 class="fw-bold mb-3 border-bottom pb-2">Billing Summary</h6>
                                                    <div class="row align-items-center">
                                                        <div class="col-md-4 mb-2">
                                                            <label class="bill-lbl">Total Amount (₹)</label>
                                                            <input type="number" id="ebase{{$booking->id}}" class="form-control fw-bold border-0 shadow-sm" value="{{ $booking->amount + $booking->discount }}" oninput="calcEdit({{$booking->id}})">
                                                        </div>
                                                        <div class="col-md-4 mb-2">
                                                            <label class="bill-lbl text-danger">Discount (₹)</label>
                                                            <!-- name="discount" added to ensure database update -->
                                                            <input type="number" name="discount" id="edisc{{$booking->id}}" class="form-control text-danger fw-bold border-0 shadow-sm" value="{{ $booking->discount }}" oninput="calcEdit({{$booking->id}})">
                                                        </div>
                                                        <div class="col-md-4 text-center">
                                                            <label class="bill-lbl">FINAL PAYABLE</label>
                                                            <h3 class="fw-bold text-primary mb-0" id="etxt{{$booking->id}}">₹{{ number_format($booking->amount, 2) }}</h3>
                                                            <input type="hidden" name="amount" id="ehid{{$booking->id}}" value="{{ $booking->amount }}">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer border-0 bg-light">
                                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow">Update Booking</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr><td colspan="7" class="text-center py-5 text-muted">No records found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">{{ $bookings->appends(request()->input())->links() }}</div>
    </div>
</div>

<!-- ==========================================
      MODAL: CREATE NEW BOOKING
     ========================================== -->
<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog modal-lg border-0">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header bg-primary text-white py-3 border-0">
                <h5 class="modal-title fw-bold">Create New Lab Booking</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="bookingForm" action="{{ route('admin.bookings.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="bill-lbl text-dark">Patient</label>
                            <select name="patient_id" class="form-select border-primary shadow-none" required>
                                <option value="">Select Patient...</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="bill-lbl text-dark">Test Type</label>
                            <select name="test_type" class="form-select border-primary shadow-none">
                                @foreach($testTypes as $type)
                                    <option value="{{ $type->name }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="bill-lbl text-dark">Payment Method</label>
                            <select name="payment_method" class="form-select border-primary shadow-none">
                                <option value="Cash">Cash</option>
                                <option value="UPI / G-Pay">UPI / G-Pay</option>
                                <option value="Card">Card</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="bill-lbl text-dark">Status</label>
                            <select name="status" class="form-select border-primary shadow-none">
                                <option value="Pending">Pending</option>
                                <option value="Confirmed">Confirmed</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="bill-lbl text-dark">Date</label>
                            <input type="date" name="booking_date" class="form-control border-primary" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="bill-lbl text-dark">Time</label>
                            <input type="time" name="booking_time" class="form-control border-primary" value="09:00" required>
                        </div>
                        <div class="col-12">
                            <label class="bill-lbl text-dark">Additional Notes</label>
                            <textarea name="notes" class="form-control border-primary shadow-none" rows="2" placeholder="Example: Fasting required..."></textarea>
                        </div>
                        <div class="col-md-12 mt-4">
                            <div class="card bg-light border-0 p-3 rounded-4 shadow-sm border-start border-primary border-4">
                                <h6 class="fw-bold mb-3 border-bottom pb-2 text-dark">Billing Summary</h6>
                                <div class="row align-items-center">
                                    <div class="col-md-4 mb-2">
                                        <label class="bill-lbl">Total Amount (₹)</label>
                                        <input type="number" id="base_amt_inp" class="form-control fw-bold border-0 shadow-sm" placeholder="0.00" step="0.01">
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <label class="bill-lbl text-danger">Discount (₹)</label>
                                        <input type="number" name="discount" id="disc_amt_inp" class="form-control text-danger fw-bold border-0 shadow-sm" value="0.00" step="0.01">
                                    </div>
                                    <div class="col-md-4 text-center">
                                        <div class="bill-lbl">FINAL PAYABLE</div>
                                        <h3 class="fw-bold text-primary mb-0" id="final_payable_txt">₹0.00</h3>
                                        <input type="hidden" name="amount" id="final_payable_hid">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 bg-light">
                    <button type="submit" class="btn btn-primary px-5 fw-bold shadow">Save Booking</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- SETUP TESTS MODAL -->
<div class="modal fade" id="setupTestsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white py-3 border-0">
                <h5 class="modal-title fw-bold"><i class="fa-solid fa-vial me-2"></i>Lab Setup</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <!-- Using generic route names to avoid 'admin.test-types' undefined errors -->
                <form action="{{ route('admin.test-types.store') }}" method="POST" class="d-flex gap-2 mb-3">
                    @csrf
                    <input type="text" name="name" class="form-control border-primary shadow-none" placeholder="New Test Name..." required>
                    <button class="btn btn-primary fw-bold" type="submit">Add</button>
                </form>
                <div class="test-list" style="max-height: 250px; overflow-y: auto;">
                    @foreach($testTypes as $type)
                    <div class="d-flex justify-content-between align-items-center p-2 mb-2 bg-light rounded border shadow-sm">
                        <span class="fw-bold ps-2 text-dark">{{ $type->name }}</span>
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm text-primary border-0" onclick="editTestType({{ $type->id }}, '{{ addslashes($type->name) }}')"><i class="fa fa-edit"></i></button>
                            <form action="{{ route('admin.test-types.destroy', $type->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm text-danger border-0"><i class="fa fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const bInp = document.getElementById('base_amt_inp');
    const dInp = document.getElementById('disc_amt_inp');
    const fTxt = document.getElementById('final_payable_txt');
    const fHid = document.getElementById('final_payable_hid');
    const overlay = document.getElementById('processingOverlay');

    function calcCreate() {
        let base = parseFloat(bInp.value) || 0;
        let disc = parseFloat(dInp.value) || 0;
        let final = base - disc;
        if (final < 0) final = 0;
        fTxt.innerText = '₹' + final.toLocaleString('en-IN', { minimumFractionDigits: 2 });
        fHid.value = final.toFixed(2);
    }
    bInp.addEventListener('input', calcCreate);
    dInp.addEventListener('input', calcCreate);

    document.querySelectorAll('form').forEach(f => {
        if(!f.method.includes('get')) f.addEventListener('submit', () => overlay.style.display = 'flex');
    });
});

function calcEdit(id) {
    let base = parseFloat(document.getElementById('ebase'+id).value) || 0;
    let disc = parseFloat(document.getElementById('edisc'+id).value) || 0;
    let final = base - disc;
    if (final < 0) final = 0;
    document.getElementById('etxt'+id).innerText = '₹' + final.toLocaleString('en-IN', { minimumFractionDigits: 2 });
    document.getElementById('ehid'+id).value = final.toFixed(2);
}

function editTest(id, name) {
    let n = prompt("Update Test Name:", name);
    if (n && n !== name) {
        let form = document.getElementById('editTestTypeForm');
        form.action = `/admin/test-types/${id}`;
        document.getElementById('editTestTypeName').value = n;
        form.style.display = 'none';
        form.submit();
    }
}
function editTestType(id, name) {
    let newName = prompt('Edit Test Name:', name);
    if (newName === null || !newName.trim()) return;
    let form = document.getElementById('editTestTypeForm');
    form.action = `/admin/test-types/${id}`;
    document.getElementById('editTestTypeName').value = newName;
    form.submit();
}
</script>

<!-- Hidden form for editing test types (name only) -->
<form id="editTestTypeForm" method="POST" style="display:none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="name" id="editTestTypeName">
</form>

<!-- Hidden form for editing test types (single inline edit) -->
<form id="editTestTypeForm" method="POST" style="display:none;">
    @csrf
    @method('PUT')
    <input type="hidden" name="name" id="editTestTypeName">
</form>
</script>

<style>
    .bg-primary { background-color: #0d6efd !important; }
    .text-primary { color: #0d6efd !important; }
    .btn-white { background-color: #fff; border-color: #dee2e6; color: #212529; }
</style>

@endsection