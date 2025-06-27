<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800 leading-tight">
            {{ __('User Role & Permission Management') }}
        </h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Create Role --}}
        <div class="mb-6 bg-white p-4 rounded shadow">
            <h3 class="text-lg font-semibold mb-2">Create Role & Permission</h3>
            <div class="flex flex-wrap gap-4">
                <form method="POST" action="{{ route('roles.create') }}" class="flex items-center gap-2">
                    @csrf
                    <input name="role" placeholder="New Role" required class="border p-2 rounded">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Add Role</button>
                </form>

                <form method="POST" action="{{ route('permissions.create') }}" class="flex items-center gap-2">
                    @csrf
                    <input name="permission" placeholder="New Permission" required class="border p-2 rounded">
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Add Permission</button>
                </form>
            </div>
        </div>

        {{-- Users Table --}}
        <div class="bg-white shadow rounded p-4 overflow-x-auto">
            <table class="min-w-full table-auto">
                <thead>
                    <tr class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                        <th class="px-4 py-2">#</th>
                        <th class="px-4 py-2">Name</th>
                        <th class="px-4 py-2">Email</th>
                        <th class="px-4 py-2">Roles</th>
                        <th class="px-4 py-2">Permissions</th>
                        <th class="px-4 py-2">Assign Role</th>
                        <th class="px-4 py-2">Assign Permission</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-800">
                    @foreach($users as $index => $user)
                        <tr class="border-t">
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>

                            {{-- Roles Display --}}
                            <td class="px-4 py-2">
                                @foreach($user->roles as $role)
                                    <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs mr-1 mb-1">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>

                            {{-- Permissions Display --}}
                            <td class="px-4 py-2">
                                @foreach($user->permissions as $permission)
                                    <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs mr-1 mb-1">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                            </td>

                            {{-- Assign Role Form --}}
                            <td class="px-4 py-2">
                                <form method="POST" action="{{ route('user.assignRole', $user) }}">
                                    @csrf
                                    <select name="roles[]" multiple class="border rounded p-1 w-full text-xs">
                                        @foreach($roles as $role)
                                            <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="mt-1 w-full bg-blue-600 text-white text-xs px-2 py-1 rounded">
                                        Save
                                    </button>
                                </form>
                            </td>

                            {{-- Assign Permission Form --}}
                            <td class="px-4 py-2">
                                <form method="POST" action="{{ route('user.assignPermission', $user) }}">
                                    @csrf
                                    <select name="permissions[]" multiple class="border rounded p-1 w-full text-xs">
                                        @foreach($permissions as $permission)
                                            <option value="{{ $permission->name }}" {{ $user->hasPermissionTo($permission->name) ? 'selected' : '' }}>
                                                {{ $permission->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="mt-1 w-full bg-green-600 text-white text-xs px-2 py-1 rounded">
                                        Save
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
