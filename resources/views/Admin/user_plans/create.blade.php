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
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
            <li class="breadcrumb-item active">Assign Plan</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Assign Plan to {{ $user->name }}</h5>
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

                <form action="{{ route('admin.users.plans.store', $user->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="plan_id" class="form-label">Select Gold Plan</label>
                        <select class="form-select" id="plan_id" name="plan_id" required>
                            <option value="">Select Plan</option>
                            @foreach ($goldPlans as $plan)
                                <option value="{{ $plan->id }}">
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
                    <a href="{{ route('admin.users.plans.index', $user->id) }}" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
