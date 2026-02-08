<<<<<<< HEAD
<aside class="w-64 bg-white border-r h-full hidden md:block" id="mobile-sidebar">
    <div class="p-4">
        <h1 class="text-xl font-bold">Vertex</h1>
        <nav class="mt-4">
            <ul>
                <li><a href="#" class="block py-2">Dashboard</a></li>
                <li><a href="#" class="block py-2">Demandas</a></li>
            </ul>
        </nav>
<aside
    class="fixed top-0 left-0 z-40 h-screen transition-transform bg-white border-r border-gray-200 dark:bg-slate-900 dark:border-slate-800 flex flex-col"
    :class="sidebarCollapsed ? 'w-20' : 'w-64'"
    aria-label="Sidebar"
>
    <div class="h-full px-3 py-4 overflow-y-auto flex flex-col">
        <!-- Logo -->
        <div class="flex items-center mb-5 pl-2.5 h-10">
            <x-icon name="layer-group" class="w-8 h-8 text-indigo-600 dark:text-indigo-400 flex-shrink-0" />
            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white ml-3 overflow-hidden" x-show="!sidebarCollapsed">
                {{ config('app.name') }}
            </span>
        </div>

        <!-- Navigation -->
        <ul class="space-y-2 font-medium flex-1">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-slate-700 group">
                    <x-icon name="chart-mixed" class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white flex-shrink-0" />
                    <span class="ml-3 whitespace-nowrap" x-show="!sidebarCollapsed">Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.backup.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-slate-700 group">
                    <x-icon name="database" class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white flex-shrink-0" />
                    <span class="ml-3 whitespace-nowrap" x-show="!sidebarCollapsed">Backups</span>
                </a>
            </li>
        </ul>

        <!-- Toggle Button (Bottom) -->
        <div class="mt-auto pt-4 border-t border-gray-200 dark:border-slate-700">
             <button @click="sidebarCollapsed = !sidebarCollapsed" class="w-full flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-slate-700 group">
                <x-icon name="arrow-left-to-line" class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white flex-shrink-0 transform transition-transform" ::class="sidebarCollapsed ? 'rotate-180' : ''" />
                <span class="ml-3 whitespace-nowrap" x-show="!sidebarCollapsed">Collapse</span>
            </button>
        </div>
=======
<aside
    class="fixed top-0 left-0 z-40 h-screen transition-all duration-300 bg-white border-r border-gray-200 dark:bg-slate-900 dark:border-slate-800"
    :class="sidebarCollapsed ? 'w-20' : 'w-64'"
>
    <!-- Header / Logo -->
    <div class="flex items-center justify-between h-16 px-4 border-b border-gray-200 dark:border-slate-800">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 truncate">
            <x-application-logo class="w-8 h-8 fill-current text-emerald-600" />
            <span class="text-lg font-bold font-poppins text-slate-800 dark:text-slate-100 truncate"
                  x-show="!sidebarCollapsed"
                  x-transition:enter="transition ease-out duration-200"
                  x-transition:enter-start="opacity-0 transform scale-90"
                  x-transition:enter-end="opacity-100 transform scale-100">
                {{ config('app.name') }}
            </span>
        </a>

        <!-- Toggle Button (Desktop) -->
        <button @click="sidebarCollapsed = !sidebarCollapsed"
                class="p-1 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:focus:ring-slate-700 hidden lg:block">
            <svg class="w-6 h-6 text-gray-500 dark:text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <div class="h-[calc(100vh-4rem)] overflow-y-auto py-4 px-3 space-y-1">

        <!-- Dashboard Link -->
        <a href="{{ route('dashboard') }}"
           class="flex items-center p-2 rounded-lg group transition-colors duration-200 font-inter
                  {{ request()->routeIs('dashboard') ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
            <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center">
               <x-icon module="Homepage" class="w-5 h-5 transition duration-75 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 {{ request()->routeIs('dashboard') ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-500 dark:text-gray-400' }}" />
            </div>
            <span class="ml-3 truncate font-medium" x-show="!sidebarCollapsed">Dashboard</span>
        </a>

        <!-- Modules Loop -->
        @foreach(config('icons.modules', []) as $module => $icon)
            @php
                $slug = Illuminate\Support\Str::slug($module);
                // Try to find a route for the module, fallback to '#' if not defined yet
                $routeName = Route::has($slug . '.index') ? route($slug . '.index') : (Route::has($slug) ? route($slug) : '#');
                $isActive = request()->routeIs($slug . '*') || request()->is($slug . '*');

                // Skip Homepage/Dashboard as it's handled above
                if ($module === 'Homepage') continue;
            @endphp

            <a href="{{ $routeName }}"
               class="flex items-center p-2 rounded-lg group transition-colors duration-200 font-inter
                      {{ $isActive ? 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400' : 'text-slate-600 dark:text-slate-400 hover:bg-gray-100 dark:hover:bg-slate-800' }}">
                <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center">
                    <x-icon module="{{ $module }}" class="w-5 h-5 transition duration-75 group-hover:text-emerald-600 dark:group-hover:text-emerald-400 {{ $isActive ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-500 dark:text-gray-400' }}" />
                </div>
                <span class="ml-3 truncate font-medium" x-show="!sidebarCollapsed">{{ $module }}</span>

                @if($isActive && !$sidebarCollapsed)
                    <div class="ml-auto w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                @endif
            </a>
        @endforeach

        <!-- Logout (Optional but common in sidebars) -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="flex items-center p-2 text-slate-600 rounded-lg dark:text-slate-400 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600 dark:hover:text-red-400 group transition-colors duration-200 font-inter">
                    <div class="flex-shrink-0 w-6 h-6 flex items-center justify-center">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400 group-hover:text-red-600 dark:group-hover:text-red-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3"/>
                        </svg>
                    </div>
                    <span class="ml-3 truncate font-medium" x-show="!sidebarCollapsed">Sair</span>
                </a>
            </form>
        </div>

>>>>>>> origin/refactor/pix-service-config-fix-9715665047343711562
    </div>
</aside>
