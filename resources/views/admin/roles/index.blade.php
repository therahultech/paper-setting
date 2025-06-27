<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Manage Roles</h2>
    </x-slot>

    <div class="p-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-3">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.roles.create') }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">+ Add Role</a>

        <table class="w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Role Name</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $role->id }}</td>
                        <td class="px-4 py-2">{{ $role->name }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.roles.edit', $role) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Delete this role?')">
                                @csrf
                                @method('DELETE')
                                <button class="text-red-600 hover:underline">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $roles->links() }}
        </div>
    </div>
</x-app-layout>
