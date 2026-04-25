@extends('layouts.app')

@section('content')
<div class="container-fluid p-0">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-black mb-1" style="color: #1e3a8a;">Support Center</h2>
            <p class="text-muted mb-0">Direct access to Suhaim Soft technical engineers and system documentation.</p>
        </div>
        <div class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill fw-bold">
            <i class="fa-solid fa-headset me-2"></i> SYSTEM VERSION 4.2.0
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Support Options -->
        <div class="col-lg-8">
            <div class="row g-4 mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: 28px;">
                        <div class="card-body p-5 position-relative">
                            <div class="position-absolute top-0 end-0 p-4 opacity-10">
                                <i class="fa-brands fa-whatsapp" style="font-size: 8rem;"></i>
                            </div>
                            <div class="icon-box bg-success text-white rounded-4 d-flex align-items-center justify-content-center mb-4" style="width: 60px; height: 60px; font-size: 24px;">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-3">WhatsApp Tech Support</h4>
                            <p class="text-muted mb-4">Get instant assistance from our support engineers for any operational issues or bugs.</p>
                            <a href="https://wa.me/918891479505?text=Hi%20Suhaim%20Soft,%20I%20need%20assistance%20with%20the%20Laboratory%20System." target="_blank" class="btn btn-success px-4 py-2 rounded-pill fw-bold">
                                <i class="fa-brands fa-whatsapp me-2"></i> Chat with Us
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100 overflow-hidden" style="border-radius: 28px;">
                        <div class="card-body p-5 position-relative">
                            <div class="position-absolute top-0 end-0 p-4 opacity-10">
                                <i class="fa-solid fa-envelope-open-text" style="font-size: 8rem;"></i>
                            </div>
                            <div class="icon-box bg-primary text-white rounded-4 d-flex align-items-center justify-content-center mb-4" style="width: 60px; height: 60px; font-size: 24px;">
                                <i class="fa-solid fa-ticket"></i>
                            </div>
                            <h4 class="fw-bold text-dark mb-3">Request Feature</h4>
                            <p class="text-muted mb-4">Want to add a new investigation or a module? Send your requirement directly to our dev team.</p>
                            <button class="btn btn-primary px-4 py-2 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#ticketModal">
                                <i class="fa-solid fa-plus-circle me-2"></i> Submit Request
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- FAQ / Documentation -->
            <div class="card border-0 shadow-sm" style="border-radius: 28px;">
                <div class="card-header bg-white border-0 pt-5 px-5">
                    <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-book-open text-primary me-2"></i> Quick Assistance FAQ</h5>
                </div>
                <div class="card-body p-5 pt-4">
                    <div class="accordion accordion-flush" id="supportAccordion">
                        <div class="accordion-item border-0 mb-3 bg-light rounded-4 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-light fw-bold text-dark collapsed shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#q1">
                                    How do I export my financial reports to CSV?
                                </button>
                            </h2>
                            <div id="q1" class="accordion-collapse collapse" data-bs-parent="#supportAccordion">
                                <div class="accordion-body text-muted small">
                                    Navigate to the <b>Control Center</b> (Admin Dashboard), click on <b>Full Panel</b> in the Backup Manager card, and select the table you wish to export under the "Export CSV" section.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 mb-3 bg-light rounded-4 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-light fw-bold text-dark collapsed shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#q2">
                                    How to generate a QR code for payments?
                                </button>
                            </h2>
                            <div id="q2" class="accordion-collapse collapse" data-bs-parent="#supportAccordion">
                                <div class="accordion-body text-muted small">
                                    Open the <b>Payment Terminal</b>, enter the amount, and select <b>QR Code</b> as the settlement gateway. A dynamic UPI QR code will be generated instantly for the patient to scan.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0 bg-light rounded-4 overflow-hidden">
                            <h2 class="accordion-header">
                                <button class="accordion-button bg-light fw-bold text-dark collapsed shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#q3">
                                    Updating Laboratory Identity
                                </button>
                            </h2>
                            <div id="q3" class="accordion-collapse collapse" data-bs-parent="#supportAccordion">
                                <div class="accordion-body text-muted small">
                                    Go to <b>Management > Operational Protocol</b>. Here you can update your lab name, address, contact details, and change your login password.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 28px; background: linear-gradient(135deg, #1e3a8a 0%, #1e40af 100%); color: white;">
                <div class="card-body p-5">
                    <h5 class="fw-bold mb-4"><i class="fa-solid fa-tower-broadcast me-2"></i> Emergency Contact</h5>
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box bg-white bg-opacity-20 rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-phone-flip"></i>
                        </div>
                        <div>
                            <div class="small opacity-75">Technical Helpline</div>
                            <div class="fw-bold">+91 8891479505</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mb-4">
                        <div class="icon-box bg-white bg-opacity-20 rounded-3 d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">
                            <i class="fa-solid fa-envelope-open-text"></i>
                        </div>
                        <div>
                            <div class="small opacity-75">Email Support</div>
                            <div class="fw-bold">alivpsuhaim@gmail.com</div>
                        </div>
                    </div>
                    <hr class="bg-white opacity-25 my-4">
                    <div class="text-center">
                        <p class="small opacity-75 mb-3">System Identity</p>
                        <h4 class="fw-black mb-0 letter-spacing-1">SUHAIM SOFT</h4>
                    </div>
                </div>
            </div>

            <!-- Remote Assistance -->
            <div class="card border-0 shadow-sm" style="border-radius: 28px;">
                <div class="card-body p-5">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-desktop text-primary me-2"></i> Remote Assistance</h5>
                    <p class="text-muted small mb-4">Need hands-on help? Our engineers can connect to your system remotely using TeamViewer or AnyDesk.</p>
                    <div class="d-grid gap-2">
                        <a href="https://download.anydesk.com/AnyDesk.exe" class="btn btn-outline-primary fw-bold rounded-pill">
                            <i class="fa-solid fa-download me-2"></i> Download AnyDesk
                        </a>
                        <a href="https://download.teamviewer.com/download/TeamViewer_Setup.exe" class="btn btn-outline-primary fw-bold rounded-pill">
                            <i class="fa-solid fa-download me-2"></i> Download TeamViewer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Ticket Modal -->
<div class="modal fade" id="ticketModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-header border-0 p-4">
                <h5 class="modal-title fw-bold">Submit Support Ticket</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.support.submit') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Subject</label>
                        <input type="text" name="subject" class="form-control bg-light border-0 py-2" required placeholder="e.g. Printer not working, Report Error">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Priority</label>
                        <select name="priority" class="form-select bg-light border-0 py-2">
                            <option value="Low">Low - Improvement</option>
                            <option value="Medium">Medium - Normal Issue</option>
                            <option value="High">High - System Blocked</option>
                        </select>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted">Description</label>
                        <textarea name="description" class="form-control bg-light border-0 py-2" rows="4" required placeholder="Tell us exactly what happened..."></textarea>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill">Send Request</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
<div class="position-fixed bottom-0 end-0 p-4" style="z-index: 9999;">
    <div class="alert alert-success border-0 shadow-lg rounded-4 d-flex align-items-center mb-0 px-4 py-3">
        <i class="fa-solid fa-circle-check fs-4 me-3"></i>
        <div>
            <div class="fw-bold">Success!</div>
            <div class="small">{{ session('success') }}</div>
        </div>
    </div>
</div>
@endif

<style>
    .accordion-button:not(.collapsed) { background: transparent; color: #1e3a8a; }
    .accordion-button::after { background-size: 1rem; }
    .letter-spacing-1 { letter-spacing: 1px; }
    .bg-soft-primary { background: rgba(30, 58, 138, 0.1); }
</style>
@endsection
