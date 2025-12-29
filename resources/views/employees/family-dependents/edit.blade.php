@extends('layouts.admin')

@section('title', 'Edit Family Dependent')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-edit fa-fw mr-2"></i>Edit Family Dependent
    </h1>
    <a href="{{ route('employees.family-dependents.index', $employee->id) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to List
    </a>
</div>

@include('employees.partials.tab-menu', ['employee' => $employee])

<div class="card shadow mb-4 border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-body">
        <form id="updateForm" action="{{ route('employees.family-dependents.update', [$employee->id, $familyDependent->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h6 class="heading-small text-muted mb-4">Dependent Details</h6>

                    @include('employees.family-dependents._form', ['familyDependent' => $familyDependent])

                    <hr class="mt-5">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" onclick="showDeleteModal('family-dependent-{{ $familyDependent->id }}')">
                                <i class="fas fa-trash mr-1"></i> Delete Dependent
                            </button>
                            
                            <div>
                                <a href="{{ route('employees.family-dependents.index', $employee->id) }}" class="btn btn-secondary mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4">Update Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<x-delete-modal modalId="family-dependent-{{ $familyDependent->id }}"
    :action="route('employees.family-dependents.destroy', [$employee->id, $familyDependent->id])"
    message="Are you sure you want to delete this family dependent?" />

@endsection

@push('js')
<script>
    document.getElementById('updateForm').addEventListener('submit', function() {
        let btn = this.querySelector('button[type="submit"]');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Updating...';
        }
    });
</script>
@endpush