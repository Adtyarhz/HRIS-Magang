@extends('layouts.admin')

@section('title', 'Family Dependents')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-users fa-fw mr-2"></i>Family Dependents
    </h1>
    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Detail
    </a>
</div>

@include('employees.partials.tab-menu', ['employee' => $employee])

<div class="card shadow mb-4 border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">Dependents List</h6>
        <a href="{{ route('employees.family-dependents.create', $employee->id) }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Add Family Member
        </a>
    </div>
    <div class="card-body">
        @if ($dependents->isNotEmpty())
            <div class="table-responsive">
                <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="20%">Name</th>
                            <th width="15%">Relationship</th>
                            <th width="15%">Phone</th>
                            <th width="25%">Address</th>
                            <th width="10%">City/Prov</th>
                            <th width="10%" class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($dependents as $dependent)
                            <tr>
                                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                                <td class="align-middle font-weight-bold text-gray-800">{{ $dependent->contact_name }}</td>
                                <td class="align-middle"><span class="badge badge-info">{{ $dependent->relationship }}</span></td>
                                <td class="align-middle">{{ $dependent->phone_number }}</td>
                                <td class="align-middle small">{{ Str::limit($dependent->address, 50) }}</td>
                                <td class="align-middle">{{ $dependent->city }}</td>
                                <td class="text-center align-middle">
                                    <a href="{{ route('employees.family-dependents.edit', [$employee->id, $dependent->id]) }}" class="btn btn-warning btn-sm" title="Edit">
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
                        <i class="fas fa-users fa-stack-1x text-gray-400"></i>
                    </span>
                </div>
                <h5 class="text-gray-500">No family dependents found</h5>
                <p class="text-gray-400 mb-4">Add family members for emergency contact or insurance purposes.</p>
                <a href="{{ route('employees.family-dependents.create', $employee->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> Add Now
                </a>
            </div>
        @endif
    </div>
</div>

@endsection