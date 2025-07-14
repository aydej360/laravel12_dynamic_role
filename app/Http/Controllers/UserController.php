<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use App\Services\EncryptionService;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::with('roles');
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $users = $query->paginate(10);
        Log::info('User list viewed by: ' . auth()->user()->name);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'roles' => 'array'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($request->has('roles')) {
            $user->assignRole($request->roles);
        }

        Log::info('User created: ' . $user->name . ' by: ' . auth()->user()->name);
        
        return redirect()->route('users.index')
            ->with('success', 'User "' . $user->name . '" has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($encryptedId)
    {
        try {
            $id = EncryptionService::decryptId($encryptedId);
            $user = User::findOrFail($id);
            $user->load('roles');
            Log::info('User profile viewed: ' . $user->name . ' by: ' . auth()->user()->name);
            return view('users.show', compact('user'));
        } catch (\Exception $e) {
            Log::error('Error viewing user: ' . $e->getMessage());
            return redirect()->route('users.index')
                ->with('error', 'Unable to view user. Invalid or expired link.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($encryptedId)
    {
        try {
            $id = EncryptionService::decryptId($encryptedId);
            $user = User::findOrFail($id);
            $roles = Role::all();
            $user->load('roles');
            return view('users.edit', compact('user', 'roles'));
        } catch (\Exception $e) {
            Log::error('Error editing user: ' . $e->getMessage());
            return redirect()->route('users.index')
                ->with('error', 'Unable to edit user. Invalid or expired link.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $encryptedId)
    {
        try {
            $id = EncryptionService::decryptId($encryptedId);
            $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'roles' => 'array'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        $user->syncRoles($request->roles ?? []);

        Log::info('User updated: ' . $user->name . ' by: ' . auth()->user()->name);

            return redirect()->route('users.index')
                ->with('success', 'User "' . $user->name . '" has been updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            return redirect()->route('users.index')
                ->with('error', 'Unable to update user. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($encryptedId)
    {
        try {
            $id = EncryptionService::decryptId($encryptedId);
            $user = User::findOrFail($id);
            
            $userName = $user->name;
            $user->delete();

            Log::info('User deleted: ' . $userName . ' by: ' . auth()->user()->name);

            return redirect()->route('users.index')
                ->with('success', 'User "' . $userName . '" has been deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            return redirect()->route('users.index')
                ->with('error', 'Unable to delete user. Please try again.');
        }
    }
}
