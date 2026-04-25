    <!-- ============================================================ -->
    <!-- Edit Registration Modals (one per patient) -->
    <!-- ============================================================ -->
    @foreach($patients as $patient)
    <div class="modal fade" id="editRegistrationModal{{ $patient->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered text-start">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
                <div class="modal-header border-0 px-4 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="modal-title fw-bold mb-1" style="color: #1e3a8a;">Modify Registration</h4>
                        <p class="text-muted small mb-0">
                            @if($patient->latestBooking)
                                Reference: <span class="badge bg-soft-primary text-primary fw-bold">{{ $patient->latestBooking->bill_no }}</span>
                            @else
                                <span class="badge bg-soft-warning text-warning fw-bold">No Booking Yet</span>
                            @endif
                        </p>
                    </div>
                    <button type="button" class="btn-close shadow-none p-3 bg-light rounded-circle" data-bs-dismiss="modal"></button>
                </div>

                {{-- enctype REQUIRED for photo upload --}}
                <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body p-4">

                        {{-- Section 1: Personal Details --}}
                        <div class="card border-0 bg-light mb-4" style="border-radius: 20px;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">

                                    {{-- Photo preview / upload --}}
                                    <div class="position-relative me-4" style="width:80px; height:80px; flex-shrink:0;">
                                        <img id="editPhotoPreview{{ $patient->id }}"
                                             src="{{ $patient->photo ? Storage::url($patient->photo) : asset('assets/img/default-patient.png') }}"
                                             class="rounded-circle shadow-sm border border-2 border-white"
                                             style="width:80px;height:80px;object-fit:cover;">
                                        <label for="editPhotoInput{{ $patient->id }}"
                                               class="btn btn-primary btn-sm rounded-circle position-absolute bottom-0 end-0 p-1 shadow"
                                               style="width:26px;height:26px;line-height:1;cursor:pointer;">
                                            <i class="fa-solid fa-camera" style="font-size:11px;"></i>
                                        </label>
                                        <input type="file" id="editPhotoInput{{ $patient->id }}" name="photo"
                                               class="d-none" accept="image/*"
                                               onchange="previewPhoto(this,'editPhotoPreview{{ $patient->id }}')">
                                    </div>

                                    <div>
                                        <h5 class="fw-bold mb-0" style="color:#1e293b;">1. Personal Details</h5>
                                        <p class="text-muted small mb-0">Identity &amp; Demographic Information</p>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Full Name</label>
                                        <input type="text" name="name" value="{{ $patient->name }}" class="form-control border-0 py-2 shadow-sm px-3" required style="border-radius:12px;">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Age (Years)</label>
                                        <input type="number" name="age" value="{{ $patient->age }}" class="form-control border-0 py-2 shadow-sm px-3" required style="border-radius:12px;">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Gender</label>
                                        <select name="gender" class="form-select border-0 py-2 shadow-sm px-3" required style="border-radius:12px;">
                                            <option value="Male"   {{ $patient->gender=='Male'   ? 'selected':'' }}>Male</option>
                                            <option value="Female" {{ $patient->gender=='Female' ? 'selected':'' }}>Female</option>
                                            <option value="Other"  {{ $patient->gender=='Other'  ? 'selected':'' }}>Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Phone Number</label>
                                        <input type="text" name="phone" value="{{ $patient->phone }}" class="form-control border-0 py-2 shadow-sm px-3" required style="border-radius:12px;">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label small fw-bold text-muted text-uppercase">Reference Doctor</label>
                                            <a href="javascript:void(0)" class="text-primary small fw-bold text-decoration-none" data-bs-toggle="modal" data-bs-target="#manageDoctorsModal">+ Manage</a>
                                        </div>
                                        <select name="reference_dr_name" class="form-select border-0 py-2 shadow-sm px-3" style="border-radius:12px;">
                                            <option value="">Self Referral</option>
                                            @foreach($doctors as $dr)
                                                <option value="{{ $dr->name }}" {{ $patient->reference_dr_name == $dr->name ? 'selected' : '' }}>{{ $dr->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Visit Date</label>
                                        <input type="date" name="visit_date"
                                               value="{{ $patient->visit_date ? $patient->visit_date->format('Y-m-d') : '' }}"
                                               class="form-control border-0 py-2 shadow-sm px-3" required style="border-radius:12px;">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Address</label>
                                        <textarea name="address" class="form-control border-0 py-2 shadow-sm px-3" rows="2" required style="border-radius:12px;">{{ $patient->address }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Investigation & Financials --}}
                        <div class="card border-0 bg-light" style="border-radius:20px;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box bg-success text-white rounded-4 d-flex align-items-center justify-content-center me-3" style="width:40px;height:40px;">
                                            <i class="fa-solid fa-file-invoice-dollar"></i>
                                        </div>
                                        <h5 class="fw-bold mb-0" style="color:#1e293b;">2. Investigation &amp; Financials</h5>
                                    </div>
                                    <button type="button" class="btn btn-soft-primary btn-sm rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#manageTestsModal">
                                        <i class="fa-solid fa-flask-vial me-1"></i> Manage Tests
                                    </button>
                                </div>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase">LAB TESTS</label>
                                        <div id="testContainer{{ $patient->id }}" class="lab-test-container shadow-none">
                                            @php $selectedTests = $patient->latestBooking->tests ?? []; @endphp
                                            @foreach($testTypes as $test)
                                                <div class="lab-test-item-wrapper d-flex align-items-center justify-content-between mb-1">
                                                    <label class="lab-test-item mb-0 flex-grow-1" for="testEdit{{ $patient->id }}_{{ $test->id }}">
                                                        <input class="form-check-input" type="checkbox"
                                                               name="tests[]" value="{{ $test->id }}"
                                                               data-price="{{ $test->price }}"
                                                               id="testEdit{{ $patient->id }}_{{ $test->id }}"
                                                               {{ in_array((string)$test->id, array_map('strval', $selectedTests)) ? 'checked' : '' }}
                                                               onchange="updateTotalBill('{{ $patient->id }}')">
                                                        <span class="lab-test-label">
                                                            {{ $test->name }} <span class="lab-test-price">(₹{{ number_format($test->price, 2) }})</span>
                                                        </span>
                                                    </label>
                                                    <div class="test-action-btns d-flex gap-1 ms-2">
                                                        <button type="button" class="btn btn-link text-primary p-0 shadow-none" onclick="openEditTestModal({{ $test->id }}, '{{ $test->name }}', {{ $test->price }})" title="Edit Test"><i class="fa-solid fa-pen-to-square" style="font-size: 12px;"></i></button>
                                                        <form action="{{ route('admin.test-types.destroy', $test->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this test?');">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-link text-danger p-0 shadow-none" title="Delete Test"><i class="fa-solid fa-trash-can" style="font-size: 12px;"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Total</label>
                                        <input type="number" name="total_amount" id="totalBill{{ $patient->id }}"
                                               value="{{ $patient->latestBooking->total_amount ?? 0 }}"
                                               class="form-control border-0 py-2 shadow-sm px-3 fw-bold text-primary" required
                                               style="border-radius:12px;" oninput="calculateBalance('{{ $patient->id }}')">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Disc.</label>
                                        <input type="number" name="discount" id="discountAmount{{ $patient->id }}"
                                               value="{{ $patient->latestBooking->discount ?? 0 }}"
                                               class="form-control border-0 py-2 shadow-sm px-3 fw-bold text-danger"
                                               style="border-radius:12px;" oninput="calculateBalance('{{ $patient->id }}')">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Advance</label>
                                        <input type="number" name="advance_amount" id="advancePaid{{ $patient->id }}"
                                               value="{{ $patient->latestBooking->advance_amount ?? 0 }}"
                                               class="form-control border-0 py-2 shadow-sm px-3 fw-bold text-success"
                                               style="border-radius:12px;" oninput="calculateBalance('{{ $patient->id }}')">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Balance Due</label>
                                        <input type="number" name="balance_amount" id="balanceDue{{ $patient->id }}"
                                               value="{{ $patient->latestBooking->balance_amount ?? 0 }}"
                                               class="form-control border-0 py-2 shadow-sm px-3 fw-bold text-danger" readonly
                                               style="border-radius:12px; background:#fff1f2 !important;">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Report Date</label>
                                        <input type="date" name="reporting_date"
                                               value="{{ optional($patient->latestBooking)->reporting_date ? $patient->latestBooking->reporting_date->format('Y-m-d') : '' }}"
                                               class="form-control border-0 py-2 shadow-sm px-3" style="border-radius:12px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 pb-4 gap-2">
                        <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none px-4" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-lg"
                                style="border-radius:12px; background:linear-gradient(135deg,#1e40af 0%,#3b82f6 100%); border:none;">
                            Update Registration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach

    <!-- ============================================================ -->
    <!-- New Patient Registration Modal -->
    <!-- ============================================================ -->
    <div class="modal fade" id="addRegistrationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius:25px; overflow:hidden;">
                <div class="modal-header border-0 px-4 pt-4 pb-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="modal-title fw-bold mb-1" style="color:#1e3a8a;">New Patient Registration</h4>
                        <p class="text-muted small mb-0">Step 1 of 2: Create Clinical Profile</p>
                    </div>
                    <button type="button" class="btn-close shadow-none p-3 bg-light rounded-circle" data-bs-dismiss="modal"></button>
                </div>

                <form action="{{ route('admin.patients.store') }}" method="POST" enctype="multipart/form-data" id="registrationForm">
                    @csrf
                    <div class="modal-body p-4">

                        {{-- Section 1: Personal Details --}}
                        <div class="card border-0 bg-light mb-4" style="border-radius:20px;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center mb-4">

                                    {{-- Photo upload --}}
                                    <div class="position-relative me-4" style="width:80px;height:80px;flex-shrink:0;">
                                        <img id="newPhotoPreview"
                                             src="{{ asset('assets/img/default-patient.png') }}"
                                             class="rounded-circle shadow-sm border border-2 border-white"
                                             style="width:80px;height:80px;object-fit:cover;">
                                        <label for="newPhotoInput"
                                               class="btn btn-primary btn-sm rounded-circle position-absolute bottom-0 end-0 p-1 shadow"
                                               style="width:26px;height:26px;line-height:1;cursor:pointer;">
                                            <i class="fa-solid fa-camera" style="font-size:11px;"></i>
                                        </label>
                                        <input type="file" id="newPhotoInput" name="photo"
                                               class="d-none" accept="image/*"
                                               onchange="previewPhoto(this,'newPhotoPreview')">
                                    </div>

                                    <div>
                                        <h5 class="fw-bold mb-0" style="color:#1e293b;">1. Personal Details</h5>
                                        <p class="text-muted small mb-0">Demographic &amp; Contact Setup</p>
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Full Name</label>
                                        <input type="text" name="name" class="form-control border-0 py-2 shadow-sm px-3" required placeholder="Enter full name" style="border-radius:12px;">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Age (Years)</label>
                                        <input type="number" name="age" class="form-control border-0 py-2 shadow-sm px-3" required placeholder="0" style="border-radius:12px;">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Gender</label>
                                        <select name="gender" class="form-select border-0 py-2 shadow-sm px-3" required style="border-radius:12px;">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                            <option value="Other">Other</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Phone Number</label>
                                        <input type="text" name="phone" class="form-control border-0 py-2 shadow-sm px-3" required placeholder="+91 ..." style="border-radius:12px;">
                                    </div>
                                    <div class="col-md-4">
                                        <div class="d-flex justify-content-between">
                                            <label class="form-label small fw-bold text-muted text-uppercase">Reference Doctor</label>
                                            <a href="javascript:void(0)" class="text-primary small fw-bold text-decoration-none" data-bs-toggle="modal" data-bs-target="#manageDoctorsModal">+ Manage</a>
                                        </div>
                                        <select name="reference_dr_name" class="form-select border-0 py-2 shadow-sm px-3" style="border-radius:12px;">
                                            <option value="">Self Referral</option>
                                            @foreach($doctors as $dr)
                                                <option value="{{ $dr->name }}">{{ $dr->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Visit Date</label>
                                        <input type="date" name="visit_date" value="{{ date('Y-m-d') }}" class="form-control border-0 py-2 shadow-sm px-3" required style="border-radius:12px;">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Address</label>
                                        <textarea name="address" class="form-control border-0 py-2 shadow-sm px-3" rows="2" required placeholder="Full residential address" style="border-radius:12px;"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Section 2: Investigation & Financials --}}
                        <div class="card border-0 bg-light" style="border-radius:20px;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between mb-4">
                                    <div class="d-flex align-items-center">
                                        <div class="icon-box bg-success text-white rounded-4 d-flex align-items-center justify-content-center me-3" style="width:40px;height:40px;">
                                            <i class="fa-solid fa-file-invoice-dollar"></i>
                                        </div>
                                        <h5 class="fw-bold mb-0" style="color:#1e293b;">2. Investigation &amp; Financials</h5>
                                    </div>
                                    <button type="button" class="btn btn-soft-primary btn-sm rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#manageTestsModal">
                                        <i class="fa-solid fa-flask-vial me-1"></i> Manage Tests
                                    </button>
                                </div>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted text-uppercase">LAB TESTS</label>
                                        <div id="testContainerNew" class="lab-test-container shadow-none">
                                            @foreach($testTypes as $test)
                                                <div class="lab-test-item-wrapper d-flex align-items-center justify-content-between mb-1">
                                                    <label class="lab-test-item mb-0 flex-grow-1" for="testNew{{ $test->id }}">
                                                        <input class="form-check-input" type="checkbox"
                                                               name="tests[]" value="{{ $test->id }}"
                                                               data-price="{{ $test->price }}"
                                                               id="testNew{{ $test->id }}"
                                                               onchange="updateTotalBill('New')">
                                                        <span class="lab-test-label">
                                                            {{ $test->name }} <span class="lab-test-price">(₹{{ number_format($test->price, 2) }})</span>
                                                        </span>
                                                    </label>
                                                    <div class="test-action-btns d-flex gap-1 ms-2">
                                                        <button type="button" class="btn btn-link text-primary p-0 shadow-none" onclick="openEditTestModal({{ $test->id }}, '{{ $test->name }}', {{ $test->price }})" title="Edit Test"><i class="fa-solid fa-pen-to-square" style="font-size: 12px;"></i></button>
                                                        <form action="{{ route('admin.test-types.destroy', $test->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this test?');">
                                                            @csrf @method('DELETE')
                                                            <button type="submit" class="btn btn-link text-danger p-0 shadow-none" title="Delete Test"><i class="fa-solid fa-trash-can" style="font-size: 12px;"></i></button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Total</label>
                                        <input type="number" name="total_amount" id="totalBillNew" value="0"
                                               class="form-control border-0 py-2 shadow-sm px-3 fw-bold text-primary" required
                                               style="border-radius:12px;" oninput="calculateBalance('New')">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Disc.</label>
                                        <input type="number" name="discount" id="discountAmountNew" value="0"
                                               class="form-control border-0 py-2 shadow-sm px-3 fw-bold text-danger"
                                               style="border-radius:12px;" oninput="calculateBalance('New')">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Advance</label>
                                        <input type="number" name="advance_amount" id="advancePaidNew" value="0"
                                               class="form-control border-0 py-2 shadow-sm px-3 fw-bold text-success"
                                               style="border-radius:12px;" oninput="calculateBalance('New')">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Balance Due</label>
                                        <input type="number" name="balance_amount" id="balanceDueNew" value="0"
                                               class="form-control border-0 py-2 shadow-sm px-3 fw-bold text-danger" readonly
                                               style="border-radius:12px; background:#fff1f2 !important;">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label small fw-bold text-muted text-uppercase">Report Date</label>
                                        <input type="date" name="reporting_date" class="form-control border-0 py-2 shadow-sm px-3" style="border-radius:12px;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer border-0 px-4 pb-4 gap-2">
                        <button type="button" class="btn btn-link text-muted fw-bold text-decoration-none px-4" data-bs-dismiss="modal">Discard</button>
                        <button type="submit" class="btn btn-primary px-5 fw-bold shadow-lg"
                                style="border-radius:12px; background:linear-gradient(135deg,#1e40af 0%,#3b82f6 100%); border:none;">
                            Complete Registration
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- Manage Doctors Modal -->
    <!-- ============================================================ -->
    <div class="modal fade" id="manageDoctorsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0" style="color: #1e3a8a;">Manage Reference Doctors</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.doctors.store') }}" method="POST" class="mb-4 bg-light p-3 rounded-4">
                        @csrf
                        <div class="row g-2">
                            <div class="col-8">
                                <input type="text" name="name" class="form-control border-0 shadow-sm" placeholder="Doctor Name" required style="border-radius: 10px;">
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary w-100 fw-bold" style="border-radius: 10px;">Add</button>
                            </div>
                        </div>
                    </form>
                    <div class="doctor-list" style="max-height: 300px; overflow-y: auto;">
                        @foreach($doctors as $dr)
                        <div class="d-flex align-items-center justify-content-between p-2 border-bottom">
                            <span class="fw-bold text-dark">{{ $dr->name }}</span>
                            <form action="{{ route('admin.doctors.destroy', $dr->id) }}" method="POST" onsubmit="return confirm('Remove this doctor?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-link text-danger p-0"><i class="fa-solid fa-trash-can"></i></button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- Manage Lab Tests Modal (Shortcut) -->
    <!-- ============================================================ -->
    <div class="modal fade" id="manageTestsModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0" style="color: #1e3a8a;">Add Custom Lab Test</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form action="{{ route('admin.test-types.store') }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted">TEST CODE</label>
                                <input type="text" name="test_code" class="form-control bg-light border-0" required placeholder="e.g. CBC01" style="border-radius: 10px;">
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted">CATEGORY</label>
                                <input type="text" name="category" class="form-control bg-light border-0" required placeholder="e.g. Hematology" style="border-radius: 10px;">
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold text-muted">TEST NAME</label>
                                <input type="text" name="name" class="form-control bg-light border-0" required placeholder="e.g. Glucose Test" style="border-radius: 10px;">
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted">PRICE (₹)</label>
                                <input type="number" name="price" class="form-control bg-light border-0" required placeholder="0.00" style="border-radius: 10px;">
                            </div>
                            <div class="col-md-6">
                                <label class="small fw-bold text-muted">STATUS</label>
                                <select name="status" class="form-select bg-light border-0" style="border-radius: 10px;">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="col-12 pt-2">
                                <button type="submit" class="btn btn-primary w-100 fw-bold py-2" style="border-radius: 12px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border: none;">Save Test to Network</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================ -->
    <!-- Edit Test Shortcut Modal -->
    <!-- ============================================================ -->
    <div class="modal fade" id="editTestShortcutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="fw-bold mb-0" style="color: #1e3a8a;">Update Test Protocol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="editTestShortcutForm" method="POST">
                        @csrf @method('PUT')
                        <div class="row g-3">
                            <input type="hidden" name="test_code" id="editTestCode">
                            <input type="hidden" name="category" id="editTestCategory">
                            <input type="hidden" name="status" value="Active">
                            <div class="col-12">
                                <label class="small fw-bold text-muted">TEST NAME</label>
                                <input type="text" name="name" id="editTestName" class="form-control bg-light border-0" required style="border-radius: 10px;">
                            </div>
                            <div class="col-12">
                                <label class="small fw-bold text-muted">PRICE (₹)</label>
                                <input type="number" name="price" id="editTestPrice" class="form-control bg-light border-0" required style="border-radius: 10px;">
                            </div>
                            <div class="col-12 pt-2">
                                <button type="submit" class="btn btn-primary w-100 fw-bold py-2" style="border-radius: 12px; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%); border: none;">Update Test</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

<script>
function previewPhoto(input, previewId) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => { document.getElementById(previewId).src = e.target.result; };
        reader.readAsDataURL(input.files[0]);
    }
}

function openEditTestModal(id, name, price) {
    const form = document.getElementById('editTestShortcutForm');
    form.action = "{{ url('admin/test-types') }}/" + id;
    document.getElementById('editTestName').value = name;
    document.getElementById('editTestPrice').value = price;
    
    // We need to fetch the existing code/category or just use defaults if not critical
    // For now, we'll keep them as they are in the DB by using hidden inputs or just sending what we have
    // In a real app, you'd fetch these via AJAX first.
    document.getElementById('editTestCode').value = "REF-" + id; 
    document.getElementById('editTestCategory').value = "General";

    var myModal = new bootstrap.Modal(document.getElementById('editTestShortcutModal'));
    myModal.show();
}
</script>
