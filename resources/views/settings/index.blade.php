@extends('layouts.app')

@section('title', 'Settings')

@section('content')
<!-- [ breadcrumb ] start -->
<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">Settings</h5>
                </div>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item" aria-current="page">Settings</li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- [ breadcrumb ] end -->

<!-- [ Main Content ] start -->
<div class="row">
    <div class="col-lg-8">
        <!-- Profile Settings Card -->
        <div class="card">
            <div class="card-header">
                <h5><i class="ti ti-user me-2"></i>Profile Settings</h5>
                <p class="text-muted mb-0">Update your profile information and password.</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings.profile.update') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <h6 class="mb-3"><i class="ti ti-lock me-2"></i>Change Password</h6>
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" name="current_password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-device-floppy me-1"></i>Update Profile
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- System Preferences Card -->
        <div class="card">
            <div class="card-header">
                <h5><i class="ti ti-settings me-2"></i>System Preferences</h5>
                <p class="text-muted mb-0">Customize your system appearance and behavior.</p>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('settings.preferences.update') }}">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="theme" class="form-label">Theme</label>
                                <select class="form-control @error('theme') is-invalid @enderror" id="theme" name="theme" onchange="previewTheme(this.value)">
                                    <option value="light" {{ $settings['theme'] === 'light' ? 'selected' : '' }}>
                                        <i class="ti ti-sun"></i> Light Theme
                                    </option>
                                    <option value="dark" {{ $settings['theme'] === 'dark' ? 'selected' : '' }}>
                                        <i class="ti ti-moon"></i> Dark Theme
                                    </option>
                                </select>
                                @error('theme')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="language" class="form-label">Language</label>
                                <select class="form-control @error('language') is-invalid @enderror" id="language" name="language">
                                    <option value="en" {{ $settings['language'] === 'en' ? 'selected' : '' }}>
                                        🇺🇸 English
                                    </option>
                                    <option value="id" {{ $settings['language'] === 'id' ? 'selected' : '' }}>
                                        🇮🇩 Bahasa Indonesia
                                    </option>
                                </select>
                                @error('language')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="sidebar_collapsed" 
                                       name="sidebar_collapsed" value="1" {{ $settings['sidebar_collapsed'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="sidebar_collapsed">
                                    <i class="ti ti-layout-sidebar-left-collapse me-1"></i>
                                    Collapsed Sidebar by Default
                                </label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="email_notifications" 
                                       name="email_notifications" value="1" {{ $settings['email_notifications'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="email_notifications">
                                    <i class="ti ti-mail me-1"></i>
                                    Email Notifications
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-check form-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="browser_notifications" 
                                       name="browser_notifications" value="1" {{ $settings['browser_notifications'] ? 'checked' : '' }}>
                                <label class="form-check-label" for="browser_notifications">
                                    <i class="ti ti-bell me-1"></i>
                                    Browser Notifications
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-secondary me-2" onclick="resetPreferences()">
                            <i class="ti ti-refresh me-1"></i>Reset to Default
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-check me-1"></i>Save Preferences
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Current User Info -->
        <div class="card">
            <div class="card-header">
                <h5>Current User</h5>
            </div>
            <div class="card-body text-center">
                <div class="avatar rounded-circle d-flex align-items-center justify-content-center bg-primary text-white" 
                     style="width:64px; height:64px; font-size:2rem; font-weight:600; margin:0 auto 1rem auto;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <h5 class="mb-1">{{ $user->name }}</h5>
                <p class="text-muted mb-2">{{ $user->email }}</p>
                <small class="text-muted">
                    <i class="ti ti-calendar me-1"></i>
                    Member since {{ $user->created_at->format('M d, Y') }}
                </small>
            </div>
        </div>

        <!-- Current Settings Summary -->
        <div class="card">
            <div class="card-header">
                <h5>Current Settings</h5>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <i class="ti ti-palette me-2"></i>
                        <span>Theme</span>
                    </div>
                    <span class="badge bg-{{ $settings['theme'] === 'dark' ? 'dark' : 'light' }} text-{{ $settings['theme'] === 'dark' ? 'light' : 'dark' }}">
                        {{ ucfirst($settings['theme']) }}
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <i class="ti ti-language me-2"></i>
                        <span>Language</span>
                    </div>
                    <span class="badge bg-light text-dark">
                        {{ $settings['language'] === 'en' ? 'English' : 'Bahasa Indonesia' }}
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <i class="ti ti-layout-sidebar me-2"></i>
                        <span>Sidebar</span>
                    </div>
                    <span class="badge bg-{{ $settings['sidebar_collapsed'] ? 'warning' : 'success' }}">
                        {{ $settings['sidebar_collapsed'] ? 'Collapsed' : 'Expanded' }}
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <i class="ti ti-mail me-2"></i>
                        <span>Email Notifications</span>
                    </div>
                    <span class="badge bg-{{ $settings['email_notifications'] ? 'success' : 'secondary' }}">
                        {{ $settings['email_notifications'] ? 'On' : 'Off' }}
                    </span>
                </div>
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <i class="ti ti-bell me-2"></i>
                        <span>Browser Notifications</span>
                    </div>
                    <span class="badge bg-{{ $settings['browser_notifications'] ? 'success' : 'secondary' }}">
                        {{ $settings['browser_notifications'] ? 'On' : 'Off' }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h5>Quick Actions</h5>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                        <i class="ti ti-user me-2"></i>Edit Profile
                    </a>
                    <button type="button" class="btn btn-outline-info" onclick="clearCache()">
                        <i class="ti ti-refresh me-2"></i>Clear Cache
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">
                        <i class="ti ti-arrow-left me-2"></i>Back to Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ Main Content ] end -->

<script>
function previewTheme(theme) {
    if (theme === 'dark') {
        document.body.setAttribute('data-pc-theme', 'dark');
    } else {
        document.body.setAttribute('data-pc-theme', 'light');
    }
}

function clearCache() {
    Swal.fire({
        title: 'Clear Cache',
        text: 'This will clear your browser cache and session data. Continue?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#17a2b8',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, clear cache',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Clear localStorage
            localStorage.clear();
            // Clear sessionStorage
            sessionStorage.clear();
            
            Swal.fire({
                title: 'Cache Cleared!',
                text: 'Browser cache has been cleared successfully.',
                icon: 'success',
                timer: 2000,
                timerProgressBar: true
            });
        }
    });
}

// Apply current theme on page load
document.addEventListener('DOMContentLoaded', function() {
    const currentTheme = '{{ $settings['theme'] }}';
    if (currentTheme === 'dark') {
        document.body.setAttribute('data-pc-theme', 'dark');
    }
});

// Reset preferences to default
function resetPreferences() {
    Swal.fire({
        title: 'Reset Preferences',
        text: 'This will reset all preferences to their default values. Continue?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, reset all',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Reset form values
            document.getElementById('theme').value = 'light';
            document.getElementById('language').value = 'en';
            document.getElementById('sidebar_collapsed').checked = false;
            document.getElementById('email_notifications').checked = true;
            document.getElementById('browser_notifications').checked = true;
            
            // Apply theme change immediately
            previewTheme('light');
            
            Swal.fire({
                title: 'Reset Complete!',
                text: 'Preferences have been reset to default values. Don\'t forget to save!',
                icon: 'info',
                timer: 3000,
                timerProgressBar: true
            });
        }
    });
}

// Real-time preference preview
document.addEventListener('DOMContentLoaded', function() {
    // Language change handler
    document.getElementById('language').addEventListener('change', function() {
        const selectedLang = this.value;
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
        });
        
        Toast.fire({
            icon: 'info',
            title: 'Language will change after saving preferences'
        });
    });
});
</script>
@endsection