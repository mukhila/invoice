@extends('Admin.layouts.main')

@section('title', 'PVC Card Preview')

@push('styles')
<style>
    /* CR80 Card Size: 85.60mm x 53.98mm */
    .pvc-card {
        width: 85.60mm;
        height: 53.98mm;
        border-radius: 3mm;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        margin: 0 auto 20px;
        position: relative;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    /* Front Card Styling */
    .card-front {
        background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
        color: #ffffff;
        padding: 4mm;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-sizing: border-box;
    }

    .card-front .card-header-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 2mm;
    }

    .card-front .company-logo {
        display: flex;
        align-items: center;
        gap: 2mm;
    }

    .card-front .company-logo .logo-icon {
        width: 8mm;
        height: 8mm;
        background: linear-gradient(135deg, #ffd700, #ffb347);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: #1a1a2e;
        font-size: 4mm;
    }

    .card-front .company-name {
        font-size: 3.5mm;
        font-weight: bold;
        color: #ffd700;
        letter-spacing: 0.5mm;
    }

    .card-front .company-tagline {
        font-size: 1.8mm;
        color: #a0a0a0;
        margin-top: 0.5mm;
    }

    .card-front .member-badge {
        background: linear-gradient(135deg, #ffd700, #ffb347);
        color: #1a1a2e;
        padding: 1mm 2mm;
        border-radius: 1mm;
        font-size: 2mm;
        font-weight: bold;
        text-transform: uppercase;
    }

    .card-front .card-body-section {
        display: flex;
        flex: 1;
        gap: 3mm;
        align-items: center;
    }

    .card-front .photo-section {
        flex-shrink: 0;
    }

    .card-front .customer-photo {
        width: 18mm;
        height: 22mm;
        border-radius: 2mm;
        border: 0.5mm solid #ffd700;
        object-fit: cover;
        background: #2a2a4e;
    }

    .card-front .customer-photo-placeholder {
        width: 18mm;
        height: 22mm;
        border-radius: 2mm;
        border: 0.5mm solid #ffd700;
        background: #2a2a4e;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        font-size: 6mm;
    }

    .card-front .info-section {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .card-front .customer-name {
        font-size: 4mm;
        font-weight: bold;
        color: #ffffff;
        margin-bottom: 1mm;
        text-transform: uppercase;
        letter-spacing: 0.3mm;
    }

    .card-front .customer-id {
        font-size: 2.5mm;
        color: #ffd700;
        font-family: 'Courier New', monospace;
        margin-bottom: 1.5mm;
        letter-spacing: 0.3mm;
    }

    .card-front .status-badge {
        display: inline-block;
        padding: 0.8mm 2mm;
        border-radius: 1mm;
        font-size: 2mm;
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
        flex-shrink: 0;
        background: #ffffff;
        padding: 1.5mm;
        border-radius: 1.5mm;
    }

    .card-front .qr-code {
        width: 18mm;
        height: 18mm;
    }

    .card-front .card-footer-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2mm;
        padding-top: 1.5mm;
        border-top: 0.3mm solid rgba(255, 215, 0, 0.3);
    }

    .card-front .member-since {
        font-size: 1.8mm;
        color: #a0a0a0;
    }

    .card-front .card-number {
        font-size: 1.8mm;
        color: #ffd700;
        font-family: 'Courier New', monospace;
    }

    /* Back Card Styling */
    .card-back {
        background: linear-gradient(135deg, #f5f5f5 0%, #e8e8e8 100%);
        color: #333333;
        padding: 4mm;
        display: flex;
        flex-direction: column;
        height: 100%;
        box-sizing: border-box;
    }

    .card-back .back-header {
        text-align: center;
        margin-bottom: 2mm;
        padding-bottom: 1.5mm;
        border-bottom: 0.3mm solid #ccc;
    }

    .card-back .back-title {
        font-size: 3mm;
        font-weight: bold;
        color: #1a1a2e;
        text-transform: uppercase;
        letter-spacing: 0.5mm;
    }

    .card-back .back-content {
        flex: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .card-back .contact-info {
        margin-bottom: 2mm;
    }

    .card-back .contact-item {
        display: flex;
        align-items: center;
        gap: 2mm;
        margin-bottom: 1.5mm;
        font-size: 2.2mm;
    }

    .card-back .contact-icon {
        width: 3.5mm;
        height: 3.5mm;
        background: #1a1a2e;
        color: #ffd700;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2mm;
    }

    .card-back .scan-notice {
        background: #1a1a2e;
        color: #ffd700;
        text-align: center;
        padding: 2mm;
        border-radius: 1.5mm;
        margin-bottom: 2mm;
    }

    .card-back .scan-notice-text {
        font-size: 2.2mm;
        font-weight: bold;
    }

    .card-back .terms-section {
        border-top: 0.3mm solid #ccc;
        padding-top: 1.5mm;
    }

    .card-back .terms-title {
        font-size: 2mm;
        font-weight: bold;
        color: #666;
        margin-bottom: 1mm;
    }

    .card-back .terms-text {
        font-size: 1.6mm;
        color: #888;
        line-height: 1.4;
    }

    .card-back .back-footer {
        text-align: center;
        font-size: 1.8mm;
        color: #666;
        margin-top: auto;
    }

    /* Preview Container */
    .preview-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 30px;
        padding: 20px;
    }

    .card-wrapper {
        text-align: center;
    }

    .card-label {
        font-size: 14px;
        color: #666;
        margin-bottom: 10px;
        font-weight: 500;
    }

    .action-buttons {
        display: flex;
        justify-content: center;
        gap: 15px;
        margin-top: 30px;
    }
</style>
@endpush

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-medium m-0">PVC Card Preview - {{ $user->name }}</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
            <li class="breadcrumb-item active">PVC Card</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Customer PVC Card</h5>
            </div>
            <div class="card-body">
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
                                        @if($photoUrl)
                                            <img src="{{ $photoUrl }}" alt="Customer Photo" class="customer-photo">
                                        @else
                                            <div class="customer-photo-placeholder">
                                                <i class="bx bx-user"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="info-section">
                                        <div class="customer-name">{{ $user->name }}</div>
                                        <div class="customer-id">{{ $user->customer_id }}</div>
                                        <span class="status-badge {{ $user->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                            {{ ucfirst($user->status) }}
                                        </span>
                                    </div>

                                    <div class="qr-section">
                                        <img src="{{ $qrCode }}" alt="QR Code" class="qr-code">
                                    </div>
                                </div>

                                <div class="card-footer-section">
                                    <div class="member-since">Member Since: {{ $user->created_at->format('M Y') }}</div>
                                    <div class="card-number">{{ substr($user->customer_id, -8) }}</div>
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
                                            Card holder agrees to abide by all membership terms.
                                        </div>
                                    </div>
                                </div>

                                <div class="back-footer">
                                    Valid only with photo ID | Card ID: {{ $user->customer_id }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="action-buttons">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="bx bx-arrow-back me-1"></i> Back to Users
                    </a>
                    <a href="{{ route('admin.users.card-pdf-preview', $user->id) }}" class="btn btn-info" target="_blank">
                        <i class="bx bx-show me-1"></i> Preview PDF
                    </a>
                    <a href="{{ route('admin.users.card-pdf', $user->id) }}" class="btn btn-primary">
                        <i class="bx bx-download me-1"></i> Download PDF
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
