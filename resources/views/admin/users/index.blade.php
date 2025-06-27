<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Users</h2>
    </x-slot>

    <div class="p-6">
        @if(session('success'))
            <div class="mb-4 text-green-700 bg-green-100 border border-green-300 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <!-- Search -->
        <form method="GET" class="mb-4 flex flex-col sm:flex-row gap-2">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Search by name or email"
                   class="w-full sm:w-1/3 px-4 py-2 border rounded focus:outline-none focus:ring focus:border-blue-300">
            <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Search
            </button>
        </form>

        <!-- Desktop Table -->
        <div class="hidden sm:block overflow-x-auto bg-white shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">#</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Name</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Email</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Roles</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Permissions</th>
                        <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600">Status</th>
                        <th class="px-4 py-2 text-center text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr>
                            <td class="px-4 py-2 text-sm text-gray-700">{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $user->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-600">{{ $user->email }}</td>
                            <td class="px-4 py-2 text-sm text-blue-700 max-w-xs flex flex-wrap">
                                @foreach($user->roles as $role)
                                    <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs mr-1 mb-1">
                                        {{ $role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-4 py-2 text-sm text-green-700 max-w-xs flex flex-wrap">
                                @foreach($user->permissions as $permission)
                                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs mr-1 mb-1">
                                        {{ $permission->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-4 py-2 text-sm">
                                <span class="inline-block px-2 py-1 rounded text-xs 
                                    {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-center space-x-1">
                                <a href="{{ route('admin.users.edit', $user) }}"
                                   class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 text-sm rounded shadow">Edit</a>
                                <a href="{{ route('admin.users.roles-permissions', $user) }}"
                                   class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 text-sm rounded shadow">Role/Permission</a>
                                <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('PATCH')
                                    @php
                                        $statusBg = $user->is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700';
                                        $statusLabel = $user->is_active ? 'Deactivate' : 'Activate';
                                    @endphp
                                    <button type="submit"
                                        onclick="return confirm('Are you sure you want to {{ strtolower($statusLabel) }} this user?')"
                                        class="{{ $statusBg }} text-white px-3 py-1 text-sm rounded shadow">
                                        {{ $statusLabel }}
                                    </button>


                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-500 py-4">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Mobile View -->
        <div class="sm:hidden space-y-4">
            @forelse($users as $user)
                <div class="bg-white shadow-md rounded-lg p-4">
                    <div class="flex justify-between items-center mb-2">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $user->name }}</h3>
                        <span class="text-xs px-2 py-1 rounded 
                            {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">{{ $user->email }}</p>
                    <div class="mb-2">
                        <strong class="text-xs text-gray-500">Roles:</strong>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach($user->roles as $role)
                                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="mb-2">
                        <strong class="text-xs text-gray-500">Permissions:</strong>
                        <div class="flex flex-wrap gap-1 mt-1">
                            @foreach($user->permissions as $permission)
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">{{ $permission->name }}</span>
                            @endforeach
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-2 mt-3">
                        <a href="{{ route('admin.users.edit', $user) }}"
                           class="bg-indigo-600 text-white px-3 py-1 rounded text-sm">Edit</a>
                        <a href="{{ route('admin.users.roles-permissions', $user) }}"
                           class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">Role/Permission</a>
                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <button type="submit"
                                    class="bg-{{ $user->is_active ? 'red' : 'green' }}-600 text-white px-3 py-1 rounded text-sm">
                                {{ $user->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500">No users found.</div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>
