    <!-- Add Booking Modal -->
    <div class="modal fade" id="addBookingModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
                <div class="modal-header border-0 px-4 pt-4 pb-0">
                    <h5 class="modal-title fw-bold" style="color: #1e3a8a;">New Clinical Booking</h5>
                    <button type="button" class="btn-close shadow-none p-3 bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.bookings.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Select Patient</label>
                            <div class="input-group bg-light rounded-4 p-1">
                                <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-user-injured text-primary"></i></span>
                                <select name="patient_id" class="form-select border-0 bg-transparent shadow-none py-2" required>
                                    <option value="" disabled selected>Choose a patient...</option>
                                    @foreach($patients as $p)
                                        <option value="{{ $p->id }}">{{ $p->name }} (ID: {{ $p->id }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Investigations Catalog</label>
                            <div class="lab-test-container shadow-none">
                                @foreach($testTypes as $test)
                                    <label class="lab-test-item" for="addTest{{ $test->id }}">
                                        <input class="form-check-input" type="checkbox" name="tests[]" value="{{ $test->id }}" id="addTest{{ $test->id }}">
                                        <span class="lab-test-label">
                                            {{ $test->name }} <span class="lab-test-price">(₹{{ number_format($test->price, 2) }})</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Booking Date</label>
                                <input type="date" name="booking_date" class="form-control bg-light border-0 py-2 shadow-none rounded-4" value="{{ date('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Initial Status</label>
                                <select name="status" class="form-select bg-light border-0 py-2 shadow-none rounded-4" required>
                                    <option value="Pending">Pending</option>
                                    <option value="Confirmed">Confirmed</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Administrative Notes</label>
                                <textarea name="notes" class="form-control bg-light border-0 py-3 shadow-none rounded-4" rows="2" placeholder="Clinical observations or instructions..."></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4 gap-2">
                        <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none px-4" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-lg" style="border-radius: 12px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border: none;">Generate Booking</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($bookings as $booking)
    <!-- Edit Booking Modal -->
    <div class="modal fade" id="editModal{{ $booking->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
                <div class="modal-header border-0 px-4 pt-4 pb-0">
                    <h5 class="modal-title fw-bold" style="color: #1e3a8a;">Modify Booking <span class="badge bg-soft-primary text-primary ms-2">{{ $booking->booking_id }}</span></h5>
                    <button type="button" class="btn-close shadow-none p-3 bg-light rounded-circle" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.bookings.update', $booking) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Reassign Patient</label>
                            <div class="input-group bg-light rounded-4 p-1">
                                <span class="input-group-text bg-transparent border-0"><i class="fa-solid fa-user-pen text-warning"></i></span>
                                <select name="patient_id" class="form-select border-0 bg-transparent shadow-none py-2" required>
                                    @foreach($patients as $p)
                                        <option value="{{ $p->id }}" {{ $booking->patient_id == $p->id ? 'selected' : '' }}>{{ $p->name }} (ID: {{ $p->id }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted text-uppercase">Update Investigations</label>
                            @php $selectedTests = is_array($booking->tests) ? $booking->tests : []; @endphp
                            <div class="lab-test-container shadow-none">
                                @foreach($testTypes as $test)
                                    <label class="lab-test-item" for="editTest{{ $booking->id }}_{{ $test->id }}">
                                        <input class="form-check-input" type="checkbox" name="tests[]" value="{{ $test->id }}" id="editTest{{ $booking->id }}_{{ $test->id }}" {{ in_array($test->id, $selectedTests) ? 'checked' : '' }}>
                                        <span class="lab-test-label">
                                            {{ $test->name }} <span class="lab-test-price">(₹{{ number_format($test->price, 2) }})</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Effective Date</label>
                                <input type="date" name="booking_date" class="form-control bg-light border-0 py-2 shadow-none rounded-4" value="{{ $booking->booking_date->format('Y-m-d') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted text-uppercase">Booking Lifecycle</label>
                                <select name="status" class="form-select bg-light border-0 py-2 shadow-none rounded-4" required>
                                    <option value="Pending" {{ $booking->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Confirmed" {{ $booking->status == 'Confirmed' ? 'selected' : '' }}>Confirmed</option>
                                    <option value="Cancelled" {{ $booking->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted text-uppercase">Observations</label>
                                <textarea name="notes" class="form-control bg-light border-0 py-3 shadow-none rounded-4" rows="2">{{ $booking->notes }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4 gap-2">
                        <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none px-4" data-bs-dismiss="modal">Cancel Edits</button>
                        <button type="submit" class="btn btn-warning px-5 fw-bold shadow-lg text-white" style="border-radius: 12px; background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); border: none;">Commit Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
