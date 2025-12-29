@extends('layouts.admin')

@section('title', 'Employee Insurance')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-file-medical-alt fa-fw mr-2"></i>Employee Insurance
    </h1>
    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Detail
    </a>
</div>

@include('employees.partials.tab-menu', ['employee' => $employee])

<div class="card shadow mb-4 border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Insurance List</h6>
        <a href="{{ route('employees.insurance.create', $employee) }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Add Insurance
        </a>
    </div>
    <div class="card-body">
        @if ($insurances->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="15%">Insurance No</th>
                            <th width="10%">Type</th>
                            <th width="20%">Faskes</th>
                            <th width="20%">Period</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="10%" class="text-center">File</th>
                            <th width="10%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($insurances as $insurance)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle font-weight-bold text-gray-800">{{ $insurance->insurance_number }}</td>
                                <td class="align-middle"><span class="badge badge-info">{{ $insurance->insurance_type }}</span></td>
                                <td class="align-middle">
                                    <div class="font-weight-bold">{{ $insurance->faskes_name }}</div>
                                    <small class="text-muted">{{ Str::limit($insurance->faskes_address, 30) }}</small>
                                </td>
                                <td class="align-middle">
                                    {{ \Carbon\Carbon::parse($insurance->start_date)->format('d/m/Y') }} - 
                                    {{ $insurance->expiry_date ? \Carbon\Carbon::parse($insurance->expiry_date)->format('d/m/Y') : 'Lifetime' }}
                                </td>
                                <td class="text-center align-middle">
                                    @if($insurance->status == 'AKTIF')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-secondary">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    @if ($insurance->insurance_file)
                                        <a href="{{ asset('storage/' . $insurance->insurance_file) }}" target="_blank" class="btn btn-sm btn-info" title="View Document">
                                            <i class="fas fa-file-alt"></i>
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('employees.insurance.edit', [$employee, $insurance]) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-5">
                <div class="mb-3">
                    <span class="fa-stack fa-2x">
                        <i class="fas fa-circle fa-stack-2x text-gray-200"></i>
                        <i class="fas fa-file-medical-alt fa-stack-1x text-gray-400"></i>
                    </span>
                </div>
                <h5 class="text-gray-500">No insurance records found</h5>
                <p class="text-gray-400 mb-4">Add insurance details for this employee.</p>
                <a href="{{ route('employees.insurance.create', $employee) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Add Now
                </a>
            </div>
        @endif
    </div>
</div>

@endsection