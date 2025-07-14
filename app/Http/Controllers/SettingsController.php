<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SettingsController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $user = Auth::user();
        
        // Get current settings from session or default values
        $settings = [
            'theme' => Session::get('theme', 'light'),
            'language' => Session::get('language', 'en'),
            'sidebar_collapsed' => Session::get('sidebar_collapsed', false),
            'email_notifications' => Session::get('email_notifications', true),
            'browser_notifications' => Session::get('browser_notifications', true),
        ];
        
        return view('settings.index', compact('user', 'settings'));
    }
    
    /**
     * Update profile information.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'current_password' => 'required_with:password',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Check current password if new password is provided
        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return redirect()->back()->with('error', 'Current password is incorrect.');
            }
        }

        // Update profile information
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Update password if provided
        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
    
    /**
     * Update system preferences.
     */
    public function updatePreferences(Request $request)
    {
        $request->validate([
            'theme' => 'required|in:light,dark',
            'language' => 'required|in:en,id',
            'sidebar_collapsed' => 'boolean',
            'email_notifications' => 'boolean',
            'browser_notifications' => 'boolean',
        ]);

        // Store preferences in session
        Session::put('theme', $request->theme);
        Session::put('language', $request->language);
        Session::put('sidebar_collapsed', $request->boolean('sidebar_collapsed'));
        Session::put('email_notifications', $request->boolean('email_notifications'));
        Session::put('browser_notifications', $request->boolean('browser_notifications'));

        return redirect()->back()->with('success', 'Preferences updated successfully.');
    }
    
    /**
     * Toggle theme via AJAX
     */
    public function toggleTheme(Request $request)
    {
        $theme = $request->input('theme', 'light');
        
        if (in_array($theme, ['light', 'dark'])) {
            Session::put('theme', $theme);
            return response()->json(['success' => true, 'theme' => $theme]);
        }
        
        return response()->json(['success' => false], 400);
    }
}
