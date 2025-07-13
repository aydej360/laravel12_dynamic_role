@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Profile Settings</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Profile</li>
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
                <h5>Profile Information</h5>
                <p class="text-muted mb-0">Update your account's profile information and email address.</p>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" name="current_password" autocomplete="current-password">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Enter your current password to confirm your changes.</small>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" autocomplete="new-password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5>Account Information</h5>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="avatar rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" style="width:48px; height:48px; font-size:1.5rem; font-weight:600; margin:0 auto 1rem auto;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <h6 class="mb-1">{{ $user->name }}</h6>
                    <p class="text-muted mb-0">{{ $user->email }}</p>
                </div>

                <div class="row">
                    <div class="col-6">
                        <small class="text-muted">Member Since</small>
                        <p class="mb-2">{{ $user->created_at->format('M d, Y') }}</p>
                    </div>
                    <div class="col-6">
                        <small class="text-muted">Last Updated</small>
                        <p class="mb-2">{{ $user->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>

                <hr>

                <div class="mb-3">
                    <small class="text-muted">Email Status</small>
                    <div class="mt-1">
                        @if($user->email_verified_at)
                            <span class="badge bg-success"><i class="ti ti-check-circle me-1"></i>Verified</span>
                        @else
                            <span class="badge bg-warning"><i class="ti ti-clock me-1"></i>Pending</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Roles</small>
                    <div class="mt-1">
                        @if($user->roles->count() > 0)
                            @foreach($user->roles as $role)
                                <span class="badge bg-light-secondary text-secondary me-1">{{ $role->name }}</span>
                            @endforeach
                        @else
                            <span class="badge bg-light-danger text-danger">No Role</span>
                        @endif
                    </div>
                </div>

                <div class="mb-3">
                    <small class="text-muted">Permissions</small>
                    <div class="mt-1">
                        @php $allPermissions = $user->getAllPermissions(); @endphp
                        @if($allPermissions->count() > 0)
                            @foreach($allPermissions->take(3) as $permission)
                                <span class="badge bg-light-primary text-primary me-1">{{ $permission->name }}</span>
                            @endforeach
                            @if($allPermissions->count() > 3)
                                <span class="badge bg-light-secondary text-secondary">+{{ $allPermissions->count() - 3 }} more</span>
                            @endif
                        @else
                            <span class="badge bg-light-danger text-danger">No Permissions</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5>Security Tips</h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="ti ti-check text-success me-2"></i>
                        Use a strong password
                    </li>
                    <li class="mb-2">
                        <i class="ti ti-check text-success me-2"></i>
                        Enable two-factor authentication
                    </li>
                    <li class="mb-2">
                        <i class="ti ti-check text-success me-2"></i>
                        Keep your email updated
                    </li>
                    <li class="mb-0">
                        <i class="ti ti-check text-success me-2"></i>
                        Log out from shared devices
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->
@endsection
