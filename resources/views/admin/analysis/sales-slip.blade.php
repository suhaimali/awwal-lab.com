@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <a href="{{ route('admin.analysis.index') }}" class="btn btn-light rounded-pill px-4">
            <i class="fa-solid fa-arrow-left me-2"></i> Back to Analysis
        </a>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-primary px-4 shadow-sm" style="border-radius: 12px;">
                <i class="fa-solid fa-print me-2"></i> Print Sales Slip
            </button>
            <button onclick="downloadPDF()" class="btn btn-dark px-4 shadow-sm" style="border-radius: 12px;">
                <i class="fa-solid fa-file-pdf me-2"></i> Save as PDF
            </button>
        </div>
    </div>

    <div id="sales-slip" class="card border-0 shadow-lg mx-auto" style="max-width: 800px; border-radius: 25px; overflow: hidden; background: #fff;">
        <!-- Header -->
        <div class="p-5 text-white" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="fw-black mb-1">SALES SLIP</h2>
                    <p class="opacity-75 mb-0">Laboratory Transaction Protocol</p>
                </div>
                <div class="text-end">
                    <h4 class="fw-bold mb-0">SUHAIM LAB</h4>
                    <p class="small opacity-75 mb-0">Automated Billing System v4.2</p>
                </div>
            </div>
        </div>

        <div class="card-body p-5">
            <!-- Patient & Transaction Info -->
            <div class="row g-4 mb-5">
                <div class="col-6">
                    <label class="text-muted small text-uppercase fw-bold letter-spacing-1 d-block mb-2">Patient Profile</label>
                    <h5 class="fw-bold mb-1 text-dark">{{ $booking->patient->name }}</h5>
                    <p class="text-muted mb-1"><i class="fa-solid fa-phone me-2 opacity-50"></i> {{ $booking->patient->phone }}</p>
                    <p class="text-muted mb-0"><i class="fa-solid fa-location-dot me-2 opacity-50"></i> {{ $booking->patient->address }}</p>
                </div>
                <div class="col-6 text-end">
                    <label class="text-muted small text-uppercase fw-bold letter-spacing-1 d-block mb-2">Transaction Details</label>
                    <p class="mb-1"><span class="text-muted">Bill No:</span> <span class="fw-bold text-primary">{{ $booking->bill_no }}</span></p>
                    <p class="mb-1"><span class="text-muted">Date:</span> <span class="fw-bold text-dark">{{ $booking->visit_date->format('d M, Y') }}</span></p>
                    <p class="mb-0"><span class="text-muted">Doctor:</span> <span class="fw-bold text-dark">{{ $booking->patient->reference_dr_name ?: 'Direct Access' }}</span></p>
                </div>
            </div>

            <!-- Investigation Table -->
            <div class="table-responsive mb-5">
                <table class="table table-borderless">
                    <thead>
                        <tr class="border-bottom">
                            <th class="ps-0 text-muted small text-uppercase fw-bold">Investigation / Service</th>
                            <th class="text-end text-muted small text-uppercase fw-bold">Unit Price</th>
                            <th class="text-end text-muted small text-uppercase fw-bold">Discount</th>
                            <th class="pe-0 text-end text-muted small text-uppercase fw-bold">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php 
                            $testTypes = \App\Models\TestType::whereIn('id', $booking->tests ?: [])->get();
                        @endphp
                        @foreach($testTypes as $test)
                        <tr>
                            <td class="ps-0 py-3">
                                <div class="fw-bold text-dark">{{ $test->name }}</div>
                                <div class="text-muted small">Code: {{ $test->test_code }}</div>
                            </td>
                            <td class="text-end py-3">₹{{ number_format($test->price, 2) }}</td>
                            <td class="text-end py-3 text-muted">₹0.00</td>
                            <td class="pe-0 text-end py-3 fw-bold">₹{{ number_format($test->price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Financial Summary -->
            <div class="row justify-content-end mb-5">
                <div class="col-md-5">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Gross Subtotal</span>
                        <span class="fw-bold">₹{{ number_format($booking->total_amount + $booking->discount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Network Discount</span>
                        <span class="text-danger fw-bold">- ₹{{ number_format($booking->discount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom">
                        <span class="text-muted">Adjusted Total</span>
                        <span class="fw-bold">₹{{ number_format($booking->total_amount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted fw-bold">Advance Received</span>
                        <span class="text-success fw-bold">₹{{ number_format($booking->advance_amount, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between p-3 bg-light rounded-4">
                        <span class="fw-black text-dark text-uppercase">Net Balance</span>
                        <span class="fw-black text-primary fs-5">₹{{ number_format($booking->balance_amount, 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="text-center pt-5 border-top">
                <p class="text-muted small mb-2">Thank you for choosing Suhaim Soft Laboratory Network.</p>
                <div class="d-flex justify-content-center gap-4">
                    <div class="small fw-bold text-dark"><i class="fa-solid fa-globe me-1 text-primary"></i> suhaim-soft.com</div>
                    <div class="small fw-bold text-dark"><i class="fa-solid fa-envelope me-1 text-primary"></i> clinicppm@gmail.com</div>
                </div>
                <div class="mt-4 opacity-25">
                    <img src="https://cdn-icons-png.flaticon.com/512/190/190411.png" style="width: 40px;" alt="Verified">
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 900; }
    .letter-spacing-1 { letter-spacing: 1px; }
    @media print {
        .no-print { display: none !important; }
        body { background: white !important; }
        .card { box-shadow: none !important; border: 1px solid #eee !important; }
        .container { width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
    }
</style>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    function downloadPDF() {
        const element = document.getElementById('sales-slip');
        const opt = {
            margin: 0,
            filename: 'Sales_Slip_{{ $booking->bill_no }}.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    }
</script>
@endsection
