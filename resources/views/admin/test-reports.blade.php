@extends('layouts.app')

@push('styles')
<style>
    .animate-in { animation: fadeIn 0.8s cubic-bezier(0.16, 1, 0.3, 1); }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
    
    .hero-gradient {
        background: radial-gradient(circle at top right, rgba(37, 99, 235, 0.05), transparent),
                    radial-gradient(circle at bottom left, rgba(16, 185, 129, 0.05), transparent);
        border-radius: 40px;
    }

    .feature-card {
        transition: all 0.3s ease;
        border: 1px solid rgba(0,0,0,0.05);
    }
    .feature-card:hover {
        transform: translateY(-5px);
        background: #ffffff;
        box-shadow: 0 20px 40px rgba(0,0,0,0.05) !important;
    }

    .progress-custom {
        height: 10px;
        background: #e2e8f0;
        border-radius: 20px;
        overflow: hidden;
    }
    .progress-bar-custom {
        background: linear-gradient(90deg, #2563eb, #10b981);
        border-radius: 20px;
    }

    .pulse-blue {
        animation: pulse-blue 2s infinite;
        border-radius: 50%;
    }
    @keyframes pulse-blue {
        0% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0.4); }
        70% { box-shadow: 0 0 0 20px rgba(37, 99, 235, 0); }
        100% { box-shadow: 0 0 0 0 rgba(37, 99, 235, 0); }
    }
</style>
@endpush

@section('content')
<div class="container-fluid py-5 px-4 animate-in">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Hero Section -->
            <div class="hero-gradient p-5 text-center mb-5 border">
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center bg-white pulse-blue" style="width: 100px; height: 100px;">
                        <i class="fa-solid fa-microscope fs-1 text-primary"></i>
                    </div>
                </div>
                
                <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill fw-bold mb-3">
                    <i class="fa-solid fa-rocket me-2"></i>MODULE EVOLUTION IN PROGRESS
                </span>
                
                <h1 class="display-4 fw-black mb-3" style="color: #0f172a;">Advanced <span class="text-primary">Diagnostics</span></h1>
                <p class="text-muted fs-5 mb-5 mx-auto" style="max-width: 600px;">
                    We are currently engineering a high-precision reporting engine. Soon, you'll be able to manage clinical outcomes with AI-assisted insights and seamless patient integration.
                </p>

                <!-- Development Progress -->
                <div class="mx-auto mb-5" style="max-width: 450px;">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold text-dark">System Integration</span>
                        <span class="fw-bold text-primary">85%</span>
                    </div>
                    <div class="progress-custom">
                        <div class="progress-bar-custom h-100" style="width: 85%"></div>
                    </div>
                </div>

                <div class="d-flex gap-3 justify-content-center">
                    <a href="{{ route('dashboard') }}" class="btn btn-dark px-4 py-3 fw-bold rounded-pill">
                        <i class="fa-solid fa-arrow-left me-2"></i> Return to Command Center
                    </a>
                    <button class="btn btn-primary px-4 py-3 fw-bold rounded-pill shadow-primary">
                        <i class="fa-solid fa-bell me-2"></i> Notify Me on Launch
                    </button>
                </div>
            </div>

            <!-- Features Teaser Grid -->
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm h-100 p-4" style="border-radius: 28px; background: rgba(255,255,255,0.6);">
                        <div class="rounded-4 bg-soft-primary text-primary d-flex align-items-center justify-content-center mb-4" style="width: 54px; height: 54px;">
                            <i class="fa-solid fa-file-waveform fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Automated Analysis</h5>
                        <p class="text-muted small mb-0">High-speed processing of laboratory results with automated clinical flagging for abnormal ranges.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm h-100 p-4" style="border-radius: 28px; background: rgba(255,255,255,0.6);">
                        <div class="rounded-4 bg-soft-success text-success d-flex align-items-center justify-content-center mb-4" style="width: 54px; height: 54px;">
                            <i class="fa-solid fa-cloud-arrow-up fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Instant Cloud Sync</h5>
                        <p class="text-muted small mb-0">Direct synchronization with patient records and instant PDF generation for digital distribution.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card border-0 shadow-sm h-100 p-4" style="border-radius: 28px; background: rgba(255,255,255,0.6);">
                        <div class="rounded-4 bg-soft-warning text-warning d-flex align-items-center justify-content-center mb-4" style="width: 54px; height: 54px;">
                            <i class="fa-solid fa-shield-halved fs-4"></i>
                        </div>
                        <h5 class="fw-bold text-dark">Verified Security</h5>
                        <p class="text-muted small mb-0">Multi-layer encryption ensuring all diagnostic data meets clinical confidentiality standards.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .fw-black { font-weight: 900; }
    .shadow-primary { box-shadow: 0 10px 25px rgba(37, 99, 235, 0.2); }
</style>
@endsection