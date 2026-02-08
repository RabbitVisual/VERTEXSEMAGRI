<aside
    class="fixed top-0 left-0 z-40 h-screen transition-transform bg-white border-r border-gray-200 dark:bg-slate-900 dark:border-slate-800 flex flex-col"
    :class="sidebarCollapsed ? 'w-20' : 'w-64'"
    aria-label="Sidebar"
>
    <div class="h-full px-3 py-4 overflow-y-auto flex flex-col">
        <!-- Logo -->
        <div class="flex items-center mb-5 pl-2.5 h-10">
            <x-icon name="layer-group" class="w-8 h-8 text-indigo-600 dark:text-indigo-400 flex-shrink-0" />
            <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white ml-3 overflow-hidden" x-show="!sidebarCollapsed" style="font-family: 'Poppins', sans-serif;">
                {{ config('app.name') }}
            </span>
        </div>

        <!-- Navigation -->
        <ul class="space-y-2 font-medium flex-1">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-slate-700 group {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 dark:bg-slate-700' : '' }}">
                    <x-icon name="chart-mixed" class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white flex-shrink-0" />
                    <span class="ml-3 whitespace-nowrap" x-show="!sidebarCollapsed">Dashboard</span>
                </a>
            </li>

            <!-- Dynamic Modules Loop -->
            @foreach(config('icons.modules', []) as $moduleName => $iconName)
                @if(\Nwidart\Modules\Facades\Module::has($moduleName) && \Nwidart\Modules\Facades\Module::isEnabled($moduleName))
                    <li>
                        <a href="{{ route(strtolower($moduleName) . '.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-slate-700 group {{ request()->is('admin/' . strtolower($moduleName) . '*') ? 'bg-gray-100 dark:bg-slate-700' : '' }}">
                            <x-icon name="{{ $iconName }}" class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white flex-shrink-0" />
                            <span class="ml-3 whitespace-nowrap" x-show="!sidebarCollapsed">{{ $moduleName }}</span>
                        </a>
                    </li>
                @endif
            @endforeach

            <li>
                <a href="{{ route('admin.backup.index') }}" class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-slate-700 group {{ request()->routeIs('admin.backup.*') ? 'bg-gray-100 dark:bg-slate-700' : '' }}">
                    <x-icon name="database" class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white flex-shrink-0" />
                    <span class="ml-3 whitespace-nowrap" x-show="!sidebarCollapsed">Backups</span>
                </a>
            </li>
        </ul>

        <!-- Toggle Button (Bottom) -->
        <div class="mt-auto pt-4 border-t border-gray-200 dark:border-slate-700">
             <button @click="sidebarCollapsed = !sidebarCollapsed" class="w-full flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-slate-700 group">
                <x-icon name="arrow-left-to-line" class="w-6 h-6 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white flex-shrink-0 transform transition-transform" ::class="sidebarCollapsed ? 'rotate-180' : ''" />
                <span class="ml-3 whitespace-nowrap" x-show="!sidebarCollapsed">Recolher</span>
            </button>
        </div>
    </div>
</aside>
