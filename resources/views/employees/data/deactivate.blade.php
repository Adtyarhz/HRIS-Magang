@extends('layouts.admin')

@section('title', 'Deactivate Employee')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-slash fa-fw mr-2"></i>Deactivate Employee
    </h1>
    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Detail
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow mb-4 border-left-danger">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-danger">Deactivation Form: {{ $employee->full_name }}</h6>
            </div>
            <div class="card-body">
                
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    <strong>Warning:</strong> Deactivating an employee will disable their access to the system.
                </div>

                <form id="deactivateForm" method="POST" action="{{ route('employees.deactivate', $employee) }}">
                    @csrf
                    @method('PUT')

                    {{-- Last Working Date --}}
                    <div class="form-group row">
                        <label for="deactivation_date" class="col-sm-4 col-form-label font-weight-bold">
                            Last Working Date <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                                <input type="date" class="form-control @error('deactivation_date') is-invalid @enderror" 
                                    id="deactivation_date" name="deactivation_date" 
                                    value="{{ old('deactivation_date') }}" required>
                                @error('deactivation_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Termination Reason --}}
                    <div class="form-group row">
                        <label for="termination_reason" class="col-sm-4 col-form-label font-weight-bold">
                            Termination Reason <span class="text-danger">*</span>
                        </label>
                        <div class="col-sm-8">
                            <select name="termination_reason" id="termination_reason" 
                                class="form-control @error('termination_reason') is-invalid @enderror" required>
                                <option value="" disabled {{ old('termination_reason') ? '' : 'selected' }}>-- Select Reason --</option>
                                <option value="Mengundurkan diri" {{ old('termination_reason') == 'Mengundurkan diri' ? 'selected' : '' }}>Resigned (Mengundurkan Diri)</option>
                                <option value="Pensiun" {{ old('termination_reason') == 'Pensiun' ? 'selected' : '' }}>Retired (Pensiun)</option>
                                <option value="Tidak lulus masa percobaan" {{ old('termination_reason') == 'Tidak lulus masa percobaan' ? 'selected' : '' }}>Failed probation</option>
                                <option value="Tidak cakap bekerja" {{ old('termination_reason') == 'Tidak cakap bekerja' ? 'selected' : '' }}>Incompetent to work</option>
                                <option value="Tidak mampu bekerja karena alasan kesehatan" {{ old('termination_reason') == 'Tidak mampu bekerja karena alasan kesehatan' ? 'selected' : '' }}>Health Reasons</option>
                                <option value="Meninggal dunia" {{ old('termination_reason') == 'Meninggal dunia' ? 'selected' : '' }}>Deceased (Meninggal Dunia)</option>
                                <option value="Melakukan pelanggaran tata tertib dan disiplin" {{ old('termination_reason') == 'Melakukan pelanggaran tata tertib dan disiplin' ? 'selected' : '' }}>Disciplinary Violation</option>
                                <option value="Merugikan perusahaan" {{ old('termination_reason') == 'Merugikan perusahaan' ? 'selected' : '' }}>Caused Company Loss</option>
                                <option value="Terlibat tindakan pidana" {{ old('termination_reason') == 'Terlibat tindakan pidana' ? 'selected' : '' }}>Criminal Involvement</option>
                            </select>
                            @error('termination_reason')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Additional Notes --}}
                    <div class="form-group row">
                        <label for="termination_notes" class="col-sm-4 col-form-label font-weight-bold">
                            Additional Notes
                        </label>
                        <div class="col-sm-8">
                            <textarea id="termination_notes" name="termination_notes" rows="4" 
                                class="form-control @error('termination_notes') is-invalid @enderror" 
                                placeholder="Add any remarks...">{{ old('termination_notes') }}</textarea>
                            @error('termination_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr>

                    {{-- Buttons --}}
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary mr-2">Cancel</a>
                        
                        {{-- Trigger Modal --}}
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deactivateModal">
                            <i class="fas fa-ban mr-1"></i> Deactivate
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

<x-deactive-modal 
    modalId="deactivateModal" 
    title="Confirm Deactivation" 
    message="Are you sure you want to deactivate this employee? This action cannot be undone immediately." 
    useFormId="deactivateForm" 
/>

@endsection

@push('js')
    <script>
        document.getElementById('deactivateForm').addEventListener('submit', function (e) {
            const modalBtn = document.querySelector('#deactivateModal .btn-primary');
            if(modalBtn) {
                modalBtn.disabled = true;
                modalBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
            }
        });
    </script>
@endpush