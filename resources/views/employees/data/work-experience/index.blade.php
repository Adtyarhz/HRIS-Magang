@extends('layouts.admin')

@section('title', 'Work Experience')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-briefcase fa-fw mr-2"></i>Work Experience
    </h1>
    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Detail
    </a>
</div>

@include('employees.partials.tab-menu', ['employee' => $employee])

<div class="card shadow mb-4 border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Experience List</h6>
        <a href="{{ route('employees.work-experience.create', $employee->id) }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Add Experience
        </a>
    </div>
    <div class="card-body">
        @if ($workExperiences->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="25%">Company</th>
                            <th width="20%">Duration</th>
                            <th width="15%">Last Salary</th>
                            <th width="15%" class="text-center">Documents</th>
                            <th width="10%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($workExperiences as $experience)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle">
                                    <div class="font-weight-bold text-gray-800">{{ $experience->company_name }}</div>
                                    <small class="text-muted">{{ $experience->position_title }}</small>
                                </td>
                                <td class="align-middle">
                                    {{ \Carbon\Carbon::parse($experience->start_date)->format('d M Y') }} - 
                                    {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('d M Y') : 'Present' }}
                                </td>
                                <td class="align-middle">
                                    Rp{{ number_format($experience->last_salary, 0, ',', '.') }}
                                </td>
                                <td class="align-middle text-center">
                                    @if ($experience->reference_letter_file)
                                        <a href="{{ asset('storage/' . $experience->reference_letter_file) }}" target="_blank" class="btn btn-sm btn-info mb-1" title="Reference Letter">
                                            <i class="fas fa-file-alt"></i> Ref
                                        </a>
                                    @endif
                                    @if ($experience->salary_slip_file)
                                        <a href="{{ asset('storage/' . $experience->salary_slip_file) }}" target="_blank" class="btn btn-sm btn-success mb-1" title="Salary Slip">
                                            <i class="fas fa-file-invoice-dollar"></i> Slip
                                        </a>
                                    @endif
                                    @if (!$experience->reference_letter_file && !$experience->salary_slip_file)
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('employees.work-experience.edit', [$employee->id, $experience->id]) }}" class="btn btn-warning btn-sm" title="Edit">
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
                        <i class="fas fa-briefcase fa-stack-1x text-gray-400"></i>
                    </span>
                </div>
                <h5 class="text-gray-500">No work experience records found</h5>
                <p class="text-gray-400 mb-4">Add your previous work experience here.</p>
                <a href="{{ route('employees.work-experience.create', $employee->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Add Now
                </a>
            </div>
        @endif
    </div>
</div>

@endsection