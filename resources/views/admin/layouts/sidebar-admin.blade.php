<aside class="flex flex-col h-full bg-white dark:bg-slate-800 border-r border-gray-200 dark:border-slate-700">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between p-4 lg:p-6 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center shadow-md">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Menu Admin</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">Navegação</p>
            </div>
        </div>
    </div>

    <!-- Navigation - Scrollable -->
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard*') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.dashboard*') ? 'bg-emerald-500 dark:bg-emerald-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-3.75v3.75m-3 .75h3.75m-3.75 0h-3.75" />
                </svg>
            </div>
            <span class="flex-1">Dashboard</span>
        </a>

        <!-- Operacional -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Operacional</h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Demandas'))
                <a href="{{ route('admin.demandas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.demandas.*') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.demandas.*') ? 'bg-emerald-500 dark:bg-emerald-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="demandas" class="w-5 h-5 {{ request()->routeIs('admin.demandas.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Demandas</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Ordens'))
                <a href="{{ route('admin.ordens.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.ordens.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.ordens.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="ordens" class="w-5 h-5 {{ request()->routeIs('admin.ordens.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Ordens de Serviço</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Infraestrutura -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Infraestrutura</h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Iluminacao'))
                <a href="{{ route('admin.iluminacao.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.iluminacao.*') ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.iluminacao.*') ? 'bg-yellow-500 dark:bg-yellow-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="iluminacao" class="w-5 h-5 {{ request()->routeIs('admin.iluminacao.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Iluminação</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Materiais'))
                <a href="{{ route('admin.materiais.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.materiais.*') ? 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.materiais.*') ? 'bg-teal-500 dark:bg-teal-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="materiais" class="w-5 h-5 {{ request()->routeIs('admin.materiais.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Materiais</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Gestão Administrativa -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Administrativo</h3>
            </div>
            <div class="space-y-1">
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.users.*') ? 'bg-emerald-500 dark:bg-emerald-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="user-group" class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Usuários</span>
                </a>

                @if(Route::has('admin.config.index'))
                <a href="{{ route('admin.config.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.config.*') ? 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.config.*') ? 'bg-slate-500 dark:bg-slate-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="cog" class="w-5 h-5 {{ request()->routeIs('admin.config.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Configurações</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Monitoramento -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400">Monitoramento</h3>
            </div>
            <div class="space-y-1">
                @if(Route::has('admin.audit.index'))
                <a href="{{ route('admin.audit.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.audit.*') ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.audit.*') ? 'bg-red-500 dark:bg-red-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="clipboard-document-list" class="w-5 h-5 {{ request()->routeIs('admin.audit.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Logs de Auditoria</span>
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="p-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-900/20 transition-all duration-200">
                <x-icon name="arrow-left-on-rectangle" class="w-5 h-5" />
                Sair do Sistema
            </button>
        </form>
    </div>
</aside>
