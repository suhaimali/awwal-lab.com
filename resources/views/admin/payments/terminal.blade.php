@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="row g-0" style="min-height: calc(100vh - 100px);">
        <!-- Side Dashboard Style Payment Form -->
        <div class="col-lg-5 p-4 border-end bg-white">
            <div class="d-flex align-items-center mb-4">
                <div class="rounded-circle bg-soft-primary p-3 me-3">
                    <i class="fa-solid fa-cash-register text-primary fs-4"></i>
                </div>
                <div>
                    <h4 class="fw-bold mb-0">Financial Terminal</h4>
                    <p class="text-muted small mb-0">Secure Transaction Node • LEDGER-MODE</p>
                </div>
            </div>

            <form id="paymentForm" class="pe-lg-4">
                @csrf
                <div class="mb-4">
                    <label class="form-label text-muted fw-bold small text-uppercase">Patient Identification</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user text-primary"></i></span>
                        <input type="text" id="patientName" name="patient_name" class="form-control bg-light border-0 py-2 shadow-none" placeholder="Search or Enter Name..." required list="patientsList">
                        <datalist id="patientsList">
                            @foreach($patients as $p)
                                <option value="{{ $p->name }}" data-id="{{ $p->id }}">{{ $p->id }}</option>
                            @endforeach
                        </datalist>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label text-muted fw-bold small text-uppercase">Internal ID</label>
                        <input type="text" id="patientId" name="patient_id_manual" class="form-control bg-light border-0 py-2 shadow-none" placeholder="P-0000" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label text-muted fw-bold small text-uppercase">Linked Booking</label>
                        <select id="bookingId" name="booking_id" class="form-select bg-light border-0 py-2 shadow-none">
                            <option value="">Independent</option>
                            @foreach($bookings as $b)
                                <option value="{{ $b->id }}">#{{ str_pad($b->id, 4, '0', STR_PAD_LEFT) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="mb-4 p-4 rounded-4" style="background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); color: white;">
                    <label class="form-label small fw-bold text-uppercase opacity-75">Transaction Value</label>
                    <div class="input-group">
                        <span class="input-group-text bg-transparent border-0 text-white fs-3">₹</span>
                        <input type="number" id="amount" name="amount" class="form-control bg-transparent border-0 text-white fs-2 fw-bold p-0 shadow-none" placeholder="0.00" required step="0.01">
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted fw-bold small text-uppercase">Settlement Gateway</label>
                    <div class="row g-2">
                        @php $methods = ['UPI', 'QR Code', 'Cash', 'Card']; @endphp
                        @foreach($methods as $method)
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="payment_method" id="method{{ $method }}" value="{{ $method }}" required {{ $loop->first ? 'checked' : '' }}>
                            <label class="btn btn-outline-light border text-dark w-100 py-2 rounded-3 text-start small fw-bold" for="method{{ $method }}">
                                <i class="fa-solid {{ $method == 'UPI' ? 'fa-mobile-screen' : ($method == 'QR Code' ? 'fa-qrcode' : ($method == 'Cash' ? 'fa-money-bill-1' : 'fa-credit-card')) }} me-2 text-primary"></i> {{ $method }}
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div id="qrSection" class="mb-4 text-center d-none">
                    <div class="p-3 bg-light rounded-4 d-inline-block">
                        <canvas id="qrCanvas"></canvas>
                        <p class="text-muted small mt-2 mb-0">Scan for Instant Ledger Entry</p>
                    </div>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted fw-bold small text-uppercase">Status</label>
                    <select class="form-select bg-light border-0 py-2 shadow-none rounded-3" name="status" required>
                        <option value="Paid">Cleared (Paid)</option>
                        <option value="Pending">Awaiting (Pending)</option>
                        <option value="Failed">Declined (Failed)</option>
                    </select>
                </div>

                <button class="btn btn-primary w-100 py-3 fw-bold rounded-4 shadow-lg mb-3" type="submit" id="payBtn">
                    <i class="fa-solid fa-shield-check me-2"></i> Commit to MySQL Ledger
                </button>
            </form>

            <div id="postAction" class="d-none">
                <div class="alert alert-success rounded-4 border-0 d-flex align-items-center mb-3">
                    <i class="fa-solid fa-circle-check fs-4 me-3"></i>
                    <div>
                        <div class="fw-bold">Payment Synchronized</div>
                        <div class="small">Record has been added to the master SQL database.</div>
                    </div>
                </div>
                <div class="d-grid gap-2">
                    <button class="btn btn-dark rounded-3 py-2 fw-bold" id="downloadReceipt"><i class="fa-solid fa-file-pdf me-2"></i> Download Audit Receipt</button>
                    <button class="btn btn-success rounded-3 py-2 fw-bold" id="shareWhatsapp"><i class="fa-brands fa-whatsapp me-2"></i> Forward to Patient</button>
                </div>
            </div>
        </div>

        <!-- Terminal Output / Visualizer -->
        <div class="col-lg-7 bg-light d-flex align-items-center justify-content-center p-5">
            <div id="receiptPreview" class="bg-white shadow-lg p-5" style="width: 100%; max-width: 500px; border-radius: 30px; border: 1px solid #e2e8f0; position: relative; overflow: hidden;">
                <div class="text-center mb-5">
                    <img src="{{ asset('favicon.png') }}" height="60" class="mb-3">
                    <h5 class="fw-bold text-dark mb-0">SUHAIM SOFT LABS</h5>
                    <p class="text-muted small mb-0">Digital Diagnostics & Clinical Audit</p>
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted small">REF-ID</span>
                    <span class="fw-bold small" id="refId">#TERM-AUTO</span>
                </div>
                <hr class="opacity-25">
                
                <div class="mb-4">
                    <div class="text-muted small text-uppercase fw-bold mb-2">Patient Details</div>
                    <div class="h5 fw-bold mb-1" id="dispName">VALUED CLIENT</div>
                    <div class="text-muted small" id="dispId">ID: P-XXXX</div>
                </div>

                <div class="p-4 rounded-4 bg-light mb-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted small">Settlement Amount</div>
                        <div class="h3 fw-bold text-primary mb-0" id="dispAmount">₹0.00</div>
                    </div>
                </div>

                <div class="row g-3 mb-5">
                    <div class="col-6">
                        <div class="text-muted small">Method</div>
                        <div class="fw-bold" id="dispMethod">ELECTRONIC</div>
                    </div>
                    <div class="col-6 text-end">
                        <div class="text-muted small">Status</div>
                        <div class="badge bg-soft-primary text-primary rounded-pill px-3" id="dispStatus">STANDBY</div>
                    </div>
                </div>

                <div class="text-center">
                    <div class="text-muted small mb-2">Authorized Ledger Entry</div>
                    <div class="fw-bold" style="font-family: 'Courier New', Courier, monospace; letter-spacing: 2px;">{{ strtoupper(bin2hex(random_bytes(4))) }}</div>
                </div>

                <div class="receipt-footer mt-5 text-center">
                    <p class="text-muted" style="font-size: 10px;">This is a computer-generated audit receipt and does not require a physical signature. Verified by Suhaim Soft Protection Protocol.</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/jspdf@2.5.1/dist/jspdf.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/qrious@4.0.2/dist/qrious.min.js"></script>
<script>
    const patients = @json($patients);
    
    document.getElementById('patientName').addEventListener('input', function(e) {
        const val = e.target.value;
        const opt = document.querySelector(`#patientsList option[value="${val}"]`);
        if (opt) {
            document.getElementById('patientId').value = opt.getAttribute('data-id');
            updatePreview();
        }
    });

    ['patientName', 'patientId', 'amount', 'bookingId'].forEach(id => {
        document.getElementById(id).addEventListener('input', updatePreview);
    });

    document.querySelectorAll('input[name="payment_method"]').forEach(el => {
        el.addEventListener('change', function() {
            if (this.value === 'QR Code') {
                document.getElementById('qrSection').classList.remove('d-none');
                generateQR();
            } else {
                document.getElementById('qrSection').classList.add('d-none');
            }
            updatePreview();
        });
    });

    function updatePreview() {
        document.getElementById('dispName').textContent = document.getElementById('patientName').value || 'VALUED CLIENT';
        document.getElementById('dispId').textContent = 'ID: ' + (document.getElementById('patientId').value || 'P-XXXX');
        document.getElementById('dispAmount').textContent = '₹' + (parseFloat(document.getElementById('amount').value) || 0).toFixed(2);
        document.getElementById('dispMethod').textContent = document.querySelector('input[name="payment_method"]:checked').value;
    }

    function generateQR() {
        const amt = document.getElementById('amount').value || 0;
        const upiUrl = `upi://pay?pa=suhaim@upi&pn=SuhaimSoftLab&am=${amt}&cu=INR`;
        new QRious({
            element: document.getElementById('qrCanvas'),
            size: 150,
            value: upiUrl
        });
    }

    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const btn = document.getElementById('payBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Synchronizing...';

        const formData = new FormData(this);
        fetch('{{ route("admin.terminal.store") }}', {
            method: 'POST',
            body: formData,
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                document.getElementById('postAction').classList.remove('d-none');
                document.getElementById('paymentForm').classList.add('d-none');
                document.getElementById('dispStatus').textContent = 'CLEARED';
                document.getElementById('dispStatus').className = 'badge bg-soft-success text-success rounded-pill px-3';
                document.getElementById('refId').textContent = '#TRX-' + data.payment_id;
            }
        });
    });

    document.getElementById('downloadReceipt').addEventListener('click', function() {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.text("SUHAIM SOFT LABS - RECEIPT", 10, 10);
        doc.text("Patient: " + document.getElementById('dispName').textContent, 10, 20);
        doc.text("Amount: " + document.getElementById('dispAmount').textContent, 10, 30);
        doc.text("Method: " + document.getElementById('dispMethod').textContent, 10, 40);
        doc.save("Receipt.pdf");
    });

    document.getElementById('shareWhatsapp').addEventListener('click', function() {
        const name = document.getElementById('dispName').textContent;
        const amt = document.getElementById('dispAmount').textContent;
        const msg = `Hi ${name}, your payment of ${amt} to Suhaim Soft Labs has been successfully recorded in our MySQL ledger. Thank you!`;
        window.open(`https://wa.me/?text=${encodeURIComponent(msg)}`);
    });
</script>

<style>
    .bg-soft-primary { background: rgba(37, 99, 235, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
</style>
@endpush
@endsection
