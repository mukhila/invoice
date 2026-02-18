@extends('Admin.layouts.main')

@section('title', 'Statement of Account')

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-medium m-0">Statement of Account</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
             <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
             <li class="breadcrumb-item"><a href="{{ route('admin.user-plans.show', $userPlan->id) }}">Plan Details</a></li>
             <li class="breadcrumb-item active">Statement</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class="clearfix">
                    <div class="float-start mb-3">
                        <h4 class="m-0 d-print-none">Aurum & Co.</h4>
                        <p class="text-muted">Consolidated Payment Statement</p>
                    </div>
                    <div class="float-end">
                        <h5 class="m-0">Plan: {{ $userPlan->plan->plan_name }}</h5>
                        <p class="text-muted mb-0">Customer: {{ $userPlan->user->name }} ({{ $userPlan->user->customer_id }})</p>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-nowrap align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Date</th>
                                        <th>Receipt No</th> {{-- Or Payment ID if no invoice --}}
                                        <th>Payment Mode</th>
                                        <th>Remarks</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $grandTotal = 0; @endphp
                                    @forelse($userPlan->payments as $payment)
                                    @php $grandTotal += $payment->amount; @endphp
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                        <td>#{{ $payment->id }}</td>
                                        <td>{{ $payment->payment_mode }}</td>
                                        <td>{{ $payment->remarks ?? '-' }}</td>
                                        <td class="text-end">Rs. {{ number_format($payment->amount, 2) }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No payments found.</td>
                                    </tr>
                                    @endforelse
                                    <tr>
                                        <td colspan="4" class="text-end border-0"><strong>Total Paid Amount</strong></td>
                                        <td class="text-end border-0"><h4 class="m-0 text-success">Rs. {{ number_format($grandTotal, 2) }}</h4></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" class="text-end border-0"><strong>Pending Amount</strong></td>
                                        <td class="text-end border-0"><h5 class="m-0 text-danger">Rs. {{ number_format($userPlan->total_pending, 2) }}</h5></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-print-none mt-4">
                    <div class="text-end">
                        <a href="javascript:window.print()" class="btn btn-primary"><i class="bx bx-printer me-1"></i> Print Statement</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
