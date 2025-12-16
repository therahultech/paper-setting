<aside class="bg-white w-64 shadow-lg flex-shrink-0 transform transition-transform duration-200 ease-in-out md:translate-x-0 md:static absolute inset-y-0 left-0 z-30"
       :class="{ '-translate-x-full': !sidebarOpen }"
       x-data="{ adminOpen: true, academicOpen: true }">
    <div class="h-16 flex items-center justify-between px-4 border-b">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8">
            <span class="text-lg font-semibold">Admin Panel</span>
        </div>
        <button class="md:hidden text-gray-600" @click="sidebarOpen = false">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <nav class="p-4 text-sm">
        <!-- Admin Section -->
        <div class="mb-4">
            <button @click="adminOpen = !adminOpen"
                    class="w-full flex justify-between items-center px-4 py-2 font-semibold text-gray-600 hover:text-black focus:outline-none">
                <span>Admin</span>
                <i :class="adminOpen ? 'fa fa-chevron-down' : 'fa fa-chevron-right'" class="text-xs"></i>
            </button>
            <ul x-show="adminOpen" x-transition class="mt-2 pl-4 space-y-1">
                <li><a href="{{ route('admin.users.index') }}"
                       class="block px-2 py-1 rounded hover:bg-gray-100 {{ request()->routeIs('admin.users.*') ? 'text-blue-600 font-semibold' : '' }}">Manage Users</a></li>
                <li><a href="{{ route('admin.roles.index') }}"
                       class="block px-2 py-1 rounded hover:bg-gray-100 {{ request()->routeIs('admin.roles.*') ? 'text-blue-600 font-semibold' : '' }}">Manage Roles</a></li>
                <li><a href="{{ route('admin.permissions.index') }}"
                       class="block px-2 py-1 rounded hover:bg-gray-100 {{ request()->routeIs('admin.permissions.*') ? 'text-blue-600 font-semibold' : '' }}">Manage Permissions</a></li>
                <li><a href="{{ route('admin.roles.permissions') }}"
                       class="block px-2 py-1 rounded hover:bg-gray-100 {{ request()->routeIs('admin.roles.permissions') ? 'text-blue-600 font-semibold' : '' }}">Role-Permission Map</a></li>
            </ul>
        </div>

        <!-- Academic Section -->
        <div class="mb-4">
            <button @click="academicOpen = !academicOpen"
                    class="w-full flex justify-between items-center px-4 py-2 font-semibold text-gray-600 hover:text-black focus:outline-none">
                <span>Academic</span>
                <i :class="academicOpen ? 'fa fa-chevron-down' : 'fa fa-chevron-right'" class="text-xs"></i>
            </button>
            <ul x-show="academicOpen" x-transition class="mt-2 pl-4 space-y-1">
                <li><a href="{{ route('department.index') }}"
                       class="block px-2 py-1 rounded hover:bg-gray-100 {{ request()->routeIs('department.*') ? 'text-blue-600 font-semibold' : '' }}">Departments</a></li>
                <li><a href="{{ route('course.index') }}"
                       class="block px-2 py-1 rounded hover:bg-gray-100 {{ request()->routeIs('course.*') ? 'text-blue-600 font-semibold' : '' }}">Courses</a></li>
                <li><a href="{{ route('subject.index') }}"
                       class="block px-2 py-1 rounded hover:bg-gray-100 {{ request()->routeIs('subject.*') ? 'text-blue-600 font-semibold' : '' }}">Subjects</a></li>
                <li><a href="{{ route('paper.index') }}"
                       class="block px-2 py-1 rounded hover:bg-gray-100 {{ request()->routeIs('paper.*') ? 'text-blue-600 font-semibold' : '' }}">Papers</a></li>
                <li><a href="{{ route('teacher.index') }}"
                       class="block px-2 py-1 rounded hover:bg-gray-100 {{ request()->routeIs('teacher.*') ? 'text-blue-600 font-semibold' : '' }}">Teachers</a></li>
                <li><a href="{{ route('paper_Allocation.index') }}"
                       class="block px-2 py-1 rounded hover:bg-gray-100 {{ request()->routeIs('paper_Allocation.*') ? 'text-blue-600 font-semibold' : '' }}">Paper Allocation</a></li>
                <li><a href="{{ route('paper_Upload.index') }}"
                       class="block px-2 py-1 rounded hover:bg-gray-100 {{ request()->routeIs('paper_Upload.*') ? 'text-blue-600 font-semibold' : '' }}">Paper Upload</a></li>
            </ul>
        </div>
    </nav>
</aside>
