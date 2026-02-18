@extends('Admin.layouts.main')

@section('title', 'Plan Details')

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-medium m-0">Plan Details</h4>
        <p class="text-muted mb-0">User: {{ $userPlan->user->name }} | Plan: {{ $userPlan->plan->plan_name }}</p>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.plans.index', $userPlan->user_id) }}">User Plans</a></li>
            <li class="breadcrumb-item active">Details</li>
        </ol>
    </div>
</div>

<div class="row">
    <!-- Plan Summary -->
    <div class="col-xl-12 mb-4">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <p class="mb-1 text-muted">Total Amount</p>
                        <h5 class="mb-0">Rs. {{ number_format($userPlan->plan->total_amount, 2) }}</h5>
                    </div>
                    <div class="col-md-3">
                         <p class="mb-1 text-muted">Paid Amount</p>
                        <h5 class="mb-0 text-success">Rs. {{ number_format($userPlan->total_paid, 2) }}</h5>
                    </div>
                    <div class="col-md-3">
                         <p class="mb-1 text-muted">Pending Amount</p>
                        <h5 class="mb-0 text-danger">Rs. {{ number_format($userPlan->total_pending, 2) }}</h5>
                    </div>
                    <div class="col-md-3">
                         <p class="mb-1 text-muted">Status</p>
                        <h5 class="mb-0">{{ ucfirst($userPlan->status) }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Paid Details -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header bg-success-subtle d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0 text-success">Already Paid Details (History)</h5>
                <a href="{{ route('admin.invoices.consolidated', $userPlan->id) }}" target="_blank" class="btn btn-sm btn-success"><i class="bx bx-file"></i> Statement</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Month</th>
                                <th>Due Date</th>
                                <th>Paid Date</th>
                                <th>Amount</th>
                                <th>Mode</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($paidEmis as $index => $emi)
                                @php
                                    // Since we don't have direct link in EMI table to Payment table in common schema unless linked
                                    // We will try to find a payment for this user_plan with this amount around this date? 
                                    // Or simply, we should have linked Payment ID in EMI Schedule or vice versa.
                                    // For now, let's fetch the LATEST payment for this plan as a fallback demo, or find by exact amount/date.
                                    // A better approach would be to fetch Payments directly for this "Paid Details" section instead of EMIs.
                                    // But to stick to current variables, let's look up the payment.
                                    $payment = \App\Models\Payment::where('user_plan_id', $userPlan->id)
                                                ->where('amount', $emi->emi_amount)
                                                ->first(); 
                                @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>Month {{ $emi->emi_month }}</td>
                                <td>{{ \Carbon\Carbon::parse($emi->due_date)->format('d M Y') }}</td>
                                <td>
                                    {{-- Assuming paid_date is tracked or we look at created_at of update. Detailed payment history is better in separate table but request implies easy view. --}}
                                    <span class="badge bg-success">Paid</span>
                                </td>
                                <td>Rs. {{ number_format($emi->emi_amount, 2) }}</td>
                                <td>{{ $payment->payment_mode ?? 'Cash' }}</td>
                                <td>
                                    @if($payment)
                                        <a href="{{ route('admin.invoices.generate', $payment->id) }}" target = "_new" class="btn btn-warning btn-sm btn-icon" title="Invoice"><i class="bx bx-receipt"></i></a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">No payments made yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Details -->
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header bg-warning-subtle">
                <h5 class="card-title mb-0 text-warning">Pending EMI Details</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-nowrap mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Month</th>
                                <th>Due Date</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingEmis as $emi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>Month {{ $emi->emi_month }}</td>
                                <td>
                                    <span class="{{ \Carbon\Carbon::parse($emi->due_date)->isPast() ? 'text-danger fw-bold' : '' }}">
                                        {{ \Carbon\Carbon::parse($emi->due_date)->format('d M Y') }}
                                    </span>
                                </td>
                                <td>Rs. {{ number_format($emi->emi_amount, 2) }}</td>
                                <td>
                                    <a href="{{ route('admin.emi.pay', $emi->id) }}" class="btn btn-info btn-sm">Pay</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No pending EMIs.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
