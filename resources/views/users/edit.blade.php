@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Edit User</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.show', \App\Services\EncryptionService::encryptId($user->id)) }}">{{ $user->name }}</a></li>
                    <li class="breadcrumb-item" aria-current="page">Edit</li>
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
                <h5>Edit User Information</h5>
                <p class="text-muted mb-0">Update the user's information and permissions.</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('users.update', \App\Services\EncryptionService::encryptId($user->id)) }}">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">New Password</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Leave blank to keep current password. Password must be at least 8 characters long.</small>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>

                    <div class="form-group">
                        <label for="roles" class="form-label">Roles</label>
                        <select class="form-select @error('roles') is-invalid @enderror" id="roles" name="roles[]" multiple>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" {{ in_array($role->id, old('roles', $user->roles->pluck('id')->toArray())) ? 'selected' : '' }}>
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
                        <input class="form-check-input" type="checkbox" id="email_verified" name="email_verified" value="1" {{ old('email_verified', $user->email_verified_at ? '1' : '') ? 'checked' : '' }}>
                        <label class="form-check-label" for="email_verified">
                            Mark email as verified
                        </label>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('users.show', \App\Services\EncryptionService::encryptId($user->id)) }}" class="btn btn-secondary">
                            <i class="ti ti-x me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i>Update User
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5>Current User Info</h5>
            </div>
            <div class="card-body text-center">
                <div class="avatar rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" style="width:48px; height:48px; font-size:1.5rem; font-weight:600; margin:0 auto 1rem auto;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-3">{{ $user->email }}</p>
                
                <div class="row text-center">
                    <div class="col-6">
                        <h6 class="mb-1">{{ $user->roles->count() }}</h6>
                        <small class="text-muted">Current Roles</small>
                    </div>
                    <div class="col-6">
                        <h6 class="mb-1">{{ $user->permissions->count() }}</h6>
                        <small class="text-muted">Permissions</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Current Roles</h5>
            </div>
            <div class="card-body">
                @if($user->roles->count() > 0)
                    @foreach($user->roles as $role)
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
                        <p class="text-muted mb-0 mt-2">No roles assigned</p>
                    </div>
                @endif
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

        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('users.show', \App\Services\EncryptionService::encryptId($user->id)) }}" class="btn btn-outline-primary">
                        <i class="ti ti-eye me-2"></i>View User
                    </a>
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-2"></i>Back to Users
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
@endsection 