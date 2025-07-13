@extends('layouts.app')

@section('title', 'Roles')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Roles Management</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Roles</li>
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
                        <h5>Roles List</h5>
                    </div>
                    <div class="col-auto">
                        @can('create roles')
                        <a href="{{ route('roles.create') }}" class="btn btn-primary">
                            <i class="ti ti-plus me-1"></i>Add New Role
                        </a>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="card-body">
                <!-- Search and Filter -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <form method="GET" action="{{ route('roles.index') }}" class="d-flex">
                            <input type="text" name="search" class="form-control me-2" placeholder="Search roles..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-outline-primary">
                                <i class="ti ti-search"></i>
                            </button>
                        </form>
                    </div>
                    <div class="col-md-6 text-end">
                        <span class="text-muted">Showing {{ $roles->firstItem() ?? 0 }} to {{ $roles->lastItem() ?? 0 }} of {{ $roles->total() }} roles</span>
                    </div>
                </div>

                @if($roles->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Role</th>
                                    <th>Permissions</th>
                                    <th>Users</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($roles as $role)
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="avatar rounded-circle d-flex align-items-center justify-content-center bg-success text-white" style="width:32px; height:32px; font-size:1rem; font-weight:600;">
                                                    {{ strtoupper(substr($role->name, 0, 1)) }}
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <h6 class="mb-0">{{ $role->name }}</h6>
                                                <small class="text-muted">ID: {{ $role->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @if($role->permissions->count() > 0)
                                            <div class="d-flex flex-wrap gap-1">
                                                @foreach($role->permissions->take(3) as $permission)
                                                    <span class="badge bg-light-primary text-primary">{{ $permission->name }}</span>
                                                @endforeach
                                                @if($role->permissions->count() > 3)
                                                    <span class="badge bg-light-secondary text-secondary">+{{ $role->permissions->count() - 3 }} more</span>
                                                @endif
                                            </div>
                                        @else
                                            <span class="badge bg-light-danger text-danger">No Permissions</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-light-info text-info me-2">{{ $role->users_count ?? 0 }} users</span>
                                            @if($role->users_count > 0)
                                                <small class="text-muted">assigned</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <span class="d-block">{{ $role->created_at->format('M d, Y') }}</span>
                                            <small class="text-muted">{{ $role->created_at->format('H:i') }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            @can('view roles')
                                            <a href="{{ route('roles.show', $role) }}" class="btn btn-sm btn-outline-primary" title="View">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            @endcan
                                            
                                            @can('edit roles')
                                            <a href="{{ route('roles.edit', $role) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                            @endcan
                                            
                                            @can('delete roles')
                                            @if($role->users_count == 0)
                                            <form method="POST" action="{{ route('roles.destroy', $role) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this role?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                    <i class="ti ti-trash"></i>
                                                </button>
                                            </form>
                                            @else
                                            <button class="btn btn-sm btn-outline-secondary" title="Cannot delete - has users" disabled>
                                                <i class="ti ti-lock"></i>
                                            </button>
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
                        {{ $roles->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="ti ti-user-tag text-muted" style="font-size: 4rem;"></i>
                        <h5 class="text-muted mt-3">No roles found</h5>
                        <p class="text-muted">Get started by creating your first role.</p>
                        @can('create roles')
                        <a href="{{ route('roles.create') }}" class="btn btn-primary">
                            <i class="ti ti-user-tag me-2"></i>Create First Role
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