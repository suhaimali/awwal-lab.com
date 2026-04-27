@extends('layouts.app')

@section('content')
<div class="container-fluid p-0 d-flex align-items-center justify-content-center" style="min-height: 80vh;">
    <div class="text-center animate-in" style="max-width: 600px;">
        <!-- Vibrant Pulse Animation -->
        <div class="maintenance-icon-wrapper mb-5 position-relative d-inline-block">
            <div class="pulse-ring"></div>
            <div class="pulse-ring-outer"></div>
            <div class="rounded-circle bg-primary d-flex align-items-center justify-content-center shadow-lg position-relative" style="width: 120px; height: 120px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;">
                <i class="fa-solid fa-screwdriver-wrench text-white fs-1"></i>
            </div>
        </div>

        <h1 class="fw-black mb-3" style="color: #0f172a; font-size: 42px; letter-spacing: -2px;">Module <span class="text-primary">Under Construction</span></h1>
        <p class="text-muted fs-5 mb-5 px-4">
            Our engineering team is currently architecting a next-gen clinical experience. Detailed analytics and AI-powered insights are coming to this module shortly.
        </p>

        <div class="row g-3 mb-5 text-start px-4">
            <div class="col-md-6">
                <div class="p-3 rounded-4 bg-white shadow-sm border border-light">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 p-2 bg-soft-primary text-primary"><i class="fa-solid fa-bolt"></i></div>
                        <div>
                            <div class="fw-bold small">Core Performance</div>
                            <div class="text-muted" style="font-size: 10px;">Optimizing SQL engine</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="p-3 rounded-4 bg-white shadow-sm border border-light">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-3 p-2 bg-soft-success text-success"><i class="fa-solid fa-shield-halved"></i></div>
                        <div>
                            <div class="fw-bold small">Security Patch</div>
                            <div class="text-muted" style="font-size: 10px;">v4.5.2 Protocols</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <a href="{{ route('dashboard') }}" class="btn btn-primary px-5 py-3 fw-bold shadow-lg" style="border-radius: 16px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border: none;">
                <i class="fa-solid fa-arrow-left me-2"></i> Return to Control Center
            </a>
        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 900; }
    .bg-soft-primary { background: rgba(37, 99, 235, 0.1); }
    .bg-soft-success { background: rgba(16, 185, 129, 0.1); }
    
    .pulse-ring {
        position: absolute;
        top: 0;
        left: 0;
        width: 120px;
        height: 120px;
        background: rgba(37, 99, 235, 0.2);
        border-radius: 50%;
        animation: pulse 2s infinite ease-out;
    }
    .pulse-ring-outer {
        position: absolute;
        top: -10px;
        left: -10px;
        width: 140px;
        height: 140px;
        background: rgba(37, 99, 235, 0.1);
        border-radius: 50%;
        animation: pulse 2s infinite ease-out 0.5s;
    }

    @keyframes pulse {
        0% { transform: scale(0.95); opacity: 0.8; }
        100% { transform: scale(1.5); opacity: 0; }
    }

    .animate-in {
        animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(40px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection