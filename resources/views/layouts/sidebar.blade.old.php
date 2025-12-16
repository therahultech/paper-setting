<aside x-data="{ open: true, menu: { admin: false, academic: false } }"
       class="bg-white shadow-lg z-30 w-64 md:static absolute inset-y-0 left-0 transform transition-transform duration-200 ease-in-out"
       :class="{ '-translate-x-full': !open, 'translate-x-0': open }">

    <!-- Sidebar Header -->
    <div class="flex items-center justify-between px-4 py-3 border-b">
        <div class="flex items-center space-x-2">
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-8 w-8">
            <span class="text-lg font-semibold">Admin Panel</span>
        </div>
        <!-- Toggle Sidebar Button (Mobile and Desktop) -->
        <button @click="open = !open" class="text-gray-600 focus:outline-none md:hidden">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Sidebar Menu -->
    <nav id="sidenav-1" class="p-4 text-sm space-y-4">
        <!-- Admin Menu -->
        <div>
            <button @click="menu.admin = !menu.admin"
                    class="flex justify-between items-center w-full px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 rounded">
                <span>Admin</span>
                <i :class="menu.admin ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
            </button>
            <div x-show="menu.admin" x-collapse class="mt-1 space-y-1 pl-4">
                <a href="{{ route('admin.users.index') }}"
                   class="block px-3 py-1 rounded {{ request()->routeIs('admin.users.*') ? 'bg-gray-200' : 'hover:bg-gray-100' }}">
                    Manage Users
                </a>
                <a href="{{ route('admin.roles.index') }}"
                   class="block px-3 py-1 rounded {{ request()->routeIs('admin.roles.*') ? 'bg-gray-200' : 'hover:bg-gray-100' }}">
                    Manage Roles
                </a>
                <a href="{{ route('admin.permissions.index') }}"
                   class="block px-3 py-1 rounded {{ request()->routeIs('admin.permissions.*') ? 'bg-gray-200' : 'hover:bg-gray-100' }}">
                    Manage Permissions
                </a>
                <a href="{{ route('admin.roles.permissions') }}"
                   class="block px-3 py-1 rounded {{ request()->routeIs('admin.roles.permissions') ? 'bg-gray-200' : 'hover:bg-gray-100' }}">
                    Role-Permission Map
                </a>
            </div>
        </div>

        <!-- Academic Menu -->
        <div>
            <button @click="menu.academic = !menu.academic"
                    class="flex justify-between items-center w-full px-3 py-2 font-medium text-gray-700 hover:bg-gray-100 rounded">
                <span>Academic</span>
                <i :class="menu.academic ? 'fas fa-chevron-up' : 'fas fa-chevron-down'"></i>
            </button>
            <div x-show="menu.academic" x-collapse class="mt-1 space-y-1 pl-4">
                <a href="{{ route('department.index') }}"
                   class="block px-3 py-1 rounded {{ request()->routeIs('department.*') ? 'bg-gray-200' : 'hover:bg-gray-100' }}">
                    Departments
                </a>
                <a href="{{ route('course.index') }}"
                   class="block px-3 py-1 rounded {{ request()->routeIs('course.*') ? 'bg-gray-200' : 'hover:bg-gray-100' }}">
                    Courses
                </a>
                <a href="{{ route('subject.index') }}"
                   class="block px-3 py-1 rounded {{ request()->routeIs('subject.*') ? 'bg-gray-200' : 'hover:bg-gray-100' }}">
                    Subjects
                </a>
                <a href="{{ route('paper.index') }}"
                   class="block px-3 py-1 rounded {{ request()->routeIs('paper.*') ? 'bg-gray-200' : 'hover:bg-gray-100' }}">
                    Papers
                </a>
                <a href="{{ route('teacher.index') }}"
                   class="block px-3 py-1 rounded {{ request()->routeIs('teacher.*') ? 'bg-gray-200' : 'hover:bg-gray-100' }}">
                    Teachers
                </a>
                <a href="{{ route('paper_Allocation.index') }}"
                   class="block px-3 py-1 rounded {{ request()->routeIs('paper_Allocation.*') ? 'bg-gray-200' : 'hover:bg-gray-100' }}">
                    Paper Allocation
                </a>
                <a href="{{ route('paper_Upload.index') }}"
                   class="block px-3 py-1 rounded {{ request()->routeIs('paper_Upload.*') ? 'bg-gray-200' : 'hover:bg-gray-100' }}">
                    Paper Upload
                </a>
            </div>
        </div>
    </nav>
</aside>
