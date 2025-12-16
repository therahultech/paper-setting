<aside class="bg-white w-64 shadow-lg flex-shrink-0 transform transition-transform duration-200 ease-in-out md:translate-x-0 md:static absolute inset-y-0 left-0 z-30" :class="{ '-translate-x-full': !sidebarOpen }">
    <div class="h-16 flex items-center justify-between px-4 border-b">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8">
            <span class="text-lg font-semibold">Admin Panel</span>
        </div>
        <button class="md:hidden text-gray-600" @click="sidebarOpen = false">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <nav class="p-4 text-sm" x-data="{ adminOpen: true, academicOpen: true }">
        <!-- Admin Section -->
        <div class="mb-2">
            <button @click="adminOpen = !adminOpen" class="w-full text-left px-4 py-2 font-semibold text-gray-600 hover:text-black flex justify-between items-center">
                <span>Admin</span>
                <i :class="adminOpen ? 'fa fa-chevron-down' : 'fa fa-chevron-right'" class="text-xs"></i>
            </button>
            <ul x-show="adminOpen" class="pl-4 space-y-1 mt-2">
                <li><a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'text-blue-600 font-medium' : '' }} block px-2 py-1 rounded hover:bg-gray-100">Manage Users</a></li>
                <li><a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'text-blue-600 font-medium' : '' }} block px-2 py-1 rounded hover:bg-gray-100">Manage Roles</a></li>
                <li><a href="{{ route('admin.permissions.index') }}" class="{{ request()->routeIs('admin.permissions.*') ? 'text-blue-600 font-medium' : '' }} block px-2 py-1 rounded hover:bg-gray-100">Manage Permissions</a></li>
                <li><a href="{{ route('admin.roles.permissions') }}" class="{{ request()->routeIs('admin.roles.permissions') ? 'text-blue-600 font-medium' : '' }} block px-2 py-1 rounded hover:bg-gray-100">Role-Permission Map</a></li>
            </ul>
        </div>

        <!-- Academic Section -->
        <div class="mb-2">
            <button @click="academicOpen = !academicOpen" class="w-full text-left px-4 py-2 font-semibold text-gray-600 hover:text-black flex justify-between items-center">
                <span>Academic</span>
                <i :class="academicOpen ? 'fa fa-chevron-down' : 'fa fa-chevron-right'" class="text-xs"></i>
            </button>
            <ul x-show="academicOpen" class="pl-4 space-y-1 mt-2">
                <li><a href="{{ route('department.index') }}" class="{{ request()->routeIs('department.*') ? 'text-blue-600 font-medium' : '' }} block px-2 py-1 hover:bg-gray-100">Departments</a></li>
                <li><a href="{{ route('course.index') }}" class="{{ request()->routeIs('course.*') ? 'text-blue-600 font-medium' : '' }} block px-2 py-1 hover:bg-gray-100">Courses</a></li>
                <li><a href="{{ route('subject.index') }}" class="{{ request()->routeIs('subject.*') ? 'text-blue-600 font-medium' : '' }} block px-2 py-1 hover:bg-gray-100">Subjects</a></li>
                <li><a href="{{ route('paper.index') }}" class="{{ request()->routeIs('paper.*') ? 'text-blue-600 font-medium' : '' }} block px-2 py-1 hover:bg-gray-100">Papers</a></li>
                <li><a href="{{ route('teacher.index') }}" class="{{ request()->routeIs('teacher.*') ? 'text-blue-600 font-medium' : '' }} block px-2 py-1 hover:bg-gray-100">Teachers</a></li>
                <li><a href="{{ route('paper_Allocation.index') }}" class="{{ request()->routeIs('paper_Allocation.*') ? 'text-blue-600 font-medium' : '' }} block px-2 py-1 hover:bg-gray-100">Paper Allocation</a></li>
                <li><a href="{{ route('paper_Upload.index') }}" class="{{ request()->routeIs('paper_Upload.*') ? 'text-blue-600 font-medium' : '' }} block px-2 py-1 hover:bg-gray-100">Paper Upload</a></li>
            </ul>
        </div>
    </nav>
</aside>
