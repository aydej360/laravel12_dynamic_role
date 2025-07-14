<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Log;
use App\Services\EncryptionService;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Role::with('permissions')->withCount('users');
        
        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }
        
        $roles = $query->paginate(10);
        Log::info('Role list viewed by: ' . auth()->user()->name);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles',
            'permissions' => 'array'
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
            $role->syncPermissions($permissionNames);
        }

        Log::info('Role created: ' . $role->name . ' by: ' . auth()->user()->name);

        return redirect()->route('roles.index')
            ->with('success', 'Role "' . $role->name . '" has been created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($encryptedId)
    {
        try {
            $id = EncryptionService::decryptId($encryptedId);
            $role = Role::findOrFail($id);
            $role->load('permissions');
            Log::info('Role details viewed: ' . $role->name . ' by: ' . auth()->user()->name);
            return view('roles.show', compact('role'));
        } catch (\Exception $e) {
            Log::error('Error viewing role: ' . $e->getMessage());
            return redirect()->route('roles.index')
                ->with('error', 'Unable to view role. Invalid or expired link.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($encryptedId)
    {
        try {
            $id = EncryptionService::decryptId($encryptedId);
            $role = Role::findOrFail($id);
            $permissions = Permission::all();
            $role->load('permissions');
            return view('roles.edit', compact('role', 'permissions'));
        } catch (\Exception $e) {
            Log::error('Error editing role: ' . $e->getMessage());
            return redirect()->route('roles.index')
                ->with('error', 'Unable to edit role. Invalid or expired link.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $encryptedId)
    {
        try {
            $id = EncryptionService::decryptId($encryptedId);
            $role = Role::findOrFail($id);
            
            $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $role->id,
                'permissions' => 'array'
            ]);

            $role->update(['name' => $request->name]);
            
            if ($request->has('permissions')) {
                $permissionNames = Permission::whereIn('id', $request->permissions)->pluck('name')->toArray();
                $role->syncPermissions($permissionNames);
            } else {
                $role->syncPermissions([]);
            }

            Log::info('Role updated: ' . $role->name . ' by: ' . auth()->user()->name);

            return redirect()->route('roles.index')
                ->with('success', 'Role "' . $role->name . '" has been updated successfully!');
        } catch (\Exception $e) {
            Log::error('Error updating role: ' . $e->getMessage());
            return redirect()->route('roles.index')
                ->with('error', 'Unable to update role. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($encryptedId)
    {
        try {
            $id = EncryptionService::decryptId($encryptedId);
            $role = Role::findOrFail($id);
            
            $roleName = $role->name;
            $role->delete();

            Log::info('Role deleted: ' . $roleName . ' by: ' . auth()->user()->name);

            return redirect()->route('roles.index')
                ->with('success', 'Role "' . $roleName . '" has been deleted successfully!');
        } catch (\Exception $e) {
            Log::error('Error deleting role: ' . $e->getMessage());
            return redirect()->route('roles.index')
                ->with('error', 'Unable to delete role. Please try again.');
        }
    }
}
