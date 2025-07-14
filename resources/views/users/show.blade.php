@extends('layouts.app')

@section('title', 'User Details')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">User Details</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item" aria-current="page">{{ $user->name }}</li>
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
                        <h5>User Information</h5>
                    </div>
                    <div class="col-auto">
                        <div class="btn-group" role="group">
                            @can('edit users')
                            <a href="{{ route('users.edit', \App\Services\EncryptionService::encryptId($user->id)) }}" class="btn btn-warning">
                                <i class="ti ti-edit me-1"></i>Edit
                            </a>
                            @endcan
                            
                            @can('delete users')
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('users.destroy', \App\Services\EncryptionService::encryptId($user->id)) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete-btn" data-name="{{ $user->name }}">
                                    <i class="ti ti-trash me-1"></i>Delete
                                </button>
                            </form>
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
                            <label class="form-label text-muted">Name</label>
                            <p class="form-control-plaintext">{{ $user->name }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-muted">Email</label>
                            <p class="form-control-plaintext">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-muted">Email Status</label>
                            <div>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success"><i class="ti ti-check-circle me-1"></i>Verified</span>
                                    <small class="text-muted d-block mt-1">Verified on {{ $user->email_verified_at->format('M d, Y H:i') }}</small>
                                @else
                                    <span class="badge bg-warning"><i class="ti ti-clock me-1"></i>Pending Verification</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-muted">Account Status</label>
                            <div>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-warning">Pending</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-muted">Created</label>
                            <p class="form-control-plaintext">{{ $user->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label text-muted">Last Updated</label>
                            <p class="form-control-plaintext">{{ $user->updated_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Roles & Permissions</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Assigned Roles</h6>
                        @if($user->roles->count() > 0)
                            @foreach($user->roles as $role)
                                <div class="d-flex align-items-center mb-2">
                                    <div class="avatar rounded-circle d-flex align-items-center justify-content-center bg-success text-white" style="width:32px; height:32px; font-size:1rem; font-weight:600;">
                                        {{ strtoupper(substr($role->name, 0, 1)) }}
                                    </div>
                                    <div class="ms-2">
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
                    <div class="col-md-6">
                        <h6 class="text-primary mb-3">Direct Permissions</h6>
                        @if($user->permissions->count() > 0)
                            <div class="d-flex flex-wrap gap-1">
                                @foreach($user->permissions as $permission)
                                    <span class="badge bg-light-primary text-primary">{{ ucwords(str_replace('_', ' ', $permission->name)) }}</span>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-3">
                                <i class="ti ti-shield text-muted" style="font-size: 2rem;"></i>
                                <p class="text-muted mb-0 mt-2">No direct permissions</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5>User Profile</h5>
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
                        <small class="text-muted">Roles</small>
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
                <h5>Account Statistics</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="text-center">
                            <h6 class="text-primary mb-1">{{ $user->created_at->diffForHumans() }}</h6>
                            <small class="text-muted">Member Since</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="text-center">
                            <h6 class="text-info mb-1">{{ $user->updated_at->diffForHumans() }}</h6>
                            <small class="text-muted">Last Updated</small>
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
                    @can('edit users')
                    <a href="{{ route('users.edit', \App\Services\EncryptionService::encryptId($user->id)) }}" class="btn btn-outline-warning">
                        <i class="ti ti-edit me-2"></i>Edit User
                    </a>
                    @endcan
                    
                    @if($user->id !== auth()->id())
                    @can('delete users')
                    <form method="POST" action="{{ route('users.destroy', \App\Services\EncryptionService::encryptId($user->id)) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100 delete-btn" data-name="{{ $user->name }}">
                            <i class="ti ti-trash me-2"></i>Delete User
                        </button>
                    </form>
                    @endcan
                    @endif
                    
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