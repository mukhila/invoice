@extends('Admin.layouts.main')

@section('title', 'Add Gold Plan')

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-medium m-0">Add Gold Plan</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.gold-plans.index') }}">Gold Plans</a></li>
            <li class="breadcrumb-item active">Add Plan</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Create New Gold Plan</h5>
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

                <form action="{{ route('admin.gold-plans.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="plan_name" class="form-label">Plan Name</label>
                        <input type="text" class="form-control" id="plan_name" name="plan_name" value="{{ old('plan_name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="duration_months" class="form-label">Duration (Months)</label>
                        <input type="number" class="form-control" id="duration_months" name="duration_months" value="{{ old('duration_months') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="monthly_emi" class="form-label">Monthly EMI</label>
                        <input type="number" step="0.01" class="form-control" id="monthly_emi" name="monthly_emi" value="{{ old('monthly_emi') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="total_amount" class="form-label">Total Plan Amount</label>
                        <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="bonus_amount" class="form-label">Bonus / Discount Amount</label>
                        <input type="number" step="0.01" class="form-control" id="bonus_amount" name="bonus_amount" value="{{ old('bonus_amount', 0) }}">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Plan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
