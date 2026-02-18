@extends('Admin.layouts.main')

@section('title', 'Assign Plan')

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-medium m-0">Assign Gold Plan</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.all-user-plans.index') }}">User Plans</a></li>
            <li class="breadcrumb-item active">Assign Plan</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Select User and Plan</h5>
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

                <form action="{{ route('admin.assign-plan.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Select Customer</label>
                        <select class="form-select" id="user_id" name="user_id" required>
                            <option value="">Select Customer</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->customer_id }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="plan_id" class="form-label">Select Gold Plan</label>
                        <select class="form-select" id="plan_id" name="plan_id" required>
                            <option value="">Select Plan</option>
                            @foreach ($goldPlans as $plan)
                                <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                    {{ $plan->plan_name }} ({{ $plan->duration_months }} Months - Rs. {{ number_format($plan->monthly_emi, 2) }}/mo)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ date('Y-m-d') }}" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Assign Plan</button>
                    <a href="{{ route('admin.all-user-plans.index') }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
