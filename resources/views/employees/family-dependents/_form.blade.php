<div class="form-group row">
    <label for="contact_name" class="col-md-3 col-form-label text-md-right font-weight-bold">Contact Person Name <span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" class="form-control @error('contact_name') is-invalid @enderror" 
            id="contact_name" name="contact_name" 
            value="{{ old('contact_name', $familyDependent->contact_name ?? '') }}" 
            placeholder="Input contact person name" required>
        @error('contact_name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="relationship" class="col-md-3 col-form-label text-md-right font-weight-bold">Relationship <span class="text-danger">*</span></label>
    <div class="col-md-9">
        <input type="text" class="form-control @error('relationship') is-invalid @enderror" 
            id="relationship" name="relationship" 
            value="{{ old('relationship', $familyDependent->relationship ?? '') }}" 
            placeholder="e.g., Spouse, Child, Parent" required>
        @error('relationship')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="phone_number" class="col-md-3 col-form-label text-md-right font-weight-bold">Phone Number <span class="text-danger">*</span></label>
    <div class="col-md-9">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text"><i class="fas fa-phone"></i></span>
            </div>
            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" 
                id="phone_number" name="phone_number" 
                value="{{ old('phone_number', $familyDependent->phone_number ?? '') }}" 
                placeholder="Input phone number" inputmode="tel" maxlength="20" required>
            @error('phone_number')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="address" class="col-md-3 col-form-label text-md-right font-weight-bold">Address <span class="text-danger">*</span></label>
    <div class="col-md-9">
        <textarea class="form-control @error('address') is-invalid @enderror" 
            id="address" name="address" rows="3" 
            placeholder="Enter full address" required>{{ old('address', $familyDependent->address ?? '') }}</textarea>
        @error('address')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="city" class="col-md-3 col-form-label text-md-right font-weight-bold">City <span class="text-danger">*</span></label>
    <div class="col-md-4">
        <input type="text" class="form-control @error('city') is-invalid @enderror" 
            id="city" name="city" 
            value="{{ old('city', $familyDependent->city ?? '') }}" 
            placeholder="Enter city" required>
        @error('city')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>

<div class="form-group row">
    <label for="province" class="col-md-3 col-form-label text-md-right font-weight-bold">Province <span class="text-danger">*</span></label>
    <div class="col-md-4">
        <input type="text" class="form-control @error('province') is-invalid @enderror" 
            id="province" name="province" 
            value="{{ old('province', $familyDependent->province ?? '') }}" 
            placeholder="Enter province" required>
        @error('province')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>