@extends('layouts.app')

@section('title', 'Role Details')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Role Details</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{ $role->name }}</li>
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
                <div class="row align-items-center">
                    <div class="col">
                        <h5>Role Information</h5>
                    </div>
                    <div class="col-auto">
                        <div class="btn-group" role="group">
                            @can('edit roles')
                            <a href="{{ route('roles.edit', \App\Services\EncryptionService::encryptId($role->id)) }}" class="btn btn-warning">
                                <i class="ti ti-edit me-1"></i>Edit
                            </a>
                            @endcan
                            
                            @can('delete roles')
                            @if($role->users_count == 0)
                            <form method="POST" action="{{ route('roles.destroy', \App\Services\EncryptionService::encryptId($role->id)) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete-btn" data-name="{{ $role->name }}">
                                    <i class="ti ti-trash me-1"></i>Delete
                                </button>
                            </form>
                            @else
                            <button class="btn btn-secondary" disabled title="Cannot delete - has users">
                                <i class="ti ti-lock me-1"></i>Locked
                            </button>
                            @endif
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-muted">Role Name</label>
                            <p class="form-control-plaintext">{{ $role->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-muted">Role Type</label>
                            <p class="form-control-plaintext">System Role</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-muted">Guard Name</label>
                            <p class="form-control-plaintext">{{ $role->guard_name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-muted">Users Count</label>
                            <div>
                                <span class="badge bg-light-info text-info">{{ $role->users_count ?? 0 }} users</span>
                                @if($role->users_count > 0)
                                    <small class="text-muted d-block mt-1">assigned to this role</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-muted">Created</label>
                            <p class="form-control-plaintext">{{ $role->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-muted">Last Updated</label>
                            <p class="form-control-plaintext">{{ $role->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Assigned Permissions</h5>
            </div>
            <div class="card-body">
                @if($role->permissions->count() > 0)
                    <div class="row">
                        @foreach($role->permissions->groupBy(function($permission) {
                            return explode(' ', $permission->name)[0];
                        }) as $group => $groupPermissions)
                            <div class="col-md-6 mb-3">
                                <div class="card border">
                                    <div class="card-header bg-light">
                                        <h6 class="mb-0 text-capitalize">{{ $group }}</h6>
                                    </div>
                                    <div class="card-body">
                                        @foreach($groupPermissions as $permission)
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="ti ti-check text-success me-2"></i>
                                                <span>{{ ucwords(str_replace('_', ' ', $permission->name)) }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="ti ti-shield text-muted" style="font-size: 3rem;"></i>
                        <h6 class="text-muted mt-2">No permissions assigned</h6>
                        <p class="text-muted">This role doesn't have any permissions assigned yet.</p>
                        @can('edit roles')
                        <a href="{{ route('roles.edit', \App\Services\EncryptionService::encryptId($role->id)) }}" class="btn btn-primary">
                            <i class="ti ti-plus me-2"></i>Assign Permissions
                        </a>
                        @endcan
                    </div>
                @endif
            </div>
        </div>

        @if($role->users_count > 0)
        <div class="card">
            <div class="card-header">
                <h5>Users with this Role</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Joined</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($role->users as $user)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm bg-primary rounded-circle me-2">
                                            <span class="avatar-text">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                        </div>
                                        <div>
                                            <h6 class="mb-0">{{ $user->name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-warning">Pending</span>
                                    @endif
                                </td>
                                <td>{{ $user->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5>Role Profile</h5>
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
                <h5>Role Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <h6 class="text-success mb-1">{{ $role->created_at->diffForHumans() }}</h6>
                            <small class="text-muted">Created</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h6 class="text-info mb-1">{{ $role->updated_at->diffForHumans() }}</h6>
                            <small class="text-muted">Updated</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @can('edit roles')
                    <a href="{{ route('roles.edit', \App\Services\EncryptionService::encryptId($role->id)) }}" class="btn btn-outline-warning">
                        <i class="ti ti-edit me-2"></i>Edit Role
                    </a>
                    @endcan
                    
                    @can('delete roles')
                    @if($role->users_count == 0)
                    <form method="POST" action="{{ route('roles.destroy', \App\Services\EncryptionService::encryptId($role->id)) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100 delete-btn" data-name="{{ $role->name }}">
                            <i class="ti ti-trash me-2"></i>Delete Role
                        </button>
                    </form>
                    @else
                    <button class="btn btn-outline-secondary w-100" disabled title="Cannot delete - has users">
                        <i class="ti ti-lock me-2"></i>Cannot Delete
                    </button>
                    @endif
                    @endcan
                    
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-2"></i>Back to Roles
                    </a>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Permission Summary</h5>
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
                        <p class="text-muted mb-0 mt-2">No permissions</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
@endsection 