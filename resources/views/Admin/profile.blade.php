@extends('Admin.layouts.main')

@section('title', 'My Account')

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-medium m-0">My Account</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
             <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
             <li class="breadcrumb-item active">My Account</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xl-4 col-lg-5">
        <div class="card text-center">
            <div class="card-body">
                <img src="{{ asset('assets/images/users/avatar/avatar-1.svg') }}" class="rounded-circle avatar-lg img-thumbnail mb-3" alt="profile-image">

                <h4 class="mb-1">{{ $admin->name }}</h4>
                <p class="text-muted mb-3">{{ $admin->designation ?? 'System Admin' }}</p> {{-- Assuming 'designation' exists or fallback --}}

                <div class="d-flex justify-content-center mb-2">
                    <span class="badge bg-primary">{{ $admin->role }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-8 col-lg-7">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Personal Information</h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label fw-bold">Full Name</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ $admin->name }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label fw-bold">Email Address</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ $admin->email }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label fw-bold">Mobile</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ $admin->mobile ?? 'N/A' }}" readonly>
                    </div>
                </div>
                <div class="row mb-3">
                    <label class="col-sm-3 col-form-label fw-bold">Role</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" value="{{ $admin->role }}" readonly>
                    </div>
                </div>
                
                {{-- If we want to allow editing, we can make this a form --}}
                <div class="mt-4">
                     <a href="{{ route('admin.password.change') }}" class="btn btn-warning"><i class="bx bx-lock-alt me-1"></i> Change Password</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
