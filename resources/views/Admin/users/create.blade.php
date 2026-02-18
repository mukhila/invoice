@extends('Admin.layouts.main')

@section('title', 'Add User')

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-medium m-0">Add User</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
            <li class="breadcrumb-item active">Add User</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Create New User</h5>
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

                <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" value="{{ old('mobile') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" id="dob" name="dob" value="{{ old('dob') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="id_proof" class="form-label">ID Proof Document (Upload)</label>
                        <input type="file" class="form-control" id="id_proof" name="id_proof" accept="image/*,application/pdf">
                    </div>
                     <div class="mb-3">
                        <label for="photo" class="form-label">User Photo (Passport Size)</label>
                        <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                    </div>
                    
                    <div class="mb-3">
                        <label for="created_by" class="form-label">Assigned Employee</label>
                        <select class="form-select" id="created_by" name="created_by" required>
                            @if(session('admin_role') == 'SuperAdmin')
                                <option value="">Select Employee</option>
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('created_by') == $employee->id ? 'selected' : '' }}>{{ $employee->name }}</option>
                                @endforeach
                            @else
                                <option value="{{ session('admin_id') }}" selected>{{ session('admin_name') }}</option>
                            @endif
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Create User</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
