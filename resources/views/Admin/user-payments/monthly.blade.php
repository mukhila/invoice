@extends('Admin.layouts.main')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">Monthly Paid & Generated(Unpaid) Users</h4>
                <form action="{{ route('admin.user-payments.monthly') }}" method="GET" class="d-flex align-items-center">
                    <label for="month" class="me-2 mb-0">Select Month:</label>
                    <input type="month" id="month" name="month" class="form-control me-2" value="{{ $selectedMonth }}">
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs nav-fill" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#paid-users" role="tab">
                            <i class="fas fa-check-circle text-success me-2"></i>Paid Users ({{ $paidUsers->count() }})
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#unpaid-users" role="tab">
                            <i class="fas fa-times-circle text-danger me-2"></i>Unpaid Users ({{ $unpaidUsers->count() }})
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content project-tab-content p-3">
                    <!-- Paid Users Tab -->
                    <div class="tab-pane fade show active" id="paid-users" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Plan Details</th>
                                        <th>Paid Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($paidUsers as $user)
                                        @foreach($user->userPlans as $plan)
                                            @foreach($plan->emiSchedules as $schedule)
                                                @if(\Carbon\Carbon::parse($schedule->due_date)->format('Y-m') == $selectedMonth && $schedule->status == 'paid')
                                                    <tr>
                                                        <td>{{ $user->customer_id ?? $user->id }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->mobile }}</td>
                                                        <td>{{ $plan->goldPlan->name ?? 'N/A' }}</td>
                                                        <td>₹{{ number_format($schedule->paid_amount, 2) }}</td>
                                                        <td><span class="badge bg-success">Paid</span></td>
                                                        <td> <a href="{{ route('admin.users.plans.index', $user->id) }}" class="btn btn-info btn-sm" title="View Plans">
                                                                <i class="bx bx-show"></i>
                                                            </a></td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No paid users found for this month.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Unpaid Users Tab -->
                    <div class="tab-pane fade" id="unpaid-users" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Plan Details</th>
                                        <th>Due Amount</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($unpaidUsers as $user)
                                        @foreach($user->userPlans as $plan)
                                            @foreach($plan->emiSchedules as $schedule)
                                                {{-- Check if this specific schedule is the one causing the 'unpaid' flag for the selected month --}}
                                                @if(\Carbon\Carbon::parse($schedule->due_date)->format('Y-m') == $selectedMonth && $schedule->status != 'paid')
                                                    <tr>
                                                        <td>{{ $user->customer_id ?? $user->id }}</td>
                                                        <td>{{ $user->name }}</td>
                                                        <td>{{ $user->mobile }}</td>
                                                        <td>{{ $plan->goldPlan->name ?? 'N/A' }}</td>
                                                        <td>₹{{ number_format($schedule->emi_amount - $schedule->paid_amount, 2) }}</td>
                                                        <td>{{ \Carbon\Carbon::parse($schedule->due_date)->format('d M, Y') }}</td>
                                                        <td><span class="badge bg-danger">{{ ucfirst($schedule->status) }}</span></td>
                                                        <td>
                                                            <a href="{{ route('admin.users.plans.index', $user->id) }}" class="btn btn-info btn-sm" title="View Plans">
                                                                <i class="bx bx-show"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">No unpaid users found for this month.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
