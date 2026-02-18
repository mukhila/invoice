@extends('Admin.layouts.main')

@section('title', 'Pay EMI')

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-medium m-0">Pay EMI - Month {{ $emiSchedule->emi_month }}</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.user-plans.show', $emiSchedule->user_plan_id) }}">Plan Details</a></li>
            <li class="breadcrumb-item active">Pay EMI</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Payment Details</h5>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('admin.emi.process', $emiSchedule->id) }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">User Name</label>
                        <input type="text" class="form-control" value="{{ $emiSchedule->userPlan->user->name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Plan</label>
                        <input type="text" class="form-control" value="{{ $emiSchedule->userPlan->plan->plan_name }}" readonly>
                    </div>

                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount to Pay</label>
                        <input type="number" step="0.01" class="form-control" id="amount" name="amount" value="{{ old('amount', $emiSchedule->emi_amount) }}" readonly>
                        <div class="form-text">Currently accepting full EMI payment only.</div>
                    </div>

                    <div class="mb-3">
                        <label for="payment_mode" class="form-label">Payment Mode</label>
                        <select class="form-select" id="payment_mode" name="payment_mode" required>
                            <option value="Cash">Cash</option>
                            <option value="UPI">UPI</option>
                            <option value="Bank">Bank Transfer</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="remarks" class="form-label">Remarks (Optional)</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="2">{{ old('remarks') }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Confirm Payment</button>
                    <a href="{{ route('admin.user-plans.show', $emiSchedule->user_plan_id) }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
