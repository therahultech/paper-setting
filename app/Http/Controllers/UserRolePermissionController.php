<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserRolePermissionController extends Controller
{
    public function index()
    {
        $users = User::with('roles', 'permissions')->get();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('admin.roles.index', compact('users', 'roles', 'permissions'));
    }

    public function assignRole(Request $request, User $user)
    {
        $user->syncRoles($request->roles);
        return back()->with('success', 'Roles updated.');
    }

    public function assignPermission(Request $request, User $user)
    {
        $user->syncPermissions($request->permissions);
        return back()->with('success', 'Permissions updated.');
    }

    public function createRole(Request $request)
    {
        Role::create(['name' => $request->role]);
        return back()->with('success', 'Role created.');
    }

    public function createPermission(Request $request)
    {
        Permission::create(['name' => $request->permission]);
        return back()->with('success', 'Permission created.');
    }
}

