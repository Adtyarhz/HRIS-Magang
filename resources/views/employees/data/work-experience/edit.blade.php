@extends('layouts.admin')

@section('title', 'Edit Work Experience')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-edit fa-fw mr-2"></i>Edit Work Experience
    </h1>
    <a href="{{ route('employees.work-experience.index', $employee->id) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to List
    </a>
</div>

@include('employees.partials.tab-menu', ['employee' => $employee])

<div class="card shadow mb-4 border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-body">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 pl-3">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="updateForm" action="{{ route('employees.work-experience.update', [$employee->id, $workExperience->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h6 class="heading-small text-muted mb-4">Experience Details</h6>
                    
                    @include('employees.data.work-experience._form', ['workExperience' => $workExperience])

                    <hr class="mt-5">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" onclick="showDeleteModal('work-experience-{{ $workExperience->id }}')">
                                <i class="fas fa-trash mr-1"></i> Delete Experience
                            </button>

                            <div>
                                <a href="{{ route('employees.work-experience.index', $employee->id) }}" class="btn btn-secondary mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4">Update Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<x-delete-modal modalId="work-experience-{{ $workExperience->id }}"
    :action="route('employees.work-experience.destroy', [$employee->id, $workExperience->id])"
    message="Are you sure you want to delete this Work Experience?" />

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formattedInput = document.getElementById('formatted_salary');
            const rawInput = document.getElementById('raw_salary');

            if (formattedInput && rawInput) {
                const cleave = new Cleave(formattedInput, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand',
                    numeralDecimalMark: ',',
                    delimiter: '.',
                    numeralDecimalScale: 2,
                    rawValueTrimPrefix: true,
                });

                if(rawInput.value) {
                    cleave.setRawValue(rawInput.value);
                }

                formattedInput.addEventListener('input', function() {
                    rawInput.value = cleave.getRawValue();
                });
            }

            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop();
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            });

            document.getElementById('updateForm').addEventListener('submit', function() {
                let btn = this.querySelector('button[type="submit"]');
                if (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Updating...';
                }
            });
        });
    </script>
@endpush