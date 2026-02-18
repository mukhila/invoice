@extends('Admin.layouts.main')

@section('title', 'All User Plans')

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-medium m-0">All User Plans</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">User Plans</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
               <div class="d-flex justify-content-between align-items-center">
                   <h5 class="card-title mb-0">List of All Assigned Plans</h5>
                   <a href="{{ route('admin.assign-plan.create') }}" class="btn btn-primary btn-sm">Assign New Plan</a>
               </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer (ID)</th>
                                <th>Plan Name</th>
                                <th>Start Date</th>
                                <th>Total Amount</th>
                                <th>Pending</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($userPlans as $key => $plan)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $plan->user->name }} <br> <small class="text-muted">{{ $plan->user->customer_id }}</small></td>
                                <td>{{ $plan->plan->plan_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($plan->start_date)->format('d M Y') }}</td>
                                <td>Rs. {{ number_format($plan->plan->total_amount, 2) }}</td>
                                <td><span class="text-danger">Rs. {{ number_format($plan->total_pending, 2) }}</span></td>
                                <td>
                                    @if($plan->status == 'active')
                                        <span class="badge badge-soft-success">Active</span>
                                    @elseif($plan->status == 'completed')
                                        <span class="badge badge-soft-primary">Completed</span>
                                    @else
                                        <span class="badge badge-soft-danger">Cancelled</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.user-plans.show', $plan->id) }}" class="btn btn-info btn-sm" title="View Details"><i class="bx bx-show"></i></a>
                                    {{-- Link to specific user plans index if needed, but detail view is usually enough --}}
                                    <a href="{{ route('admin.users.plans.index', $plan->user_id) }}" class="btn btn-warning btn-sm" title="User's Plans"><i class="bx bx-crown"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
