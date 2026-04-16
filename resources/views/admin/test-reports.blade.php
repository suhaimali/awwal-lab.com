@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 90vh; background: linear-gradient(135deg, #a78bfa 0%, #06b6d4 100%);">
    <div class="text-center bg-white rounded-4 shadow-lg p-5 w-100" style="max-width: 440px;">
        <div class="mb-4">
            <i class="fa-solid fa-file-medical fa-3x text-primary"></i>
        </div>
        <h1 class="fw-bold mb-2" style="color:#7c3aed;">Test Reports</h1>
        <div class="mb-3">
            <span class="badge bg-gradient" style="background: linear-gradient(90deg,#06b6d4,#a78bfa); color: #fff; font-size: 1rem; padding: 8px 18px;">Admin: {{ Auth::user()->name ?? 'Admin' }}</span>
        </div>
        <p class="lead text-secondary mb-4">This feature is <span class="fw-bold text-primary">Coming Soon</span>.<br>Here you will be able to view and manage all lab test reports in one place.</p>
        <div class="alert alert-info d-inline-block px-4 py-2 fw-bold" style="font-size:1.1rem; background: linear-gradient(90deg,#a78bfa,#06b6d4); color:#fff; border:none;">Coming Soon</div>
        <a href="/admin/test-reports" class="btn btn-lg mt-4 fw-bold" style="background: linear-gradient(90deg,#06b6d4,#a78bfa); color: #fff; border: none;">Test Reports (Coming Soon)</a>
    </div>
</div>
@endsection@extends('layouts.app')

@section('content')
<div class="d-flex align-items-center justify-content-center" style="min-height: 90vh; background: linear-gradient(135deg, #a78bfa 0%, #06b6d4 100%);">
    <div class="text-center bg-white rounded-4 shadow-lg p-5 w-100" style="max-width: 440px;">
        <div class="mb-4">
            <i class="fa-solid fa-file-medical fa-3x text-primary"></i>
        </div>
        <h1 class="fw-bold mb-2" style="color:#7c3aed;">Test Reports</h1>
        <div class="mb-3">
            <span class="badge bg-gradient" style="background: linear-gradient(90deg,#06b6d4,#a78bfa); color: #fff; font-size: 1rem; padding: 8px 18px;">Admin: {{ Auth::user()->name ?? 'Admin' }}</span>
        </div>
        <p class="lead text-secondary mb-4">This feature is <span class="fw-bold text-primary">Coming Soon</span>.<br>Here you will be able to view and manage all lab test reports in one place.</p>
        <div class="alert alert-info d-inline-block px-4 py-2 fw-bold" style="font-size:1.1rem; background: linear-gradient(90deg,#a78bfa,#06b6d4); color:#fff; border:none;">Coming Soon</div>
        <a href="/admin/test-reports" class="btn btn-lg mt-4 fw-bold" style="background: linear-gradient(90deg,#06b6d4,#a78bfa); color: #fff; border: none;">Test Reports (Coming Soon)</a>
    </div>
</div>
@endsection