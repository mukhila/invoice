<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>PVC Card - {{ $user->customer_id }}</title>

    <style>
    @page { margin: 0; }

* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    font-family: 'DejaVu Sans', sans-serif;
    background: #ffffff;
}

/* ✅ CARD PAGE EXACT SIZE */
.page-container {
    width: 120.60mm;
    height: 75.98mm;
    padding: 5mm;
    margin: 5mm;
}

/* ✅ Hide extra heading for print */
.page-title,
.print-info {
    display: none;
}

.cards-wrapper {
    width: 100%;
    height: 100%;
}

.card-container {
    width: 100%;
    height: 100%;
    padding: 0;
    margin: 0;
    text-align: center;
}

.card-label { display: none; }

/* ✅ FIXED CARD SIZE */
.pvc-card {
    width: 120.60mm;
    height: 60.98mm;
    border-radius: 3mm;
    overflow: hidden;
    border: 0.5mm solid #333;
}

/* ✅ FRONT CARD */
.card-front {
    width: 100%;
    height: 100%;
    background-color: #1a1a2e;
    color: #ffffff;
    padding: 4mm;
}

/* ✅ Header Fixed */
.front-header {
    display: table;
    width: 100%;
    height: 14mm;  /* ✅ FIXED */
}

.logo-section {
    display: table-cell;
    vertical-align: middle;
    width: 70%;
}

.logo-icon {
    display: inline-block;
    width: 10mm;
    height: 10mm;
    background-color: #ffd700;
    border-radius: 50%;
    text-align: center;
    line-height: 10mm;
    font-weight: bold;
    color: #1a1a2e;
    font-size: 6mm;
    vertical-align: middle;
}

.company-info {
    display: inline-block;
    vertical-align: middle;
    margin-left: 2mm;
}

.company-name {
    font-size: 4.2mm;
    font-weight: bold;
    color: #ffd700;
    letter-spacing: 0.3mm;
}

.company-tagline {
    font-size: 2.2mm;
    color: #cccccc;
    margin-top: 0.5mm;
}

.badge-section {
    display: table-cell;
    vertical-align: middle;
    text-align: left;
    width: 20%;
}

.member-badge {
    display: inline-block;
    background-color: #ffd700;
    color: #1a1a2e;
    padding: 1.5mm 3mm;
    border-radius: 1.5mm;
    font-size: 2.8mm;
    font-weight: bold;
    text-transform: uppercase;
}

/* ✅ BODY SECTION FIX */
.front-body {
    display: table;
    width: 100%;
    height: 28mm;  /* ✅ FIXED */
    margin-top: 2mm;
}

/* ✅ PHOTO */
.photo-cell {
    display: table-cell;
    vertical-align: middle;
    width: 24mm;
    text-align: left;
}

.customer-photo {
    width: 20mm;
    height: 26mm;
    border-radius: 2mm;
    border: 0.5mm solid #ffd700;
}

.photo-placeholder {
    width: 20mm;
    height: 26mm;
    border-radius: 2mm;
    border: 0.5mm solid #ffd700;
    background-color: #2a2a4e;
    text-align: center;
    line-height: 26mm;
    color: #ffd700;
    font-size: 3.5mm;
    font-weight: bold;
}

/* ✅ INFO CENTER */
.info-cell {
    display: table-cell;
    vertical-align: middle;
    text-align: center;
    width: 32mm;
}

.customer-name {
    font-size: 4mm;
    font-weight: bold;
    margin-bottom: 1mm;
    text-transform: uppercase;
}

.customer-id {
    font-size: 2.8mm;
    color: #ffd700;
    font-family: 'DejaVu Sans Mono', monospace;
    margin-bottom: 2mm;
}

.status-badge {
    display: inline-block;
    padding: 1.2mm 4mm;
    border-radius: 1mm;
    font-size: 2.6mm;
    font-weight: bold;
    text-transform: uppercase;
}

.status-active { background-color: #28a745; color: #fff; }
.status-inactive { background-color: #dc3545; color: #fff; }

/* ✅ QR RIGHT */
.qr-cell {
    display: table-cell;
    vertical-align: middle;
    width: 25mm;
    text-align: left;
}

.qr-wrapper {
    display: inline-block;
    background: #fff;
    padding: 1mm;
    border-radius: 2mm;
}

.qr-code {
    width: 18mm;
    height: 18mm;
}

/* ✅ FOOTER FIX */
.front-footer {
    display: table;
    width: 100%;
    height: 6mm; /* ✅ FIXED */
    margin-top: 2mm;
    padding-top: 1.5mm;
    border-top: 0.3mm solid #ffd700;
}

.member-since {
    display: table-cell;
    font-size: 2.3mm;
    color: #cccccc;
    vertical-align: middle;
    text-align: left;
}

.card-number {
    display: table-cell;
    text-align: left;
    font-size: 2.3mm;
    color: #ffd700;
    font-family: 'DejaVu Sans Mono', monospace;
    vertical-align: middle;
}

/* ✅ BACK CARD SAME AS YOUR DESIGN (ONLY SAFE CHANGES) */
.card-back {
    width: 100%;
    height: 100%;
    background-color: #f5f5f5;
    color: #333;
    padding: 4mm;
}

.back-header {
    text-align: center;
    margin-bottom: 2mm;
    padding-bottom: 2mm;
    border-bottom: 0.3mm solid #999;
}

.back-title {
    font-size: 3.4mm;
    font-weight: bold;
    color: #1a1a2e;
    text-transform: uppercase;
    letter-spacing: 0.4mm;
}

.contact-info {
    margin-bottom: 2mm;
    text-align: left;
}

.contact-item {
    margin-bottom: 1.2mm;
    font-size: 2.7mm;
    color: #333;
}

.contact-label {
    display: inline-block;
    font-weight: bold;
    color: #1a1a2e;
    width: 18mm;
}

.scan-notice {
    background-color: #1a1a2e;
    color: #ffd700;
    text-align: center;
    padding: 2mm;
    border-radius: 2mm;
    margin-bottom: 2mm;
}

.scan-notice-text {
    font-size: 2.7mm;
    font-weight: bold;
}

.terms-section {
    border-top: 0.3mm solid #999;
    padding-top: 2mm;
}

.terms-title {
    font-size: 2.5mm;
    font-weight: bold;
    color: #666;
    margin-bottom: 1mm;
}

.terms-text {
    font-size: 2mm;
    color: #666;
    line-height: 1.3;
}

.back-footer {
    text-align: center;
    font-size: 2.3mm;
    color: #666;
    margin-top: 2mm;
    padding-top: 2mm;
    border-top: 0.3mm solid #ccc;
}

/* ✅ Separate Pages */
.page-break {
    page-break-before: always;
}
    </style>
</head>

<body>

    <!-- ✅ PAGE 1: FRONT ONLY -->
    <div class="page-container">
        <div class="cards-wrapper">
            <div class="card-container">
                <div class="card-label">Front Side</div>
                <div class="pvc-card">
                    <div class="card-front">
                        <div class="front-header">
                            <div class="logo-section">
                                <span class="logo-icon">A</span>
                                <div class="company-info">
                                    <div class="company-name">AURUM & CO.</div>
                                    <div class="company-tagline">Gold Investment Plan</div>
                                </div>
                            </div>
                            <div class="badge-section">
                                <span class="member-badge">MEMBER</span>
                            </div>
                        </div>

                        <div class="front-body">
                            <div class="photo-cell">
                                @if($photoBase64)
                                    <img src="{{ $photoBase64 }}" alt="Photo" class="customer-photo">
                                @else
                                    <div class="photo-placeholder">PHOTO</div>
                                @endif
                            </div>

                            <div class="info-cell">
                                <div class="customer-name">{{ $user->name }}</div>
                                <div class="customer-id">{{ $user->customer_id }}</div>
                                <span class="status-badge {{ $user->status == 'active' ? 'status-active' : 'status-inactive' }}">
                                    {{ ucfirst($user->status) }}
                                </span>
                            </div>

                            <div class="qr-cell">
                                <div class="qr-wrapper">
                                    <img src="{{ $qrCode }}" alt="QR Code" class="qr-code">
                                </div>
                            </div>
                        </div>

                        <div class="front-footer">
                            <span class="member-since">Member Since: {{ $user->created_at->format('M Y') }}</span>
                            <span class="card-number">{{ substr($user->customer_id, -8) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- ✅ PAGE 2: BACK ONLY -->
    <div class="page-container page-break">
        <div class="cards-wrapper">
            <div class="card-container">
                <div class="card-label">Back Side</div>
                <div class="pvc-card">
                    <div class="card-back">
                        <div class="back-header">
                            <div class="back-title">Aurum & Co. Membership Card</div>
                        </div>

                        <div class="contact-info">
                            <div class="contact-item">
                                <span class="contact-label">Helpline:</span>
                                <span>+91 98765 43210</span>
                            </div>
                            <div class="contact-item">
                                <span class="contact-label">Email:</span>
                                <span>support@aurumco.com</span>
                            </div>
                            <div class="contact-item">
                                <span class="contact-label">Website:</span>
                                <span>www.aurumco.com</span>
                            </div>
                            <div class="contact-item">
                                <span class="contact-label">Address:</span>
                                <span>123 Gold Street, Business District</span>
                            </div>
                        </div>

                        <div class="scan-notice">
                            <div class="scan-notice-text">SCAN QR CODE FOR VERIFICATION</div>
                        </div>

                        <div class="terms-section">
                            <div class="terms-title">Terms & Conditions</div>
                            <div class="terms-text">
                                This card is non-transferable and remains the property of Aurum & Co.
                                Present this card for all transactions. Report lost cards immediately.
                            </div>
                        </div>

                        <div class="back-footer">
                            Valid only with photo ID | {{ $user->customer_id }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
