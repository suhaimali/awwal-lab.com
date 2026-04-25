    <!-- Import CSV Modal -->
    <div class="modal fade" id="importCsvModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <h5 class="modal-title fw-bold" style="color: #1e3a8a;">Bulk Import Test Types</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.test-types.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-4 text-center">
                            <div class="p-3 bg-light rounded-4 mb-3">
                                <i class="fa-solid fa-file-csv fs-1 text-success"></i>
                            </div>
                            <p class="text-muted small">Upload a CSV file with headers: <br> <strong>test_code, name, category, price, status, custom_field</strong></p>
                            <a href="{{ route('admin.test-types.template') }}" class="btn btn-sm btn-link text-primary fw-bold text-decoration-none">
                                <i class="fa-solid fa-download me-1"></i> Download CSV Template
                            </a>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted text-uppercase">Select CSV File</label>
                            <input type="file" name="csv_file" class="form-control bg-light border-0 py-2 px-3" accept=".csv" required style="border-radius: 12px;">
                        </div>
                    </div>
                    <div class="modal-footer border-0 px-4 pb-4">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal" style="border-radius: 10px;">Cancel</button>
                        <button type="submit" class="btn btn-success px-4 fw-bold shadow-sm" style="border-radius: 10px;">
                            <i class="fa-solid fa-cloud-arrow-up me-1"></i> Upload & Build
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="addTestModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" style="color: #1e3a8a;"><i class="fa-solid fa-plus me-2 text-primary"></i> Add New Test</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.test-types.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted fw-bold small text-uppercase">Test Code</label>
                                <input type="text" name="test_code" class="form-control bg-light border-0 shadow-none py-2" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted fw-bold small text-uppercase">Test Name</label>
                                <input type="text" name="name" class="form-control bg-light border-0 shadow-none py-2" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted fw-bold small text-uppercase">Category</label>
                                <select name="category" class="form-select bg-light border-0 shadow-none py-2" required>
                                    <option value="">Select Category...</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted fw-bold small text-uppercase">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">₹</span>
                                    <input type="number" step="0.01" name="price" class="form-control bg-light border-0 shadow-none py-2" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold small text-uppercase letter-spacing-1">Select Parameters</label>
                            <div class="lab-test-container shadow-none">
                                @foreach($allParameters as $p)
                                    <label class="lab-test-item" for="paramAdd{{ $p->id }}">
                                        <input class="form-check-input" type="checkbox" name="parameters[]" value="{{ $p->name }}" id="paramAdd{{ $p->id }}">
                                        <span class="lab-test-label">
                                            {{ $p->name }} <span class="lab-test-info">({{ $p->unit ?: 'N/A' }})</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold small text-uppercase">Description / Investigation Note</label>
                            <textarea name="description" class="form-control bg-light border-0 shadow-none py-2" rows="2" placeholder="Brief description for billing..." style="border-radius: 12px;"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold small text-uppercase">Status</label>
                            <select name="status" class="form-select bg-light border-0 shadow-none py-2">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" style="border-radius: 10px;">Save Test</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach($testTypes as $test)
    <!-- View Modal -->
    <div class="modal fade" id="viewModal{{ $test->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" style="color: #1e3a8a;">Test Details</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-4">
                    <div class="text-center mb-4">
                        <div class="avatar bg-primary text-white d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px; border-radius: 20px; font-size: 32px; font-weight: bold; background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%) !important;">
                            <i class="fa-solid fa-vial"></i>
                        </div>
                        <h4 class="fw-bold mb-0">{{ $test->name }}</h4>
                        <p class="text-muted mb-0">Code: {{ $test->test_code }}</p>
                    </div>
                    <div class="bg-light rounded p-3 mb-3">
                        <div class="row g-3">
                            <div class="col-6"><span class="text-muted d-block small text-uppercase fw-bold">Category</span> <span class="fw-bold">{{ $test->category }}</span></div>
                            <div class="col-6"><span class="text-muted d-block small text-uppercase fw-bold">Price</span> <span class="fw-bold text-success">₹{{ number_format($test->price, 2) }}</span></div>
                            <div class="col-6"><span class="text-muted d-block small text-uppercase fw-bold">Status</span> <span class="fw-bold">{{ $test->status }}</span></div>
                            <div class="col-12"><span class="text-muted d-block small text-uppercase fw-bold">Parameters</span> <span class="fw-bold">{{ is_array($test->parameters) ? implode(', ', $test->parameters) : ($test->parameters ?: 'None') }}</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal{{ $test->id }}" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 20px; border: none;">
                <div class="modal-header border-bottom-0 pb-0">
                    <h5 class="modal-title fw-bold" style="color: #1e3a8a;">Edit Test</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.test-types.update', $test->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted fw-bold small text-uppercase">Test Code</label>
                                <input type="text" name="test_code" class="form-control bg-light border-0 shadow-none py-2" value="{{ $test->test_code }}" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted fw-bold small text-uppercase">Test Name</label>
                                <input type="text" name="name" class="form-control bg-light border-0 shadow-none py-2" value="{{ $test->name }}" required>
                            </div>
                        </div>
                        <div class="row g-3 mb-3">
                            <div class="col-6">
                                <label class="form-label text-muted fw-bold small text-uppercase">Category</label>
                                <select name="category" class="form-select bg-light border-0 shadow-none py-2" required>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->name }}" {{ $test->category == $cat->name ? 'selected' : '' }}>{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label class="form-label text-muted fw-bold small text-uppercase">Price</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0">₹</span>
                                    <input type="number" step="0.01" name="price" class="form-control bg-light border-0 shadow-none py-2" value="{{ $test->price }}" required>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold small text-uppercase letter-spacing-1">Select Parameters</label>
                            <div class="lab-test-container shadow-none">
                                @php $selectedParams = is_array($test->parameters) ? $test->parameters : []; @endphp
                                @foreach($allParameters as $p)
                                    <label class="lab-test-item" for="paramEdit{{ $test->id }}{{ $p->id }}">
                                        <input class="form-check-input" type="checkbox" name="parameters[]" value="{{ $p->name }}" id="paramEdit{{ $test->id }}{{ $p->id }}" {{ in_array($p->name, $selectedParams) ? 'checked' : '' }}>
                                        <span class="lab-test-label">
                                            {{ $p->name }} <span class="lab-test-info">({{ $p->unit ?: 'N/A' }})</span>
                                        </span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold small text-uppercase">Description / Investigation Note</label>
                            <textarea name="description" class="form-control bg-light border-0 shadow-none py-2" rows="2" style="border-radius: 12px;">{{ $test->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label text-muted fw-bold small text-uppercase">Status</label>
                            <select name="status" class="form-select bg-light border-0 shadow-none py-2">
                                <option value="Active" {{ $test->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $test->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-top-0 pt-0">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" style="border-radius: 10px;">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endforeach
