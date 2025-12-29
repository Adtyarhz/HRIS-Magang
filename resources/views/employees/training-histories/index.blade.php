@extends('layouts.admin')

@section('title', 'Employee Training History')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-chalkboard-teacher fa-fw mr-2"></i>Employee Training History
    </h1>
    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Detail
    </a>
</div>

@include('employees.partials.tab-menu', ['employee' => $employee])

<div class="card shadow mb-4 border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Training Records List</h6>
        <a href="{{ route('employees.training-histories.create', $employee->id) }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Add Record
        </a>
    </div>
    <div class="card-body">
        @if ($trainingHistories->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="20%">Training Name</th>
                            <th width="15%">Provider</th>
                            <th width="12%">Start Date</th>
                            <th width="12%">End Date</th>
                            <th width="15%">Certificate</th>
                            <th width="10%">Materials</th>
                            <th width="10%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($trainingHistories as $history)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle font-weight-bold text-gray-800">{{ $history->training_name }}</td>
                                <td class="align-middle">{{ $history->provider }}</td>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($history->start_date)->format('d M Y') }}</td>
                                <td class="align-middle">{{ \Carbon\Carbon::parse($history->end_date)->format('d M Y') }}</td>
                                
                                <td class="align-middle text-center">
                                    @if ($history->certificate_file)
                                        <a href="{{ asset('storage/' . $history->certificate_file) }}" target="_blank" class="btn btn-info btn-sm">
                                            <i class="fas fa-file-pdf"></i> View
                                        </a>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <td class="align-middle text-center">
                                    @if ($history->trainingMaterials->isNotEmpty())
                                        <span class="badge badge-secondary">{{ $history->trainingMaterials->count() }} Files</span>
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>

                                <td class="text-center align-middle">
                                    <a href="{{ route('employees.training-histories.edit', [$employee->id, $history->id]) }}" class="btn btn-warning btn-sm" title="Edit">
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
                        <i class="fas fa-chalkboard-teacher fa-stack-1x text-gray-400"></i>
                    </span>
                </div>
                <h5 class="text-gray-500">No training records found</h5>
                <p class="text-gray-400 mb-4">Add new training history to display here.</p>
                <a href="{{ route('employees.training-histories.create', $employee->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Add Now
                </a>
            </div>
        @endif
    </div>
</div>

@endsection