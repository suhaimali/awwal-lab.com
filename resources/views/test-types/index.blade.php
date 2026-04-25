@extends('layouts.app')
@section('content')

<style>
/* ── Investigations Inventory — Blue & White Responsive ── */
@keyframes fadeUp {
    from { opacity:0; transform:translateY(16px); }
    to   { opacity:1; transform:translateY(0); }
}
.inv-animate { animation: fadeUp .5s cubic-bezier(.16,1,.3,1) both; }
.d1 { animation-delay:.06s; }
.d2 { animation-delay:.12s; }
.d3 { animation-delay:.18s; }
.d4 { animation-delay:.24s; }
.d5 { animation-delay:.30s; }

/* Hero */
.inv-hero {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 70%, #06b6d4 100%);
    border-radius: 26px;
    padding: 2rem 2.2rem;
    color: #fff;
    position: relative;
    overflow: hidden;
    box-shadow: 0 14px 40px rgba(37,99,235,.22);
    margin-bottom: 1.75rem;
}
.inv-hero::before {
    content:''; position:absolute;
    top:-50px; right:-40px;
    width:210px; height:210px;
    background: radial-gradient(circle, rgba(255,255,255,.15) 0%, transparent 70%);
    border-radius:50%;
}
.inv-hero::after {
    content:''; position:absolute;
    bottom:-30px; left:30%;
    width:130px; height:130px;
    background: radial-gradient(circle, rgba(6,182,212,.2) 0%, transparent 70%);
    border-radius:50%;
}

/* Quick nav pills */
.inv-nav-pill {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: .55rem 1.25rem;
    border-radius: 50px;
    background: #fff;
    border: 1.5px solid #e2e8f0;
    color: #475569;
    font-weight: 700;
    font-size: .85rem;
    white-space: nowrap;
    text-decoration: none;
    transition: all .2s;
    box-shadow: 0 2px 8px rgba(30,58,138,.05);
}
.inv-nav-pill:hover {
    background: #eff6ff;
    border-color: #3b82f6;
    color: #1e40af;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(59,130,246,.14);
}

/* Metric cards */
.inv-metric {
    border-radius: 22px;
    border: 1px solid #e8f0fe;
    background: #fff;
    box-shadow: 0 4px 20px rgba(30,58,138,.06);
    padding: 1.5rem;
    transition: transform .3s, box-shadow .3s;
}
.inv-metric:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 32px rgba(30,58,138,.12);
}
.inv-metric-icon {
    width: 48px; height: 48px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.25rem;
    margin-bottom: 1rem;
}

/* Filter bar */
.inv-filter-bar {
    background: #fff;
    border: 1px solid #e8f0fe;
    border-radius: 20px;
    padding: 1.25rem 1.5rem;
    box-shadow: 0 2px 12px rgba(30,58,138,.05);
    margin-bottom: 0;
}
.inv-search {
    background: #f8fafc !important;
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 50px !important;
    padding: .5rem 1rem .5rem 2.5rem !important;
    font-size: .9rem;
    transition: border-color .2s, box-shadow .2s;
}
.inv-search:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59,130,246,.12) !important;
    background: #fff !important;
}
.inv-select {
    background: #f8fafc !important;
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 50px !important;
    padding: .5rem 1rem !important;
    font-size: .9rem;
    transition: border-color .2s;
    cursor: pointer;
}
.inv-select:focus { border-color: #3b82f6 !important; outline: none; box-shadow: 0 0 0 3px rgba(59,130,246,.12) !important; }

/* Buttons */
.btn-blue-grad {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    color: #fff; border: none;
    border-radius: 50px;
    padding: .5rem 1.5rem;
    font-weight: 700; font-size: .88rem;
    box-shadow: 0 4px 14px rgba(59,130,246,.3);
    transition: opacity .2s, transform .2s;
}
.btn-blue-grad:hover { opacity:.9; transform:translateY(-1px); color:#fff; }

.btn-white-outline {
    background: #fff;
    color: #3b82f6;
    border: 1.5px solid #3b82f6;
    border-radius: 50px;
    padding: .5rem 1.25rem;
    font-weight: 700; font-size: .88rem;
    transition: background .2s, color .2s;
}
.btn-white-outline:hover { background: #3b82f6; color: #fff; }

.btn-white-plain {
    background: #fff;
    border: 1.5px solid #e2e8f0;
    color: #64748b;
    border-radius: 50px;
    padding: .5rem 1.25rem;
    font-weight: 700; font-size: .88rem;
    transition: border-color .2s, color .2s;
}
.btn-white-plain:hover { border-color: #3b82f6; color: #3b82f6; }

/* Table */
.inv-table-card {
    background: #fff;
    border-radius: 22px;
    border: 1px solid #e8f0fe;
    box-shadow: 0 4px 20px rgba(30,58,138,.06);
    overflow: hidden;
}
.inv-table thead th {
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #64748b;
    padding: 14px 12px;
    border: none;
    background: #f8fafc;
}
.inv-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: background .15s;
}
.inv-table tbody tr:hover { background: #eff6ff; }
.inv-table tbody td { padding: 14px 12px; border: none; vertical-align: middle; }
.inv-table tbody tr:last-child { border-bottom: none; }

/* Test avatar */
.test-avatar {
    width: 42px; height: 42px;
    border-radius: 13px;
    background: #dbeafe;
    color: #1e40af;
    display: flex; align-items: center; justify-content: center;
    font-weight: 900; font-size: 16px;
    flex-shrink: 0;
}

/* Responsive */
@media (max-width: 767px) {
    .inv-hero { padding: 1.5rem 1.1rem; }
    .inv-filter-bar .row { gap: .5rem; }
}
</style>

<div class="container-fluid p-0">

    {{-- ── Hero ── --}}
    <div class="inv-hero inv-animate">
        <div class="position-relative" style="z-index:2;">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:52px;height:52px;background:rgba(255,255,255,.15);border-radius:16px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(6px);">
                        <i class="fa-solid fa-flask-vial fs-4"></i>
                    </div>
                    <div>
                        <h2 class="fw-black mb-0" style="font-size:1.55rem;letter-spacing:-.5px;">Investigations Inventory</h2>
                        <p class="mb-0 small" style="opacity:.8;">Define and manage available laboratory tests and clinical parameters.</p>
                    </div>
                </div>
                <div class="d-flex gap-2 flex-wrap" style="z-index:2;">
                    <button type="button" class="btn fw-bold px-3 py-2"
                            style="background:rgba(255,255,255,.15);border:1.5px solid rgba(255,255,255,.3);color:#fff;border-radius:12px;backdrop-filter:blur(4px);"
                            data-bs-toggle="modal" data-bs-target="#importCsvModal">
                        <i class="fa-solid fa-file-import me-2"></i> Bulk Import
                    </button>
                    <button type="button" class="btn fw-bold px-4 py-2"
                            style="background:#fff;color:#1e40af;border-radius:12px;border:none;box-shadow:0 4px 14px rgba(0,0,0,.12);"
                            data-bs-toggle="modal" data-bs-target="#addTestModal">
                        <i class="fa-solid fa-plus me-2"></i> Add Investigation
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Quick Nav ── --}}
    <div class="d-flex gap-3 mb-4 overflow-auto pb-1 inv-animate d1">
        <a href="{{ route('admin.test-categories.index') }}" class="inv-nav-pill">
            <i class="fa-solid fa-list-ul text-primary"></i> Categories
        </a>
        <a href="{{ route('admin.test-parameters.index') }}" class="inv-nav-pill">
            <i class="fa-solid fa-microscope" style="color:#0891b2;"></i> Parameters
        </a>
        <a href="{{ route('admin.test-reports') }}" class="inv-nav-pill">
            <i class="fa-solid fa-chart-bar text-primary"></i> Analytics
        </a>
    </div>

    {{-- ── Metrics Row ── --}}
    <div class="row g-4 mb-4 inv-animate d2">
        {{-- Total Tests --}}
        <div class="col-6 col-md-4">
            <div class="inv-metric" style="background:linear-gradient(135deg,#1e40af 0%,#3b82f6 100%);color:#fff;border:none;">
                <div class="inv-metric-icon" style="background:rgba(255,255,255,.2);">
                    <i class="fa-solid fa-flask"></i>
                </div>
                <div class="fw-black" style="font-size:2rem;">{{ count($testTypes) }}</div>
                <div class="fw-bold text-white-75 small text-uppercase" style="letter-spacing:1px;">Total Catalogued Tests</div>
            </div>
        </div>
        {{-- Active --}}
        <div class="col-6 col-md-4">
            <div class="inv-metric">
                <div class="inv-metric-icon" style="background:#d1fae5;">
                    <i class="fa-solid fa-check-double" style="color:#16a34a;"></i>
                </div>
                <div class="fw-black text-dark" style="font-size:2rem;">{{ $testTypes->where('status','Active')->count() }}</div>
                <div class="fw-bold text-muted small text-uppercase" style="letter-spacing:1px;">Operational</div>
                <span class="badge rounded-pill mt-1 px-2" style="background:#d1fae5;color:#16a34a;font-size:10px;">Active</span>
            </div>
        </div>
        {{-- Categories --}}
        <div class="col-6 col-md-4">
            <div class="inv-metric">
                <div class="inv-metric-icon" style="background:#dbeafe;">
                    <i class="fa-solid fa-tags text-primary"></i>
                </div>
                <div class="fw-black text-dark" style="font-size:2rem;">{{ count($categories) }}</div>
                <div class="fw-bold text-muted small text-uppercase" style="letter-spacing:1px;">Defined Groups</div>
                <span class="badge rounded-pill mt-1 px-2" style="background:#dbeafe;color:#1e40af;font-size:10px;">Categories</span>
            </div>
        </div>
    </div>

    {{-- ── Filter Bar ── --}}
    <div class="inv-filter-bar mb-4 inv-animate d3">
        <form method="GET" action="{{ route('admin.test-types.index') }}">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-md-5">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-1" style="font-size:10px;letter-spacing:1px;">Search</label>
                    <div class="position-relative">
                        <i class="fa-solid fa-magnifying-glass position-absolute text-primary" style="left:14px;top:50%;transform:translateY(-50%);font-size:13px;"></i>
                        <input type="text" name="search" value="{{ request('search') }}"
                               class="form-control inv-search"
                               placeholder="Name or billing code...">
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <label class="form-label small fw-bold text-muted text-uppercase mb-1" style="font-size:10px;letter-spacing:1px;">Status</label>
                    <select name="status" class="form-select inv-select" onchange="this.form.submit()">
                        <option value="">All Status</option>
                        <option value="Active"   {{ request('status')=='Active'   ? 'selected':'' }}>Active Only</option>
                        <option value="Inactive" {{ request('status')=='Inactive' ? 'selected':'' }}>Inactive Only</option>
                    </select>
                </div>
                <div class="col-6 col-md-4 d-flex gap-2 justify-content-end justify-content-md-start">
                    <button type="submit" class="btn btn-blue-grad">
                        <i class="fa-solid fa-filter me-1"></i> Apply
                    </button>
                    <a href="{{ route('admin.test-types.index') }}" class="btn btn-white-outline">
                        <i class="fa-solid fa-rotate-left me-1"></i> Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- ── Inventory Table ── --}}
    <div class="inv-table-card inv-animate d4">
        <div class="table-responsive">
            <table class="table inv-table mb-0">
                <thead>
                    <tr>
                        <th class="ps-4">Investigation</th>
                        <th>Category</th>
                        <th>Billing Code</th>
                        <th>Unit Price</th>
                        <th class="text-center">Status</th>
                        <th class="pe-4 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($testTypes as $test)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <div class="test-avatar">
                                    {{ strtoupper(substr($test->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="fw-bold text-dark small">{{ $test->name }}</div>
                                    <div class="text-muted" style="font-size:11px;">
                                        @php $pCount = is_array($test->parameters) ? count($test->parameters) : 0; @endphp
                                        <i class="fa-solid fa-vials me-1 opacity-50"></i>{{ $pCount }} parameter(s)
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge rounded-pill px-3 py-1 fw-bold"
                                  style="background:#dbeafe;color:#1e40af;font-size:11px;">
                                {{ $test->category ?: '—' }}
                            </span>
                        </td>
                        <td>
                            <code class="px-2 py-1 rounded fw-bold"
                                  style="background:#f0f9ff;color:#0369a1;font-size:12px;border:1px solid #bae6fd;">
                                {{ $test->test_code ?: 'N/A' }}
                            </code>
                        </td>
                        <td>
                            <span class="fw-black" style="color:#1e40af;font-size:15px;">
                                ₹{{ number_format($test->price, 2) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($test->status == 'Active')
                                <span class="badge rounded-pill px-3 py-1 fw-bold"
                                      style="background:#d1fae5;color:#16a34a;font-size:11px;">
                                    <i class="fa-solid fa-circle-check me-1" style="font-size:9px;"></i>Active
                                </span>
                            @else
                                <span class="badge rounded-pill px-3 py-1 fw-bold"
                                      style="background:#fee2e2;color:#dc2626;font-size:11px;">
                                    <i class="fa-solid fa-circle-xmark me-1" style="font-size:9px;"></i>Inactive
                                </span>
                            @endif
                        </td>
                        <td class="pe-4 text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm fw-bold"
                                        style="background:#eff6ff;color:#1e40af;border:1.5px solid #bfdbfe;border-radius:8px 0 0 8px;"
                                        data-bs-toggle="modal" data-bs-target="#editModal{{ $test->id }}"
                                        title="Edit">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <form action="{{ route('admin.test-types.destroy', $test->id) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Archive this investigation?');">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-sm fw-bold"
                                            style="background:#fff5f5;color:#dc2626;border:1.5px solid #fecaca;border-left:none;border-radius:0 8px 8px 0;"
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
                            <i class="fa-solid fa-flask-vial opacity-20 mb-3 d-block" style="font-size:3rem;color:#3b82f6;"></i>
                            <div class="fw-bold text-dark mb-1">No investigations found</div>
                            <div class="text-muted small">Add a new investigation to get started.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

@push('styles')
<style>
    .bg-soft-primary { background: rgba(37,99,235,.1); }
    .bg-soft-success { background: rgba(16,185,129,.1); }
    .bg-soft-info    { background: rgba(14,165,233,.1); }
    .bg-soft-danger  { background: rgba(239,68,68,.1);  }
    .letter-spacing-1 { letter-spacing: 1px; }
    .lab-test-container { border:1px solid #e2e8f0; border-radius:16px; padding:12px; max-height:250px; overflow-y:auto; }
    .lab-test-item { display:flex; align-items:center; padding:8px 12px; border-radius:10px; cursor:pointer; margin-bottom:4px; transition:.2s; }
    .lab-test-item:hover { background:#f8fafc; }
    .lab-test-item input { width:18px; height:18px; margin-right:12px; border-radius:4px; }
    .lab-test-label { font-size:14px; font-weight:bold; color:#334155; margin-bottom:0; flex:1; }
</style>
@endpush

@include('test-types.partials.modals')

@endsection
