<!-- Initialize Report Modal -->
<div class="modal fade" id="newReportModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 30px; overflow: hidden;">
            <div class="modal-header border-0 px-4 pt-4 pb-0 d-flex justify-content-between align-items-center">
                <h4 class="modal-title fw-black" style="color: #1e3a8a;">Select <span class="text-primary">Investigation</span></h4>
                <button type="button" class="btn-close shadow-none p-3 bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.reports.store') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted small mb-4">Choose an applicable booking to initialize the analysis workflow.</p>
                    
                    <div class="pending-bookings-list pe-2" style="max-height: 400px; overflow-y: auto; scrollbar-width: thin;">
                        @forelse($pendingBookings as $b)
                        <div class="custom-radio-card mb-3 position-relative">
                            <input class="form-check-input visually-hidden-radio" type="radio" name="booking_id" value="{{ $b->id }}" id="booking{{ $b->id }}" required>
                            <label class="form-check-label w-100 p-4 rounded-4 cursor-pointer" for="booking{{ $b->id }}">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-xs bg-primary bg-opacity-10 text-primary rounded-circle d-flex align-items-center justify-content-center fw-bold me-3" style="width: 32px; height: 32px; font-size: 11px;">
                                            {{ strtoupper(substr($b->patient->name ?? 'P', 0, 1)) }}
                                        </div>
                                        <div class="fw-bold text-dark fs-5">{{ $b->patient->name ?? 'N/A' }}</div>
                                        <div class="ms-2 badge bg-light text-muted border-0" style="font-size: 10px;">{{ $b->patient->age ?? '-' }}Y / {{ $b->patient->gender ?? '-' }}</div>
                                    </div>
                                    <span class="badge bg-light text-primary border px-2 py-1" style="font-size: 10px;">#BK-{{ str_pad($b->id, 4, '0', STR_PAD_LEFT) }}</span>
                                </div>
                                <div class="ps-5">
                                    <div class="text-muted small mb-2 d-flex align-items-center">
                                        <i class="fa-solid fa-microscope me-2 opacity-50"></i>
                                        @php 
                                            $bTestIds = $b->tests ?: [];
                                            $bTestNames = $testTypes->whereIn('id', $bTestIds)->pluck('name')->toArray();
                                        @endphp
                                        <span class="text-truncate">{{ !empty($bTestNames) ? implode(', ', $bTestNames) : 'Clinical Investigation' }}</span>
                                    </div>
                                    <div class="text-muted" style="font-size: 10px;">
                                        <i class="fa-solid fa-calendar-day me-2 opacity-50"></i> Booked on: {{ $b->created_at->format('M d, Y • h:i A') }}
                                    </div>
                                </div>
                            </label>
                        </div>
                        @empty
                        <div class="text-center py-5 bg-light rounded-5 border-2 border-dashed">
                            <div class="rounded-circle bg-white shadow-sm d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                <i class="fa-solid fa-clipboard-check text-success fs-2"></i>
                            </div>
                            <h6 class="fw-bold text-dark">Queue Empty</h6>
                            <p class="text-muted small mb-0 px-4">All active bookings have been initialized into the diagnostic lifecycle.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 gap-2">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="submitBtn" class="btn btn-primary px-5 py-3 fw-bold shadow-primary" style="border-radius: 16px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border: none;" @if($pendingBookings->isEmpty()) disabled @endif>
                        Initialize Report <i class="fa-solid fa-chevron-right ms-2 small"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Bulk Import Modal -->
<div class="modal fade" id="importResultsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 30px; overflow: hidden;">
            <div class="modal-header border-0 px-4 pt-4 pb-0">
                <h4 class="modal-title fw-black" style="color: #1e3a8a;">Bulk <span class="text-success">Import</span></h4>
                <button type="button" class="btn-close shadow-none p-3 bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.reports.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="p-4 rounded-4 text-center mb-4 border-2 border-dashed" style="background: rgba(16, 185, 129, 0.03); border-color: rgba(16, 185, 129, 0.2);">
                        <i class="fa-solid fa-file-csv fs-1 text-success mb-3"></i>
                        <p class="text-muted small mb-0">Synchronize data from clinical analyzers via CSV sequence. Required mapping: <strong>report_id, parameter_name, result_value</strong></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase letter-spacing-1 mb-2">Source Data File</label>
                        <div class="input-group">
                            <input type="file" name="results_file" class="form-control bg-light border-0 py-3 shadow-none rounded-4" accept=".csv" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4 gap-2">
                    <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none px-4" data-bs-dismiss="modal">Discard</button>
                    <button type="submit" class="btn btn-success px-5 py-3 fw-bold shadow-lg text-white" style="border-radius: 16px; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border: none;">Execute Import</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 900; }
    .bg-soft-danger { background: rgba(239, 68, 68, 0.1); }
</style>
