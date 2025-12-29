@extends('layouts.admin')

@section('title', 'Data Karyawan')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-users fa-fw mr-2"></i>Employee Information
    </h1>
    @if(auth()->user()->role === 'superadmin')
        <a href="{{ route('employees.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 mr-1"></i> Add New Employee
        </a>
    @endif
</div>

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-primary">List of Employees</h6>
    </div>
    
    <div class="card-body">
        
        {{-- Search & Filter Form --}}
        <form action="{{ route('employees.index') }}" method="GET" class="mb-4">
            <div class="row align-items-end">
                {{-- Search Input --}}
                <div class="col-md-6 col-12 mb-3 mb-md-0">
                    <label class="small font-weight-bold text-secondary">Search</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control bg-light border-1 small" 
                               placeholder="Input Employee’s Name or NIP..." 
                               aria-label="Search" 
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="col-md-6 col-12 text-md-right">
                    <button type="button" class="btn btn-info btn-icon-split" id="filter-toggle-btn">
                        <span class="icon text-white-50">
                            <i class="fas fa-filter"></i>
                        </span>
                        <span class="text">Filter Options</span>
                    </button>

                    <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-icon-split ml-2" id="filter-reset" style="display: none;">
                        <span class="icon text-white-50">
                            <i class="fas fa-undo"></i>
                        </span>
                        <span class="text">Reset</span>
                    </a>
                </div>
            </div>

            {{-- Collapsible Filter Section --}}
            <div class="mt-3 p-3 bg-light rounded border" id="filter-container" style="display: none;">
                <h6 class="font-weight-bold text-gray-700 mb-3"><i class="fas fa-sliders-h mr-1"></i> Advanced Filter</h6>
                <div class="row">
                    {{-- Division Filter --}}
                    <div class="col-md-3 mb-3">
                        <label for="division_id" class="small">Division</label>
                        <select name="division_id" id="division_id" class="form-control form-control-sm">
                            <option value="">All Divisions</option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division->id }}" {{ request('division_id') == $division->id ? 'selected' : '' }}>
                                    {{ $division->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Employment Type Filter --}}
                    <div class="col-md-3 mb-3">
                        <label for="employee_type" class="small">Employment Type</label>
                        <select name="employee_type" id="employee_type" class="form-control form-control-sm">
                            <option value="">All Types</option>
                            <option value="PKWT" {{ request('employee_type') == 'PKWT' ? 'selected' : '' }}>PKWT</option>
                            <option value="PKWTT" {{ request('employee_type') == 'PKWTT' ? 'selected' : '' }}>PKWTT</option>
                            <option value="Probation" {{ request('employee_type') == 'Probation' ? 'selected' : '' }}>Probation</option>
                            <option value="Intern" {{ request('employee_type') == 'Intern' ? 'selected' : '' }}>Intern</option>
                        </select>
                    </div>

                    {{-- Position Filter --}}
                    <div class="col-md-3 mb-3">
                        <label for="position_id" class="small">Position</label>
                        <select name="position_id" id="position_id" class="form-control form-control-sm">
                            <option value="">All Positions</option>
                            @foreach ($positions as $position)
                                <option value="{{ $position->id }}" {{ request('position_id') == $position->id ? 'selected' : '' }}>
                                    {{ $position->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Office Filter --}}
                    <div class="col-md-3 mb-3">
                        <label for="office" class="small">Office</label>
                        <select name="office" id="office" class="form-control form-control-sm">
                            <option value="">All Offices</option>
                            <option value="Kantor Pusat" {{ request('office') == 'Kantor Pusat' ? 'selected' : '' }}>Kantor Pusat</option>
                            <option value="Kantor Cabang" {{ request('office') == 'Kantor Cabang' ? 'selected' : '' }}>Kantor Cabang</option>
                        </select>
                    </div>
                </div>
                <div class="text-right">
                     <button type="submit" class="btn btn-primary btn-sm">Apply Filters</button>
                </div>
            </div>
        </form>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 35%;">Employee Name</th>
                        <th style="width: 30%;">Position & Division</th>
                        <th style="width: 15%;">Status</th>
                        <th style="width: 15%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($employees as $index => $employee)
                        <tr>
                            <td class="align-middle text-center">
                                {{ $index + 1 + ($employees->currentPage() - 1) * $employees->perPage() }}
                            </td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <img class="img-profile rounded-circle mr-3" 
                                         style="width: 45px; height: 45px; object-fit: cover;"
                                         src="{{ $employee->photo ? asset('storage/' . $employee->photo) : 'https://placehold.co/160x160/9A3B3B/FFFFFF?text=' . strtoupper(substr($employee->full_name, 0, 1)) }}"
                                         alt="Avatar">
                                    <div>
                                        <div class="font-weight-bold text-gray-800">{{ $employee->full_name }}</div>
                                        <div class="small text-gray-500">NIP: {{ $employee->nip }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle">
                                <div class="font-weight-bold">{{ $employee->position->title ?? 'Belum Diatur' }}</div>
                                <div class="small text-muted">{{ $employee->division->name ?? 'Belum Diatur' }}</div>
                            </td>
                            <td class="align-middle text-center">
                                @if($employee->status == 'Aktif')
                                    <span class="badge badge-success px-2 py-1">Active</span>
                                @else
                                    <span class="badge badge-secondary px-2 py-1">Inactive</span>
                                @endif
                            </td>
                            <td class="align-middle text-center">
                                <a href="{{ route('employees.show', $employee) }}" class="btn btn-info btn-sm btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                    <span class="text">Details</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3 text-gray-300"></i><br>
                                Tidak ada data karyawan yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($employees->hasPages())
            <div class="mt-4 d-flex justify-content-end">
                {{ $employees->withQueryString()->links('pagination::bootstrap-4') }}
            </div>
        @endif

    </div>
</div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterToggleBtn = document.getElementById('filter-toggle-btn');
            const filterContainer = document.getElementById('filter-container');
            const resetButton = document.getElementById('filter-reset');

            const urlParams = new URLSearchParams(window.location.search);
            const hasFilters = ['division_id', 'position_id', 'employee_type', 'office'].some(param =>
                urlParams.has(param) && urlParams.get(param) !== '');

            if (hasFilters) {
                filterContainer.style.display = 'block';
                resetButton.style.display = 'inline-flex';
            }

            // Logic Toggle Filter
            filterToggleBtn.addEventListener('click', function(event) {
                event.preventDefault();

                if (filterContainer.style.display === 'none' || filterContainer.style.display === '') {
                    filterContainer.style.display = 'block';
                    resetButton.style.display = 'inline-flex';
                } else {
                    filterContainer.style.display = 'none';
                    if(!hasFilters) {
                        resetButton.style.display = 'none';
                    }
                }
            });
        });
    </script>
@endpush