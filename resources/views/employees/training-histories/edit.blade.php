@extends('layouts.admin')

@section('title', 'Edit Training Record')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-edit fa-fw mr-2"></i>Edit Training Record
    </h1>
    <a href="{{ route('employees.training-histories.index', $employee->id) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to List
    </a>
</div>

@include('employees.partials.tab-menu', ['employee' => $employee])

<div class="card shadow mb-4 border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-body">
        <form id="updateForm" action="{{ route('employees.training-histories.update', [$employee->id, $trainingHistory->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h6 class="heading-small text-muted mb-4">Training Details</h6>

                    <div class="form-group row">
                        <label for="training_name" class="col-md-3 col-form-label text-md-right font-weight-bold">Training Name <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control @error('training_name') is-invalid @enderror" 
                                id="training_name" name="training_name" 
                                value="{{ old('training_name', $trainingHistory->training_name) }}" required>
                            @error('training_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="provider" class="col-md-3 col-form-label text-md-right font-weight-bold">Provider <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control @error('provider') is-invalid @enderror" 
                                id="provider" name="provider" value="{{ old('provider', $trainingHistory->provider) }}" required>
                            @error('provider')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-3 col-form-label text-md-right font-weight-bold">Description <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="3" required>{{ old('description', $trainingHistory->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="start_date" class="col-md-3 col-form-label text-md-right font-weight-bold">Start Date <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
                                id="start_date" name="start_date" 
                                value="{{ old('start_date', \Carbon\Carbon::parse($trainingHistory->start_date)->format('Y-m-d')) }}" required>
                            @error('start_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="end_date" class="col-md-3 col-form-label text-md-right font-weight-bold">End Date <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <input type="date" class="form-control @error('end_date') is-invalid @enderror" 
                                id="end_date" name="end_date" 
                                value="{{ old('end_date', optional(\Carbon\Carbon::parse($trainingHistory->end_date ?? ''))->format('Y-m-d')) }}" required>
                            @error('end_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cost" class="col-md-3 col-form-label text-md-right font-weight-bold">Cost <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="number" step="any" class="form-control @error('cost') is-invalid @enderror" 
                                    id="cost" name="cost" value="{{ old('cost', $trainingHistory->cost) }}" required>
                            </div>
                            @error('cost')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="location" class="col-md-3 col-form-label text-md-right font-weight-bold">Location <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <textarea class="form-control @error('location') is-invalid @enderror" 
                                id="location" name="location" rows="2" required>{{ old('location', $trainingHistory->location) }}</textarea>
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    <h6 class="heading-small text-muted mb-4">Documents</h6>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-md-right font-weight-bold">Certificate File</label>
                        <div class="col-md-9">
                             <div class="custom-file mb-2">
                                <input type="file" class="custom-file-input @error('certificate_file') is-invalid @enderror" id="certificate_file" name="certificate_file">
                                <label class="custom-file-label" for="certificate_file">Choose file to replace...</label>
                                @error('certificate_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            @if ($trainingHistory->certificate_file)
                                <div>
                                    <span class="text-muted small mr-2">Current file:</span>
                                    <a href="{{ asset('storage/' . $trainingHistory->certificate_file) }}" target="_blank" class="btn btn-sm btn-info">
                                        <i class="fas fa-file-pdf mr-1"></i> View Certificate
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-3 col-form-label text-md-right font-weight-bold">Training Files</label>
                        <div class="col-md-9">
                            @if ($trainingHistory->trainingMaterials->isNotEmpty())
                                <ul class="list-group mb-3">
                                    @foreach ($trainingHistory->trainingMaterials as $material)
                                        <li class="list-group-item d-flex justify-content-between align-items-center p-2">
                                            <a href="{{ asset('storage/training_materials/' . $material->file_path) }}" target="_blank" class="text-decoration-none">
                                                <i class="fas fa-file-alt text-primary mr-2"></i>
                                                {{ Str::afterLast($material->file_path, '/') }}
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" 
                                                onclick="showDeleteModal('delete-material', '{{ route('employees.training-histories.materials.destroy', [$employee->id, $trainingHistory->id, $material->id]) }}')">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted small font-italic mb-2">No training materials uploaded.</p>
                            @endif

                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('material_files') is-invalid @enderror" id="material_files" name="material_files[]" multiple>
                                <label class="custom-file-label" for="material_files">Add more files...</label>
                                @error('material_files')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="mt-5">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-between">
                            <button type="button" class="btn btn-danger" onclick="showDeleteModal('training-history-{{ $trainingHistory->id }}')">
                                <i class="fas fa-trash mr-1"></i> Delete Record
                            </button>
                            
                            <div>
                                <a href="{{ route('employees.training-histories.index', $employee->id) }}" class="btn btn-secondary mr-2">Cancel</a>
                                <button type="submit" class="btn btn-primary px-4">Update Record</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<x-delete-modal modalId="training-history-{{ $trainingHistory->id }}"
    :action="route('employees.training-histories.destroy', [$employee->id, $trainingHistory->id])"
    message="Are you sure you want to delete this training record? This will also remove all associated files." />

<x-delete-modal-material modalId="delete-material" message="Are you sure you want to delete this file?" />

@endsection

@push('js')
<script>
    $('.custom-file-input').on('change', function() {
        var files = $(this)[0].files;
        if (files.length > 1) {
            $(this).next('.custom-file-label').html(files.length + ' files selected');
        } else if (files.length == 1) {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        }
    });

    document.getElementById('updateForm').addEventListener('submit', function() {
        let btn = this.querySelector('button[type="submit"]');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Updating...';
        }
    });
</script>
@endpush