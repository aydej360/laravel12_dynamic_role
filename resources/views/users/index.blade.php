@extends('layouts.app')

@section('title', 'Users')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Users Management</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Users</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="row align-items-center">
                    <div class="col">
                        <h5>Users List</h5>
                    </div>
                    <div class="col-auto">
                        @can('create users')
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i>Add New User
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Search and Filter -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('users.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search users..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="ti ti-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6 text-end">
                        <span class="text-muted">Showing {{ $users->firstItem() ?? 0 }} to {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} users</span>
                    </div>
                </div>

                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="avatar rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" style="width:32px; height:32px; font-size:1rem; font-weight:600;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">{{ $user->name }}</h6>
                                                <small class="text-muted">Registered User</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="d-block">{{ $user->email }}</span>
                                            @if($user->email_verified_at)
                                                <small class="text-success"><i class="ti ti-check-circle"></i> Verified</small>
                                            @else
                                                <small class="text-warning"><i class="ti ti-clock"></i> Pending</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        @if($user->roles->count() > 0)
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-light-secondary text-secondary me-1">{{ $role->name }}</span>
                                            @endforeach
                                        @else
                                            <span class="badge bg-light-danger text-danger">No Role</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($user->email_verified_at)
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-warning">Pending</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div>
                                            <span class="d-block">{{ $user->created_at->format('M d, Y') }}</span>
                                            <small class="text-muted">{{ $user->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @can('view users')
                                            <a href="{{ route('users.show', \App\Services\EncryptionService::encryptId($user->id)) }}" class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            @endcan
                                            
                                            @can('edit users')
                                            <a href="{{ route('users.edit', \App\Services\EncryptionService::encryptId($user->id)) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            @endcan
                                            
                                            @can('delete users')
                                            @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('users.destroy', \App\Services\EncryptionService::encryptId($user->id)) }}" class="d-inline delete-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger delete-btn" title="Delete" data-name="{{ $user->name }}">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                            @endif
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        {{ $users->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ti ti-users text-muted" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mt-3">No users found</h5>
                        <p class="text-muted">Get started by creating your first user.</p>
                        @can('create users')
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="ti ti-user-plus me-2"></i>Create First User
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