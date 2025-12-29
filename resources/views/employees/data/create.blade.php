@extends('layouts.admin')

@section('title', 'Add New Employee Account')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-plus fa-fw mr-2"></i>Add New Employee Account
    </h1>
    <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to List
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(isset($offeringLetter) && $offeringLetter->offering_status === 'accepted')
    <div class="modal fade" id="offerConfirmModal" tabindex="-1" role="dialog" aria-labelledby="offerConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="offerConfirmModalLabel">Konfirmasi Penerimaan Penawaran</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to add this applicant data to employee data?</p>
                    <div class="mt-3 bg-light p-3 rounded">
                        <div class="d-flex mb-2 border-bottom pb-2">
                            <div style="width: 140px;" class="font-weight-bold">Nama Kandidat</div>
                            <div>: {{ $applicant->full_name ?? '-' }}</div>
                        </div>
                        <div class="d-flex mb-2 border-bottom pb-2">
                            <div style="width: 140px;" class="font-weight-bold">Posisi</div>
                            <div>: {{ $applicant->position->title ?? '-' }}</div>
                        </div>
                        <div class="d-flex mb-2">
                            <div style="width: 140px;" class="font-weight-bold">Jenis Kontrak</div>
                            <div>: {{ $offeringLetter->contract_type ?? '-' }}</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="{{ route('applicants.show', $applicant->id) }}" class="btn btn-secondary">Batal</a>
                    <button type="button" id="confirm-offer-btn" class="btn btn-primary">Konfirmasi & Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="card shadow mb-4" id="create-form-wrapper" style="{{ (isset($offeringLetter) && $offeringLetter->offering_status === 'accepted') ? 'display: none;' : '' }}">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Employee Registration Form</h6>
    </div>
    <div class="card-body">
        <form id="createForm" action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-lg-8">
                    <h6 class="heading-small text-muted mb-4">Personal & Contact Information</h6>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="full_name">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('full_name') is-invalid @enderror"
                                    id="full_name" name="full_name" placeholder="Enter full name"
                                    value="{{ old('full_name', $applicant->full_name ?? '') }}" required>
                                @error('full_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="nik">NIK <span class="text-danger">*</span></label>
                                <input type="number" class="form-control @error('nik') is-invalid @enderror"
                                    id="nik" name="nik" placeholder="16 digit NIK"
                                    value="{{ old('nik', $applicant->nik ?? '') }}" required>
                                @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label">Gender <span class="text-danger">*</span></label>
                                <div class="mt-2">
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="male" name="gender" class="custom-control-input" value="Laki-laki" 
                                            {{ old('gender', $applicant->gender ?? '') == 'Laki-laki' ? 'checked' : '' }} required>
                                        <label class="custom-control-label" for="male">Laki-laki</label>
                                    </div>
                                    <div class="custom-control custom-radio custom-control-inline">
                                        <input type="radio" id="female" name="gender" class="custom-control-input" value="Perempuan" 
                                            {{ old('gender', $applicant->gender ?? '') == 'Perempuan' ? 'checked' : '' }} required>
                                        <label class="custom-control-label" for="female">Perempuan</label>
                                    </div>
                                </div>
                                @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="religion">Religion <span class="text-danger">*</span></label>
                                <select class="form-control @error('religion') is-invalid @enderror" id="religion" name="religion" required>
                                    <option value="">Select Religion</option>
                                    @foreach (['Islam','Kristen','Katolik','Hindu','Buddha','Khonghucu'] as $religion)
                                        <option value="{{ $religion }}" {{ old('religion', $applicant->religion ?? '') == $religion ? 'selected' : '' }}>
                                            {{ $religion }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('religion') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="birth_place">Birth Place <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('birth_place') is-invalid @enderror"
                                    id="birth_place" name="birth_place" placeholder="City"
                                    value="{{ old('birth_place', $applicant->birth_place ?? '') }}" required>
                                @error('birth_place') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="birth_date">Birth Date <span class="text-danger">*</span></label>
                                <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                    id="birth_date" name="birth_date" value="{{ old('birth_date', $applicant->birth_date ?? '') }}" required>
                                @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
                                        id="phone_number" name="phone_number" value="{{ old('phone_number', $applicant->phone_number ?? $applicant->phone ?? '') }}"
                                        placeholder="+62..." required>
                                    @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="email">Email <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" name="email" placeholder="employee@example.com"
                                        value="{{ old('email', $applicant->email ?? '') }}" required>
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="marital_status">Marital Status <span class="text-danger">*</span></label>
                                <select class="form-control @error('marital_status') is-invalid @enderror" id="marital_status" name="marital_status" required>
                                    <option value="">Select Status</option>
                                    @foreach (['Lajang','Pernikahan Pertama','Pernikahan Kedua','Pernikahan Ketiga','Cerai Hidup','Cerai Mati'] as $status)
                                        <option value="{{ $status }}" {{ old('marital_status', $applicant->marital_status ?? '') == $status ? 'selected' : '' }}>
                                            {{ $status }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('marital_status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-control-label" for="dependents">Dependents</label>
                                <input type="number" class="form-control @error('dependents') is-invalid @enderror"
                                    id="dependents" name="dependents" placeholder="0" min="0"
                                    value="{{ old('dependents', $applicant->dependents ?? 0) }}">
                                @error('dependents') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                             <h6 class="heading-small text-muted mb-4">Address Information</h6>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label" for="ktp_address">ID Address (KTP) <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('ktp_address') is-invalid @enderror" id="ktp_address" name="ktp_address"
                                    rows="2" placeholder="Enter address as per ID card" required>{{ old('ktp_address', $applicant->ktp_address ?? '') }}</textarea>
                                @error('ktp_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label class="form-control-label" for="current_address">Current Address <span class="text-danger">*</span></label>
                                <textarea class="form-control @error('current_address') is-invalid @enderror" id="current_address"
                                    name="current_address" rows="2" placeholder="Enter current residential address" required>{{ old('current_address', $applicant->address ?? '') }}</textarea>
                                @error('current_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                     <h6 class="heading-small text-muted mb-4">Employment Details</h6>
                    
                    <div class="card bg-light border-0 mb-4">
                        <div class="card-body">
                            <div class="form-group text-center">
                                <label class="form-control-label mb-2">Profile Picture</label>
                                <div class="mb-3">
                                    <img id="photo-preview" src="{{ $applicant->photo_url ?? 'https://placehold.co/150x150/e2e8f0/a0aec0?text=No+Image' }}" 
                                         alt="Preview" class="img-thumbnail rounded-circle shadow-sm" style="width: 150px; height: 150px; object-fit: cover;">
                                </div>
                                <div class="custom-file text-left">
                                    <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" id="photo" name="photo" accept="image/*">
                                    <label class="custom-file-label" for="photo">Choose photo</label>
                                    @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            
                            <hr>

                            <div class="form-group">
                                <label class="form-control-label" for="cv_file">CV File</label>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('cv_file') is-invalid @enderror" id="cv_file" name="cv_file" accept=".pdf,.doc,.docx">
                                    <label class="custom-file-label" for="cv_file">Upload CV</label>
                                    @error('cv_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="nip">NIP (Employee ID)</label>
                        <input type="text" class="form-control @error('nip') is-invalid @enderror"
                            id="nip" name="nip" value="{{ old('nip') }}" placeholder="Auto or Input NIP">
                        @error('nip') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="npwp">NPWP</label>
                        <input type="text" class="form-control @error('npwp') is-invalid @enderror"
                            id="npwp" name="npwp" value="{{ old('npwp') }}" placeholder="Input NPWP">
                        @error('npwp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="hire_date">Date of Entry <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('hire_date') is-invalid @enderror" id="hire_date"
                            name="hire_date" value="{{ old('hire_date') }}" required>
                        @error('hire_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="separation_date">Exit Date</label>
                        <input type="date" class="form-control @error('separation_date') is-invalid @enderror" id="separation_date"
                            name="separation_date" value="{{ old('separation_date') }}">
                        @error('separation_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="status">Status <span class="text-danger">*</span></label>
                        <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="Tidak Aktif" {{ old('status') == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="employee_type">Employee Type <span class="text-danger">*</span></label>
                        <select class="form-control @error('employee_type') is-invalid @enderror" id="employee_type" name="employee_type" required>
                            <option value="">-- Select Type --</option>
                            @foreach(['PKWT', 'PKWTT', 'Probation', 'Intern'] as $type)
                                <option value="{{ $type }}" {{ old('employee_type', $employee->employee_type ?? '') == $type ? 'selected' : '' }}>{{ $type }}</option>
                            @endforeach
                        </select>
                        @error('employee_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="office">Office Location <span class="text-danger">*</span></label>
                        <select class="form-control @error('office') is-invalid @enderror" id="office" name="office" required>
                            <option value="">Select Office</option>
                            <option value="Kantor Pusat" {{ old('office') == 'Kantor Pusat' ? 'selected' : '' }}>Kantor Pusat</option>
                            <option value="Kantor Cabang" {{ old('office') == 'Kantor Cabang' ? 'selected' : '' }}>Kantor Cabang</option>
                        </select>
                        @error('office') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label" for="position_id">Position <span class="text-danger">*</span></label>
                        <select name="position_id" id="position_id" class="form-control @error('position_id') is-invalid @enderror" required>
                            <option value="">-- Select Position --</option>
                            @foreach ($positions as $pos)
                                <option value="{{ $pos->id }}"
                                    data-division-id="{{ $pos->division_id }}"
                                    data-division="{{ $pos->division->name ?? '-' }}"
                                    {{ old('position_id', $applicant->applied_position ?? '') == $pos->id ? 'selected' : '' }}>
                                    {{ $pos->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('position_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-control-label">Division</label>
                        <input type="text" id="division_name" class="form-control bg-light"
                            value="{{ old('division_name', $applicant->division->name ?? '-') }}" readonly>
                        <input type="hidden" name="division_id" id="division_id"
                            value="{{ old('division_id', $applicant->division_id ?? '') }}">
                    </div>

                </div>
            </div>

            <hr class="mt-4">
            <div class="row">
                <div class="col-12 text-right">
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary mr-2">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save mr-1"></i> Create Employee
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('js')
<script>
    $(document).ready(function() {
        var offerModal = $('#offerConfirmModal');
        var formWrapper = $('#create-form-wrapper');

        // Check if modal exists
        if (offerModal.length > 0) {
            offerModal.modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });

            $('#confirm-offer-btn').on('click', function() {
                offerModal.modal('hide');
                formWrapper.show();
                $('html, body').animate({ scrollTop: 0 }, 'fast');
            });
        } else {
            formWrapper.show();
        }

        // Photo Preview
        $('#photo').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);

            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#photo-preview').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // CV File Name
        $('#cv_file').on('change', function() {
            let fileName = $(this).val().split('\\').pop();
            $(this).next('.custom-file-label').addClass("selected").html(fileName);
        });

        // Auto-fill Division
        $('#position_id').on('change', function() {
            var selected = $(this).find('option:selected');
            var divisionName = selected.data('division') || '-';
            var divisionId = selected.data('division-id') || '';

            $('#division_name').val(divisionName);
            $('#division_id').val(divisionId);
        });

        // Trigger change on load if position is already selected (e.g. after validation error)
        if ($('#position_id').val()) {
            $('#position_id').trigger('change');
        }

        // Prevent double submit
        $('#createForm').on('submit', function() {
            var btn = $(this).find('button[type="submit"]');
            btn.prop('disabled', true);
            btn.html('<i class="fas fa-spinner fa-spin mr-1"></i> Creating...');
        });
    });
</script>
@endpush