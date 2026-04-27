{{-- Simple Blue & White Registration Modals --}}

{{-- EDIT REGISTRATION MODAL --}}
@foreach($patients as $patient)
<div class="modal fade" id="editRegistrationModal{{ $patient->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-primary text-white p-4 border-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fa-solid fa-user-pen text-primary"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0">Modify Patient Profile</h5>
                        <small class="text-white-50">Patient ID: #{{ $patient->id }}</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.patients.update', $patient->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4 bg-light">
                    <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius: 15px;">
                        <div class="row g-3">
                            {{-- Photo Section --}}
                            <div class="col-12 mb-3">
                                <div class="d-flex align-items-center gap-3 photo-upload-container">
                                    <div class="photo-preview" style="width: 70px; height: 70px;">
                                        @if($patient->photo)
                                            <img src="{{ Storage::url($patient->photo) }}" class="rounded-circle shadow-sm" style="width:100%;height:100%;object-fit:cover;border:3px solid #fff;">
                                        @else
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center fw-bold" style="width:100%;height:100%;font-size:24px;">
                                                {{ strtoupper(substr($patient->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-label small fw-bold text-muted mb-1">Update Patient Photo</label>
                                        <input type="file" name="photo" class="form-control form-control-sm border-0 bg-light rounded-3" onchange="previewImage(this)">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label small fw-bold text-muted">Full Name</label>
                                <input type="text" name="name" value="{{ $patient->name }}" class="form-control rounded-3 border-light shadow-none" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Age</label>
                                <input type="number" name="age" value="{{ $patient->age }}" class="form-control rounded-3 border-light shadow-none" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Gender</label>
                                <select name="gender" class="form-select rounded-3 border-light shadow-none" required>
                                    <option value="Male" {{ $patient->gender=='Male' ? 'selected':'' }}>Male</option>
                                    <option value="Female" {{ $patient->gender=='Female' ? 'selected':'' }}>Female</option>
                                    <option value="Other" {{ $patient->gender=='Other' ? 'selected':'' }}>Other</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label small fw-bold text-muted">Phone Number</label>
                                <input type="text" name="phone" value="{{ $patient->phone }}" class="form-control rounded-3 border-light shadow-none" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Reference Doctor</label>
                                <select name="reference_dr_name" class="form-select rounded-3 border-light shadow-none">
                                    <option value="">Direct/Self</option>
                                    @foreach($doctors as $dr)
                                        <option value="{{ $dr->name }}" {{ $patient->reference_dr_name == $dr->name ? 'selected' : '' }}>{{ $dr->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Visit Date</label>
                                <input type="date" name="visit_date" value="{{ $patient->visit_date ? $patient->visit_date->format('Y-m-d') : '' }}" class="form-control rounded-3 border-light shadow-none" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">Address</label>
                                <textarea name="address" class="form-control rounded-3 border-light shadow-none" rows="2" required>{{ $patient->address }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white p-3 border-0">
                    <button type="button" class="btn btn-light px-4 fw-bold rounded-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-5 fw-bold rounded-3">Update Profile</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

{{-- NEW REGISTRATION MODAL --}}
<div class="modal fade" id="addRegistrationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-primary text-white p-4 border-0">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-white rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 45px; height: 45px;">
                        <i class="fa-solid fa-user-plus text-primary"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0">New Patient Registration</h5>
                        <small class="text-white-50">SoftLab Clinical Intake</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('admin.patients.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4 bg-light">
                    <div class="card border-0 shadow-sm p-4 mb-3" style="border-radius: 15px;">
                        <div class="row g-3">
                            {{-- Photo Section --}}
                            <div class="col-12 mb-3">
                                <div class="d-flex align-items-center gap-3 photo-upload-container">
                                    <div class="photo-preview bg-light rounded-circle d-flex align-items-center justify-content-center text-muted border" style="width: 70px; height: 70px; border-style: dashed !important;">
                                        <i class="fa-solid fa-camera fs-4"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-label small fw-bold text-muted mb-1">Patient Photo (Optional)</label>
                                        <input type="file" name="photo" class="form-control form-control-sm border-0 bg-light rounded-3" onchange="previewImage(this)">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <label class="form-label small fw-bold text-muted">Full Name</label>
                                <input type="text" name="name" class="form-control rounded-3 border-light shadow-none" required placeholder="John Doe">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Age</label>
                                <input type="number" name="age" class="form-control rounded-3 border-light shadow-none" required placeholder="0">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label small fw-bold text-muted">Gender</label>
                                <select name="gender" class="form-select rounded-3 border-light shadow-none" required>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <label class="form-label small fw-bold text-muted">Phone Number</label>
                                <input type="text" name="phone" class="form-control rounded-3 border-light shadow-none" required placeholder="+91 ...">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Reference Doctor</label>
                                <select name="reference_dr_name" class="form-select rounded-3 border-light shadow-none">
                                    <option value="">Direct/Self</option>
                                    @foreach($doctors as $dr)
                                        <option value="{{ $dr->name }}">{{ $dr->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold text-muted">Visit Date</label>
                                <input type="date" name="visit_date" value="{{ date('Y-m-d') }}" class="form-control rounded-3 border-light shadow-none" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold text-muted">Address</label>
                                <textarea name="address" class="form-control rounded-3 border-light shadow-none" rows="2" required placeholder="Complete residential address..."></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-white p-3 border-0">
                    <button type="button" class="btn btn-light px-4 fw-bold rounded-3" data-bs-dismiss="modal">Discard</button>
                    <button type="submit" class="btn btn-primary px-5 fw-bold rounded-3">Complete Registration</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- DELETE CONFIRMATION MODAL --}}
@foreach($patients as $patient)
<div class="modal fade" id="deletePatientModal{{ $patient->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 400px;">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-body p-4 text-center">
                <div class="text-danger mb-3">
                    <i class="fa-solid fa-circle-exclamation fs-1"></i>
                </div>
                <h5 class="fw-bold text-dark">Archive Record?</h5>
                <p class="text-muted small mb-4">Are you sure you want to archive <strong>{{ $patient->name }}</strong>? This action cannot be undone.</p>
                
                <form action="{{ route('admin.patients.destroy', $patient) }}" method="POST">
                    @csrf @method('DELETE')
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-light w-100 fw-bold rounded-3" data-bs-dismiss="modal">No, Keep</button>
                        <button type="submit" class="btn btn-danger w-100 fw-bold rounded-3">Yes, Archive</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach
