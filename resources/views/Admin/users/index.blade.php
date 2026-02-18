@extends('Admin.layouts.main')

@section('title', 'List Users')

@push('styles')
<style>
    /* PVC Card Modal Styles */
    .pvc-card-modal .modal-dialog {
        max-width: 900px;
    }

    /* CR80 Card Size: 85.60mm x 53.98mm - Scaled for preview */
    .pvc-card {
        width: 323px; /* 85.60mm scaled */
        height: 204px; /* 53.98mm scaled */
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        margin: 0 auto 15px;
        position: relative;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Front Card Styling */
    .card-front {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        color: #ffffff;
        padding: 15px;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-sizing: border-box;
    }

    .card-front .card-header-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 8px;
    }

    .card-front .company-logo {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .card-front .logo-icon {
        width: 30px;
        height: 30px;
        background: linear-gradient(135deg, #ffd700, #ffb347);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #1a1a2e;
        font-size: 14px;
    }

    .card-front .company-name {
        font-size: 13px;
        font-weight: bold;
        color: #ffd700;
        letter-spacing: 1px;
    }

    .card-front .company-tagline {
        font-size: 7px;
        color: #a0a0a0;
        margin-top: 2px;
    }

    .card-front .member-badge {
        background: linear-gradient(135deg, #ffd700, #ffb347);
        color: #1a1a2e;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 8px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .card-front .card-body-section {
        display: flex;
        flex: 1;
        gap: 12px;
        align-items: center;
    }

    .card-front .customer-photo {
        width: 68px;
        height: 83px;
        border-radius: 6px;
        border: 2px solid #ffd700;
        object-fit: cover;
        background: #2a2a4e;
    }

    .card-front .customer-photo-placeholder {
        width: 68px;
        height: 83px;
        border-radius: 6px;
        border: 2px solid #ffd700;
        background: #2a2a4e;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        font-size: 24px;
    }

    .card-front .info-section {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card-front .customer-name {
        font-size: 15px;
        font-weight: bold;
        color: #ffffff;
        margin-bottom: 4px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .card-front .customer-id {
        font-size: 10px;
        color: #ffd700;
        font-family: 'Courier New', monospace;
        margin-bottom: 6px;
        letter-spacing: 0.5px;
    }

    .card-front .status-badge {
        display: inline-block;
        padding: 2px 8px;
        border-radius: 4px;
        font-size: 8px;
        font-weight: bold;
        text-transform: uppercase;
    }

    .card-front .status-active {
        background: #28a745;
        color: #fff;
    }

    .card-front .status-inactive {
        background: #dc3545;
        color: #fff;
    }

    .card-front .qr-section {
        background: #ffffff;
        padding: 5px;
        border-radius: 6px;
    }

    .card-front .qr-code {
        width: 68px;
        height: 68px;
    }

    .card-front .card-footer-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 8px;
        padding-top: 6px;
        border-top: 1px solid rgba(255, 215, 0, 0.3);
    }

    .card-front .member-since {
        font-size: 7px;
        color: #a0a0a0;
    }

    .card-front .card-number {
        font-size: 7px;
        color: #ffd700;
        font-family: 'Courier New', monospace;
    }

    /* Back Card Styling */
    .card-back {
        background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
        color: #333333;
        padding: 15px;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-sizing: border-box;
    }

    .card-back .back-header {
        text-align: center;
        margin-bottom: 8px;
        padding-bottom: 6px;
        border-bottom: 1px solid #ccc;
    }

    .card-back .back-title {
        font-size: 11px;
        font-weight: bold;
        color: #1a1a2e;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .card-back .back-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-back .contact-info {
        margin-bottom: 8px;
    }

    .card-back .contact-item {
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 5px;
        font-size: 8px;
    }

    .card-back .contact-icon {
        width: 14px;
        height: 14px;
        background: #1a1a2e;
        color: #ffd700;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 8px;
    }

    .card-back .scan-notice {
        background: #1a1a2e;
        color: #ffd700;
        text-align: center;
        padding: 6px;
        border-radius: 5px;
        margin-bottom: 8px;
    }

    .card-back .scan-notice-text {
        font-size: 9px;
        font-weight: bold;
    }

    .card-back .terms-section {
        border-top: 1px solid #ccc;
        padding-top: 6px;
    }

    .card-back .terms-title {
        font-size: 8px;
        font-weight: bold;
        color: #666;
        margin-bottom: 3px;
    }

    .card-back .terms-text {
        font-size: 6px;
        color: #888;
        line-height: 1.4;
    }

    .card-back .back-footer {
        text-align: center;
        font-size: 7px;
        color: #666;
        margin-top: auto;
    }

    /* Preview Container */
    .preview-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 20px;
        padding: 15px;
    }

    .card-wrapper {
        text-align: center;
    }

    .card-label {
        font-size: 12px;
        color: #666;
        margin-bottom: 8px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255,255,255,0.9);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000;
    }
</style>
@endpush

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-medium m-0">User List</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Users</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
               <div class="d-flex justify-content-between align-items-center">
                   <h5 class="card-title mb-0">All Users</h5>
                   <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">Add New User</a>
               </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Created By</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $key => $user)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $user->customer_id ?? 'N/A' }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->mobile }}</td>
                                <td>{{ $user->creator->name ?? 'N/A' }}</td>
                                <td>
                                    @if($user->status == 'active')
                                        <span class="badge badge-soft-success">Active</span>
                                    @else
                                        <span class="badge badge-soft-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button"
                                            class="btn btn-success btn-sm btn-generate-card"
                                            data-user-id="{{ $user->id }}"
                                            data-user-name="{{ $user->name }}"
                                            title="Generate PVC Card">
                                        <i class="bx bx-id-card"></i>
                                    </button>
                                    <a href="{{ route('admin.users.plans.index', $user->id) }}" class="btn btn-warning btn-sm" title="Plans"><i class="bx bx-crown"></i></a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary btn-sm"><i class="bx bx-pencil"></i></a>
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- PVC Card Preview Modal -->
<div class="modal fade pvc-card-modal" id="pvcCardModal" tabindex="-1" aria-labelledby="pvcCardModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pvcCardModalLabel">PVC Card Preview</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="pvcCardModalBody">
                <div class="text-center py-5" id="cardLoadingSpinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-muted">Generating card...</p>
                </div>

                <div id="cardPreviewContent" style="display: none;">
                    <div class="preview-container">
                        <!-- Front Card -->
                        <div class="card-wrapper">
                            <div class="card-label">FRONT SIDE</div>
                            <div class="pvc-card">
                                <div class="card-front">
                                    <div class="card-header-section">
                                        <div class="company-logo">
                                            <div class="logo-icon">A</div>
                                            <div>
                                                <div class="company-name">AURUM & CO.</div>
                                                <div class="company-tagline">Gold Investment Plan</div>
                                            </div>
                                        </div>
                                        <div class="member-badge">MEMBER</div>
                                    </div>

                                    <div class="card-body-section">
                                        <div class="photo-section">
                                            <img src="" alt="Customer Photo" class="customer-photo" id="cardCustomerPhoto" style="display: none;">
                                            <div class="customer-photo-placeholder" id="cardPhotoPlaceholder">
                                                <i class="bx bx-user"></i>
                                            </div>
                                        </div>

                                        <div class="info-section">
                                            <div class="customer-name" id="cardCustomerName"></div>
                                            <div class="customer-id" id="cardCustomerId"></div>
                                            <span class="status-badge" id="cardStatusBadge"></span>
                                        </div>

                                        <div class="qr-section">
                                            <img src="" alt="QR Code" class="qr-code" id="cardQrCode">
                                        </div>
                                    </div>

                                    <div class="card-footer-section">
                                        <div class="member-since" id="cardMemberSince"></div>
                                        <div class="card-number" id="cardNumber"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Back Card -->
                        <div class="card-wrapper">
                            <div class="card-label">BACK SIDE</div>
                            <div class="pvc-card">
                                <div class="card-back">
                                    <div class="back-header">
                                        <div class="back-title">Aurum & Co. Membership Card</div>
                                    </div>

                                    <div class="back-content">
                                        <div class="contact-info">
                                            <div class="contact-item">
                                                <span class="contact-icon"><i class="bx bx-phone"></i></span>
                                                <span>Helpline: +91 98765 43210</span>
                                            </div>
                                            <div class="contact-item">
                                                <span class="contact-icon"><i class="bx bx-envelope"></i></span>
                                                <span>support@aurumco.com</span>
                                            </div>
                                            <div class="contact-item">
                                                <span class="contact-icon"><i class="bx bx-globe"></i></span>
                                                <span>www.aurumco.com</span>
                                            </div>
                                            <div class="contact-item">
                                                <span class="contact-icon"><i class="bx bx-map"></i></span>
                                                <span>123 Gold Street, Business District</span>
                                            </div>
                                        </div>

                                        <div class="scan-notice">
                                            <div class="scan-notice-text">Scan QR Code for Verification</div>
                                        </div>

                                        <div class="terms-section">
                                            <div class="terms-title">Terms & Conditions</div>
                                            <div class="terms-text">
                                                This card is non-transferable and remains the property of Aurum & Co.
                                                Present this card for all transactions. Report lost cards immediately.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="back-footer" id="cardBackFooter">
                                        Valid only with photo ID | Card ID: <span id="cardBackId"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <a href="#" class="btn btn-info" id="btnPreviewPdf" target="_blank">
                    <i class="bx bx-show me-1"></i> Preview PDF
                </a>
                <a href="#" class="btn btn-primary" id="btnDownloadPdf">
                    <i class="bx bx-download me-1"></i> Download PDF
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Generate PVC Card button click handler
    $('.btn-generate-card').on('click', function() {
        const userId = $(this).data('user-id');
        const userName = $(this).data('user-name');

        // Update modal title
        $('#pvcCardModalLabel').text('PVC Card Preview - ' + userName);

        // Show loading, hide content
        $('#cardLoadingSpinner').show();
        $('#cardPreviewContent').hide();

        // Update PDF links
        $('#btnPreviewPdf').attr('href', '/admin/users/' + userId + '/card-pdf-preview');
        $('#btnDownloadPdf').attr('href', '/admin/users/' + userId + '/card-pdf');

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('pvcCardModal'));
        modal.show();

        // Make AJAX request to generate card
        $.ajax({
            url: '/admin/users/' + userId + '/generate-card',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                if (response.success) {
                    const data = response.data;

                    // Update card preview with data
                    $('#cardCustomerName').text(data.name);
                    $('#cardCustomerId').text(data.customer_id);
                    $('#cardQrCode').attr('src', data.qr_code);
                    $('#cardMemberSince').text('Member Since: ' + data.member_since);
                    $('#cardNumber').text(data.customer_id.slice(-8));
                    $('#cardBackId').text(data.customer_id);

                    // Update status badge
                    const statusBadge = $('#cardStatusBadge');
                    statusBadge.text(data.status.charAt(0).toUpperCase() + data.status.slice(1));
                    statusBadge.removeClass('status-active status-inactive');
                    statusBadge.addClass(data.status === 'active' ? 'status-active' : 'status-inactive');

                    // Update photo
                    if (data.photo) {
                        $('#cardCustomerPhoto').attr('src', data.photo).show();
                        $('#cardPhotoPlaceholder').hide();
                    } else {
                        $('#cardCustomerPhoto').hide();
                        $('#cardPhotoPlaceholder').show();
                    }

                    // Hide loading, show content
                    $('#cardLoadingSpinner').hide();
                    $('#cardPreviewContent').show();
                }
            },
            error: function(xhr) {
                alert('Error generating card. Please try again.');
                const modal = bootstrap.Modal.getInstance(document.getElementById('pvcCardModal'));
                modal.hide();
            }
        });
    });
});
</script>
@endpush
