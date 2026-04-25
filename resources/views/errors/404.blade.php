@extends('layouts.app')

@section('content')
<style>
@keyframes pulseGlow {
    0% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.4); }
    70% { box-shadow: 0 0 0 20px rgba(59, 130, 246, 0); }
    100% { box-shadow: 0 0 0 0 rgba(59, 130, 246, 0); }
}
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}
.error-container {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
}
.error-code {
    font-size: 150px;
    font-weight: 900;
    line-height: 1;
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 50%, #60a5fa 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    margin-bottom: -10px;
    animation: float 4s ease-in-out infinite;
}
.terminal-card {
    background: #fff;
    border-radius: 32px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 25px 50px -12px rgba(30, 58, 138, 0.15);
    max-width: 550px;
    width: 100%;
    overflow: hidden;
}
.terminal-header {
    background: #f8fafc;
    padding: 12px 20px;
    border-bottom: 1px solid #e2e8f0;
    display: flex;
    gap: 6px;
}
.dot { width: 10px; height: 10px; border-radius: 50%; }
.dot-red { background: #ef4444; }
.dot-amber { background: #f59e0b; }
.dot-green { background: #10b981; }

.icon-circle {
    width: 90px;
    height: 90px;
    background: #eff6ff;
    color: #3b82f6;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 24px;
    position: relative;
}
.icon-circle::after {
    content: '';
    position: absolute;
    inset: 0;
    border-radius: 50%;
    animation: pulseGlow 2s infinite;
}
</style>

<div class="error-container">
    <div class="text-center">
        <div class="error-code">404</div>
        
        <div class="terminal-card">
            <div class="terminal-header">
                <div class="dot dot-red"></div>
                <div class="dot dot-amber"></div>
                <div class="dot dot-green"></div>
                <span class="ms-2 small text-muted fw-bold">SYSTEM_ERROR_PROTOCOL</span>
            </div>
            <div class="card-body p-5">
                <div class="icon-circle">
                    <i class="fa-solid fa-microscope fs-1"></i>
                </div>
                
                <h3 class="fw-black text-dark mb-2">Protocol Interrupted</h3>
                <p class="text-muted mb-4 px-4">The resource you are searching for has been relocated or sequestered by the laboratory security protocol.</p>
                
                <div class="d-flex flex-column gap-2 px-md-5">
                    <a href="{{ route('dashboard') }}" class="btn btn-primary py-3 fw-bold shadow-lg" style="border-radius: 16px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border: none;">
                        <i class="fa-solid fa-house-chimney-window me-2"></i> Return to Control Center
                    </a>
                    <a href="javascript:history.back()" class="btn btn-light py-3 fw-bold text-muted" style="border-radius: 16px;">
                        <i class="fa-solid fa-chevron-left me-2"></i> Previous Node
                    </a>
                </div>
            </div>
        </div>
        
        <div class="mt-4 opacity-50">
            <code class="small text-primary">REF: ERROR_CODE_404_SUHAIM_SOFT_CORE</code>
        </div>
    </div>
</div>
@endsection
