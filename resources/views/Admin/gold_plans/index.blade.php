@extends('Admin.layouts.main')

@section('title', 'Gold Plans')

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-medium m-0">Gold Plans list</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Gold Plans</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
               <div class="d-flex justify-content-between align-items-center">
                   <h5 class="card-title mb-0">All Gold Plans</h5>
                   <a href="{{ route('admin.gold-plans.create') }}" class="btn btn-primary btn-sm">Add New Plan</a>
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
                                <th>Duration (Months)</th>
                                <th>Monthly EMI</th>
                                <th>Total Amount</th>
                                <th>Bonus</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($goldPlans as $key => $plan)
                            <tr>
                                <td>{{ $goldPlans->firstItem() + $key }}</td>
                                <td>{{ $plan->plan_name }}</td>
                                <td>{{ $plan->duration_months }}</td>
                                <td>Rs. {{ number_format($plan->monthly_emi, 2) }}</td>
                                <td>Rs. {{ number_format($plan->total_amount, 2) }}</td>
                                <td>Rs. {{ number_format($plan->bonus_amount, 2) }}</td>
                                <td>
                                    @if($plan->status == 'active')
                                        <span class="badge badge-soft-success">Active</span>
                                    @else
                                        <span class="badge badge-soft-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.gold-plans.edit', $plan->id) }}" class="btn btn-primary btn-sm"><i class="bx bx-pencil"></i></a>
                                    <form action="{{ route('admin.gold-plans.destroy', $plan->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')"><i class="bx bx-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $goldPlans->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
