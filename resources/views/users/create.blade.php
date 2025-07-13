@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Create New User</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item" aria-current="page">Create</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5>User Information</h5>
                <p class="text-muted mb-0">Fill in the information below to create a new user account.</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">Password must be at least 8 characters long.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="roles" class="form-label">Roles</label>
                        <select class="form-select @error('roles') is-invalid @enderror" id="roles" name="roles[]" multiple>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', [])) ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('roles')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Hold Ctrl (or Cmd on Mac) to select multiple roles.</small>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="email_verified" name="email_verified" value="1" {{ old('email_verified') ? 'checked' : '' }}>
                        <label class="form-check-label" for="email_verified">
                            Mark email as verified
                        </label>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">
                            <i class="ti ti-x me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-user-plus me-1"></i>Create User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5>Form Guidelines</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <h6 class="text-primary">Required Fields</h6>
                    <ul class="list-unstyled mb-0">
                        <li><i class="ti ti-check text-success me-2"></i>Name</li>
                        <li><i class="ti ti-check text-success me-2"></i>Email</li>
                        <li><i class="ti ti-check text-success me-2"></i>Password</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary">Password Requirements</h6>
                    <ul class="list-unstyled mb-0">
                        <li><i class="ti ti-check text-success me-2"></i>Minimum 8 characters</li>
                        <li><i class="ti ti-check text-success me-2"></i>At least one letter</li>
                        <li><i class="ti ti-check text-success me-2"></i>At least one number</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary">Email Verification</h6>
                    <p class="text-muted mb-0">If you check "Mark email as verified", the user won't need to verify their email address.</p>
                </div>

                <div>
                    <h6 class="text-primary">Roles Assignment</h6>
                    <p class="text-muted mb-0">Assign appropriate roles to control user access and permissions in the system.</p>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Available Roles</h5>
            </div>
            <div class="card-body">
                @if($roles->count() > 0)
                    @foreach($roles as $role)
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar rounded-circle d-flex align-items-center justify-content-center bg-success text-white" style="width:32px; height:32px; font-size:1rem; font-weight:600;">
                                {{ strtoupper(substr($role->name, 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="mb-0">{{ $role->name }}</h6>
                                <small class="text-muted">{{ $role->permissions->count() }} permissions</small>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="ti ti-user-tag text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0 mt-2">No roles available</p>
                        @can('create roles')
                        <a href="{{ route('roles.create') }}" class="btn btn-sm btn-primary mt-2">
                            <i class="ti ti-plus me-1"></i>Create Role
                        </a>
                        @endcan
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
@endsection 