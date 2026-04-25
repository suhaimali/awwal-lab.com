@extends('layouts.app')

@section('content')
<div class="container-fluid h-100 d-flex align-items-center justify-content-center">
    <div class="text-center animate-in">
        <div class="mb-4">
            <h1 class="fw-black mb-0" style="font-size: 120px; background: linear-gradient(135deg, #ef4444 0%, #b91c1c 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; line-height: 1;">403</h1>
            <p class="fw-bold text-muted text-uppercase letter-spacing-1" style="font-size: 14px;">Security Error: Access Denied</p>
        </div>
        
        <div class="card border-0 shadow-sm mx-auto mb-5" style="border-radius: 24px; max-width: 500px; background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px);">
            <div class="card-body p-5">
                <div class="rounded-circle bg-soft-danger text-danger d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                    <i class="fa-solid fa-user-lock fs-1"></i>
                </div>
                <h4 class="fw-bold text-dark mb-3">Clearance Required</h4>
                <p class="text-muted small mb-4">Your current operator profile does not have the necessary clearance level to access this system node.</p>
                <div class="d-flex gap-2 justify-content-center">
                    <a href="{{ route('dashboard') }}" class="btn btn-dark px-4 py-2 fw-bold" style="border-radius: 12px;">Back to Safety</a>
                    <a href="{{ route('login') }}" class="btn btn-outline-danger px-4 py-2 fw-bold" style="border-radius: 12px;">Switch Profile</a>
                </div>
            </div>
        </div>

        <p class="text-muted small opacity-50">Error Reference: HTTP_403_FORBIDDEN_SUHAIM_SOFT</p>
    </div>
</div>

<style>
    .fw-black { font-weight: 900; }
    .letter-spacing-1 { letter-spacing: 2px; }
    .bg-soft-danger { background: rgba(239, 68, 68, 0.1); }
</style>
@endsection
