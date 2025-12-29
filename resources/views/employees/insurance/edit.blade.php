@extends('layouts.admin')

@section('title', 'Edit Insurance')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-edit fa-fw mr-2"></i>Edit Insurance
    </h1>
    <a href="{{ route('employees.insurance.index', $employee) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to List
    </a>
</div>

@include('employees.partials.tab-menu', ['employee' => $employee])

<div class="card shadow mb-4 border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-body">
        <form id="updateForm" action="{{ route('employees.insurance.update', [$employee, $insurance]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h6 class="heading-small text-muted mb-4">Insurance Details</h6>

                    @include('employees.insurance._form', ['insurance' => $insurance])

                    <hr class="mt-5">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" onclick="showDeleteModal('insurance-{{ $insurance->id }}')">
                                <i class="fas fa-trash mr-1"></i> Delete Insurance
                            </button>
                            
                            <div>
                                <a href="{{ route('employees.insurance.index', $employee) }}" class="btn btn-secondary mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4">Update Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<x-delete-modal modalId="insurance-{{ $insurance->id }}"
    :action="route('employees.insurance.destroy', [$employee, $insurance])"
    message="Are you sure you want to delete this Insurance record?" />

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

    // Custom file input label update
    $('.custom-file-input').on('change', function() {
        let fileName = $(this).val().split('\\').pop();
        $(this).next('.custom-file-label').addClass("selected").html(fileName);
    });
</script>
@endpush