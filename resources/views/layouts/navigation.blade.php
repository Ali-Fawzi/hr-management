<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>
                    @can('user-list')
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                            {{ __('Users') }}
                        </x-nav-link>
                    @endcan
                    @can('role-list')
                        <x-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.index')">
                            {{ __('Roles') }}
                        </x-nav-link>
                    @endcan
                    @can('employee-list')
                        <x-nav-link :href="route('employees.index')" :active="request()->routeIs('employees.index')">
                            {{ __('Employees') }}
                        </x-nav-link>
                    @endcan
                    @can('position-list')
                        <x-nav-link :href="route('positions.index')" :active="request()->routeIs('positions.index')">
                            {{ __('Positions') }}
                        </x-nav-link>
                    @endcan
                    @can('department-list')
                        <x-nav-link :href="route('departments.index')" :active="request()->routeIs('departments.index')">
                            {{ __('Departments') }}
                        </x-nav-link>
                    @endcan
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- Notifications Dropdown -->
                <div class="relative ms-4">
                    <button id="notificationButton" class="inline-flex items-center p-2 text-gray-500 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 bg-red-600 rounded-full">
                                {{ auth()->user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </button>
                    <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-64 bg-white rounded-lg shadow-sm border border-gray-200">
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-gray-700">Notifications</h3>
                            <div class="mt-2">
                                @forelse(auth()->user()->unreadNotifications as $notification)
                                    <div class="p-2 hover:bg-gray-100 rounded-lg cursor-pointer" onclick="markAsRead('{{ $notification->id }}')">
                                        <p class="text-sm text-gray-600">{{ $notification->data['message'] }}</p>
                                        <p class="text-xs text-gray-500">{{ $notification->created_at->diffForHumans() }}</p>
                                    </div>
                                @empty
                                    <p class="text-sm text-gray-600">No new notifications.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            
                <!-- Settings Dropdown -->
                <div class="ms-4">
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>
            
                                <div class="ms-1">
                                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>
            
                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>
            
                            <x-dropdown-link :href="route('notifications.index')">
                                {{ __('Notifications') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('logs.index')">
                                {{ __('Activity Logs') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>
            </div>
            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
            @can('user-list')
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    {{ __('Users') }}
                </x-responsive-nav-link>
            @endcan
            @can('role-list')
                <x-responsive-nav-link :href="route('roles.index')" :active="request()->routeIs('roles.index')">
                    {{ __('Roles') }}
                </x-responsive-nav-link>
            @endcan
            @can('employee-list')
                <x-responsive-nav-link :href="route('employees.index')" :active="request()->routeIs('employees.index')">
                    {{ __('Employees') }}
                </x-responsive-nav-link>
            @endcan
            @can('position-list')
                <x-responsive-nav-link :href="route('positions.index')" :active="request()->routeIs('positions.index')">
                    {{ __('Positions') }}
                </x-responsive-nav-link>
            @endcan
            @can('department-list')
                <x-responsive-nav-link :href="route('departments.index')" :active="request()->routeIs('departments.index')">
                    {{ __('Department') }}
                </x-responsive-nav-link>
            @endcan
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('notifications.index')">
                    {{ __('Notifications') }}
                </x-responsive-nav-link>
                
                <x-responsive-nav-link :href="route('logs.index')">
                    {{ __('Activity Logs') }}
                </x-responsive-nav-link>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
