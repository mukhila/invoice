@extends('Admin.layouts.main')

@section('title', 'Dashboard')

@section('content')
<div class="row mt-2">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between mb-3 mt-2">
            <h4 class="mb-sm-0 ">{{ session('admin_role') == 'SuperAdmin' ? 'Super Admin' : 'Employee' }} Dashboard</h4>
            @if(session('admin_role') !== 'SuperAdmin')
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item active">My Customers Portfolio</li>
                </ol>
            </div>
            @endif
        </div>
    </div>
</div>
{{-- Top Section: User Analytics (KPI Cards) --}}
<div class="row">
    {{-- Total Customers --}}
    <div class="col-xl-2 col-md-6">
        <div class="card bg-primary text-white border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mt-0 header-title text-white-50">Total Customers</h4>
                        <h3 class="my-3 text-white">{{ $totalCustomers }}</h3>
                    </div>
                    <div class="flex-shrink-0">
                        <iconify-icon icon="solar:users-group-rounded-bold-duotone" width="40" height="40"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- New Customers --}}
    <div class="col-xl-2 col-md-6">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mt-0 header-title text-muted">New (This Month)</h4>
                        <h3 class="my-3 text-success">{{ $newCustomers }}</h3>
                    </div>
                    <div class="flex-shrink-0 text-success">
                         <iconify-icon icon="solar:user-plus-bold-duotone" width="40" height="40"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Active Customers --}}
    <div class="col-xl-2 col-md-6">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mt-0 header-title text-muted">Active Customers</h4>
                        <h3 class="my-3 text-info">{{ $activeCustomers }}</h3>
                        <small class="text-muted">Currently Paying</small>
                    </div>
                    <div class="flex-shrink-0 text-info">
                         <iconify-icon icon="solar:wallet-money-bold-duotone" width="40" height="40"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>

     {{-- Total Overdue --}}
     <div class="col-xl-3 col-md-6">
        <div class="card bg-danger-subtle border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mt-0 header-title text-danger">Total Overdue</h4>
                        <h3 class="my-3 text-danger">Rs. {{ number_format($totalOverdue, 2) }}</h3>
                    </div>
                    <div class="flex-shrink-0 text-danger">
                        <iconify-icon icon="solar:danger-circle-bold-duotone" width="40" height="40"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Total EMI Due (Month) --}}
    <div class="col-xl-3 col-md-6">
        <div class="card border-0">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h4 class="mt-0 header-title text-muted">Total EMI Due (Month)</h4>
                        <h3 class="my-3">Rs. {{ number_format($currentMonthEmi, 2) }}</h3>
                    </div>
                    <div class="flex-shrink-0 text-muted">
                        <iconify-icon icon="solar:calendar-bold-duotone" width="40" height="40"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Middle Section: Monthly Financial Summary --}}
<div class="row">
    <div class="col-12">
        <h4 class="mb-3 text-uppercase fw-bold text-muted fs-14">Monthly Financial Summary</h4>
    </div>
    
    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted text-uppercase fs-13">Total Pending Amount <br>(This Month)</h5>
                        <h3 class="mb-0 mt-2 text-warning">Rs. {{ number_format($monthlyPending, 2) }}</h3>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-warning-subtle rounded-3 fs-3 text-warning">
                             <iconify-icon icon="solar:hourglass-line-duotone"></iconify-icon>
                        </span>
                    </div>
                </div>
                <div class="mt-3">
                     <div class="progress progress-sm">
                        <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                     </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted text-uppercase fs-13">Total EMI Demand <br>(This Month)</h5>
                        <h3 class="mb-0 mt-2">Rs. {{ number_format($currentMonthEmi, 2) }}</h3>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-info-subtle rounded-3 fs-3 text-info">
                             <iconify-icon icon="solar:bill-list-bold-duotone"></iconify-icon>
                        </span>
                    </div>
                </div>
                <div class="mt-3">
                     <div class="progress progress-sm">
                        <div class="progress-bar bg-info" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                     </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6">
         <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="text-muted text-uppercase fs-13">Total Paid Amount <br>(This Month)</h5>
                        <h3 class="mb-0 mt-2 text-success">Rs. {{ number_format($monthlyPaid, 2) }}</h3>
                    </div>
                     <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-success-subtle rounded-3 fs-3 text-success">
                             <iconify-icon icon="solar:check-circle-bold-duotone"></iconify-icon>
                        </span>
                    </div>
                </div>
                @php
                    $collectionPercentage = $currentMonthEmi > 0 ? ($monthlyPaid / $currentMonthEmi) * 100 : 0;
                @endphp
                <div class="mt-3">
                     <div class="progress progress-sm">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $collectionPercentage }}%" aria-valuenow="{{ $collectionPercentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                     </div>
                     <span class="text-muted fs-12 mt-1 d-block">{{ number_format($collectionPercentage, 1) }}% collected</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Bottom Section: Overdue Risk Analysis --}}
<div class="row">
    <div class="col-12">
        <h4 class="mb-3 text-uppercase fw-bold text-muted fs-14">Overdue Aging Profiling (Risk Analysis)</h4>
    </div>
    
    <div class="col-xl-4">
        <div class="card border-start border-4 border-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                         <h5 class="text-muted text-uppercase fs-13 mb-2">1–30 Days Overdue</h5>
                         <h3 class="mb-0 text-warning">Rs. {{ number_format($overdue30, 2) }}</h3>
                         <span class="badge bg-warning-subtle text-warning mt-2">Low Risk</span>
                    </div>
                     <div class="flex-shrink-0">
                        <iconify-icon icon="solar:clock-circle-bold-duotone" class="text-warning fs-1 text-opacity-50" width="48" height="48"></iconify-icon>
                     </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card border-start border-4 border-orange" style="border-color: #fd7e14 !important;">
            <div class="card-body">
                 <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                         <h5 class="text-muted text-uppercase fs-13 mb-2">31–60 Days Overdue</h5>
                         <h3 class="mb-0" style="color: #fd7e14;">Rs. {{ number_format($overdue60, 2) }}</h3>
                         <span class="badge mt-2" style="background-color: #ffe8cc; color: #fd7e14;">Medium Risk</span>
                    </div>
                     <div class="flex-shrink-0">
                        <iconify-icon icon="solar:bell-bing-bold-duotone" style="color: #fd7e14;" class="fs-1 text-opacity-50" width="48" height="48"></iconify-icon>
                     </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4">
        <div class="card border-start border-4 border-danger">
            <div class="card-body">
                 <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                         <h5 class="text-muted text-uppercase fs-13 mb-2">61–90 Days Overdue</h5>
                         <h3 class="mb-0 text-danger">Rs. {{ number_format($overdue90, 2) }}</h3>
                         <span class="badge bg-danger-subtle text-danger mt-2">High Risk</span>
                    </div>
                     <div class="flex-shrink-0">
                        <iconify-icon icon="solar:shield-warning-bold-duotone" class="text-danger fs-1 text-opacity-50" width="48" height="48"></iconify-icon>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
