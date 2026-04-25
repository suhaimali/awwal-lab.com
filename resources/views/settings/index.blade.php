@extends('layouts.app')

@section('content')
<style>
/* ── Settings Page — Full Color Responsive ── */
@keyframes fadeUp {
    from { opacity:0; transform:translateY(18px); }
    to   { opacity:1; transform:translateY(0); }
}
.s-animate { animation: fadeUp .5s cubic-bezier(.16,1,.3,1) both; }
.s-delay-1 { animation-delay:.08s; }
.s-delay-2 { animation-delay:.16s; }
.s-delay-3 { animation-delay:.24s; }
.s-delay-4 { animation-delay:.32s; }

/* Hero Banner */
.settings-hero {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 60%, #06b6d4 100%);
    border-radius: 28px;
    padding: 2.2rem 2.5rem;
    color: #fff;
    position: relative;
    overflow: hidden;
    margin-bottom: 2rem;
    box-shadow: 0 16px 40px rgba(37,99,235,.22);
}
.settings-hero::before {
    content:'';
    position:absolute; top:-60px; right:-60px;
    width:240px; height:240px;
    background: radial-gradient(circle, rgba(255,255,255,.18) 0%, transparent 70%);
    border-radius:50%;
}
.settings-hero::after {
    content:'';
    position:absolute; bottom:-40px; left:20%;
    width:160px; height:160px;
    background: radial-gradient(circle, rgba(6,182,212,.25) 0%, transparent 70%);
    border-radius:50%;
}

/* Section Cards */
.set-card {
    background: #fff;
    border-radius: 22px;
    border: 1px solid #e8f0fe;
    box-shadow: 0 4px 24px rgba(30,58,138,.06);
    overflow: hidden;
    transition: box-shadow .3s, transform .3s;
}
.set-card:hover {
    box-shadow: 0 8px 36px rgba(30,58,138,.12);
    transform: translateY(-2px);
}
.set-card-header {
    display: flex;
    align-items: center;
    gap: 14px;
    padding: 1.5rem 1.75rem 1rem;
    border-bottom: 1px solid #f1f5f9;
}
.set-icon {
    width: 44px; height: 44px;
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.15rem;
    flex-shrink: 0;
}
.set-card-body { padding: 1.5rem 1.75rem; }

/* Inputs */
.set-input {
    background: #f8fafc !important;
    border: 1.5px solid #e2e8f0 !important;
    border-radius: 12px !important;
    padding: .55rem 1rem !important;
    font-size: .9rem;
    transition: border-color .2s, box-shadow .2s;
}
.set-input:focus {
    border-color: #3b82f6 !important;
    box-shadow: 0 0 0 3px rgba(59,130,246,.12) !important;
    outline: none;
}
.set-label {
    font-size: 10px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #64748b;
    margin-bottom: .4rem;
}

/* Sidebar UI Panel */
.ui-panel {
    background: linear-gradient(155deg, #1e3a8a 0%, #0f172a 100%);
    border-radius: 22px;
    color: #fff;
    box-shadow: 0 8px 32px rgba(30,58,138,.3);
}

/* Toggle switches */
.set-switch .form-check-input {
    width: 44px; height: 24px; cursor: pointer;
}
.set-switch .form-check-input:checked { background-color: #3b82f6; border-color: #3b82f6; }

/* Color swatches */
.color-swatch {
    width: 32px; height: 32px;
    border-radius: 50%;
    cursor: pointer;
    border: 3px solid rgba(255,255,255,.25);
    transition: transform .2s, border-color .2s, box-shadow .2s;
    position: relative;
}
.color-swatch:hover { transform: scale(1.2); }
.color-swatch.active {
    border-color: #fff !important;
    box-shadow: 0 0 0 3px rgba(255,255,255,.4);
}
.color-swatch.active::after {
    content: '✓';
    position: absolute;
    inset: 0;
    display: flex; align-items: center; justify-content: center;
    font-size: 12px; font-weight: 900; color: #fff;
}

/* Stat mini cards */
.stat-mini {
    background: rgba(255,255,255,.07);
    border: 1px solid rgba(255,255,255,.1);
    border-radius: 14px;
    padding: .75rem 1rem;
    display: flex; align-items: center; gap: 10px;
}

/* Buttons */
.btn-set-primary {
    background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
    color: #fff; border: none;
    border-radius: 12px;
    padding: .6rem 1.5rem;
    font-weight: 700; font-size: .9rem;
    transition: opacity .2s, transform .2s;
    box-shadow: 0 4px 14px rgba(59,130,246,.35);
}
.btn-set-primary:hover { opacity: .92; transform: translateY(-1px); color:#fff; }
.btn-set-outline {
    background: transparent;
    border: 1.5px solid #3b82f6;
    color: #3b82f6;
    border-radius: 12px;
    padding: .6rem 1.5rem;
    font-weight: 700; font-size: .9rem;
    transition: background .2s, color .2s;
}
.btn-set-outline:hover { background: #3b82f6; color: #fff; }

/* Responsive stacking */
@media (max-width: 991px) {
    .settings-hero { padding: 1.75rem 1.25rem; }
    .set-card-body { padding: 1.25rem; }
}
</style>

<div class="container-fluid p-0">

    {{-- ── Hero Banner ── --}}
    <div class="settings-hero s-animate">
        <div class="position-relative" style="z-index:2;">
            <div class="d-flex align-items-center gap-3 mb-2">
                <div style="width:48px;height:48px;background:rgba(255,255,255,.15);border-radius:16px;display:flex;align-items:center;justify-content:center;backdrop-filter:blur(6px);">
                    <i class="fa-solid fa-gear fa-spin-pulse fs-5"></i>
                </div>
                <div>
                    <h2 class="fw-black mb-0" style="font-size:1.6rem;letter-spacing:-.5px;">System Settings</h2>
                    <p class="mb-0 text-white-75 small">Identity · Security · Interface Customization</p>
                </div>
            </div>
        </div>
        <div class="d-flex gap-2 flex-wrap mt-3" style="z-index:2; position:relative;">
            <span class="badge px-3 py-2 fw-bold rounded-pill" style="background:rgba(255,255,255,.15);font-size:11px;backdrop-filter:blur(4px);">
                <i class="fa-solid fa-microchip me-1"></i> Core Engine v4.2.0
            </span>
            <span class="badge px-3 py-2 fw-bold rounded-pill" style="background:rgba(16,185,129,.2);font-size:11px;color:#6ee7b7;">
                <i class="fa-solid fa-circle-check me-1"></i> All Systems Operational
            </span>
        </div>
    </div>

    {{-- Alerts --}}
    @if(session('success'))
    <div class="d-flex align-items-center gap-3 rounded-4 px-4 py-3 mb-4 s-animate"
         style="background:#d1fae5;color:#065f46;border:1px solid #a7f3d0;">
        <i class="fa-solid fa-circle-check fs-5"></i>
        <span class="fw-bold">{{ session('success') }}</span>
    </div>
    @endif
    @if($errors->any())
    <div class="rounded-4 px-4 py-3 mb-4 s-animate" style="background:#fee2e2;color:#991b1b;border:1px solid #fca5a5;">
        <ul class="mb-0 ps-3">
            @foreach($errors->all() as $error)
                <li class="fw-bold small">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- ── Main Grid ── --}}
    <div class="row g-4">

        {{-- ════════════════════════════════════════════ --}}
        {{-- LEFT COLUMN: Identity + Security             --}}
        {{-- ════════════════════════════════════════════ --}}
        <div class="col-12 col-lg-8 d-flex flex-column gap-4">

            {{-- Operator Identity Card --}}
            <div class="set-card s-animate s-delay-1">
                <div class="set-card-header">
                    <div class="set-icon" style="background:linear-gradient(135deg,#dbeafe,#bfdbfe);">
                        <i class="fa-solid fa-id-card-clip text-primary"></i>
                    </div>
                    <div>
                        <h5 class="fw-black mb-0" style="color:#0f172a;">Operator Identity</h5>
                        <p class="text-muted small mb-0">Your display name and account credentials</p>
                    </div>
                </div>
                <div class="set-card-body">
                    <form action="{{ route('admin.settings.identity') }}" method="POST">
                        @csrf
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="set-label">Operator ID (Email)</label>
                                <div class="position-relative">
                                    <input type="email" name="email" class="set-input form-control ps-4"
                                           value="{{ auth()->user()->email }}" required>
                                    <i class="fa-solid fa-envelope position-absolute text-muted" style="left:12px;top:50%;transform:translateY(-50%);font-size:12px;"></i>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="set-label">Display Name</label>
                                <div class="position-relative">
                                    <input type="text" name="name" class="set-input form-control ps-4"
                                           value="{{ auth()->user()->name }}" required>
                                    <i class="fa-solid fa-user position-absolute text-muted" style="left:12px;top:50%;transform:translateY(-50%);font-size:12px;"></i>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-3 mb-4 p-3 rounded-3" style="background:#f8fafc;border:1px solid #e2e8f0;">
                            <div style="width:38px;height:38px;background:linear-gradient(135deg,#dbeafe,#bfdbfe);border-radius:10px;display:flex;align-items:center;justify-content:center;">
                                <i class="fa-solid fa-shield-halved text-primary" style="font-size:14px;"></i>
                            </div>
                            <div>
                                <div class="fw-bold small text-dark">Clearance Level</div>
                                <div class="text-muted" style="font-size:11px;">
                                    <span class="badge rounded-pill px-3 py-1 fw-bold me-1"
                                          style="background:#dbeafe;color:#1e40af;font-size:10px;">
                                        {{ strtoupper(auth()->user()->role) }}
                                    </span>
                                    Full administrative access
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-set-primary">
                            <i class="fa-solid fa-floppy-disk me-2"></i> Save Identity
                        </button>
                    </form>
                </div>
            </div>

            {{-- Access & Security Card --}}
            <div class="set-card s-animate s-delay-2">
                <div class="set-card-header">
                    <div class="set-icon" style="background:linear-gradient(135deg,#fef3c7,#fde68a);">
                        <i class="fa-solid fa-key" style="color:#b45309;"></i>
                    </div>
                    <div>
                        <h5 class="fw-black mb-0" style="color:#0f172a;">Access &amp; Security</h5>
                        <p class="text-muted small mb-0">Rotate your verification key periodically</p>
                    </div>
                </div>
                <div class="set-card-body">
                    <form action="{{ route('admin.settings.security') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="set-label">Current Verification Key</label>
                            <div class="position-relative">
                                <input type="password" name="current_password"
                                       class="set-input form-control ps-4"
                                       placeholder="••••••••••••" required>
                                <i class="fa-solid fa-lock position-absolute text-muted" style="left:12px;top:50%;transform:translateY(-50%);font-size:12px;"></i>
                            </div>
                        </div>
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="set-label">New Access Key</label>
                                <div class="position-relative">
                                    <input type="password" name="password"
                                           class="set-input form-control ps-4"
                                           placeholder="Min 12 characters" required>
                                    <i class="fa-solid fa-key position-absolute text-muted" style="left:12px;top:50%;transform:translateY(-50%);font-size:12px;"></i>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="set-label">Confirm Key</label>
                                <div class="position-relative">
                                    <input type="password" name="password_confirmation"
                                           class="set-input form-control ps-4"
                                           placeholder="Repeat key" required>
                                    <i class="fa-solid fa-check-double position-absolute text-muted" style="left:12px;top:50%;transform:translateY(-50%);font-size:12px;"></i>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-set-outline">
                            <i class="fa-solid fa-rotate me-2"></i> Rotate Security Key
                        </button>
                    </form>
                </div>
            </div>

        </div>

        {{-- ════════════════════════════════════════════ --}}
        {{-- RIGHT COLUMN: UI + Audit                    --}}
        {{-- ════════════════════════════════════════════ --}}
        <div class="col-12 col-lg-4 d-flex flex-column gap-4">

            {{-- Interface Optimization Panel --}}
            <div class="ui-panel p-4 s-animate s-delay-3">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <div style="width:44px;height:44px;background:rgba(255,255,255,.12);border-radius:14px;display:flex;align-items:center;justify-content:center;">
                        <i class="fa-solid fa-wand-magic-sparkles text-info fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-black mb-0">Interface</h5>
                        <p class="text-white-50 small mb-0">Personalize your workspace</p>
                    </div>
                </div>

                {{-- Visual Effects --}}
                <div class="mb-4">
                    <div class="set-label text-white-50 mb-3">Visual Effects</div>
                    <div class="d-flex flex-column gap-2">
                        <div class="stat-mini justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-droplet text-info small"></i>
                                <span class="small fw-bold">Glassmorphism</span>
                            </div>
                            <div class="form-check form-switch m-0 set-switch">
                                <input class="form-check-input" type="checkbox" id="glassToggle" onchange="toggleUI('glass')">
                            </div>
                        </div>
                        <div class="stat-mini justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-compress text-cyan small" style="color:#67e8f9;"></i>
                                <span class="small fw-bold">Compact View</span>
                            </div>
                            <div class="form-check form-switch m-0 set-switch">
                                <input class="form-check-input" type="checkbox" id="compactToggle" onchange="toggleUI('compact')">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Accent Palette --}}
                <div>
                    <div class="set-label text-white-50 mb-3">Accent Palette</div>
                    <div class="d-flex gap-2 flex-wrap">
                        <div class="color-swatch" style="background:#2563eb;" data-color="blue"    title="Blue"    onclick="setAccent('blue')"></div>
                        <div class="color-swatch" style="background:#8b5cf6;" data-color="purple"  title="Purple"  onclick="setAccent('purple')"></div>
                        <div class="color-swatch" style="background:#10b981;" data-color="emerald" title="Emerald" onclick="setAccent('emerald')"></div>
                        <div class="color-swatch" style="background:#f43f5e;" data-color="rose"    title="Rose"    onclick="setAccent('rose')"></div>
                        <div class="color-swatch" style="background:#f59e0b;" data-color="amber"   title="Amber"   onclick="setAccent('amber')"></div>
                        <div class="color-swatch" style="background:#06b6d4;" data-color="cyan"    title="Cyan"    onclick="setAccent('cyan')"></div>
                    </div>
                </div>
            </div>

            {{-- Audit History Card --}}
            <div class="set-card s-animate s-delay-4">
                <div class="set-card-header">
                    <div class="set-icon" style="background:linear-gradient(135deg,#f0fdf4,#bbf7d0);">
                        <i class="fa-solid fa-clock-rotate-left" style="color:#16a34a;"></i>
                    </div>
                    <div>
                        <h5 class="fw-black mb-0" style="color:#0f172a;">Audit History</h5>
                        <p class="text-muted small mb-0">Security &amp; change log</p>
                    </div>
                </div>
                <div class="set-card-body">
                    {{-- Mini timeline --}}
                    <div class="d-flex flex-column gap-3 mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:36px;height:36px;background:#eff6ff;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fa-solid fa-rotate text-primary" style="font-size:12px;"></i>
                            </div>
                            <div>
                                <div class="fw-bold small text-dark">Security Key Rotated</div>
                                <div class="text-muted" style="font-size:11px;">14 days ago</div>
                            </div>
                            <span class="badge rounded-pill ms-auto" style="background:#eff6ff;color:#2563eb;font-size:9px;">System</span>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div style="width:36px;height:36px;background:#f0fdf4;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fa-solid fa-user-check" style="color:#16a34a;font-size:12px;"></i>
                            </div>
                            <div>
                                <div class="fw-bold small text-dark">Identity Updated</div>
                                <div class="text-muted" style="font-size:11px;">{{ auth()->user()->updated_at->diffForHumans() }}</div>
                            </div>
                            <span class="badge rounded-pill ms-auto" style="background:#f0fdf4;color:#16a34a;font-size:9px;">Profile</span>
                        </div>
                    </div>
                    <button class="btn w-100 fw-bold py-2"
                            style="background:#f8fafc;border:1.5px solid #e2e8f0;border-radius:12px;color:#64748b;font-size:13px;">
                        <i class="fa-solid fa-list-ul me-2"></i> View Full System Logs
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const glass   = localStorage.getItem('ui_glass')   === 'true';
    const compact = localStorage.getItem('ui_compact') === 'true';
    const accent  = localStorage.getItem('ui_accent')  || 'blue';

    document.getElementById('glassToggle').checked   = glass;
    document.getElementById('compactToggle').checked = compact;

    document.querySelectorAll('.color-swatch').forEach(s => {
        s.classList.toggle('active', s.dataset.color === accent);
    });
    applyUI();
});

function toggleUI(key) {
    const val = document.getElementById(key + 'Toggle').checked;
    localStorage.setItem('ui_' + key, val);
    applyUI();
}

function setAccent(color) {
    localStorage.setItem('ui_accent', color);
    document.querySelectorAll('.color-swatch').forEach(s =>
        s.classList.toggle('active', s.dataset.color === color)
    );
    applyUI();
}

function applyUI() {
    const glass   = localStorage.getItem('ui_glass')   === 'true';
    const compact = localStorage.getItem('ui_compact') === 'true';
    const accent  = localStorage.getItem('ui_accent')  || 'blue';
    document.documentElement.classList.toggle('glass-ui',   glass);
    document.documentElement.classList.toggle('compact-ui', compact);
    document.documentElement.setAttribute('data-accent', accent);
    document.body.classList.toggle('glass-ui',   glass);
    document.body.classList.toggle('compact-ui', compact);
}
</script>
@endsection
