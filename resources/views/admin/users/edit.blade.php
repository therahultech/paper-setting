<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold">Edit User</h2>
    </x-slot>

    <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">
        <form method="POST" action="{{ route('admin.users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="w-full border rounded px-3 py-2 mt-1" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="w-full border rounded px-3 py-2 mt-1" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">New Password</label>
                <input type="password" name="password"
                       class="w-full border rounded px-3 py-2 mt-1">
                <small class="text-gray-500">Leave blank if you don’t want to change it.</small>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation"
                       class="w-full border rounded px-3 py-2 mt-1">
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Status</label>
                <select name="is_active" class="w-full border rounded px-3 py-2 mt-1">
                    <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>

            <div class="mt-6">
                <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Update User
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
