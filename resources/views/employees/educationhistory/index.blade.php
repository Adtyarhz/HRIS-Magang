@extends('layouts.admin')

@section('title', 'Education History')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-graduation-cap fa-fw mr-2"></i>Education History
    </h1>
    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Detail
    </a>
</div>

@include('employees.partials.tab-menu', ['employee' => $employee])

<div class="card shadow mb-4 border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Education List</h6>
        <a href="{{ route('employees.educationhistory.create', $employee) }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Add Education
        </a>
    </div>
    <div class="card-body">
        @if($educationHistories->isEmpty())
            <div class="text-center py-5">
                <div class="mb-3">
                    <span class="fa-stack fa-2x">
                        <i class="fas fa-circle fa-stack-2x text-gray-200"></i>
                        <i class="fas fa-school fa-stack-1x text-gray-400"></i>
                    </span>
                </div>
                <h5 class="text-gray-500">No education records found</h5>
                <p class="text-gray-400 mb-4">Add education history to complete the profile.</p>
                <a href="{{ route('employees.educationhistory.create', $employee) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Add Now
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="10%">Level</th>
                            <th width="25%">Institution</th>
                            <th width="20%">Major</th>
                            <th width="15%">Period</th>
                            <th width="10%">GPA</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($educationHistories as $index => $education)
                            <tr>
                                <td class="text-center align-middle">{{ $index + 1 }}</td>
                                <td class="align-middle"><span class="badge badge-secondary">{{ $education->education_level }}</span></td>
                                <td class="align-middle">
                                    <div class="font-weight-bold text-gray-800">{{ $education->institution_name }}</div>
                                    <small class="text-muted">{{ Str::limit($education->institution_address, 30) }}</small>
                                </td>
                                <td class="align-middle">{{ $education->major ?? '-' }}</td>
                                <td class="align-middle">{{ $education->start_year }} - {{ $education->end_year }}</td>
                                <td class="align-middle font-weight-bold">{{ $education->gpa_or_score ?? '-' }}</td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('employees.educationhistory.edit', [$employee, $education]) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>

@endsection