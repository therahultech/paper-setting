<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Edit User - {{ $user->name }}</h2>
    </x-slot>

    <div class="p-6 max-w-4xl mx-auto bg-white rounded-lg shadow">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700 mb-1">Roles</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                    @foreach($roles as $role)
                        <label class="inline-flex items-center space-x-2">
                            <input type="checkbox" name="roles[]"
                                   value="{{ $role->name }}"
                                   {{ $user->roles->pluck('name')->contains($role->name) ? 'checked' : '' }}>
                            <span>{{ $role->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700 mb-1">Permissions</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                    @foreach($permissions as $permission)
                        <label class="inline-flex items-center space-x-2">
                            <input type="checkbox" name="permissions[]"
                                   value="{{ $permission->name }}"
                                   {{ $user->permissions->pluck('name')->contains($permission->name) ? 'checked' : '' }}>
                            <span>{{ $permission->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mt-6">
                <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded shadow">
                    Update User
                </button>
                <a href="{{ route('admin.users.index') }}"
                   class="ml-4 text-sm text-gray-600 underline hover:text-gray-800">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</x-app-layout>
