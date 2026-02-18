<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | GoldSaver</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
	html, body {
  height: 100%;
}
        body {
            background-color: #f4f6f8;
            font-family: 'Segoe UI', sans-serif;
            padding-bottom: 80px; /* Space for bottom nav if added later */
        }
        .header {
            background: white;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.03);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .profile-icon {
            width: 40px;
            height: 40px;
            background: #f0f0f0;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #555;
            cursor: pointer;
        }
        .alert-card {
            background-color: #ffeaea;
            border: 1px solid #ffcccc;
            border-radius: 12px;
            padding: 1rem;
            margin: 1rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .gold-card {
            background: linear-gradient(135deg, #d4a017 0%, #f6d365 100%);
            border-radius: 16px;
            padding: 1.5rem;
            margin: 1rem;
            color: #fff;
            box-shadow: 0 5px 15px rgba(212, 160, 23, 0.3);
            position: relative;
            overflow: hidden;
        }
        .gold-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.1);
            border-radius: 50%;
        }
        .section-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin: 1.5rem 1rem 1rem 1rem;
            color: #333;
        }
        .transaction-item {
            background: white;
            border-radius: 10px;
            padding: 1rem;
            margin: 0.5rem 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.02);
        }
        .status-badge {
            font-size: 0.75rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
        }
        .status-success { background: #e6fffa; color: #00b894; }
        .status-pending { background: #fff8e6; color: #ffb900; }
        
        /* Logout Form hidden styling */
        .logout-btn {
            background: none;
            border: none;
            color: inherit;
            padding: 0;
            font: inherit;
            cursor: pointer;
            outline: inherit;
        }
    </style>
</head>
<body>

    <!-- 1. Header Section -->
    <div class="header">
        <div>
            <span class="text-muted small">Welcome back,</span>
            <h5 class="m-0 fw-bold">{{ explode(' ', $user->name)[0] }}</h5>
        </div>
        <div class="d-flex align-items-center gap-3">
             <!-- Gold Rate Badge -->
            <div class="bg-warning bg-opacity-10 px-3 py-1 rounded-pill border border-warning border-opacity-25">
                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.65rem;">Today's Rate</small>
                <div class="d-flex align-items-center text-warning fw-bold" style="line-height: 1;">
                    <i class='bx bxs-up-arrow-alt'></i> ₹{{ number_format($goldRatePerGram) }}/g
                </div>
            </div>

            <div class="dropdown">
                <div class="profile-icon" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class='bx bx-user fs-4'></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                    <li><a class="dropdown-item" href="#">Profile Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('user.logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- 2. Critical Alert Section (Conditional) -->
    @if($alert)
    <div class="alert-card">
        <div>
            <h6 class="text-danger fw-bold m-0"><i class='bx bx-error-circle me-1'></i>Action Required</h6>
            <p class="small text-muted m-0 mt-1">₹{{ number_format($alert['amount']) }} Payment Overdue</p>
            <small class="text-danger fw-semibold" style="font-size: 0.7rem;">Due since {{ $alert['due_date'] }}</small>
        </div>
        <button class="btn btn-sm btn-danger px-3 rounded-pill fw-bold shadow-sm">Pay Now</button>
    </div>
    @endif

    <!-- 3. Gold Plan Summary Card -->
    @if($plan)
        @php
            $grams = $plan->total_paid / $goldRatePerGram; // Calculated based on rate
        @endphp
    <div class="gold-card">
        <div class="d-flex justify-content-between align-items-start position-relative" style="z-index: 2;">
            <div>
                <span class="opacity-75 small text-uppercase fw-semibold">Total Accumulated Gold</span>
                <h2 class="fw-bold m-0 display-4 mt-1">{{ number_format($grams, 2) }} <span class="fs-4">grams</span></h2>
            </div>
            <i class='bx bxs-diamond fs-1 opacity-50'></i>
        </div>
        
        <div class="mt-4 pt-3 border-top border-white border-opacity-25 position-relative" style="z-index: 2;">
            <div class="row g-0">
                <div class="col-6 border-end border-white border-opacity-25 pe-3">
                    <span class="d-block small opacity-75">Plan Value</span>
                    <span class="fw-bold fs-5">₹{{ number_format($plan->total_paid) }}</span>
                </div>
                <div class="col-6 ps-3">
                    <span class="d-block small opacity-75">Maturity Date</span>
                    <span class="fw-bold fs-5">{{ \Carbon\Carbon::parse($plan->maturity_date)->format('M Y') }}</span>
                </div>
            </div>
            <div class="mt-3">
                <span class="badge bg-white bg-opacity-25 rounded-pill px-3 py-1 small fw-normal">
                    <i class='bx bxs-crown me-1 text-warning'></i> {{ $plan->plan->plan_name }}
                </span>
            </div>
        </div>
    </div>
    @else
    <div class="gold-card text-center">
        <h4 class="mb-3">Start your journey</h4>
        <p>No active gold plan found.</p>
        <button class="btn btn-light text-warning fw-bold">Explore Plans</button>
    </div>
    @endif

    <!-- 4. Payment Overview -->
    <h5 class="section-title">Payment Overview</h5>

    <div class="container-fluid px-3">
        <div class="row g-3">
            <!-- Chart -->
        <div class="col-md-6">
    <div class="bg-white p-3 rounded-3 shadow-sm">
        <h6 class="small text-muted mb-3 fw-bold text-uppercase">Savings Trend</h6>
        <div style="height: 200px; position: relative;">
            <canvas id="savingsChart"></canvas>
        </div>
    </div>
</div>


            <!-- Recent Transactions -->
            <div class="col-md-6">
                <h6 class="small text-muted mb-2 px-1 fw-bold text-uppercase d-md-none mt-3">Recent Transactions</h6>
                @forelse($recentTransactions as $transaction)
                <div class="transaction-item">
                    <div class="d-flex align-items-center">
                        <div class="bg-light rounded p-2 me-3 text-success">
                            <i class='bx bx-down-arrow-alt fs-4'></i>
                        </div>
                        <div>
                            <h6 class="m-0 fw-semibold">Installment Paid</h6>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($transaction->payment_date)->format('d M, Y') }}</small>
                        </div>
                    </div>
                    <div class="text-end">
                        <h6 class="m-0 fw-bold">₹{{ number_format($transaction->amount) }}</h6>
                        <span class="status-badge status-success">Success</span>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-3">
                    <small>No recent transactions</small>
                </div>
                @endforelse
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const ctx = document.getElementById('savingsChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Savings (₹)',
                data: @json($chartData),
                borderColor: '#d4a017',
                backgroundColor: 'rgba(212, 160, 23, 0.1)',
                tension: 0.4,
                fill: true,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#d4a017',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true, // Changed to true
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { display: false },
                x: { grid: { display: false } }
            }
        }
    });
</script>
</body>
</html>
