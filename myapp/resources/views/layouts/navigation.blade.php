<nav x-data="{ open: false }" class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-xl font-bold text-indigo-600">LMS</a>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-1 pt-4 pb-2 text-sm font-medium {{ request()->routeIs('home') ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">Home</a>
                    <a href="{{ route('courses.catalog') }}" class="inline-flex items-center px-1 pt-4 pb-2 text-sm font-medium {{ request()->routeIs('courses.catalog') ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">Courses</a>
                    @auth
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-4 pb-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'border-b-2 border-indigo-500 text-indigo-600' : 'text-gray-500 hover:text-gray-700' }}">Dashboard</a>
                    @if(auth()->user()?->isInstructor())
                    <a href="{{ route('instructor.courses.index') }}" class="inline-flex items-center px-1 pt-4 pb-2 text-sm font-medium text-gray-500 hover:text-gray-700">My Courses</a>
                    @endif
                    @if(auth()->user()?->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center px-1 pt-4 pb-2 text-sm font-medium text-gray-500 hover:text-gray-700">Admin</a>
                    @endif
                    @endauth
                </div>
            </div>
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm font-medium rounded-md text-gray-500 bg-white hover:text-gray-700">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1"><svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" /></svg></div>
                        </button>
                    </x-slot>
                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">Profile</x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();">Log Out</x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
                @else
                <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700 mr-4">Log in</a>
                <a href="{{ route('register') }}" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700">Register</a>
                @endauth
            </div>
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-500">Home</a>
            <a href="{{ route('courses.catalog') }}" class="block px-4 py-2 text-gray-500">Courses</a>
            @auth
            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-gray-500">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="block px-4 py-2 text-gray-500">Log in</a>
            <a href="{{ route('register') }}" class="block px-4 py-2 text-gray-500">Register</a>
            @endauth
        </div>
    </div>
</nav>
