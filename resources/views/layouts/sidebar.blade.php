<aside
    class="fixed md:static inset-y-0 left-0 z-40 bg-white shadow-lg transition-transform duration-300 ease-in-out
           w-64"
    :class="{
        '-translate-x-full': !sidebarOpen && isMobile,
        'translate-x-0': sidebarOpen || !isMobile
    }"
>

    <!-- Header -->
    <div class="h-16 flex items-center justify-between px-4 py-3 border-b">
        <img src="{{ asset('images/logo.png') }}" class="h-8" alt="Logo">
        <span class="font-semibold text-lg">Admin Panel</span>
        

        <!-- Desktop collapse -->
        <button
            @click="sidebarOpen = !sidebarOpen"
            class="ml-auto hidden md:inline text-gray-500 hover:text-gray-700"
        >
            <i class="fas fa-angle-left" :class="{ 'rotate-180': !sidebarOpen }"></i>
        </button>

        <!-- Toggle Sidebar Button (Mobile and Desktop) -->
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-600 focus:outline-none md:hidden">
            <i class="fas fa-times"></i>
        </button>
    </div>

    

    <nav class="p-4 text-sm space-y-4" x-data="{ admin: true, academic: true }">

        <!-- ADMIN -->
        @if(Auth::user()->hasAnyRole(['Super_Admin']))
        <div>
            <button
                @click="admin = !admin"
                class="flex items-center justify-between w-full text-gray-600 uppercase text-xs font-semibold"
            >
                <span>Admin</span>
                <i class="fas fa-chevron-down transition-transform"
                   :class="{ 'rotate-180': admin }"></i>
            </button>

            <div x-show="admin" x-transition class="mt-2 space-y-1">
                <a href="{{ route('admin.users.index') }}"
                   class="block px-3 py-2 rounded {{ request()->routeIs('admin.users.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                    Manage Users
                </a>
                <a href="{{ route('admin.roles.index') }}"
                   class="block px-3 py-2 rounded {{ request()->routeIs('admin.roles.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                    Manage Roles
                </a>
                <a href="{{ route('admin.permissions.index') }}"
                   class="block px-3 py-2 rounded {{ request()->routeIs('admin.permissions.*') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                    Manage Permissions
                </a>
                <a href="{{ route('admin.roles.permissions') }}"
                   class="block px-3 py-2 rounded {{ request()->routeIs('admin.roles.permissions') ? 'bg-blue-100 text-blue-700' : 'hover:bg-gray-100' }}">
                    Role-Permission Map
                </a>
            </div>
        </div>
        @endif

        <!-- ACADEMIC -->
        <div>
            <button
                @click="academic = !academic"
                class="flex items-center justify-between w-full text-gray-600 uppercase text-xs font-semibold"
            >
                <span>Academic</span>
                <i class="fas fa-chevron-down transition-transform"
                   :class="{ 'rotate-180': academic }"></i>
            </button>

            <div x-show="academic" x-transition class="mt-2 space-y-1">
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
