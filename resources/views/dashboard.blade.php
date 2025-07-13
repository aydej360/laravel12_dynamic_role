@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Dashboard</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Dashboard</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<!-- [ Main Content ] start -->
<div class="row">
    <!-- [ sample-page ] start -->
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Total Users</h6>
                <h4 class="mb-3">{{ $stats['total_users'] }} <span class="badge bg-light-success border border-success"><i class="ti ti-trending-up"></i> {{ number_format(($stats['total_users'] / max($stats['total_users'], 1)) * 100, 1) }}%</span></h4>
                <p class="mb-0 text-muted text-sm">Total registered users in system</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Total Roles</h6>
                <h4 class="mb-3">{{ $stats['total_roles'] }} <span class="badge bg-light-primary border border-primary"><i class="ti ti-trending-up"></i> {{ number_format(($stats['total_roles'] / max($stats['total_roles'], 1)) * 100, 1) }}%</span></h4>
                <p class="mb-0 text-muted text-sm">Total roles available</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">Active Sessions</h6>
                <h4 class="mb-3">{{ auth()->check() ? '1' : '0' }} <span class="badge bg-light-info border border-info"><i class="ti ti-user-check"></i> Active</span></h4>
                <p class="mb-0 text-muted text-sm">Current active sessions</p>
            </div>
        </div>
    </div>
    <div class="col-md-6 col-xl-3">
        <div class="card">
            <div class="card-body">
                <h6 class="mb-2 f-w-400 text-muted">System Status</h6>
                <h4 class="mb-3">Online <span class="badge bg-light-success border border-success"><i class="ti ti-server"></i> Running</span></h4>
                <p class="mb-0 text-muted text-sm">System is running normally</p>
            </div>
        </div>
    </div>
    <!-- [ sample-page ] end -->

    <!-- [ Recent Users ] start -->
    <div class="col-xl-8">
        <div class="card">
            <div class="card-header">
                <h5>Recent Users</h5>
            </div>
            <div class="card-body">
                @if($stats['recent_users']->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats['recent_users'] as $user)
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
                                                @if($user->email_verified_at)
                                                    <small class="text-success"><i class="ti ti-check-circle"></i> Verified</small>
                                                @else
                                                    <small class="text-warning"><i class="ti ti-clock"></i> Pending</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach($user->roles as $role)
                                            <span class="badge bg-light-secondary text-secondary">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>{{ $user->created_at->format('M d, Y') }}</td>
                                    <td>
                                        @can('view users')
                                        <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        @endcan
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="ti ti-users text-muted" style="font-size: 3rem;"></i>
                        <h6 class="text-muted mt-2">No users found</h6>
                        <p class="text-muted">Get started by creating your first user.</p>
                        @can('create users')
                        <a href="{{ route('users.create') }}" class="btn btn-primary">
                            <i class="ti ti-user-plus"></i> Create User
                        </a>
                        @endcan
                    </div>
                @endif
            </div>
        </div>
    </div>
    <!-- [ Recent Users ] end -->

    <!-- [ Quick Actions ] start -->
    <div class="col-xl-4">
        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    @can('create users')
                    <a href="{{ route('users.create') }}" class="btn btn-primary">
                        <i class="ti ti-user-plus me-2"></i>Add New User
                    </a>
                    @endcan
                    
                    @can('create roles')
                    <a href="{{ route('roles.create') }}" class="btn btn-success">
                        <i class="ti ti-user-tag me-2"></i>Create Role
                    </a>
                    @endcan
                    
                    @can('view users')
                    <a href="{{ route('users.index') }}" class="btn btn-outline-primary">
                        <i class="ti ti-list me-2"></i>View All Users
                    </a>
                    @endcan
                    
                    @can('view roles')
                    <a href="{{ route('roles.index') }}" class="btn btn-outline-success">
                        <i class="ti ti-tags me-2"></i>Manage Roles
                    </a>
                    @endcan
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>System Info</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Laravel Version</small>
                        <p class="mb-2">{{ app()->version() }}</p>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">PHP Version</small>
                        <p class="mb-2">{{ phpversion() }}</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Environment</small>
                        <p class="mb-2">{{ config('app.env') }}</p>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Timezone</small>
                        <p class="mb-0">{{ config('app.timezone') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- [ Quick Actions ] end -->
</div>
<!-- [ Main Content ] end -->
@endsection
