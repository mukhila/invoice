@extends('Admin.layouts.main')

@section('title', 'User Plans')

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-medium m-0">Plans for {{ $user->name }}</h4>
        <p class="text-muted mb-0">Customer ID: {{ $user->customer_id }}</p>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
            <li class="breadcrumb-item active">Plans</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
               <div class="d-flex justify-content-between align-items-center">
                   <h5 class="card-title mb-0">Assigned Gold Plans</h5>
                   <a href="{{ route('admin.users.plans.create', $user->id) }}" class="btn btn-primary btn-sm">Assign New Plan</a>
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
                                <th>Plan Name</th>
                                <th>Start Date</th>
                                <th>Maturity Date</th>
                                <th>Total Amount</th>
                                <th>Paid</th>
                                <th>Pending</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($plans as $key => $plan)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $plan->plan->plan_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($plan->start_date)->format('d M Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($plan->maturity_date)->format('d M Y') }}</td>
                                <td>Rs. {{ number_format($plan->plan->total_amount, 2) }}</td>
                                <td><span class="text-success">Rs. {{ number_format($plan->total_paid, 2) }}</span></td>
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
                                    <a href="{{ route('admin.user-plans.show', $plan->id) }}" class="btn btn-info btn-sm" title="View Details"><i class="bx bx-show"></i> Details</a>
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
