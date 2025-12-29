<div class="row justify-content-center">
    <div class="col-lg-8">
        <h6 class="heading-small text-muted mb-4">Address Information</h6>
        
        <div class="form-group">
            <label class="form-control-label" for="ktp_address">KTP Address (Sesuai KTP) <span class="text-danger">*</span></label>
            <textarea class="form-control @error('ktp_address') is-invalid @enderror" id="ktp_address" 
                name="ktp_address" rows="3" required>{{ old('ktp_address', $employee->ktp_address) }}</textarea>
            @error('ktp_address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label class="form-control-label" for="current_address">Current Address (Domisili) <span class="text-danger">*</span></label>
            <textarea class="form-control @error('current_address') is-invalid @enderror" id="current_address" 
                name="current_address" rows="3" required>{{ old('current_address', $employee->current_address) }}</textarea>
            <small class="form-text text-muted">Isi sama dengan KTP jika tinggal sesuai alamat KTP.</small>
            @error('current_address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Hidden fields required for update validation if controller validates generic fields --}}
        <input type="hidden" name="full_name" value="{{ $employee->full_name }}">
        <input type="hidden" name="gender" value="{{ $employee->gender }}">
        <input type="hidden" name="birth_place" value="{{ $employee->birth_place }}">
        <input type="hidden" name="birth_date" value="{{ $employee->birth_date }}">
        <input type="hidden" name="religion" value="{{ $employee->religion }}">
        <input type="hidden" name="nik" value="{{ $employee->nik }}">
        <input type="hidden" name="marital_status" value="{{ $employee->marital_status }}">
        <input type="hidden" name="phone_number" value="{{ $employee->phone_number }}">
        <input type="hidden" name="email" value="{{ $employee->email }}">
        <input type="hidden" name="status" value="{{ $employee->status }}">
        <input type="hidden" name="employee_type" value="{{ $employee->employee_type }}">
        <input type="hidden" name="division_id" value="{{ $employee->division_id }}">
        <input type="hidden" name="hire_date" value="{{ $employee->hire_date }}">
        <input type="hidden" name="office" value="{{ $employee->office }}">

    </div>
</div>