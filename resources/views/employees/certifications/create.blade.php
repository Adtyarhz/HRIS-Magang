@extends('layouts.admin')

@section('title', 'Add Certification')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-certificate fa-fw mr-2"></i>Add Certification
    </h1>
    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Detail
    </a>
</div>

@include('employees.partials.tab-menu', ['employee' => $employee])

<div class="card shadow mb-4 border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-body">
        <form action="{{ route('employees.certifications.store', $employee->id) }}" method="POST" enctype="multipart/form-data" id="createForm">
            @csrf

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h6 class="heading-small text-muted mb-4">Certification Details</h6>

                    <div class="form-group row">
                        <label for="certification_name" class="col-md-3 col-form-label text-md-right font-weight-bold">Certification Name <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control @error('certification_name') is-invalid @enderror" 
                                id="certification_name" name="certification_name" 
                                value="{{ old('certification_name') }}" 
                                placeholder="e.g., AWS Certified Solutions Architect" required>
                            @error('certification_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="issuer" class="col-md-3 col-form-label text-md-right font-weight-bold">Issuer <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <input type="text" class="form-control @error('issuer') is-invalid @enderror" 
                                id="issuer" name="issuer" value="{{ old('issuer') }}" 
                                placeholder="e.g., Amazon Web Services" required>
                            @error('issuer')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="description" class="col-md-3 col-form-label text-md-right font-weight-bold">Description</label>
                        <div class="col-md-9">
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                id="description" name="description" rows="3" 
                                placeholder="Brief description of certification">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="date_obtained" class="col-md-3 col-form-label text-md-right font-weight-bold">Date Obtained <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <input type="date" class="form-control @error('date_obtained') is-invalid @enderror" 
                                id="date_obtained" name="date_obtained" 
                                value="{{ old('date_obtained') }}" required>
                            @error('date_obtained')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="expiry_date" class="col-md-3 col-form-label text-md-right font-weight-bold">Expiry Date</label>
                        <div class="col-md-4">
                            <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" 
                                id="expiry_date" name="expiry_date" 
                                value="{{ old('expiry_date') }}">
                            @error('expiry_date')
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
                                    id="cost" name="cost" value="{{ old('cost') }}" 
                                    placeholder="0" required>
                            </div>
                            @error('cost')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    <h6 class="heading-small text-muted mb-4">Documents</h6>

                    <div class="form-group row">
                        <label for="certificate_file" class="col-md-3 col-form-label text-md-right font-weight-bold">Main Certificate <span class="text-danger">*</span></label>
                        <div class="col-md-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('certificate_file') is-invalid @enderror" 
                                    id="certificate_file" name="certificate_file" required>
                                <label class="custom-file-label" for="certificate_file">Choose file...</label>
                                @error('certificate_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted mt-2">Format: PDF, JPG, PNG. Max: 5MB.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="material_files" class="col-md-3 col-form-label text-md-right font-weight-bold">Supporting Files</label>
                        <div class="col-md-9">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('material_files') is-invalid @enderror" 
                                    id="material_files" name="material_files[]" multiple>
                                <label class="custom-file-label" for="material_files">Choose files...</label>
                                @error('material_files')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="form-text text-muted mt-2">Multiple files allowed. Max 10MB per file.</small>
                        </div>
                    </div>

                    <hr class="mt-5">
                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="{{ route('employees.certifications.index', $employee->id) }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

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

    document.getElementById('createForm').addEventListener('submit', function() {
        let btn = this.querySelector('button[type="submit"]');
        if (btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Saving...';
        }
    });
</script>
@endpush