@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <!-- Premium Navigation & Context -->
    <div class="d-flex justify-content-between align-items-center mb-5 animate-in">
        <div class="d-flex align-items-center gap-4">
            <a href="{{ route('admin.test-reports') }}" class="btn-back rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 48px; height: 48px; background: #fff; border: 1px solid #e2e8f0; color: #1e40af;">
                <i class="fa-solid fa-chevron-left"></i>
            </a>
            <div>
                <h3 class="fw-black mb-1" style="color: #0f172a; letter-spacing: -1px;">Clinical Result Intake</h3>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 small fw-bold">
                        <li class="breadcrumb-item"><a href="{{ route('admin.test-reports') }}" class="text-decoration-none text-primary">Diagnostic Hub</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Verification</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="d-flex gap-3">
            <button type="button" class="btn btn-outline-primary d-flex align-items-center gap-2 px-4 shadow-sm" style="border-radius: 14px; height: 50px; font-weight: 700;" data-bs-toggle="modal" data-bs-target="#addParameterModal">
                <i class="fa-solid fa-dna"></i> Add Param
            </button>
            <button type="button" onclick="document.getElementById('resultForm').submit()" class="btn btn-primary d-flex align-items-center gap-2 px-4 shadow-lg border-0" style="border-radius: 14px; height: 50px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); font-weight: 700;">
                <i class="fa-solid fa-cloud-arrow-up"></i> Finalize Report
            </button>
        </div>
    </div>

    <div class="row g-4">
        <!-- Patient Clinical Context (Sidebar) -->
        <div class="col-xl-3">
            <div class="card border-0 shadow-sm mb-4 sticky-top" style="border-radius: 28px; top: 20px;">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <div class="avatar-lg bg-soft-primary text-primary rounded-circle d-inline-flex align-items-center justify-content-center fw-black mx-auto mb-3" style="width: 80px; height: 80px; font-size: 30px; background: rgba(37, 99, 235, 0.1);">
                            {{ strtoupper(substr($report->booking->patient->name ?? 'P', 0, 1)) }}
                        </div>
                        <h5 class="fw-bold text-dark mb-1">{{ $report->booking->patient->name ?? 'N/A' }}</h5>
                        <span class="badge bg-light text-muted rounded-pill px-3 py-2 border" style="font-size: 11px;">#SMPL-{{ str_pad($report->id, 6, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <div class="d-flex flex-column gap-3">
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-4 bg-light border-0">
                            <span class="small fw-bold text-muted">AGE / SEX</span>
                            <span class="small fw-black text-dark">{{ $report->booking->patient->age ?? '—' }}Y / {{ $report->booking->patient->gender ?? '—' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-4 bg-light border-0">
                            <span class="small fw-bold text-muted">REF. DR</span>
                            <span class="small fw-black text-primary">{{ $report->booking->patient->reference_dr_name ?: 'Self' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center p-3 rounded-4 bg-light border-0">
                            <span class="small fw-bold text-muted">STATUS</span>
                            <span class="badge bg-{{ $report->status == 'Completed' ? 'success' : 'warning' }} rounded-pill">{{ $report->status }}</span>
                        </div>
                    </div>

                    <div class="mt-4 pt-4 border-top">
                        <h6 class="fw-bold small text-uppercase letter-spacing-1 text-muted mb-3">Associated Tests</h6>
                        @php 
                            $editTestIds = $report->booking->tests ?: [];
                            $editTestNames = $testTypes->whereIn('id', $editTestIds)->pluck('name')->toArray();
                        @endphp
                        <div class="d-flex flex-wrap gap-2">
                            @foreach($editTestNames as $tName)
                                <span class="badge bg-white text-primary border px-2 py-1" style="font-size: 10px;">{{ $tName }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Investigation Entry Area -->
        <div class="col-xl-9">
            <form id="resultForm" action="{{ route('admin.reports.update', $report->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                @php 
                    $groupedItems = $report->reportItems->groupBy(function($item) {
                        return $item->category ?: 'GENERAL INVESTIGATION';
                    });
                @endphp

                @forelse($groupedItems as $category => $items)
                <div class="card mb-4 border-0 shadow-sm" style="border-radius: 28px; overflow: hidden;">
                    <div class="card-header border-0 py-4 px-4" style="background: linear-gradient(90deg, #1e40af 0%, #1e3a8a 100%);">
                        <div class="d-flex align-items-center">
                            <div class="rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 32px; height: 32px; background: rgba(255,255,255,0.15);">
                                <i class="fa-solid fa-vials text-white small"></i>
                            </div>
                            <h6 class="fw-bold mb-0 text-white text-uppercase letter-spacing-1">{{ $category }}</h6>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr class="bg-light">
                                        <th class="ps-4 py-3 border-0 small text-uppercase fw-bold text-muted">Investigation</th>
                                        <th class="py-3 border-0 small text-uppercase fw-bold text-muted text-center" style="width: 25%;">Result</th>
                                        <th class="py-3 border-0 small text-uppercase fw-bold text-muted text-center">Unit</th>
                                        <th class="py-3 border-0 small text-uppercase fw-bold text-muted text-center">Reference Range</th>
                                        <th class="pe-4 py-3 border-0 small text-uppercase fw-bold text-muted text-end">Remarks</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($items as $item)
                                    <tr class="hover-shadow" id="paramRow{{ $item->id }}">
                                        <td class="ps-4">
                                            <div class="fw-bold text-dark">{{ $item->parameter_name }}</div>
                                            <div class="text-muted" style="font-size: 10px;">{{ $item->testType->name ?? 'General' }}</div>
                                        </td>
                                        <td>
                                            <input type="text" name="items[{{ $item->id }}][value]" value="{{ $item->result_value }}" 
                                                class="form-control text-center fw-bold text-primary shadow-none py-2" 
                                                style="border-radius: 12px; background: #f0f7ff; border: 2px solid #dbeafe;" 
                                                placeholder="Enter result">
                                        </td>
                                        <td class="text-center">
                                            <span class="badge bg-light text-muted border px-2">{{ $item->unit ?: '-' }}</span>
                                        </td>
                                        <td class="text-center">
                                            <span class="small fw-bold text-dark">{{ $item->normal_range ?: 'N/A' }}</span>
                                        </td>
                                        <td class="pe-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <input type="text" name="items[{{ $item->id }}][remarks]" value="{{ $item->remarks }}" 
                                                    class="form-control border-0 bg-light text-end small shadow-none" 
                                                    style="border-radius: 10px;" placeholder="Remarks...">
                                                <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="deleteParam({{ $item->id }})">
                                                    <i class="fa-solid fa-circle-xmark"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @empty
                <div class="card border-0 shadow-sm text-center p-5" style="border-radius: 28px;">
                    <i class="fa-solid fa-microscope fs-1 text-muted opacity-25 mb-3"></i>
                    <h5 class="fw-bold text-dark">No Parameters Initialized</h5>
                    <p class="text-muted">Use the "Add Parameter" button to begin investigation entry.</p>
                </div>
                @endforelse

                <!-- Global Remarks -->
                <div class="card border-0 shadow-sm mb-5" style="border-radius: 28px;">
                    <div class="card-body p-4">
                        <label class="form-label small fw-bold text-muted text-uppercase letter-spacing-1 mb-3">Overall Clinical Observations</label>
                        <textarea name="remarks" class="form-control bg-light border-0 py-3 rounded-4 shadow-none" rows="3" placeholder="Enter findings, clinical correlation, or suggestions...">{{ $report->remarks }}</textarea>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addParameterModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 30px;">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-black" style="color: #1e3a8a;">Add Investigation</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.reports.add-parameter', $report->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4 pt-0">
                    <div class="mb-4">
                        <label class="form-label small fw-bold text-muted text-uppercase mb-3">Select Parameter</label>
                        <div class="list-group list-group-flush rounded-4 overflow-hidden border" style="max-height: 250px; overflow-y: auto;">
                            @foreach($allParameters as $p)
                            <label class="list-group-item list-group-item-action d-flex justify-content-between align-items-center py-3">
                                <div class="d-flex align-items-center">
                                    <input class="form-check-input me-3" type="radio" name="parameter_name" value="{{ $p->name }}" 
                                        data-category="{{ $p->category }}" data-unit="{{ $p->unit }}" data-range="{{ $p->normal_range }}" 
                                        onchange="updateParamDetails(this)">
                                    <span class="fw-bold text-dark small">{{ $p->name }}</span>
                                </div>
                                <span class="badge bg-light text-muted border-0">{{ $p->category ?: 'General' }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                    <input type="hidden" name="category" id="paramCategory">
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">Unit</label>
                            <input type="text" name="unit" id="paramUnit" class="form-control bg-light border-0 py-2 rounded-3">
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">Range</label>
                            <input type="text" name="normal_range" id="paramRange" class="form-control bg-light border-0 py-2 rounded-3">
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted">Result Value</label>
                        <input type="text" name="result_value" class="form-control bg-primary bg-opacity-10 border-0 py-2 rounded-3 fw-bold text-primary">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-3 fw-bold rounded-4 shadow-lg border-0" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);">Add to Analysis</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 900; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .hover-shadow { transition: all 0.2s; }
    .hover-shadow:hover { background: #f8fafc; }
    .btn-back:hover { transform: translateX(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1) !important; }
    .animate-in { animation: slideIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    @keyframes slideIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .bg-soft-primary { background: rgba(37, 99, 235, 0.1); }
</style>
@endsection

@push('scripts')
<script>
function updateParamDetails(radio) {
    if (radio && radio.checked) {
        document.getElementById('paramUnit').value = radio.getAttribute('data-unit') || '';
        document.getElementById('paramRange').value = radio.getAttribute('data-range') || '';
        document.getElementById('paramCategory').value = radio.getAttribute('data-category') || 'General';
    }
}

function deleteParam(id) {
    if (!confirm('Delete this parameter?')) return;
    fetch(`/admin/reports/delete-parameter/${id}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const row = document.getElementById('paramRow' + id);
            if (row) {
                row.style.opacity = '0';
                setTimeout(() => row.remove(), 300);
            }
        }
    });
}
</script>
@endpush
