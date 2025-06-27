<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Manage Permissions</h2>
    </x-slot>

    <div class="p-4">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-3">{{ session('success') }}</div>
        @endif

        <a href="{{ route('admin.permissions.create') }}" class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">+ Add Permission</a>

        <table class="w-full text-sm border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2">#</th>
                    <th class="px-4 py-2">Permission Name</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $permission)
                    <tr class="border-t">
                        <td class="px-4 py-2">{{ $permission->id }}</td>
                        <td class="px-4 py-2">{{ $permission->name }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.permissions.edit', $permission) }}" class="text-blue-600 hover:underline">Edit</a>
                            <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Delete this permission?')">
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
            {{ $permissions->links() }}
        </div>
    </div>
</x-app-layout>
