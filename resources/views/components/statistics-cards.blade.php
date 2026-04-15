<div class="row g-3 mb-4 px-2">
    <div class="col-6 col-md-2">
        <div class="card stat-card bg-gradient-blue shadow-sm">
            <div class="card-body p-3">
                <small class="fw-bold opacity-75">TOTAL</small>
                <h3 class="mb-0 fw-bold">{{ $bookings->total() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2 text-white">
        <div class="card stat-card bg-success shadow-sm h-100">
            <div class="card-body p-3">
                <small class="fw-bold opacity-75">CONFIRMED</small>
                <h3 class="mb-0 fw-bold text-white">{{ $bookings->where('status', 'Confirmed')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-2 text-dark">
        <div class="card stat-card bg-warning shadow-sm h-100">
            <div class="card-body p-3">
                <small class="fw-bold opacity-75">PENDING</small>
                <h3 class="mb-0 fw-bold text-dark">{{ $bookings->where('status', 'Pending')->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-12 col-md-6">
        <div class="card border-0 shadow-sm bg-white border-start border-primary border-5 h-100">
            <div class="card-body p-3 d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted small fw-bold">ESTIMATED REVENUE</div>
                    <h3 class="mb-0 fw-bold text-primary">₹ {{ number_format($totalRevenue ?? 0, 2) }}</h3>
                </div>
                <i class="fa fa-indian-rupee-sign text-primary opacity-25 fa-2x"></i>
            </div>
        </div>
    </div>
</div>