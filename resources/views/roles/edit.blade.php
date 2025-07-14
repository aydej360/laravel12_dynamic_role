@extends('layouts.app')

@section('title', 'Edit Role')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Edit Role</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.show', \App\Services\EncryptionService::encryptId($role->id)) }}">{{ $role->name }}</a></li>
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
                <h5>Edit Role Information</h5>
                <p class="text-muted mb-0">Update the role's information and permissions.</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('roles.update', \App\Services\EncryptionService::encryptId($role->id)) }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $role->name) }}" required autofocus>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Use descriptive names like "Admin", "Moderator", "Editor", etc.</small>
                    </div>

                    <div class="form-group">
                        <label for="permissions" class="form-label">Permissions</label>
                        <div class="row">
                            @foreach($permissions->groupBy(function($permission) {
                                return explode(' ', $permission->name)[0];
                            }) as $group => $groupPermissions)
                                <div class="col-md-6 mb-3">
                                    <div class="card border">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0 text-capitalize">{{ $group }}</h6>
                                        </div>
                                        <div class="card-body">
                                            @foreach($groupPermissions as $permission)
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" 
                                                           name="permissions[]" value="{{ $permission->id }}" 
                                                           id="permission_{{ $permission->id }}"
                                                           {{ in_array($permission->id, old('permissions', $role->permissions->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="permission_{{ $permission->id }}">
                                                        {{ ucwords(str_replace('_', ' ', $permission->name)) }}
                                                    </label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @error('permissions')
                            <div class="text-danger small">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('roles.show', \App\Services\EncryptionService::encryptId($role->id)) }}" class="btn btn-secondary">
                            <i class="ti ti-x me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i>Update Role
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5>Current Role Info</h5>
            </div>
            <div class="card-body text-center">
                <div class="avatar rounded-circle d-flex align-items-center justify-content-center bg-success text-white" style="width:48px; height:48px; font-size:1.5rem; font-weight:600; margin:0 auto 1rem auto;">
                    {{ strtoupper(substr($role->name, 0, 1)) }}
                </div>
                <h5 class="mb-1">{{ $role->name }}</h5>
                <p class="text-muted mb-3">System Role</p>
                
                <div class="row text-center">
                    <div class="col-6">
                        <h6 class="mb-1">{{ $role->permissions->count() }}</h6>
                        <small class="text-muted">Permissions</small>
                    </div>
                    <div class="col-6">
                        <h6 class="mb-1">{{ $role->users_count ?? 0 }}</h6>
                        <small class="text-muted">Users</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Current Permissions</h5>
            </div>
            <div class="card-body">
                @if($role->permissions->count() > 0)
                    @foreach($role->permissions->groupBy(function($permission) {
                        return explode(' ', $permission->name)[0];
                    }) as $group => $groupPermissions)
                        <div class="mb-3">
                            <h6 class="text-capitalize text-primary mb-2">{{ $group }}</h6>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($groupPermissions as $permission)
                                    <span class="badge bg-light-secondary text-secondary">{{ ucwords(str_replace('_', ' ', $permission->name)) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="ti ti-shield text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0 mt-2">No permissions assigned</p>
                    </div>
                @endif
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Available Permissions</h5>
            </div>
            <div class="card-body">
                @if($permissions->count() > 0)
                    <div class="mb-2">
                        <small class="text-muted">Total: {{ $permissions->count() }} permissions</small>
                    </div>
                    @foreach($permissions->groupBy(function($permission) {
                        return explode(' ', $permission->name)[0];
                    }) as $group => $groupPermissions)
                        <div class="mb-3">
                            <h6 class="text-capitalize text-primary mb-2">{{ $group }}</h6>
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($groupPermissions as $permission)
                                    <span class="badge bg-light-secondary text-secondary">{{ ucwords(str_replace('_', ' ', $permission->name)) }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-3">
                        <i class="ti ti-shield text-muted" style="font-size: 2rem;"></i>
                        <p class="text-muted mb-0 mt-2">No permissions available</p>
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
                    <a href="{{ route('roles.show', \App\Services\EncryptionService::encryptId($role->id)) }}" class="btn btn-outline-primary">
                        <i class="ti ti-eye me-2"></i>View Role
                    </a>
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-2"></i>Back to Roles
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
@endsection 