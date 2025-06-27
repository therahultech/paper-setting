<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Assign Roles & Permissions to {{ $user->name }}</h2>
    </x-slot>

    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow space-y-6">
        <form action="{{ route('admin.users.roles-permissions.update', $user) }}" method="POST">
            @csrf

            <div class="mb-6">
                <h3 class="font-semibold mb-2">Roles</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
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

            <div class="mb-6">
                <h3 class="font-semibold mb-2">Direct Permissions</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
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

            <div>
                <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Save Roles & Permissions
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
