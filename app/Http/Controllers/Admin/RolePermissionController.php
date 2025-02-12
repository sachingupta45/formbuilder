<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Class RolePermissionController
 *
 * This controller manages roles and permissions for the application's admin panel.
 */
class RolePermissionController extends Controller
{
    /**
     * Display a listing of roles.
     *
     * @return \Illuminate\View\View
     */
    public function roleIndex()
    {dd('here');
        try {
            $roles = Role::get();
            return view('admin.role.index', compact('roles'));
        } catch (\Exception $e) {
            Log::error('Error in roleIndex: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching roles.');
        }
    }

    /**
     * Show the form for creating or updating a role.
     *
     * @param Role|null $role
     * @return \Illuminate\View\View
     */
    public function createOrUpdate(Role $role = null)
    {
        try {
            $permissions = Permission::all()->groupBy('group_name');
            $rolePermissions = $role ? $role->permissions->pluck('name')->toArray() : [];
            return view('admin.role.add', compact('role', 'permissions', 'rolePermissions'));
        } catch (\Exception $e) {
            Log::error('Error in createOrUpdate: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading the role form.');
        }
    }

    /**
     * Store a newly created or updated role in storage.
     *
     * @param Request $request
     * @param Role|null $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeRole(Request $request, Role $role = null)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
        ]);

        try {
            if (is_null($role)) {
                $role = Role::create(['name' => $request->name]);
            } else {
                $role->update(['name' => $request->name]);
                $role->permissions()->detach();
            }

            $role->syncPermissions($request->permissions);
            return redirect()->route('admin.role.index')->with('success', 'Role saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error in storeRole: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Role save failed: ' . $e->getMessage());
        }
    }

    /**
     * Display the form for creating a new permission.
     *
     * @return \Illuminate\View\View
     */
    public function createPermission()
    {
        return view('admin.permission.add');
    }

    /**
     * Store a newly created or updated permission in storage.
     *
     * @param Request $request
     * @param Permission|null $permission
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storePermission(Request $request, Permission $permission = null)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            if (is_null($permission)) {
                Permission::create(['name' => $request->name]);
            } else {
                $permission->update(['name' => $request->name]);
            }

            return redirect()->route('admin.permission.index')->with('success', 'Permission saved successfully.');
        } catch (\Exception $e) {
            Log::error('Error in storePermission: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Permission save failed: ' . $e->getMessage());
        }
    }

    /**
     * Display a listing of permissions.
     *
     * @return \Illuminate\View\View
     */
    public function permissionIndex()
    {
        try {
            $permissions = Permission::all();
            return view('admin.permission.index', compact('permissions'));
        } catch (\Exception $e) {
            Log::error('Error in permissionIndex: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching permissions.');
        }
    }

    /**
     * Show the form for editing the specified permission.
     *
     * @param Permission $permission
     * @return \Illuminate\View\View
     */
    public function editPermission(Permission $permission)
    {
        try {
            return view('admin.permission.edit', compact('permission'));
        } catch (\Exception $e) {
            Log::error('Error in editPermission: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading the permission edit form.');
        }
    }

    /**
     * Remove the specified role from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Role $role)
    {
        try {
            $role->permissions()->detach();
            $role->delete();
            return redirect()->route('admin.role.index')->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error in destroy: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Role deletion failed: ' . $e->getMessage());
        }
    }
}
