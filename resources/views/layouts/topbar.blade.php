<header class="bg-white shadow h-16 flex items-center justify-between px-4">

    <!-- Left -->
    <div class="flex items-center gap-3">
        <button
            @click="sidebarOpen = !sidebarOpen"
            class="md:hidden text-gray-600 focus:outline-none"
        >
            <i class="fas fa-bars"></i>
        </button>

        <h1 class="text-lg font-semibold hidden md:block">
            {{ $header ?? 'Dashboard' }}
        </h1>
    </div>

    <!-- Right -->
    <div class="relative" x-data="{ open: false }">
        <button
            type="button"
            @click.stop="open = !open"
            class="flex items-center gap-2 text-gray-700 focus:outline-none"
        >
            <i class="fas fa-user-circle text-xl"></i>
            <span>{{ Auth::user()->name }}</span>
            <i class="fas fa-chevron-down text-xs"></i>
        </button>

        <!-- Dropdown -->
        <div
            :class="open ? 'block' : 'hidden'"
            @click.outside="open = false"
            class="absolute right-0 mt-2 w-48 bg-white border rounded shadow z-50"
        >
            <a href="#" class="block px-4 py-2 hover:bg-gray-100 text-sm">
                <i class="fas fa-cog mr-2"></i> Settings
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full text-left px-4 py-2 hover:bg-gray-100 text-sm"
                >
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </div>

</header>
