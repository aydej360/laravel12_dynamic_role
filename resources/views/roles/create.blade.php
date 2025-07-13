@extends('layouts.app')

@section('title', 'Create Role')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Create New Role</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
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
                <h5>Role Information</h5>
                <p class="text-muted mb-0">Fill in the information below to create a new role with specific permissions.</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('roles.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="name" class="form-label">Role Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required autofocus>
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
                                                           {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
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
                        <a href="{{ route('roles.index') }}" class="btn btn-secondary">
                            <i class="ti ti-x me-1"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-user-tag me-1"></i>Create Role
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
                    <h6 class="text-primary">Role Naming</h6>
                    <ul class="list-unstyled mb-0">
                        <li><i class="ti ti-check text-success me-2"></i>Use clear, descriptive names</li>
                        <li><i class="ti ti-check text-success me-2"></i>Avoid special characters</li>
                        <li><i class="ti ti-check text-success me-2"></i>Use title case (Admin, Editor)</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary">Permission Groups</h6>
                    <ul class="list-unstyled mb-0">
                        <li><i class="ti ti-users text-info me-2"></i>User Management</li>
                        <li><i class="ti ti-user-tag text-info me-2"></i>Role Management</li>
                        <li><i class="ti ti-shield text-info me-2"></i>Permission Management</li>
                    </ul>
                </div>

                <div class="mb-3">
                    <h6 class="text-primary">Best Practices</h6>
                    <ul class="list-unstyled mb-0">
                        <li><i class="ti ti-check text-success me-2"></i>Assign minimal required permissions</li>
                        <li><i class="ti ti-check text-success me-2"></i>Review permissions regularly</li>
                        <li><i class="ti ti-check text-success me-2"></i>Document role purposes</li>
                    </ul>
                </div>

                <div>
                    <h6 class="text-primary">Security Note</h6>
                    <p class="text-muted mb-0">Be careful when assigning permissions. Only grant what's necessary for the role's function.</p>
                </div>
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
    </div>
</div>
<!-- [ Main Content ] end -->
@endsection 