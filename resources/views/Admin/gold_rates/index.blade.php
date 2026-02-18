@extends('Admin.layouts.main')

@section('title', 'Gold Rates')

@section('content')
<div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
    <div class="flex-grow-1">
        <h4 class="fs-18 fw-medium m-0">Gold Rates</h4>
    </div>
    <div class="text-end">
        <ol class="breadcrumb m-0 py-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Gold Rates</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
               <div class="d-flex justify-content-between align-items-center">
                   <h5 class="card-title mb-0">Daily Gold Rates</h5>
                   <a href="{{ route('admin.gold-rates.create') }}" class="btn btn-primary btn-sm">Add Gold Rate</a>
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
                                <th>Date</th>
                                <th>Rate (per gram)</th>
                                <th>Created By</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($goldRates as $key => $rate)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ \Carbon\Carbon::parse($rate->rate_date)->format('d M Y') }}</td>
                                <td>Rs. {{ number_format($rate->rate_per_gram, 2) }}</td>
                                <td>{{ $rate->creator->name ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.gold-rates.edit', $rate->id) }}" class="btn btn-primary btn-sm"><i class="bx bx-pencil"></i></a>
                                    <form action="{{ route('admin.gold-rates.destroy', $rate->id) }}" method="POST" style="display:inline-block;">
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

            </div>
        </div>
    </div>
</div>
@endsection
