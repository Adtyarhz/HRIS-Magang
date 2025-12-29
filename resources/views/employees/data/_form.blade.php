<div class="row">
    <div class="col-lg-4 col-md-5 mb-4">
        <div class="card bg-light border-0">
            <div class="card-body text-center">
                <label class="font-weight-bold text-gray-700">Profile Picture</label>
                <div class="mb-3">
                    <img id="photo-preview"
                        src="{{ $employee->photo ? asset('storage/' . $employee->photo) : 'https://placehold.co/200x200/e2e8f0/a0aec0?text=No+Image' }}"
                        alt="Profile Picture" 
                        class="img-thumbnail rounded-circle shadow-sm"
                        style="width: 180px; height: 180px; object-fit: cover;">
                </div>
                
                <div class="custom-file text-left mb-3">
                    <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                    <label class="custom-file-label" for="photo">Choose file...</label>
                    @error('photo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <small class="text-muted d-block mb-4">Format: JPG, PNG, JPEG. Max: 2MB</small>

                <hr>

                <label class="font-weight-bold text-gray-700 mt-2">CV / Resume</label>
                <div class="custom-file text-left">
                    <input type="file" class="custom-file-input @error('cv_file') is-invalid @enderror" id="cv_file" name="cv_file" accept=".pdf,.doc,.docx">
                    <label class="custom-file-label" for="cv_file">Upload CV...</label>
                    @error('cv_file')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                @if ($employee->cv_file)
                    <div class="mt-2 text-left">
                        <a href="{{ asset('storage/' . $employee->cv_file) }}" target="_blank" class="btn btn-sm btn-info btn-block">
                            <i class="fas fa-file-download mr-1"></i> Download Current CV
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-8 col-md-7">
        <h6 class="heading-small text-muted mb-4">User Information</h6>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="full_name">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('full_name') is-invalid @enderror" id="full_name"
                        name="full_name" value="{{ old('full_name', $employee->full_name) }}" required>
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label">Gender <span class="text-danger">*</span></label>
                    <div class="mt-2">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="male" name="gender" class="custom-control-input" value="Laki-laki" 
                                {{ old('gender', $employee->gender) == 'Laki-laki' ? 'checked' : '' }} required>
                            <label class="custom-control-label" for="male">Laki-laki</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="female" name="gender" class="custom-control-input" value="Perempuan" 
                                {{ old('gender', $employee->gender) == 'Perempuan' ? 'checked' : '' }} required>
                            <label class="custom-control-label" for="female">Perempuan</label>
                        </div>
                    </div>
                    @error('gender')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="birth_place">Birth Place <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('birth_place') is-invalid @enderror"
                        name="birth_place" value="{{ old('birth_place', $employee->birth_place) }}" required>
                    @error('birth_place')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="birth_date">Birth Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                        name="birth_date" value="{{ old('birth_date', $employee->birth_date) }}" required>
                    @error('birth_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="religion">Religion <span class="text-danger">*</span></label>
                    <select class="form-control @error('religion') is-invalid @enderror" id="religion" name="religion" required>
                        <option value="">Select Religion</option>
                        @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha', 'Khonghucu'] as $rel)
                            <option value="{{ $rel }}" {{ old('religion', $employee->religion) == $rel ? 'selected' : '' }}>{{ $rel }}</option>
                        @endforeach
                    </select>
                    @error('religion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="marital_status">Marital Status <span class="text-danger">*</span></label>
                    <select class="form-control @error('marital_status') is-invalid @enderror" name="marital_status" required>
                        @foreach (['Lajang', 'Pernikahan Pertama', 'Pernikahan Kedua', 'Pernikahan Ketiga', 'Cerai Hidup', 'Cerai Mati'] as $status)
                            <option value="{{ $status }}" {{ old('marital_status', $employee->marital_status) == $status ? 'selected' : '' }}>
                                {{ $status }}
                            </option>
                        @endforeach
                    </select>
                    @error('marital_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="dependents">Dependents</label>
                    <input type="number" class="form-control @error('dependents') is-invalid @enderror"
                        name="dependents" value="{{ old('dependents', $employee->dependents ?? 0) }}" min="0">
                    @error('dependents')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="phone_number">Phone Number <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        </div>
                        <input type="tel" class="form-control @error('phone_number') is-invalid @enderror"
                            id="phone_number" name="phone_number" value="{{ old('phone_number', $employee->phone_number) }}" required>
                        @error('phone_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="email">Email (Personal) <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        </div>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $employee->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-4" />
        <h6 class="heading-small text-muted mb-4">Employment Information</h6>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="nik">NIK (KTP) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control @error('nik') is-invalid @enderror" id="nik"
                        name="nik" value="{{ old('nik', $employee->nik) }}" required>
                    @error('nik')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="nip">NIP (Employee ID)</label>
                    <input type="number" class="form-control @error('nip') is-invalid @enderror" id="nip"
                        name="nip" value="{{ old('nip', $employee->nip) }}">
                    @error('nip')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="npwp">NPWP</label>
                    <input type="number" class="form-control @error('npwp') is-invalid @enderror" id="npwp"
                        name="npwp" value="{{ old('npwp', $employee->npwp) }}">
                    @error('npwp')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="status">Status <span class="text-danger">*</span></label>
                    <select class="form-control @error('status') is-invalid @enderror" name="status" required>
                        <option value="Aktif" {{ old('status', $employee->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="Tidak Aktif" {{ old('status', $employee->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="employee_type">Employment Type <span class="text-danger">*</span></label>
                    <select class="form-control @error('employee_type') is-invalid @enderror" name="employee_type" required>
                        @foreach(['PKWT', 'PKWTT', 'Probation', 'Intern'] as $type)
                            <option value="{{ $type }}" {{ old('employee_type', $employee->employee_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                        @endforeach
                    </select>
                    @error('employee_type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="office">Office Location <span class="text-danger">*</span></label>
                    <select class="form-control @error('office') is-invalid @enderror" name="office" required>
                        <option value="Kantor Pusat" {{ old('office', $employee->office) == 'Kantor Pusat' ? 'selected' : '' }}>Kantor Pusat</option>
                        <option value="Kantor Cabang" {{ old('office', $employee->office) == 'Kantor Cabang' ? 'selected' : '' }}>Kantor Cabang</option>
                    </select>
                    @error('office')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="position_id">Position</label>
                    <select id="position_id" class="form-control @error('position_id') is-invalid @enderror" name="position_id">
                        <option value="">-- Select Position --</option>
                        @foreach ($positions as $position)
                            <option value="{{ $position->id }}"
                                data-division-id="{{ $position->division_id }}"
                                data-division="{{ $position->division->name ?? '-' }}"
                                {{ old('position_id', $employee->position_id) == $position->id ? 'selected' : '' }}>
                                {{ $position->title }}
                            </option>
                        @endforeach
                    </select>
                    @error('position_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label">Division</label>
                    <input type="text" id="division_name" class="form-control bg-light"
                        value="{{ $employee->division->name ?? '-' }}" readonly>
                    <input type="hidden" name="division_id" id="division_id" value="{{ $employee->division_id }}">
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="hire_date">Date of Entry <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('hire_date') is-invalid @enderror"
                        name="hire_date" value="{{ old('hire_date', $employee->hire_date) }}" required>
                    @error('hire_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label class="form-control-label" for="separation_date">Exit Date</label>
                    <input type="date" class="form-control @error('separation_date') is-invalid @enderror"
                        name="separation_date" value="{{ old('separation_date', $employee->separation_date) }}">
                    <small class="text-muted">Leave empty if currently active</small>
                    @error('separation_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Hidden Address Fields (Default values for Personal tab update) --}}
<input type="hidden" name="ktp_address" value="{{ $employee->ktp_address }}">
<input type="hidden" name="current_address" value="{{ $employee->current_address }}">

@push('js')
    <script>
        document.getElementById('position_id').addEventListener('change', function() {
            const selected = this.options[this.selectedIndex];
            const divisionName = selected.getAttribute('data-division') || '-';
            const divisionId = selected.getAttribute('data-division-id') || '';

            document.getElementById('division_name').value = divisionName;
            document.getElementById('division_id').value = divisionId;
        });

        $('.custom-file-input').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
            
            if(this.id == 'photo' && this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#photo-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    </script>
@endpush