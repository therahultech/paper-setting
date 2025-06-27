<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Add New Permission</h2>
    </x-slot>

    <div class="p-4 max-w-xl mx-auto">
        <form method="POST" action="{{ route('admin.permissions.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block font-medium mb-1">Permission Name</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2" required>
                @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Create</button>
        </form>
    </div>
</x-app-layout>
