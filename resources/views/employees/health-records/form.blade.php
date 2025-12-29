@extends('layouts.admin')

@section('title', 'Health Record')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-heartbeat fa-fw mr-2"></i>Health Record
    </h1>
    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Detail
    </a>
</div>

@include('employees.partials.tab-menu', ['employee' => $employee])

<div class="card shadow mb-4 border-top-0" style="border-top-left-radius: 0; border-top-right-radius: 0;">
    <div class="card-body">
        <form action="{{ route('health-records.storeOrUpdate', $employee->id) }}" method="POST" id="healthForm">
            @csrf

            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <h6 class="heading-small text-muted mb-4">Physical Attributes</h6>

                    <div class="form-group row">
                        <label for="height" class="col-md-3 col-form-label text-md-right font-weight-bold">Height <span class="text-danger">*</span></label>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control @error('height') is-invalid @enderror" 
                                    id="height" name="height" 
                                    value="{{ old('height', $healthRecord->height ?? '') }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">cm</span>
                                </div>
                            </div>
                            @error('height')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="weight" class="col-md-3 col-form-label text-md-right font-weight-bold">Weight <span class="text-danger">*</span></label>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="number" step="0.01" class="form-control @error('weight') is-invalid @enderror" 
                                    id="weight" name="weight" 
                                    value="{{ old('weight', $healthRecord->weight ?? '') }}" required>
                                <div class="input-group-append">
                                    <span class="input-group-text">kg</span>
                                </div>
                            </div>
                            @error('weight')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="blood_type" class="col-md-3 col-form-label text-md-right font-weight-bold">Blood Type <span class="text-danger">*</span></label>
                        <div class="col-md-3">
                            <select class="form-control @error('blood_type') is-invalid @enderror" id="blood_type" name="blood_type" required>
                                <option value="">Select Type</option>
                                @foreach (['A', 'B', 'AB', 'O', 'Tidak Tahu'] as $type)
                                    <option value="{{ $type }}" {{ old('blood_type', $healthRecord->blood_type ?? '') == $type ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                            @error('blood_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    <h6 class="heading-small text-muted mb-4">Medical History</h6>

                    <div class="form-group row">
                        <label for="known_allergies" class="col-md-3 col-form-label text-md-right font-weight-bold">Allergies <span class="text-danger">*</span></label>
                        <div class="col-md-7">
                            <textarea class="form-control @error('known_allergies') is-invalid @enderror" 
                                id="known_allergies" name="known_allergies" rows="3" 
                                placeholder="List any allergies..." required>{{ old('known_allergies', $healthRecord->known_allergies ?? '') }}</textarea>
                            @error('known_allergies')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="chronic_diseases" class="col-md-3 col-form-label text-md-right font-weight-bold">Chronic Diseases <span class="text-danger">*</span></label>
                        <div class="col-md-7">
                            <textarea class="form-control @error('chronic_diseases') is-invalid @enderror" 
                                id="chronic_diseases" name="chronic_diseases" rows="3" 
                                placeholder="List chronic diseases..." required>{{ old('chronic_diseases', $healthRecord->chronic_diseases ?? '') }}</textarea>
                            @error('chronic_diseases')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    <h6 class="heading-small text-muted mb-4">Last Checkup Details</h6>

                    <div class="form-group row">
                        <label for="last_checkup_date" class="col-md-3 col-form-label text-md-right font-weight-bold">Date <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <input type="date" class="form-control @error('last_checkup_date') is-invalid @enderror" 
                                id="last_checkup_date" name="last_checkup_date" 
                                value="{{ old('last_checkup_date', isset($healthRecord) && $healthRecord->last_checkup_date ? \Carbon\Carbon::parse($healthRecord->last_checkup_date)->format('Y-m-d') : '') }}" required>
                            @error('last_checkup_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="price_last_checkup" class="col-md-3 col-form-label text-md-right font-weight-bold">Cost <span class="text-danger">*</span></label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp</span>
                                </div>
                                <input type="text" class="form-control" id="price_last_checkup_display" placeholder="0" required>
                                <input type="hidden" name="price_last_checkup" id="price_last_checkup" 
                                    value="{{ old('price_last_checkup', $healthRecord?->price_last_checkup) }}">
                            </div>
                            @error('price_last_checkup')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="checkup_loc" class="col-md-3 col-form-label text-md-right font-weight-bold">Location <span class="text-danger">*</span></label>
                        <div class="col-md-7">
                            <textarea class="form-control @error('checkup_loc') is-invalid @enderror" 
                                id="checkup_loc" name="checkup_loc" rows="2" required>{{ old('checkup_loc', $healthRecord->checkup_loc ?? '') }}</textarea>
                            @error('checkup_loc')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="notes" class="col-md-3 col-form-label text-md-right font-weight-bold">Notes</label>
                        <div class="col-md-7">
                            <textarea class="form-control @error('notes') is-invalid @enderror" 
                                id="notes" name="notes" rows="3">{{ old('notes', $healthRecord->notes ?? '') }}</textarea>
                            @error('notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="mt-5">
                    <div class="row">
                        <div class="col-12 text-right">
                            <a href="{{ route('employees.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                            <button type="submit" class="btn btn-primary px-4">Save Health Record</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/cleave.js@1.6.0/dist/cleave.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Price Formatting
            const formattedInput = document.getElementById('price_last_checkup_display');
            const rawInput = document.getElementById('price_last_checkup');

            if (formattedInput && rawInput) {
                const cleave = new Cleave(formattedInput, {
                    numeral: true,
                    numeralThousandsGroupStyle: 'thousand',
                    numeralDecimalMark: ',',
                    delimiter: '.',
                    numeralDecimalScale: 2,
                    rawValueTrimPrefix: true,
                });

                // Set initial value
                if (rawInput.value) {
                    cleave.setRawValue(rawInput.value);
                }

                formattedInput.addEventListener('input', function() {
                    rawInput.value = cleave.getRawValue();
                });
            }

            // Prevent Double Submit
            document.getElementById('healthForm').addEventListener('submit', function (e) {
                const submitButton = this.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Saving...';
                }
            });
        });
    </script>
@endpush