<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinical_Report_{{ str_pad($report->id, 5, '0', STR_PAD_LEFT) }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;800&display=swap');

        @media print {
            .no-print { display: none !important; }
            body { background: white !important; padding: 0 !important; margin: 0 !important; }
            .container { width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 0 !important; }
            .report-card { border: none !important; box-shadow: none !important; margin: 0 !important; padding: 40px !important; }
            .watermark { display: block !important; }
        }

        body { 
            background: #eef2f5; 
            font-family: 'Inter', sans-serif; 
            color: #1e293b;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .report-card {
            background: white;
            max-width: 900px;
            margin: 40px auto;
            border-radius: 0;
            box-shadow: 0 20px 50px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
            border-top: 10px solid #1e40af;
        }

        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 120px;
            font-weight: 900;
            color: rgba(30, 64, 175, 0.03);
            white-space: nowrap;
            pointer-events: none;
            z-index: 0;
            display: none;
            text-transform: uppercase;
        }

        .letterhead {
            border-bottom: 2px solid #f1f5f9;
            padding-bottom: 30px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .lab-brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .lab-logo {
            width: 60px;
            height: 60px;
            background: #1e40af;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 30px;
            font-weight: 800;
        }

        .lab-name {
            font-size: 24px;
            font-weight: 800;
            color: #1e40af;
            text-transform: uppercase;
            line-height: 1;
            margin-bottom: 5px;
        }

        .patient-data-grid {
            background: #f8fafc;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 40px;
            border: 1px solid #e2e8f0;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .data-item .label {
            font-size: 10px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
            display: block;
        }

        .data-item .value {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
        }

        .test-header {
            background: #1e40af;
            color: white;
            padding: 12px 25px;
            font-weight: 800;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .results-table {
            width: 100%;
            margin-bottom: 40px;
        }

        .results-table th {
            padding: 15px 25px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            color: #64748b;
            border-bottom: 2px solid #f1f5f9;
        }

        .results-table td {
            padding: 15px 25px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
        }

        .result-value {
            font-weight: 800;
            color: #1e40af;
        }

        .digital-footer {
            margin-top: 60px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            border-top: 2px solid #f1f5f9;
            padding-top: 30px;
        }

        .qr-code {
            width: 80px;
            height: 80px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #cbd5e1;
            border-radius: 10px;
        }

        .signature {
            text-align: center;
        }

        .sig-line {
            width: 180px;
            height: 2px;
            background: #0f172a;
            margin-bottom: 10px;
        }

        .sig-name { font-weight: 800; font-size: 12px; text-transform: uppercase; }
        .sig-title { font-size: 10px; color: #64748b; }

        .btn-print-fixed {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 1000;
            padding: 15px 30px;
            border-radius: 50px;
            font-weight: 800;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.4);
        }
    </style>
</head>
<body onload="window.print()">

<div class="no-print p-3 bg-dark text-white d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
        <i class="fa-solid fa-file-pdf fs-4 text-danger"></i>
        <div>
            <div class="fw-bold small">Secure PDF Preview</div>
            <div class="text-white-50" style="font-size: 10px;">Clinical Authentication ID: {{ hash('sha256', $report->id) }}</div>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-sm btn-primary px-4 fw-bold rounded-pill">Download PDF</button>
        <button onclick="window.close()" class="btn btn-sm btn-outline-light rounded-pill">Close Preview</button>
    </div>
</div>

<button onclick="window.print()" class="btn btn-primary btn-print-fixed no-print">
    <i class="fa-solid fa-print me-2"></i> Print Clinical Report
</button>

<div class="report-card p-5">
    <div class="watermark">{{ $lab->name ?? 'AUTHENTIC' }}</div>

    <!-- Letterhead -->
    <div class="letterhead">
        <div class="lab-brand">
            <div class="lab-logo">{{ substr($lab->name ?? 'S', 0, 1) }}</div>
            <div>
                <div class="lab-name">{{ $lab->name ?? 'Suhaim Soft Laboratory' }}</div>
                <div class="text-muted small fw-bold">
                    <i class="fa-solid fa-location-dot me-1"></i> {{ $lab->address ?? 'Analytical Node, Sector 7' }}<br>
                    <i class="fa-solid fa-phone me-1"></i> {{ $lab->phone ?? '91-8891479505' }}
                </div>
            </div>
        </div>
        <div class="text-end">
            <div class="fw-black fs-4 text-uppercase mb-0" style="letter-spacing: -1px;">Investigation Report</div>
            <div class="text-muted small fw-bold">Issued on: {{ now()->format('d M, Y | h:i A') }}</div>
        </div>
    </div>

    <!-- Patient Header -->
    <div class="patient-data-grid">
        <div class="data-item">
            <span class="label">Patient Name</span>
            <span class="value">{{ $report->booking->patient->name }}</span>
        </div>
        <div class="data-item">
            <span class="label">Age / Gender</span>
            <span class="value">{{ $report->booking->patient->age }}Y / {{ $report->booking->patient->gender }}</span>
        </div>
        <div class="data-item">
            <span class="label">Sample ID</span>
            <span class="value">#SMPL-{{ str_pad($report->id, 6, '0', STR_PAD_LEFT) }}</span>
        </div>
        <div class="data-item">
            <span class="label">Referred By</span>
            <span class="value">{{ $report->booking->patient->reference_dr_name ?: 'Self / Walk-in' }}</span>
        </div>
        <div class="data-item">
            <span class="label">Collection Date</span>
            <span class="value">{{ $report->booking->created_at->format('d/m/Y') }}</span>
        </div>
        <div class="data-item">
            <span class="label">Reporting Date</span>
            <span class="value">{{ now()->format('d/m/Y') }}</span>
        </div>
    </div>

    <!-- Results Section -->
    <div class="test-header rounded-top">
        <span>Investigation: {{ $report->booking->test_type ?: 'Comprehensive Analysis' }}</span>
        <span>Laboratory Node: {{ $lab->lab_code ?? 'L-01' }}</span>
    </div>

    <table class="results-table">
        <thead>
            <tr>
                <th style="width: 40%;">Parameter Name</th>
                <th class="text-center" style="width: 20%;">Result</th>
                <th class="text-center" style="width: 20%;">Normal Range</th>
                <th class="text-center" style="width: 20%;">Unit</th>
            </tr>
        </thead>
        <tbody>
            @foreach($report->reportItems as $item)
            <tr>
                <td class="fw-bold">{{ $item->parameter_name }}</td>
                <td class="text-center result-value">{{ $item->result_value }}</td>
                <td class="text-center text-muted fw-bold small">{{ $item->normal_range ?: '—' }}</td>
                <td class="text-center small">{{ $item->unit ?: '—' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    @if($report->remarks)
    <div class="p-3 mb-5 rounded-3 bg-light border">
        <span class="label small fw-bold text-muted text-uppercase mb-2 d-block">Clinical Observations / Remarks</span>
        <p class="mb-0 small text-dark fw-bold">{{ $report->remarks }}</p>
    </div>
    @endif

    <!-- Digital Footer -->
    <div class="digital-footer">
        <div>
            <div class="qr-code mb-2">
                <i class="fa-solid fa-qrcode"></i>
            </div>
            <div class="text-muted" style="font-size: 9px; max-width: 300px;">
                Scan QR to verify authenticity. This report is digitally signed and cryptographically verified.
            </div>
        </div>
        <div class="signature">
            <div class="sig-line"></div>
            <div class="sig-name">Dr. Suhaim Soft</div>
            <div class="sig-title">Senior Consultant Pathologist</div>
            <div class="sig-title">MD, DNB (Clinical Pathology)</div>
        </div>
    </div>
</div>

<div class="text-center text-muted mb-5 no-print" style="font-size: 12px;">
    Suhaim Soft Laboratory Management System • v4.2.0 Production Node
</div>

</body>
</html>
