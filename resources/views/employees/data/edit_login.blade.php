@extends('layouts.admin')

@section('title', 'Edit Login Account')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-user-lock fa-fw mr-2"></i>Edit Login: {{ $employee->full_name }}
    </h1>
    <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary btn-sm shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50 mr-1"></i> Back to Detail
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-circle mr-1"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    
    <div class="col-lg-8">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Account Credentials</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('employees.data.update_login', $employee->id) }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="font-weight-bold">Login Name</label>
                        <input type="text" name="name" id="name" 
                               class="form-control @error('name') is-invalid @enderror" 
                               value="{{ old('name', $user->name ?? '') }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email" class="font-weight-bold">Email Login</label>
                        <input type="email" name="email" id="email" 
                               class="form-control @error('email') is-invalid @enderror"
                               value="{{ old('email', $user->email ?? '') }}"
                               @if(!in_array(auth()->user()->role, ['superadmin', 'hc'])) readonly @endif required>
                        @if(!in_array(auth()->user()->role, ['superadmin', 'hc']))
                            <small class="form-text text-muted">Only Superadmin or HC can change the login email.</small>
                        @endif
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="role" class="font-weight-bold">Role</label>
                        <select name="role" id="role" class="form-control @error('role') is-invalid @enderror"
                                @if(!in_array(auth()->user()->role, ['superadmin', 'hc'])) disabled @endif required>
                            <option value="">-- Select Role --</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" {{ (isset($user) && $user->role === $role) ? 'selected' : '' }}>
                                    {{ ucfirst(str_replace('_', ' ', $role)) }}
                                </option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <div class="form-group">
                        <label for="password" class="font-weight-bold">New Password</label>
                        <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" autocomplete="new-password">
                        <small class="form-text text-muted">Leave blank if you do not wish to change the password.</small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="font-weight-bold">Confirm New Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" autocomplete="new-password">
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-secondary mr-2">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        @if (auth()->check() && in_array(auth()->user()->role, ['superadmin', 'hc']))
        <div class="card shadow mb-4 border-left-warning">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-warning">Reset Password</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <i class="fas fa-key fa-3x text-gray-300"></i>
                </div>
                <p class="small text-muted text-center mb-3">
                    Forgot password? This action will reset the user's password to their default <strong>NIP</strong>.
                </p>
                
                <form action="{{ route('employees.reset_password', $employee->id) }}" method="POST" id="resetPasswordForm">
                    @csrf
                    <button type="button" class="btn btn-warning btn-block font-weight-bold" id="resetPasswordBtn">
                        Initiate Reset
                    </button>

                    <div class="mt-3 p-3 bg-gray-100 rounded border" id="defaultPasswordText" style="display: none;">
                        <p class="mb-2 text-danger font-weight-bold text-center small">
                            Confirm Password Reset?
                        </p>
                        <div class="text-center small mb-3">
                            New Password: <strong>{{ $employee->nip }}</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-sm btn-secondary" id="cancelReset">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-danger">Yes, Reset</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif
    </div>

</div>

@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('resetPasswordBtn');
            const text = document.getElementById('defaultPasswordText');
            const cancelBtn = document.getElementById('cancelReset');

            if (btn && text && cancelBtn) {
                $(btn).on('click', function() {
                    $(text).slideDown();
                    $(this).hide();
                });

                $(cancelBtn).on('click', function() {
                    $(text).slideUp(function() {
                        $(btn).fadeIn();
                    });
                });
            }
        });
    </script>
@endpush