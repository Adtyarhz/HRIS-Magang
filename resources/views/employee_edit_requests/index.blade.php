@extends('layouts.admin')

@section('title', 'Employee Edit Requests')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-clipboard-list fa-fw mr-2"></i>Employee Data Change Requests
    </h1>
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
        <h6 class="m-0 font-weight-bold text-primary">Request List</h6>
    </div>
    <div class="card-body">
        
        {{-- Search & Filter Form --}}
        <form action="{{ route('employee-edit-requests.index') }}" method="GET" class="mb-4">
            <div class="row align-items-end">
                <div class="col-md-6 col-12 mb-3 mb-md-0">
                    <label class="small font-weight-bold text-secondary">Search</label>
                    <div class="input-group">
                        <input type="text" name="search" class="form-control bg-light border-1 small" 
                               placeholder="Input Employee’s Name..." 
                               aria-label="Search" 
                               value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-12 text-md-right">
                    <button type="button" class="btn btn-info btn-icon-split shadow-sm" id="filter-toggle-btn">
                        <span class="icon text-white-50">
                            <i class="fas fa-filter"></i>
                        </span>
                        <span class="text">Filter</span>
                    </button>

                    <a href="{{ route('employee-edit-requests.index') }}" class="btn btn-secondary btn-icon-split shadow-sm ml-2" id="filter-reset" style="display: none;">
                        <span class="icon text-white-50">
                            <i class="fas fa-undo"></i>
                        </span>
                        <span class="text">Reset</span>
                    </a>
                </div>
            </div>

            {{-- Collapsible Filter Section --}}
            <div class="mt-3 p-3 bg-light rounded border" id="filter-container" style="display: none;">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="status" class="small font-weight-bold">Status</label>
                        <select name="status" id="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="waiting" {{ request('status') == 'waiting' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="sort" class="small font-weight-bold">Sort By Date</label>
                        <select name="sort" id="sort" class="form-control">
                            <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Newest First</option>
                            <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Oldest First</option>
                        </select>
                    </div>
                    <div class="col-12 text-right">
                         <button type="submit" class="btn btn-primary btn-sm px-4">Apply Filter</button>
                    </div>
                </div>
            </div>
        </form>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th>Employee</th>
                        <th class="text-center">Status</th>
                        <th>Submission Date</th>
                        <th>Approved By</th>
                        <th class="text-center" style="width: 15%;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($requests as $index => $req)
                        <tr>
                            <td class="align-middle text-center">{{ $index + 1 + ($requests->currentPage() - 1) * $requests->perPage() }}</td>
                            <td class="align-middle">
                                <div class="d-flex align-items-center">
                                    <img class="img-profile rounded-circle mr-3" 
                                         style="width: 40px; height: 40px; object-fit: cover;"
                                         src="{{ $req->employee->photo ? asset('storage/' . $req->employee->photo) : 'https://placehold.co/40x40/9A3B3B/FFFFFF?text=' . strtoupper(substr($req->employee->full_name ?? '-', 0, 1)) }}"
                                         alt="Avatar">
                                    <div>
                                        <div class="font-weight-bold text-gray-800">{{ $req->employee->full_name ?? '-' }}</div>
                                        <div class="small text-gray-500">ID: {{ $req->employee->id ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle text-center">
                                @if ($req->status === 'waiting')
                                    <span class="badge badge-warning px-2 py-1">Pending</span>
                                @elseif ($req->status === 'approved')
                                    <span class="badge badge-success px-2 py-1">Approved</span>
                                @elseif ($req->status === 'rejected')
                                    <span class="badge badge-danger px-2 py-1">Rejected</span>
                                @endif
                            </td>
                            <td class="align-middle">
                                {{ $req->requested_at ? \Carbon\Carbon::parse($req->requested_at)->format('d M Y, H:i') : '-' }}
                            </td>
                            <td class="align-middle">
                                {{ $req->approvedBy->name ?? '-' }}
                            </td>
                            <td class="align-middle text-center">
                                <a href="{{ route('employee-edit-requests.show', $req->id) }}" class="btn btn-primary btn-sm btn-icon-split">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                    <span class="text">Detail</span>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 text-gray-300"></i><br>
                                No change requests found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($requests->hasPages())
            <div class="mt-4 d-flex justify-content-end">
                {{ $requests->withQueryString()->links('pagination::bootstrap-4') }}
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
            const hasFilters = ['status', 'sort'].some(param =>
                urlParams.has(param) && urlParams.get(param) !== ''
            );

            if (hasFilters) {
                filterContainer.style.display = 'block';
                resetButton.style.display = 'inline-flex';
            }

            filterToggleBtn.addEventListener('click', function(event) {
                event.preventDefault();
                if (filterContainer.style.display === 'none' || filterContainer.style.display === '') {
                    filterContainer.style.display = 'block';
                    resetButton.style.display = 'inline-flex';
                } else {
                    filterContainer.style.display = 'none';
                    if(!hasFilters) resetButton.style.display = 'none';
                }
            });
        });
    </script>
@endpush