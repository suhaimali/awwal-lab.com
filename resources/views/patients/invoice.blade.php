@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">

    {{-- ── Header / Toolbar ── --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1" style="color:#1e3a8a;">Patient Invoice</h2>
            <p class="text-muted mb-0">Billing & Investigation Summary — Suhaim Soft Laboratory</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="downloadPDF()" class="btn btn-primary fw-bold px-4 shadow-sm" style="border-radius:12px; background:linear-gradient(135deg,#1e40af,#3b82f6); border:none;">
                <i class="fa-solid fa-file-pdf me-2"></i> Download PDF
            </button>
            <button onclick="window.print()" class="btn btn-white border fw-bold px-4 shadow-sm" style="border-radius:12px;">
                <i class="fa-solid fa-print me-2"></i> Print
            </button>
            <a href="{{ route('admin.patients.index') }}" class="btn btn-light fw-bold px-4" style="border-radius:12px;">
                <i class="fa-solid fa-arrow-left me-2"></i> Back
            </a>
        </div>
    </div>

    {{-- ── Invoice Card (the printable area) ── --}}
    <div id="invoiceArea" class="card border-0 shadow" style="border-radius:24px; overflow:hidden; max-width:860px; margin:auto;">

        {{-- Lab Header --}}
        <div style="background:linear-gradient(135deg,#1e3a8a 0%,#2563eb 100%); padding:32px 40px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="text-white fw-black mb-1" style="letter-spacing:-1px; font-size:28px;">
                        Suhaim Soft Laboratory
                    </h2>
                    <div class="text-white-50 small">Clinical Diagnostic Services</div>
                    <div class="text-white-50 small mt-1">
                        <i class="fa-solid fa-phone me-1"></i> 8891479505 &nbsp;·&nbsp;
                        <i class="fa-solid fa-envelope me-1"></i> alivpsuhaim@gmail.com
                    </div>
                </div>
                <div class="text-end">
                    <div class="badge fw-bold px-3 py-2 text-white mb-2" style="background:rgba(255,255,255,.15); border-radius:10px; font-size:13px;">
                        INVOICE
                    </div>
                    <div class="text-white fw-bold" style="font-size:20px;">
                        {{ $booking?->bill_no ?? 'N/A' }}
                    </div>
                    <div class="text-white-50 small">{{ now()->format('d M, Y') }}</div>
                </div>
            </div>
        </div>

        <div class="p-5">

            {{-- Patient + Booking Details --}}
            <div class="row g-4 mb-5">
                {{-- Patient Profile --}}
                <div class="col-md-6">
                    <div class="d-flex align-items-center mb-3">
                        @if($patient->photo)
                            <img src="{{ Storage::url($patient->photo) }}"
                                 class="rounded-circle border me-3"
                                 style="width:70px;height:70px;object-fit:cover;">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold me-3"
                                 style="width:70px;height:70px;background:#dbeafe;color:#1e3a8a;font-size:28px;">
                                {{ strtoupper(substr($patient->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <div class="fw-black" style="font-size:18px; color:#1e293b;">{{ $patient->name }}</div>
                            <div class="text-muted small">{{ $patient->age }} years · {{ $patient->gender }}</div>
                        </div>
                    </div>
                    <table class="table table-borderless table-sm mb-0">
                        <tr><td class="text-muted small fw-bold ps-0" style="width:110px;">Phone</td><td class="fw-bold small">{{ $patient->phone }}</td></tr>
                        <tr><td class="text-muted small fw-bold ps-0">Address</td><td class="fw-bold small">{{ $patient->address }}</td></tr>
                        <tr><td class="text-muted small fw-bold ps-0">Ref. Doctor</td><td class="fw-bold small">{{ $patient->reference_dr_name ?: 'Self Referral' }}</td></tr>
                        <tr><td class="text-muted small fw-bold ps-0">Visit Date</td><td class="fw-bold small">{{ $patient->visit_date?->format('d M, Y') }}</td></tr>
                    </table>
                </div>

                {{-- Booking Summary --}}
                <div class="col-md-6">
                    <div class="p-4 rounded-4" style="background:#f8fafc; border:1px solid #e2e8f0;">
                        <div class="fw-black mb-3" style="color:#1e3a8a; font-size:14px; letter-spacing:1px;">BILLING SUMMARY</div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted small">Gross Amount</span>
                            <span class="fw-bold">₹{{ number_format($booking?->total_amount ?? 0, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted small">Discount</span>
                            <span class="fw-bold text-danger">- ₹{{ number_format($booking?->discount ?? 0, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 border-bottom">
                            <span class="text-muted small">Advance Paid</span>
                            <span class="fw-bold text-success">₹{{ number_format($booking?->advance_amount ?? 0, 2) }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-2 mt-1">
                            <span class="fw-black" style="font-size:15px;">Balance Due</span>
                            <span class="fw-black" style="font-size:16px; color:{{ ($booking?->balance_amount ?? 0) > 0 ? '#dc2626' : '#16a34a' }};">
                                ₹{{ number_format($booking?->balance_amount ?? 0, 2) }}
                            </span>
                        </div>
                        @php
                            $total   = $booking?->total_amount ?? 1;
                            $paid    = $booking?->advance_amount ?? 0;
                            $perc    = $total > 0 ? min(100, ($paid / $total) * 100) : 0;
                        @endphp
                        <div class="progress mt-3" style="height:6px; border-radius:4px;">
                            <div class="progress-bar bg-{{ $perc >= 100 ? 'success' : 'primary' }}"
                                 style="width:{{ $perc }}%; border-radius:4px;"></div>
                        </div>
                        <div class="d-flex justify-content-between mt-1">
                            <span class="text-muted" style="font-size:10px;">Payment Progress</span>
                            <span class="text-primary fw-bold" style="font-size:10px;">{{ number_format($perc, 0) }}%</span>
                        </div>
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <div class="badge rounded-pill px-3 py-2 fw-bold"
                             style="background:#dbeafe; color:#1e3a8a; font-size:11px;">
                            {{ $booking?->status ?? 'Pending' }}
                        </div>
                        @if($booking?->reporting_date)
                        <div class="badge rounded-pill px-3 py-2 fw-bold"
                             style="background:#dcfce7; color:#166534; font-size:11px;">
                            Report: {{ $booking->reporting_date->format('d M, Y') }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Investigations Table --}}
            <div class="mb-5">
                <div class="fw-black mb-3" style="color:#1e3a8a; font-size:14px; letter-spacing:1px;">
                    INVESTIGATIONS ORDERED
                </div>
                <table class="table align-middle" style="border-radius:12px; overflow:hidden;">
                    <thead style="background:#f1f5f9;">
                        <tr>
                            <th class="fw-bold small text-muted py-3 ps-4" style="border:none;">#</th>
                            <th class="fw-bold small text-muted py-3" style="border:none;">Test Name</th>
                            <th class="fw-bold small text-muted py-3 text-end pe-4" style="border:none;">Amount (₹)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $tests = $booking?->tests ?? []; $i = 1; @endphp
                        @forelse($tests as $testId)
                            @php $test = $testTypes[$testId] ?? null; @endphp
                            @if($test)
                            <tr style="border-bottom:1px solid #f1f5f9;">
                                <td class="ps-4 text-muted small">{{ $i++ }}</td>
                                <td class="fw-bold">{{ $test->name }}</td>
                                <td class="text-end pe-4 fw-bold text-primary">₹{{ number_format($test->price, 2) }}</td>
                            </tr>
                            @endif
                        @empty
                            <tr><td colspan="3" class="text-center text-muted py-4">No investigations recorded.</td></tr>
                        @endforelse
                    </tbody>
                    <tfoot style="background:#f8fafc;">
                        <tr>
                            <td colspan="2" class="fw-black ps-4 py-3" style="color:#1e3a8a;">TOTAL</td>
                            <td class="text-end pe-4 fw-black py-3" style="font-size:16px; color:#1e3a8a;">
                                ₹{{ number_format($booking?->total_amount ?? 0, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            {{-- Footer --}}
            <div class="d-flex justify-content-between align-items-end pt-4" style="border-top:1px solid #e2e8f0;">
                <div>
                    <div class="text-muted small">This is a computer-generated document.</div>
                    <div class="text-muted small">Printed: {{ now()->format('d M, Y h:i A') }}</div>
                </div>
                <div class="text-end">
                    <div class="fw-bold" style="color:#1e3a8a; font-size:13px;">Suhaim Soft Laboratory</div>
                    <div class="text-muted small">Authorized Signatory</div>
                    <div class="mt-3 pt-3" style="border-top:1px solid #94a3b8; min-width:160px;"></div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- jsPDF via CDN --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
async function downloadPDF() {
    const { jsPDF } = window.jspdf;
    const invoiceEl = document.getElementById('invoiceArea');

    // Temporarily hide action buttons during capture
    const toolbar = document.querySelector('.d-flex.justify-content-between.align-items-center.mb-4');
    toolbar.style.display = 'none';

    const canvas = await html2canvas(invoiceEl, {
        scale: 2,
        useCORS: true,
        logging: false,
        backgroundColor: '#ffffff'
    });

    toolbar.style.display = '';

    const imgData  = canvas.toDataURL('image/jpeg', 0.95);
    const pdf      = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
    const pdfW     = pdf.internal.pageSize.getWidth();
    const pdfH     = (canvas.height * pdfW) / canvas.width;

    pdf.addImage(imgData, 'JPEG', 0, 0, pdfW, pdfH);
    pdf.save('Invoice_{{ $booking?->bill_no ?? $patient->id }}_{{ $patient->name }}.pdf');
}
</script>

<style>
@media print {
    .d-flex.justify-content-between.align-items-center.mb-4 { display: none !important; }
    body { background: white !important; }
    .card { box-shadow: none !important; }
}
</style>
@endsection
