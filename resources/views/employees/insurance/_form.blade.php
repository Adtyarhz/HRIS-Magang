<div class="form-group row">
    <label for="insurance_number" class="col-md-3 col-form-label text-md-right font-weight-bold">Insurance Number <span class="text-danger">*</span></label>
    <div class="col-md-5">
        <input type="text" class="form-control @error('insurance_number') is-invalid @enderror" 
            id="insurance_number" name="insurance_number" 
            value="{{ old('insurance_number', $insurance->insurance_number ?? '') }}" 
            placeholder="Enter insurance number" required>
        @error('insurance_number')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="insurance_type" class="col-md-3 col-form-label text-md-right font-weight-bold">Insurance Type <span class="text-danger">*</span></label>
    <div class="col-md-4">
        <select id="insurance_type" class="form-control @error('insurance_type') is-invalid @enderror" name="insurance_type" required>
            <option value="">-- Select Type --</option>
            @foreach (['KES', 'TK', 'N-BPJS'] as $type)
                <option value="{{ $type }}" {{ old('insurance_type', $insurance->insurance_type ?? '') === $type ? 'selected' : '' }}>
                    {{ $type }}
                </option>
            @endforeach
        </select>
        @error('insurance_type')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="faskes_name" class="col-md-3 col-form-label text-md-right font-weight-bold">Faskes Name <span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" class="form-control @error('faskes_name') is-invalid @enderror" 
            id="faskes_name" name="faskes_name"
            value="{{ old('faskes_name', $insurance->faskes_name ?? '') }}"
            placeholder="Enter hospital or clinic name" required>
        @error('faskes_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="faskes_address" class="col-md-3 col-form-label text-md-right font-weight-bold">Faskes Address <span class="text-danger">*</span></label>
    <div class="col-md-9">
        <textarea class="form-control @error('faskes_address') is-invalid @enderror"
            id="faskes_address" name="faskes_address" rows="2"
            placeholder="Enter hospital or clinic address" required>{{ old('faskes_address', $insurance->faskes_address ?? '') }}</textarea>
        @error('faskes_address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="start_date" class="col-md-3 col-form-label text-md-right font-weight-bold">Start Date <span class="text-danger">*</span></label>
    <div class="col-md-4">
        <input type="date" class="form-control @error('start_date') is-invalid @enderror" 
            id="start_date" name="start_date"
            value="{{ old('start_date', isset($insurance) && $insurance->start_date ? \Carbon\Carbon::parse($insurance->start_date)->format('Y-m-d') : '') }}"
            required>
        @error('start_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="expiry_date" class="col-md-3 col-form-label text-md-right font-weight-bold">Expiry Date <span class="text-danger">*</span></label>
    <div class="col-md-4">
        <input type="date" class="form-control @error('expiry_date') is-invalid @enderror" 
            id="expiry_date" name="expiry_date"
            value="{{ old('expiry_date', isset($insurance) && $insurance->expiry_date ? \Carbon\Carbon::parse($insurance->expiry_date)->format('Y-m-d') : '') }}"
            required>
        @error('expiry_date')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="status" class="col-md-3 col-form-label text-md-right font-weight-bold">Status <span class="text-danger">*</span></label>
    <div class="col-md-4">
        <select id="status" class="form-control @error('status') is-invalid @enderror" name="status" required>
            @foreach (['AKTIF', 'NONAKTIF'] as $status)
                <option value="{{ $status }}" {{ old('status', $insurance->status ?? '') === $status ? 'selected' : '' }}>
                    {{ ucfirst(strtolower($status)) }}
                </option>
            @endforeach
        </select>
        @error('status')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="insurance_file" class="col-md-3 col-form-label text-md-right font-weight-bold">Insurance File</label>
    <div class="col-md-9">
        <div class="custom-file">
            <input type="file" class="custom-file-input @error('insurance_file') is-invalid @enderror" id="insurance_file" name="insurance_file">
            <label class="custom-file-label" for="insurance_file">Choose file...</label>
            @error('insurance_file')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <small class="form-text text-muted mt-2">Upload document (PDF, JPG, PNG, max 5MB).</small>

        @if (!empty($insurance?->insurance_file))
            <div class="mt-2">
                <span class="text-muted small mr-2">Current file:</span>
                <a href="{{ asset('storage/' . $insurance->insurance_file) }}" target="_blank" class="btn btn-sm btn-info">
                    <i class="fas fa-file-alt mr-1"></i> {{ Str::afterLast($insurance->insurance_file, '_') }}
                </a>
                <input type="hidden" name="existing_insurance_file" value="{{ $insurance->insurance_file }}">
            </div>
        @endif
    </div>
</div>