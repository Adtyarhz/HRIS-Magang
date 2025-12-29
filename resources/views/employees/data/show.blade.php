@extends('layouts.admin')

@section('title', 'Detail Karyawan')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-tie fa-fw mr-2"></i>Detail Employee: {{ $employee->full_name }}
    </h1>
    
    <div class="d-flex">
        @if(in_array(Auth::user()->role, ['superadmin','hc']))
            <a href="{{ route('employees.index') }}" class="btn btn-secondary btn-sm shadow-sm mr-2">
                <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back
            </a>
            
            <a href="{{ route('employees.deactivate.form', $employee) }}" class="btn btn-danger btn-sm shadow-sm mr-2">
                <i class="fas fa-ban fa-sm text-white-50 mr-1"></i> Deactivate
            </a>
        @endif

        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-primary btn-sm shadow-sm mr-2">
            <i class="fas fa-edit fa-sm text-white-50 mr-1"></i> Edit Data
        </a>
        
        <a href="{{ route('employees.data.edit_login', $employee->id) }}" class="btn btn-info btn-sm shadow-sm">
            <i class="fas fa-user-cog fa-sm text-white-50 mr-1"></i> Edit Login
        </a>
    </div>
</div>

<div class="row">

    <div class="col-lg-6">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-briefcase mr-2"></i>Employment Data</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm m-0">
                    <tr>
                        <th style="width: 40%">Status</th>
                        <td>
                            @if ($employee->status == 'Aktif')
                                <span class="badge badge-success px-2">Active</span>
                            @else
                                <span class="badge badge-secondary px-2">Inactive</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td>{{ $employee->employee_type }}</td>
                    </tr>
                    <tr>
                        <th>Division</th>
                        <td>{{ $employee->division->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Position</th>
                        <td>{{ $employee->position->title ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Office</th>
                        <td>{{ $employee->office }}</td>
                    </tr>
                    <tr>
                        <th>Date of Entry</th>
                        <td>{{ $employee->hire_date ? \Carbon\Carbon::parse($employee->hire_date)->format('d F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>Exit Date</th>
                        <td>{{ $employee->separation_date ? \Carbon\Carbon::parse($employee->separation_date)->format('d F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <th>CV File</th>
                        <td>
                            @if ($employee->cv_file)
                                <a href="{{ asset('storage/' . $employee->cv_file) }}" target="_blank" class="btn btn-sm btn-light border">
                                    <i class="fas fa-file-pdf text-danger mr-1"></i> View CV
                                </a>
                            @else
                                <span class="text-muted small">Not uploaded</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-lock mr-2"></i>Login Account Data</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm m-0">
                    <tr>
                        <th style="width: 40%">Username</th>
                        <td>{{ $employee->user->name ?? 'Not Connected' }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $employee->user->email ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Role</th>
                        <td><span class="badge badge-info">{{ $employee->user->role ?? '-' }}</span></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>

    <div class="col-lg-6">

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-id-card mr-2"></i>Personal Data</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <img class="img-profile rounded-circle border shadow-sm" 
                         style="width: 120px; height: 120px; object-fit: cover;"
                         src="{{ $employee->photo ? asset('storage/' . $employee->photo) : 'https://placehold.co/120x120/4e73df/ffffff?text=' . strtoupper(substr($employee->full_name, 0, 1)) }}">
                </div>
                <table class="table table-borderless table-sm">
                    <tr>
                        <th style="width: 40%">Full Name</th>
                        <td class="font-weight-bold text-gray-800">{{ $employee->full_name }}</td>
                    </tr>
                    <tr>
                        <th>NIK</th>
                        <td>{{ $employee->nik }}</td>
                    </tr>
                    <tr>
                        <th>NIP</th>
                        <td>{{ $employee->nip ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>NPWP</th>
                        <td>{{ $employee->npwp ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td>{{ $employee->gender }}</td>
                    </tr>
                    <tr>
                        <th>Religion</th>
                        <td>{{ $employee->religion }}</td>
                    </tr>
                    <tr>
                        <th>Birth Info</th>
                        <td>{{ $employee->birth_place }}, {{ $employee->birth_date ? \Carbon\Carbon::parse($employee->birth_date)->format('d F Y') : '' }}</td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td>{{ $age ? $age . ' Years' : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Marital Status</th>
                        <td>
                            {{ $employee->marital_status }}
                            <small class="text-muted d-block">
                                @if ($employee->marital_status !== 'Lajang')
                                    ({{ $employee->dependents == 0 ? 'No dependents' : $employee->dependents . ' Dependents' }})
                                @endif
                            </small>
                        </td>
                    </tr>
                    <tr>
                        <th>KTP Address</th>
                        <td>{{ $employee->ktp_address }}</td>
                    </tr>
                    <tr>
                        <th>Domicile</th>
                        <td>{{ $employee->current_address }}</td>
                    </tr>
                    <tr>
                        <th>Email (Personal)</th>
                        <td>{{ $employee->email }}</td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td>{{ $employee->phone_number }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-12">

        <div class="card shadow mb-4">
            <a href="#healthCollapse" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="healthCollapse">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-heartbeat mr-2"></i>Health History</h6>
            </a>
            <div class="collapse" id="healthCollapse">
                <div class="card-body">
                    @if ($healthRecord)
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr><th width="40%">Height</th><td>{{ $healthRecord->height ?? '-' }} cm</td></tr>
                                    <tr><th>Weight</th><td>{{ $healthRecord->weight ?? '-' }} kg</td></tr>
                                    <tr><th>Blood Type</th><td>{{ $healthRecord->blood_type ?? '-' }}</td></tr>
                                    <tr><th>Allergies</th><td>{{ $healthRecord->known_allergies ?? '-' }}</td></tr>
                                    <tr><th>Chronic Diseases</th><td>{{ $healthRecord->chronic_diseases ?? '-' }}</td></tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr><th width="40%">Last Checkup</th><td>{{ $healthRecord->last_checkup_date ? \Carbon\Carbon::parse($healthRecord->last_checkup_date)->format('d F Y') : '-' }}</td></tr>
                                    <tr><th>Location</th><td>{{ $healthRecord->checkup_loc ?? '-' }}</td></tr>
                                    <tr><th>Price</th><td>{{ $healthRecord->price_last_checkup ? 'Rp ' . number_format($healthRecord->price_last_checkup, 0, ',', '.') : '-' }}</td></tr>
                                    <tr><th>Notes</th><td>{{ $healthRecord->notes ?? '-' }}</td></tr>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-3 text-muted">No health history data available.</div>
                    @endif
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <a href="#eduCollapse" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="eduCollapse">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-graduate mr-2"></i>Education History</h6>
            </a>
            <div class="collapse" id="eduCollapse">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Level</th>
                                    <th>Institution</th>
                                    <th>Major</th>
                                    <th>Year</th>
                                    <th>GPA</th>
                                    <th>Certificate</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($educationHistories as $edu)
                                    <tr>
                                        <td>{{ $edu->education_level }}</td>
                                        <td>
                                            <div class="font-weight-bold">{{ $edu->institution_name }}</div>
                                            <small>{{ $edu->institution_address }}</small>
                                        </td>
                                        <td>{{ $edu->major }}</td>
                                        <td>{{ $edu->start_year }} - {{ $edu->end_year }}</td>
                                        <td>{{ $edu->gpa_or_score }}</td>
                                        <td>{{ $edu->certificate_number ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted">No education data available.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <a href="#familyCollapse" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="familyCollapse">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-users mr-2"></i>Family & Dependents</h6>
            </a>
            <div class="collapse" id="familyCollapse">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Relationship</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dependents as $fam)
                                    <tr>
                                        <td>{{ $fam->contact_name }}</td>
                                        <td><span class="badge badge-info">{{ $fam->relationship }}</span></td>
                                        <td>{{ $fam->phone_number }}</td>
                                        <td>{{ $fam->address }}, {{ $fam->city }}, {{ $fam->province }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="text-center text-muted">No family data available.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <a href="#workCollapse" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="workCollapse">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-briefcase mr-2"></i>Work Experience</h6>
            </a>
            <div class="collapse" id="workCollapse">
                <div class="card-body">
                     @forelse ($workExperiences as $work)
                        <div class="border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between">
                                <h5 class="font-weight-bold text-gray-800">{{ $work->company_name }}</h5>
                                <small class="text-muted">{{ $work->start_date ? \Carbon\Carbon::parse($work->start_date)->format('M Y') : '' }} - {{ $work->end_date ? \Carbon\Carbon::parse($work->end_date)->format('M Y') : 'Present' }}</small>
                            </div>
                            <div class="mb-2">
                                <span class="badge badge-primary">{{ $work->position_title }}</span>
                                <span class="text-muted small ml-2"><i class="fas fa-map-marker-alt"></i> {{ $work->company_address }}</span>
                            </div>
                            <p class="mb-1 small"><strong>Responsibilities:</strong> {{ $work->responsibilities }}</p>
                            
                            <div class="mt-2">
                                @if ($work->reference_letter_file)
                                    <a href="{{ asset('storage/' . $work->reference_letter_file) }}" target="_blank" class="btn btn-sm btn-outline-secondary mr-1">
                                        <i class="fas fa-file-alt"></i> Reference Letter
                                    </a>
                                @endif
                                @if ($work->salary_slip_file)
                                    <a href="{{ asset('storage/' . $work->salary_slip_file) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-file-invoice-dollar"></i> Salary Slip
                                    </a>
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No work experience available.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <a href="#trainingCollapse" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="trainingCollapse">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-chalkboard-teacher mr-2"></i>Training History</h6>
            </a>
            <div class="collapse" id="trainingCollapse">
                <div class="card-body">
                    @forelse ($employee->trainingHistories()->with('trainingMaterials')->latest()->get() as $training)
                        <div class="border-left-primary pl-3 mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <h5 class="font-weight-bold text-primary mb-0">{{ $training->training_name }}</h5>
                                <span class="small text-gray-500">
                                    {{ $training->start_date ? \Carbon\Carbon::parse($training->start_date)->format('d M Y') : '' }} - 
                                    {{ $training->end_date ? \Carbon\Carbon::parse($training->end_date)->format('d M Y') : '' }}
                                </span>
                            </div>
                            <div class="text-muted mb-2">
                                <strong>Provider:</strong> {{ $training->provider }} | 
                                <strong>Location:</strong> {{ $training->location }} |
                                <strong>Cost:</strong> {{ $training->cost ? 'Rp ' . number_format($training->cost, 0, ',', '.') : '-' }}
                            </div>
                            <p class="small mb-2">{{ $training->description }}</p>
                            
                            <div class="d-flex flex-wrap gap-2">
                                @if ($training->certificate_file)
                                    <a href="{{ asset('storage/' . $training->certificate_file) }}" target="_blank" class="btn btn-sm btn-success mr-2 mb-1">
                                        <i class="fas fa-certificate"></i> Certificate
                                    </a>
                                @endif
                                
                                @if ($training->trainingMaterials && $training->trainingMaterials->count())
                                    @foreach ($training->trainingMaterials as $matIndex => $material)
                                        <a href="{{ asset('storage/' . $material->file_path) }}" target="_blank" class="btn btn-sm btn-info mr-2 mb-1">
                                            <i class="fas fa-file-download"></i> Material {{ $matIndex + 1 }}
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No training history available.</p>
                    @endforelse
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <a href="#certCollapse" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="certCollapse">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-certificate mr-2"></i>Certifications</h6>
            </a>
            <div class="collapse" id="certCollapse">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Issuer</th>
                                    <th>Date Obtained</th>
                                    <th>Expiry</th>
                                    <th>Files</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($employee->certifications as $cert)
                                    <tr>
                                        <td>{{ $cert->certification_name }}</td>
                                        <td>{{ $cert->issuer }}</td>
                                        <td>{{ $cert->date_obtained ? \Carbon\Carbon::parse($cert->date_obtained)->format('d M Y') : '-' }}</td>
                                        <td>
                                            @if($cert->expiry_date)
                                                {{ \Carbon\Carbon::parse($cert->expiry_date)->format('d M Y') }}
                                            @else
                                                <span class="badge badge-success">No Expiry</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($cert->certificate_file)
                                                <a href="{{ asset('storage/' . $cert->certificate_file) }}" target="_blank" class="text-decoration-none">
                                                    <i class="fas fa-file-alt"></i> View
                                                </a>
                                            @else
                                                -
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted">No certifications recorded.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
             <a href="#insuranceCollapse" class="d-block card-header py-3 collapsed" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="insuranceCollapse">
                <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-file-medical-alt mr-2"></i>Insurance</h6>
            </a>
            <div class="collapse" id="insuranceCollapse">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Number</th>
                                    <th>Type</th>
                                    <th>Faskes</th>
                                    <th>Validity</th>
                                    <th>File</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($insurances as $ins)
                                    <tr>
                                        <td class="font-weight-bold">{{ $ins->insurance_number }}</td>
                                        <td>{{ $ins->insurance_type }}</td>
                                        <td>
                                            {{ $ins->faskes_name }}<br>
                                            <small class="text-muted">{{ $ins->faskes_address }}</small>
                                        </td>
                                        <td>
                                            {{ $ins->start_date ? \Carbon\Carbon::parse($ins->start_date)->format('d/m/y') : '...' }} - 
                                            {{ $ins->expiry_date ? \Carbon\Carbon::parse($ins->expiry_date)->format('d/m/y') : '...' }}
                                        </td>
                                        <td>
                                            @if($ins->insurance_file)
                                                <a href="{{ asset('storage/' . $ins->insurance_file) }}" target="_blank">
                                                    <i class="fas fa-file-contract"></i>
                                                </a>
                                            @else - @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="5" class="text-center text-muted">No insurance data found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function(){
        if(window.location.hash){
            $(window.location.hash).collapse('show');
        }
    });
</script>
@endpush