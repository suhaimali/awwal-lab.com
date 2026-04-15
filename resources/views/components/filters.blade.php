<div class="card border-0 shadow-sm mb-4 mx-2">
    <div class="card-body p-3">
        <form method="GET" class="row g-3 align-items-end">
            <div class="col-12 col-md-3">
                <label class="bill-lbl">Search Patient</label>
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm bg-light border-0 shadow-none" placeholder="Name or phone...">
            </div>
            <div class="col-12 col-md-4">
                <label class="bill-lbl">Date Range</label>
                <div class="input-group input-group-sm">
                    <input type="date" name="from" value="{{ request('from') }}" class="form-control border-0 bg-light">
                    <input type="date" name="to" value="{{ request('to') }}" class="form-control border-0 bg-light ms-1">
                </div>
            </div>
            <div class="col-12 col-md-2">
                <label class="bill-lbl">Status</label>
                <select name="status" class="form-select form-select-sm border-0 bg-light">
                    <option value="">All Status</option>
                    <option value="Confirmed" {{ request('status') == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                </select>
            </div>
            <div class="col-12 col-md-3 d-flex gap-2">
                <button class="btn btn-primary btn-sm w-100 fw-bold shadow-sm" type="submit">Filter Results</button>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-light btn-sm border px-3"><i class="fa fa-sync-alt"></i></a>
            </div>
        </form>
    </div>
</div>