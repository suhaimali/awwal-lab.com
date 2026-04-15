<div class="standard-table mx-2 shadow-sm mb-4">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead>
                <tr>
                    <th class="ps-3 text-center">ID</th>
                    <th>Patient Details</th>
                    <th>Schedule</th>
                    <th>Test Type</th>
                    <th>Billing Summary</th>
                    <th>Status</th>
                    <th class="text-end pe-3">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($bookings as $booking)
                <tr>
                    <td data-label="ID No" class="ps-md-3 text-md-center fw-bold"><span class="id-badge">#{{ $loop->iteration }}</span></td>
                    <td data-label="Patient">
                        <div class="fw-bold text-dark">{{ $booking->patient->name ?? 'Unknown' }}</div>
                        <small class="text-muted">{{ $booking->patient->phone ?? 'N/A' }}</small>
                        @if($booking->notes)
                        <div class="text-muted mt-1" style="font-size: 0.65rem; font-style: italic;">Note: {{ Str::limit($booking->notes, 20) }}</div>
                        @endif
                    </td>
                    <td data-label="Schedule">
                        <div class="small fw-bold text-nowrap"><i class="fa fa-calendar-alt text-primary me-1"></i> {{ $booking->booking_date }}</div>
                        <div class="small text-muted text-nowrap mt-1"><i class="fa fa-clock text-primary me-1"></i> {{ $booking->booking_time }}</div>
                    </td>
                    <td data-label="Test Type">
                        <span class="badge bg-light text-primary border border-primary px-2">{{ $booking->test_type }}</span>
                    </td>
                    <td data-label="Billing Summary">
                        <div class="bill-stack">
                            <span class="bill-lbl">Total Amount (₹)</span>
                            <span class="bill-val">₹{{ number_format($booking->amount + $booking->discount, 2) }}</span>
                            <span class="bill-lbl text-danger">Discount (₹)</span>
                            <span class="bill-val text-danger">-₹{{ number_format($booking->discount, 2) }}</span>
                            <span class="bill-final-lbl">FINAL PAYABLE</span>
                            <span class="bill-final-val">₹{{ number_format($booking->amount, 2) }}</span>
                            <small class="text-muted uppercase" style="font-size: 0.6rem;">{{ $booking->payment_method ?? 'Cash' }}</small>
                        </div>
                    </td>
                    <td data-label="Status">
                        <span class="status-pill @if($booking->status == 'Confirmed') bg-success-soft @else bg-warning-soft @endif">
                            {{ $booking->status }}
                        </span>
                    </td>
                    <td data-label="Actions" class="text-end pe-3">
                        <div class="btn-group bg-white border rounded shadow-sm">
                            <button class="btn btn-sm text-primary border-0" data-bs-toggle="modal" data-bs-target="#editModal{{ $booking->id }}"><i class="fa fa-edit"></i></button>
                            <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm text-danger border-0 border-start" onclick="return confirm('Delete?')"><i class="fa fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-5 text-muted">No records found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $bookings->appends(request()->input())->links() }}</div>
</div>