@extends('layouts.admin')

@section('title', 'Edit Employee Information')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-edit fa-fw mr-2"></i>Edit Employee: {{ $employee->full_name }}
    </h1>
    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Detail
    </a>
</div>

@include('employees.partials.tab-menu', ['employee' => $employee])

<div class="card shadow mb-4 border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-body">
        <form id="updateForm" action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
            @method('PUT')
            @csrf

            @if (request()->routeIs('employees.edit'))
                @include('employees.data._form', [
                    'employee' => $employee,
                    'divisions' => $divisions,
                    'positions' => $positions,
                    'users' => $users,
                ])
            @elseif(request()->routeIs('employees.address.edit'))
                @include('employees.data._address_form', ['employee' => $employee])
            @else
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-tools fa-3x mb-3"></i>
                    <p>Konten untuk tab ini belum tersedia atau sedang dalam pengembangan.</p>
                </div>
            @endif

            <hr class="mt-4">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary mr-2">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save mr-1"></i> Save Changes
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection

@push('js')
    <script>
        // Disable submit button on form submission to prevent double submit
        document.getElementById('updateForm').addEventListener('submit', function (e) {
            const submitButton = this.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Saving...';
            }
        });
    </script>
@endpush