<div class="form-group row">
    <label for="education_level" class="col-md-3 col-form-label text-md-right font-weight-bold">Education Level <span class="text-danger">*</span></label>
    <div class="col-md-4">
        <select name="education_level" id="education_level" class="form-control @error('education_level') is-invalid @enderror" required>
            <option value="">-- Select Level --</option>
            @foreach(['SD', 'SMP', 'SMA', 'D1', 'D2', 'D3', 'S1', 'S2', 'S3'] as $level)
                <option value="{{ $level }}" {{ old('education_level', $education?->education_level) == $level ? 'selected' : '' }}>{{ $level }}</option>
            @endforeach
        </select>
        @error('education_level')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="institution_name" class="col-md-3 col-form-label text-md-right font-weight-bold">Institution Name <span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" id="institution_name" name="institution_name"
            class="form-control @error('institution_name') is-invalid @enderror"
            value="{{ old('institution_name', $education?->institution_name) }}"
            placeholder="e.g., University of Indonesia" required>
        @error('institution_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="institution_address" class="col-md-3 col-form-label text-md-right font-weight-bold">Institution Address <span class="text-danger">*</span></label>
    <div class="col-md-9">
        <textarea id="institution_address" name="institution_address" rows="2"
            class="form-control @error('institution_address') is-invalid @enderror"
            placeholder="Enter full address" required>{{ old('institution_address', $education?->institution_address) }}</textarea>
        @error('institution_address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="major" class="col-md-3 col-form-label text-md-right font-weight-bold">Major <span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" id="major" name="major"
            class="form-control @error('major') is-invalid @enderror"
            value="{{ old('major', $education?->major) }}"
            placeholder="e.g., Computer Science" required>
        @error('major')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="start_year" class="col-md-3 col-form-label text-md-right font-weight-bold">Start Year <span class="text-danger">*</span></label>
    <div class="col-md-3">
        <input type="number" id="start_year" name="start_year"
            class="form-control @error('start_year') is-invalid @enderror"
            min="1900" max="2099"
            value="{{ old('start_year', $education?->start_year) }}"
            placeholder="YYYY" required>
        @error('start_year')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="end_year" class="col-md-3 col-form-label text-md-right font-weight-bold">End Year <span class="text-danger">*</span></label>
    <div class="col-md-3">
        <input type="number" id="end_year" name="end_year"
            class="form-control @error('end_year') is-invalid @enderror"
            min="1900" max="2099"
            value="{{ old('end_year', $education?->end_year) }}"
            placeholder="YYYY" required>
        @error('end_year')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="gpa_or_score" class="col-md-3 col-form-label text-md-right font-weight-bold">GPA / Score <span class="text-danger">*</span></label>
    <div class="col-md-3">
        <input type="number" id="gpa_or_score" name="gpa_or_score"
            class="form-control @error('gpa_or_score') is-invalid @enderror"
            step="0.01" min="0" max="100"
            value="{{ old('gpa_or_score', $education?->gpa_or_score) }}"
            placeholder="e.g., 3.50" required>
        @error('gpa_or_score')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="certificate_number" class="col-md-3 col-form-label text-md-right font-weight-bold">Certificate No.</label>
    <div class="col-md-5">
        <input type="text" id="certificate_number" name="certificate_number"
            class="form-control @error('certificate_number') is-invalid @enderror"
            value="{{ old('certificate_number', $education?->certificate_number) }}"
            placeholder="Optional">
        @error('certificate_number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>