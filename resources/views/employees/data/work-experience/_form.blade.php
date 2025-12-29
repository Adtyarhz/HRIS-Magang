<div class="form-group row">
    <label for="company_name" class="col-md-3 col-form-label text-md-right font-weight-bold">Company Name <span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" id="company_name" name="company_name"
            class="form-control @error('company_name') is-invalid @enderror"
            value="{{ old('company_name', $workExperience?->company_name) }}"
            placeholder="e.g., PT BPR Daya Perdana Nusantara" required>
        @error('company_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="company_address" class="col-md-3 col-form-label text-md-right font-weight-bold">Company Address <span class="text-danger">*</span></label>
    <div class="col-md-9">
        <textarea id="company_address" name="company_address" rows="2"
            class="form-control @error('company_address') is-invalid @enderror"
            placeholder="e.g., Jl. Raya Bogor, Mekarsari, Cimanggis District, Depok City">{{ old('company_address', $workExperience?->company_address) }}</textarea>
        @error('company_address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="company_phone" class="col-md-3 col-form-label text-md-right font-weight-bold">Company Phone <span class="text-danger">*</span></label>
    <div class="col-md-5">
        <input type="text" id="company_phone" name="company_phone"
            class="form-control @error('company_phone') is-invalid @enderror"
            value="{{ old('company_phone', $workExperience?->company_phone) }}" 
            placeholder="e.g., (021) 8720479">
        @error('company_phone')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="position_title" class="col-md-3 col-form-label text-md-right font-weight-bold">Position Title <span class="text-danger">*</span></label>
    <div class="col-md-5">
        <input type="text" id="position_title" name="position_title"
            class="form-control @error('position_title') is-invalid @enderror"
            value="{{ old('position_title', $workExperience?->position_title) }}" 
            placeholder="e.g., Software Engineer" required>
        @error('position_title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="start_date" class="col-md-3 col-form-label text-md-right font-weight-bold">Start Date <span class="text-danger">*</span></label>
    <div class="col-md-4">
        <input type="date" id="start_date" name="start_date"
            class="form-control @error('start_date') is-invalid @enderror"
            value="{{ old('start_date', optional($workExperience?->start_date ? \Carbon\Carbon::parse($workExperience->start_date) : null)->format('Y-m-d')) }}"
            required>
        @error('start_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="end_date" class="col-md-3 col-form-label text-md-right font-weight-bold">End Date <span class="text-danger">*</span></label>
    <div class="col-md-4">
        <input type="date" id="end_date" name="end_date"
            class="form-control @error('end_date') is-invalid @enderror"
            value="{{ old('end_date', optional($workExperience?->end_date ? \Carbon\Carbon::parse($workExperience->end_date) : null)->format('Y-m-d')) }}">
        @error('end_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="responsibilities" class="col-md-3 col-form-label text-md-right font-weight-bold">Responsibilities <span class="text-danger">*</span></label>
    <div class="col-md-9">
        <textarea id="responsibilities" name="responsibilities"
            class="form-control @error('responsibilities') is-invalid @enderror" rows="4"
            placeholder="Describe your main responsibilities and tasks">{{ old('responsibilities', $workExperience?->responsibilities) }}</textarea>
        @error('responsibilities')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="reason_to_leave" class="col-md-3 col-form-label text-md-right font-weight-bold">Reason to Leave <span class="text-danger">*</span></label>
    <div class="col-md-9">
        <textarea id="reason_to_leave" name="reason_to_leave"
            class="form-control @error('reason_to_leave') is-invalid @enderror" rows="3"
            placeholder="e.g., Career advancement, relocation, better opportunity">{{ old('reason_to_leave', $workExperience?->reason_to_leave) }}</textarea>
        @error('reason_to_leave')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="last_salary" class="col-md-3 col-form-label text-md-right font-weight-bold">Last Salary <span class="text-danger">*</span></label>
    <div class="col-md-4">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text">Rp</span>
            </div>
            <input type="text" id="formatted_salary" class="form-control" placeholder="0"
                value="{{ old('last_salary', $workExperience?->last_salary) ? number_format(old('last_salary', $workExperience?->last_salary), 2, ',', '.') : '' }}">
            <input type="hidden" name="last_salary" id="raw_salary" value="{{ old('last_salary', $workExperience?->last_salary) }}">
        </div>
        @error('last_salary')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>

<hr class="my-4">
<h6 class="heading-small text-muted mb-4">Supporting Documents</h6>

<div class="form-group row">
    <label for="reference_letter_file" class="col-md-3 col-form-label text-md-right font-weight-bold">Reference Letter</label>
    <div class="col-md-9">
        <div class="custom-file">
            <input type="file" class="custom-file-input @error('reference_letter_file') is-invalid @enderror" 
                id="reference_letter_file" name="reference_letter_file">
            <label class="custom-file-label" for="reference_letter_file">Choose file...</label>
            @error('reference_letter_file')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @if (!empty($workExperience?->reference_letter_file))
            <div class="mt-2">
                <span class="text-muted small mr-2">Current:</span>
                <a href="{{ asset('storage/' . $workExperience->reference_letter_file) }}" target="_blank">
                    <i class="fas fa-file-alt mr-1"></i> {{ Str::afterLast($workExperience->reference_letter_file, '_') }}
                </a>
            </div>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for="salary_slip_file" class="col-md-3 col-form-label text-md-right font-weight-bold">Salary Slip</label>
    <div class="col-md-9">
        <div class="custom-file">
            <input type="file" class="custom-file-input @error('salary_slip_file') is-invalid @enderror" 
                id="salary_slip_file" name="salary_slip_file">
            <label class="custom-file-label" for="salary_slip_file">Choose file...</label>
            @error('salary_slip_file')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        @if (!empty($workExperience?->salary_slip_file))
            <div class="mt-2">
                <span class="text-muted small mr-2">Current:</span>
                <a href="{{ asset('storage/' . $workExperience->salary_slip_file) }}" target="_blank">
                    <i class="fas fa-file-invoice-dollar mr-1"></i> {{ Str::afterLast($workExperience->salary_slip_file, '_') }}
                </a>
            </div>
        @endif
    </div>
</div>