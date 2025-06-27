<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-bold text-gray-800">Role-Permission Mapping</h2>
    </x-slot>

    <div class="p-6 space-y-6">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded shadow-sm border border-green-300">
                {{ session('success') }}
            </div>
        @endif

        @foreach($roles as $role)
            <div class="bg-white shadow rounded-lg border border-gray-200">
                <form method="POST" action="{{ route('admin.roles.permissions.update') }}" class="p-6">
                    @csrf
                    <input type="hidden" name="role_id" value="{{ $role->id }}">

                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-700">
                            {{ ucwords($role->name) }}
                        </h3>

                        <button type="button"
                                onclick="togglePermissions(this)"
                                class="text-sm text-blue-600 underline hover:text-blue-800">
                            Select All
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 max-h-48 overflow-y-auto border p-3 rounded">
                        @foreach($permissions as $permission)
                            <label class="flex items-center space-x-2 text-sm text-gray-700">
                                <input type="checkbox" name="permissions[]"
                                       value="{{ $permission->name }}"
                                       {{ $role->permissions->pluck('name')->contains($permission->name) ? 'checked' : '' }}
                                       class="perm-checkbox">
                                <span>{{ ucwords(str_replace('_', ' ', $permission->name)) }}</span>
                            </label>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <button class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-2 rounded shadow">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        @endforeach
    </div>

    <script>
        function togglePermissions(button) {
            const container = button.closest('form');
            const checkboxes = container.querySelectorAll('.perm-checkbox');
            const allChecked = Array.from(checkboxes).every(cb => cb.checked);

            checkboxes.forEach(cb => cb.checked = !allChecked);
            button.innerText = allChecked ? 'Select All' : 'Deselect All';
        }
    </script>
</x-app-layout>
