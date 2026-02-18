@extends('Admin.layouts.main')

@section('title', 'Edit Gold Rate')

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-medium m-0">Edit Gold Rate</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.gold-rates.index') }}">Gold Rates</a></li>
            <li class="breadcrumb-item active">Edit Rate</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Update Gold Rate</h5>
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

                <form action="{{ route('admin.gold-rates.update', $goldRate->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="rate_date" class="form-label">Date</label>
                        <input type="date" class="form-control" id="rate_date" name="rate_date" value="{{ old('rate_date', $goldRate->rate_date) }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="rate_per_gram" class="form-label">Rate (Per Gram)</label>
                        <input type="number" step="0.01" class="form-control" id="rate_per_gram" name="rate_per_gram" value="{{ old('rate_per_gram', $goldRate->rate_per_gram) }}" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Update Rate</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
