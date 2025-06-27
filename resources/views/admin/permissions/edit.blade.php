<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Edit Permission</h2>
    </x-slot>

    <div class="p-4 max-w-xl mx-auto">
        <form method="POST" action="{{ route('admin.permissions.update', $permission) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium mb-1">Permission Name</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" value="{{ $permission->name }}" required>
                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>
    </div>
</x-app-layout>
