@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-0" style="color: #1f1140;">System Settings</h2>
            <p class="text-muted mb-0">Configure your network profile and system preferences.</p>
        </div>
        <button class="btn btn-primary d-none d-md-flex align-items-center gap-2">
            <i class="fa fa-save"></i> Save Configuration
        </button>
    </div>

    <div class="row g-4">
        <!-- Profile Settings Card -->
        <div class="col-md-6">
            <div class="card h-100" style="border-top: 5px solid #d946ef;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold" style="color: #2b1d6f;"><i class="fa fa-user-shield me-2 text-primary"></i> Operator Profile</h5>
                </div>
                <div class="card-body">
                    <form action="#">
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">Operator ID</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->email }}" disabled style="background: rgba(240, 244, 248, 0.7);">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">Network Name</label>
                            <input type="text" class="form-control" value="{{ auth()->user()->name }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted" style="font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">Clearance Level</label>
                            <input type="text" class="form-control text-uppercase fw-bold" value="{{ auth()->user()->role }}" disabled style="background: rgba(240, 244, 248, 0.7); text-transform: uppercase;">
                        </div>
                        <button type="submit" class="btn btn-outline-primary w-100" style="border-radius: 10px;">Update Identity</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Security & Access Card -->
        <div class="col-md-6">
            <div class="card h-100" style="border-top: 5px solid #8b5cf6;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold" style="color: #2b1d6f;"><i class="fa fa-lock me-2 text-primary"></i> Access & Security</h5>
                </div>
                <div class="card-body">
                    <form action="#">
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">Current Verification Key</label>
                            <input type="password" class="form-control" placeholder="••••••••••••">
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted" style="font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">New Keycade</label>
                            <input type="password" class="form-control" placeholder="Enter new key">
                        </div>
                        <div class="mb-4">
                            <label class="form-label text-muted" style="font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase;">Confirm Keycade</label>
                            <input type="password" class="form-control" placeholder="Re-enter tracking key">
                        </div>
                        <button type="submit" class="btn btn-outline-primary w-100" style="border-radius: 10px;">Update Security Key</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- UI Preferences (Cosmetics) -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card" style="border-top: 5px solid #f52988;">
                <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                    <h5 class="fw-bold" style="color: #2b1d6f;"><i class="fa fa-paint-roller me-2 text-primary"></i> UI & Notification Preferences</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center p-3 mb-2 rounded" style="background: rgba(240, 244, 248, 0.5);">
                        <div>
                            <div class="fw-bold text-dark">Data Grid Alerts</div>
                            <div class="text-muted" style="font-size: 12px;">Receive push alerts when equipment goes offline.</div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" checked style="width: 40px; height: 20px;">
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center p-3 rounded" style="background: rgba(240, 244, 248, 0.5);">
                        <div>
                            <div class="fw-bold text-dark">Dark Mode Console</div>
                            <div class="text-muted" style="font-size: 12px;">Toggle low-light visual mode for late-night research.</div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" disabled style="width: 40px; height: 20px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
