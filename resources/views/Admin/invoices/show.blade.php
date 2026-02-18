@extends('Admin.layouts.main')

@section('title', 'Invoice Details')

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-medium m-0">Invoice #{{ $invoice->invoice_number }}</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
             <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
             <li class="breadcrumb-item active">Invoice</li>
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
                    </div>
                    <div class="float-end">
                        <h4 class="m-0 d-print-none">Invoice</h4>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="float-start mt-3">
                            <p><b>Hello, {{ $invoice->payment->user->name }}</b></p>
                            <p class="text-muted">Thanks for your payment. <br> Please check the details below.</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="mt-3 float-end">
                            <p class="m-0"><strong>Invoice Date: </strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</p>
                            <p class="m-0"><strong>Order Status: </strong> <span class="badge bg-success">Paid</span></p>
                            <p class="m-0"><strong>Order ID: </strong> #123456</p>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-nowrap align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Item</th>
                                        <th>Plan</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Gold Plan Installment</td>
                                        <td>{{ $invoice->payment->userPlan->plan->plan_name }}</td>
                                        <td class="text-end">Rs. {{ number_format($invoice->payment->amount, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-end border-0"><strong>Total</strong></td>
                                        <td class="text-end border-0"><h4 class="m-0">Rs. {{ number_format($invoice->payment->amount, 2) }}</h4></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="d-print-none mt-4">
                    <div class="text-end">
                        <a href="javascript:window.print()" class="btn btn-primary"><i class="bx bx-printer me-1"></i> Print</a>
                        {{-- <a href="#" class="btn btn-info">Download Pdf</a> --}}
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
