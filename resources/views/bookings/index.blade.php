@extends('layouts.app')

@section('content')
<style>
/* ── Booking Analytics — Blue & White Responsive ── */
@keyframes fadeUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
}
.ba-animate { animation: fadeUp .5s cubic-bezier(.16,1,.3,1) both; }
.d1{animation-delay:.06s} .d2{animation-delay:.12s}
.d3{animation-delay:.18s} .d4{animation-delay:.24s}

/* ── Hero Banner ── */
.ba-hero {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 65%, #06b6d4 100%);
    border-radius: 26px;
    padding: 2rem 2.2rem;
    color: #fff;
    position: relative;
    overflow: hidden;
    box-shadow: 0 14px 40px rgba(37,99,235,.22);
    margin-bottom: 1.75rem;
}
.ba-hero::before {
    content:''; position:absolute; top:-55px; right:-45px;
    width:210px; height:210px;
    background:radial-gradient(circle,rgba(255,255,255,.15) 0%,transparent 70%);
    border-radius:50%;
}
.ba-hero::after {
    content:''; position:absolute; bottom:-30px; left:28%;
    width:140px; height:140px;
    background:radial-gradient(circle,rgba(6,182,212,.2) 0%,transparent 70%);
    border-radius:50%;
}

/* ── Metric Cards ── */
.ba-metric {
    border-radius: 22px;
    border: 1px solid #e8f0fe;
    background: #fff;
    box-shadow: 0 4px 20px rgba(30,58,138,.06);
    padding: 1.5rem;
    transition: transform .3s, box-shadow .3s;
}
.ba-metric:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(30,58,138,.12);
}
.ba-metric-icon {
    width:48px; height:48px; border-radius:14px;
    display:flex; align-items:center; justify-content:center;
    font-size:1.2rem; margin-bottom:1rem;
}

/* ── Filter Bar ── */
.ba-filter-bar {
    background: #fff;
    border: 1px solid #e8f0fe;
    border-radius: 20px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 2px 12px rgba(30,58,138,.05);
    margin-bottom: 1.5rem;
}
.ba-input {
    background: #f8fafc !important;
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 50px !important;
    padding: .5rem 1rem .5rem 2.4rem !important;
    font-size: .9rem;
    transition: border-color .2s, box-shadow .2s;
}
.ba-input:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59,130,246,.12) !important;
    background: #fff !important;
    outline: none;
}
.ba-select {
    background: #f8fafc !important;
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 50px !important;
    padding: .5rem 1rem !important;
    font-size: .9rem;
    cursor: pointer;
    transition: border-color .2s;
}
.ba-select:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59,130,246,.12) !important;
    outline: none;
}
.ba-date {
    background: #f8fafc !important;
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 50px !important;
    padding: .5rem 1rem !important;
    font-size: .9rem;
    transition: border-color .2s;
}
.ba-date:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59,130,246,.12) !important;
    outline: none;
}

/* ── Buttons ── */
.btn-ba-blue {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    color: #fff; border: none;
    border-radius: 50px;
    padding: .52rem 1.5rem;
    font-weight: 700; font-size: .88rem;
    box-shadow: 0 4px 14px rgba(59,130,246,.3);
    transition: opacity .2s, transform .2s;
    display: inline-flex; align-items: center; gap: 6px;
}
.btn-ba-blue:hover { opacity:.9; transform:translateY(-1px); color:#fff; }

.btn-ba-white {
    background: #fff;
    color: #3b82f6;
    border: 1.5px solid #3b82f6;
    border-radius: 50px;
    padding: .52rem 1.25rem;
    font-weight: 700; font-size: .88rem;
    display: inline-flex; align-items: center; gap: 6px;
    transition: background .2s, color .2s;
}
.btn-ba-white:hover { background: #3b82f6; color: #fff; }

/* ── Table ── */
.ba-table-card {
    background: #fff;
    border-radius: 22px;
    border: 1px solid #e8f0fe;
    box-shadow: 0 4px 20px rgba(30,58,138,.06);
    overflow: hidden;
}
.ba-table thead th {
    font-size: 10px; font-weight: 800;
    text-transform: uppercase; letter-spacing: 1px;
    color: #64748b; padding: 14px 12px;
    border: none; background: #f8fafc;
}
.ba-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background .15s;
}
.ba-table tbody tr:hover { background: #eff6ff; }
.ba-table tbody td { padding: 14px 12px; border: none; vertical-align: middle; }
.ba-table tbody tr:last-child { border-bottom: none; }

/* Patient avatar */
.pat-avatar {
    width:38px; height:38px; border-radius:50%;
    background:#dbeafe; color:#1e40af;
    display:flex; align-items:center; justify-content:center;
    font-weight:900; font-size:14px; flex-shrink:0;
}

/* Test badges */
.test-badge {
    background:#f0f9ff; color:#0369a1;
    border:1px solid #bae6fd;
    border-radius:6px; font-size:10px;
    font-weight:700; padding:2px 8px;
}

/* Soft helpers */
.bg-soft-primary { background:rgba(37,99,235,.1); }
.bg-soft-success { background:rgba(16,185,129,.1); }
.bg-soft-warning { background:rgba(245,158,11,.1); }
.bg-soft-danger  { background:rgba(239,68,68,.1);  }
.letter-spacing-1 { letter-spacing:1px; }

.lab-test-container { border:1px solid #e2e8f0; border-radius:16px; padding:12px; max-height:250px; overflow-y:auto; }
.lab-test-item { display:flex; align-items:center; padding:8px 12px; border-radius:10px; cursor:pointer; margin-bottom:4px; transition:.2s; }
.lab-test-item:hover { background:#f8fafc; }
.lab-test-item input { width:18px; height:18px; margin-right:12px; border-radius:4px; }
.lab-test-label { font-size:14px; font-weight:bold; color:#334155; margin-bottom:0; flex:1; }
.lab-test-price { color:#64748b; font-weight:500; margin-left:8px; font-size:12px; }

@media (max-width:767px) {
    .ba-hero { padding:1.5rem 1.1rem; }
    .ba-filter-bar .row { gap:.5rem; }
}
</style>

<div class="container-fluid p-0">

    {{-- ── Hero ── --}}
    <div class="ba-hero ba-animate">
        <div class="position-relative" style="z-index:2;">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:52px;height:52px;background:rgba(255,255,255,.15);border-radius:16px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(6px);">
                        <i class="fa-solid fa-chart-gantt fs-4"></i>
                    </div>
                    <div>
                        <h2 class="fw-black mb-0" style="font-size:1.55rem;letter-spacing:-.5px;">Booking Analytics</h2>
                        <p class="mb-0 small" style="opacity:.82;">Track and manage laboratory investigation lifecycle.</p>
                    </div>
                </div>
                <div class="d-flex gap-2 flex-wrap" style="z-index:2;">
                    <button type="button" class="btn fw-bold px-4 py-2"
                            style="background:#fff;color:#1e40af;border-radius:12px;border:none;box-shadow:0 4px 14px rgba(0,0,0,.12);"
                            data-bs-toggle="modal" data-bs-target="#addBookingModal">
                        <i class="fa-solid fa-plus-circle me-2"></i> New Booking
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Metrics Row ── --}}
    <div class="row g-4 mb-4 ba-animate d1">

        {{-- Lifecycle Total --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="ba-metric h-100" style="background:linear-gradient(135deg,#1e40af 0%,#3b82f6 100%);color:#fff;border:none;">
                <div class="ba-metric-icon" style="background:rgba(255,255,255,.2);">
                    <i class="fa-solid fa-clipboard-list"></i>
                </div>
                <div class="fw-black" style="font-size:2rem;">{{ $totalBookings }}</div>
                <div class="fw-bold small text-uppercase" style="opacity:.75;letter-spacing:1px;">Lifecycle Total</div>
                <div class="mt-2">
                    <span class="badge rounded-pill px-3 py-1 fw-bold" style="background:rgba(255,255,255,.2);font-size:10px;">All Time</span>
                </div>
            </div>
        </div>

        {{-- Today's Fresh Records --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="ba-metric h-100">
                <div class="ba-metric-icon" style="background:#d1fae5;">
                    <i class="fa-solid fa-calendar-check" style="color:#16a34a;"></i>
                </div>
                <div class="fw-black text-dark" style="font-size:2rem;">{{ $todayBookings }}</div>
                <div class="fw-bold text-muted small text-uppercase" style="letter-spacing:1px;">Fresh Records</div>
                <div class="mt-2">
                    <span class="badge rounded-pill px-3 py-1 fw-bold" style="background:#d1fae5;color:#16a34a;font-size:10px;">
                        <i class="fa-solid fa-calendar-day me-1"></i>Today
                    </span>
                </div>
            </div>
        </div>

        {{-- Pending Stage --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="ba-metric h-100">
                <div class="ba-metric-icon" style="background:#fff7ed;">
                    <i class="fa-solid fa-clock-rotate-left" style="color:#f59e0b;"></i>
                </div>
                <div class="fw-black text-dark" style="font-size:2rem;">{{ $pendingBookings }}</div>
                <div class="fw-bold text-muted small text-uppercase" style="letter-spacing:1px;">Pending Stage</div>
                <div class="mt-2">
                    <span class="badge rounded-pill px-3 py-1 fw-bold" style="background:#fff7ed;color:#f59e0b;font-size:10px;">
                        <i class="fa-solid fa-hourglass-half me-1"></i>In Queue
                    </span>
                </div>
            </div>
        </div>

        {{-- Gross Inflow --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="ba-metric h-100">
                <div class="ba-metric-icon" style="background:#dbeafe;">
                    <i class="fa-solid fa-indian-rupee-sign text-primary"></i>
                </div>
                <div class="fw-black text-dark" style="font-size:1.75rem;">₹{{ number_format($totalRevenue, 2) }}</div>
                <div class="fw-bold text-muted small text-uppercase" style="letter-spacing:1px;">Gross Inflow</div>
                <div class="mt-2">
                    <span class="badge rounded-pill px-3 py-1 fw-bold" style="background:#dbeafe;color:#1e40af;font-size:10px;">
                        <i class="fa-solid fa-arrow-trend-up me-1"></i>Revenue
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Filter Bar ── --}}
    <div class="ba-filter-bar ba-animate d2">
        <form method="GET">
            <div class="row g-3 align-items-end">
                {{-- Search --}}
                <div class="col-12 col-lg-4">
                    <label class="form-label mb-1 fw-bold text-muted text-uppercase" style="font-size:10px;letter-spacing:1px;">Identity Search</label>
                    <div class="position-relative">
                        <i class="fa-solid fa-magnifying-glass position-absolute text-primary" style="left:14px;top:50%;transform:translateY(-50%);font-size:12px;"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="form-control ba-input"
                               placeholder="Booking ID or patient name...">
                    </div>
                </div>

                {{-- Status --}}
                <div class="col-6 col-md-4 col-lg-2">
                    <label class="form-label mb-1 fw-bold text-muted text-uppercase" style="font-size:10px;letter-spacing:1px;">Clinical Stage</label>
                    <select name="status" class="form-select ba-select">
                        <option value="All">All Stages</option>
                        <option value="Pending"   {{ request('status')=='Pending'   ? 'selected':'' }}>Pending</option>
                        <option value="Confirmed" {{ request('status')=='Confirmed' ? 'selected':'' }}>Confirmed</option>
                        <option value="Cancelled" {{ request('status')=='Cancelled' ? 'selected':'' }}>Cancelled</option>
                    </select>
                </div>

                {{-- Date --}}
                <div class="col-6 col-md-4 col-lg-3">
                    <label class="form-label mb-1 fw-bold text-muted text-uppercase" style="font-size:10px;letter-spacing:1px;">Timeline</label>
                    <input type="date" name="date" value="{{ request('date') }}"
                           class="form-control ba-date">
                </div>

                {{-- Buttons --}}
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-ba-blue flex-grow-1 justify-content-center">
                            <i class="fa-solid fa-rotate me-1"></i> Sync Results
                        </button>
                        <a href="{{ request()->url() }}" class="btn btn-ba-white flex-grow-0" title="Clear Filters">
                            <i class="fa-solid fa-xmark"></i>
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- ── Bookings Table ── --}}
    <div class="ba-table-card ba-animate d3">
        <div class="table-responsive">
            <table class="table ba-table mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Identity</th>
                        <th>Patient</th>
                        <th>Investigations</th>
                        <th>Billing</th>
                        <th class="text-center">Status</th>
                        <th class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $booking)
                    <tr>
                        {{-- Booking ID --}}
                        <td class="ps-4">
                            <div class="fw-black" style="color:#1e40af;font-size:13px;">{{ $booking->booking_id }}</div>
                            <div class="text-muted" style="font-size:11px;">
                                <i class="fa-solid fa-calendar-days me-1 opacity-50"></i>
                                {{ $booking->booking_date->format('M d, Y') }}
                            </div>
                        </td>

                        {{-- Patient --}}
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="pat-avatar">
                                    {{ strtoupper(substr($booking->patient->name ?? '?', 0, 1)) }}
                                </div>
                                <div class="fw-bold text-dark small">{{ $booking->patient->name ?? 'Unknown' }}</div>
                            </div>
                        </td>

                        {{-- Tests --}}
                        <td>
                            @if($booking->tests && is_array($booking->tests))
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($booking->tests as $testId)
                                        @php $test = $testTypes->firstWhere('id', $testId); @endphp
                                        <span class="test-badge">{{ $test ? $test->name : 'N/A' }}</span>
                                    @endforeach
                                </div>
                            @else
                                <span class="text-muted small">None</span>
                            @endif
                        </td>

                        {{-- Billing --}}
                        <td>
                            <span class="fw-black" style="color:#1e40af;font-size:14px;">₹{{ number_format($booking->total_amount, 2) }}</span>
                        </td>

                        {{-- Status --}}
                        <td class="text-center">
                            @if($booking->status == 'Confirmed')
                                <span class="badge rounded-pill px-3 py-1 fw-bold"
                                      style="background:#d1fae5;color:#16a34a;font-size:11px;">
                                    <i class="fa-solid fa-circle-check me-1" style="font-size:9px;"></i>Confirmed
                                </span>
                            @elseif($booking->status == 'Pending')
                                <span class="badge rounded-pill px-3 py-1 fw-bold"
                                      style="background:#fef9c3;color:#854d0e;font-size:11px;">
                                    <i class="fa-solid fa-clock me-1" style="font-size:9px;"></i>In-Queue
                                </span>
                            @else
                                <span class="badge rounded-pill px-3 py-1 fw-bold"
                                      style="background:#fee2e2;color:#dc2626;font-size:11px;">
                                    <i class="fa-solid fa-circle-xmark me-1" style="font-size:9px;"></i>Void
                                </span>
                            @endif
                        </td>

                        {{-- Actions --}}
                        <td class="pe-4 text-end">
                            <div class="d-inline-flex gap-1">
                                <button class="btn btn-sm fw-bold"
                                        style="background:#eff6ff;color:#1e40af;border:1.5px solid #bfdbfe;border-radius:8px;"
                                        data-bs-toggle="modal" data-bs-target="#editModal{{ $booking->id }}"
                                        title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Archive booking {{ $booking->booking_id }}?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm fw-bold"
                                            style="background:#fff5f5;color:#dc2626;border:1.5px solid #fecaca;border-radius:8px;"
                                            type="submit" title="Delete">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fa-solid fa-calendar-xmark d-block mb-3 opacity-20"
                               style="font-size:3rem;color:#3b82f6;"></i>
                            <div class="fw-bold text-dark mb-1">No lifecycle records found</div>
                            <div class="text-muted small">Adjust your filters or create a new booking.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@include('bookings.partials.modals')

@endsection
