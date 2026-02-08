<nav class="flex flex-col h-full bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
    <!-- Header Sidebar -->
    <div class="flex items-center justify-between p-4 lg:p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Menu Principal</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">Navegação</p>
            </div>
        </div>
        <!-- Close button mobile -->
        <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('co-admin.dashboard') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('co-admin.dashboard*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 shadow-sm border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('dashboard') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                <svg class="w-5 h-5 {{ request()->routeIs('dashboard') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-3.75v3.75m-3 .75h3.75m-3.75 0h-3.75" />
                </svg>
            </div>
            <span class="flex-1">Dashboard</span>
            @if(request()->routeIs('co-admin.dashboard*'))
            <div class="w-1.5 h-1.5 rounded-full bg-indigo-600 dark:bg-indigo-400"></div>
            @endif
        </a>

        <!-- Módulos do Sistema -->
        @if(\Nwidart\Modules\Facades\Module::isEnabled('Demandas') && Route::has('co-admin.demandas.index'))
        <div class="space-y-1" data-sidebar-menu="demandas">
            <!-- Menu Principal - Demandas -->
            <button type="button" onclick="toggleSidebarSubmenu('demandas')" class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.demandas.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.demandas.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                    <x-module-icon module="demandas" class="w-5 h-5 {{ request()->routeIs('co-admin.demandas.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" />
                </div>
                <span class="flex-1 text-left">Demandas</span>
                <!-- Ícone de expansão -->
                <svg id="demandas-chevron" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.demandas.*') ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>

            <!-- Submenu Colapsável -->
            <div id="demandas-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.demandas.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.demandas.*') ? 'max-height: 500px; opacity: 1;' : '' }}">
                <!-- Listar Todas -->
                <a href="{{ route('co-admin.demandas.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.demandas.index') && !request()->has('status') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span>Listar Todas</span>
                </a>

                <!-- Nova Demanda -->
                <a href="{{ route('co-admin.demandas.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.demandas.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Nova Demanda</span>
                </a>

                <!-- Separador visual -->
                <div class="my-2 border-t border-gray-200 dark:border-gray-700"></div>

                <!-- Filtros rápidos por Status -->
                <p class="px-3 py-1 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Por Status</p>

                <a href="{{ route('co-admin.demandas.index', ['status' => 'aberta']) }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.demandas.index') && request('status') === 'aberta' ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    <span class="w-2 h-2 rounded-full bg-amber-500 flex-shrink-0"></span>
                    <span>Abertas</span>
                </a>

                <a href="{{ route('co-admin.demandas.index', ['status' => 'em_andamento']) }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.demandas.index') && request('status') === 'em_andamento' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    <span class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0"></span>
                    <span>Em Andamento</span>
                </a>

                <a href="{{ route('co-admin.demandas.index', ['status' => 'concluida']) }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.demandas.index') && request('status') === 'concluida' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 flex-shrink-0"></span>
                    <span>Concluídas</span>
                </a>

                <!-- Separador visual -->
                <div class="my-2 border-t border-gray-200 dark:border-gray-700"></div>

                <!-- Relatório -->
                <a href="{{ route('co-admin.demandas.relatorio.abertas.pdf') }}" target="_blank" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200">
                    <svg class="w-4 h-4 flex-shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span>Relatório PDF</span>
                    <svg class="w-3 h-3 ml-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </a>
            </div>
        </div>
        @endif

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Ordens') && Route::has('co-admin.ordens.index'))
        <div class="space-y-1" data-sidebar-menu="ordens">
            <button type="button" onclick="toggleSidebarSubmenu('ordens')" class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.ordens.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.ordens.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                <x-module-icon module="ordens" class="w-5 h-5 {{ request()->routeIs('co-admin.ordens.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" />
            </div>
                <span class="flex-1 text-left">Ordens de Serviço</span>
                <svg id="ordens-chevron" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.ordens.*') ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div id="ordens-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.ordens.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.ordens.*') ? 'max-height: 400px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.ordens.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.ordens.index') && !request()->has('status') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span>Listar Todas</span>
                </a>
                <a href="{{ route('co-admin.ordens.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.ordens.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50 hover:text-gray-900 dark:hover:text-gray-200' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Nova Ordem</span>
                </a>
                <div class="my-2 border-t border-gray-200 dark:border-gray-700"></div>
                <p class="px-3 py-1 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Por Status</p>
                <a href="{{ route('co-admin.ordens.index', ['status' => 'pendente']) }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request('status') === 'pendente' ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-amber-500 flex-shrink-0"></span>
                    <span>Pendentes</span>
                </a>
                <a href="{{ route('co-admin.ordens.index', ['status' => 'em_andamento']) }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request('status') === 'em_andamento' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0"></span>
                    <span>Em Execução</span>
                </a>
                <a href="{{ route('co-admin.ordens.index', ['status' => 'concluida']) }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request('status') === 'concluida' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 flex-shrink-0"></span>
                    <span>Concluídas</span>
                </a>
                <div class="my-2 border-t border-gray-200 dark:border-gray-700"></div>
                <a href="{{ route('co-admin.ordens.relatorio.demandas-dia.pdf') }}" target="_blank" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50">
                    <svg class="w-4 h-4 flex-shrink-0 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                    </svg>
                    <span>Relatório do Dia</span>
                    <svg class="w-3 h-3 ml-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                    </svg>
                </a>
            </div>
        </div>
        @endif

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Localidades') && Route::has('co-admin.localidades.index'))
        <div class="space-y-1" data-sidebar-menu="localidades">
            <button type="button" onclick="toggleSidebarSubmenu('localidades')" class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.localidades.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.localidades.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                <x-module-icon module="localidades" class="w-5 h-5 {{ request()->routeIs('co-admin.localidades.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" />
            </div>
                <span class="flex-1 text-left">Localidades</span>
                <svg id="localidades-chevron" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.localidades.*') ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div id="localidades-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.localidades.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.localidades.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.localidades.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.localidades.index') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span>Listar Todas</span>
                </a>
                <a href="{{ route('co-admin.localidades.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.localidades.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Nova Localidade</span>
                </a>
            </div>
        </div>
        @endif

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Pessoas') && Route::has('co-admin.pessoas.index'))
        <div class="space-y-1" data-sidebar-menu="pessoas">
            <button type="button" onclick="toggleSidebarSubmenu('pessoas')" class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.pessoas.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.pessoas.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                <x-module-icon module="pessoas" class="w-5 h-5 {{ request()->routeIs('co-admin.pessoas.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" />
            </div>
                <span class="flex-1 text-left">Pessoas - CadÚnico</span>
                <svg id="pessoas-chevron" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.pessoas.*') ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div id="pessoas-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.pessoas.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.pessoas.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.pessoas.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.pessoas.index') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                    <span>Buscar Pessoas</span>
                </a>
                <a href="{{ route('co-admin.pessoas.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.pessoas.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                    </svg>
                    <span>Nova Pessoa</span>
                </a>
            </div>
        </div>
        @endif

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Iluminacao') && Route::has('co-admin.iluminacao.index'))
        <div class="space-y-1" data-sidebar-menu="iluminacao">
            <button type="button" onclick="toggleSidebarSubmenu('iluminacao')" class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.iluminacao.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.iluminacao.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                <x-module-icon module="iluminacao" class="w-5 h-5 {{ request()->routeIs('co-admin.iluminacao.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" />
            </div>
                <span class="flex-1 text-left">Iluminação</span>
                <svg id="iluminacao-chevron" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.iluminacao.*') ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div id="iluminacao-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.iluminacao.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.iluminacao.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.iluminacao.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.iluminacao.index') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span>Listar Pontos</span>
                </a>
                <a href="{{ route('co-admin.iluminacao.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.iluminacao.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Novo Ponto</span>
                </a>
            </div>
        </div>
        @endif

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Agua') && Route::has('co-admin.agua.index'))
        <div class="space-y-1" data-sidebar-menu="agua">
            <button type="button" onclick="toggleSidebarSubmenu('agua')" class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.agua.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.agua.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                <x-module-icon module="agua" class="w-5 h-5 {{ request()->routeIs('co-admin.agua.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" />
            </div>
                <span class="flex-1 text-left">Água</span>
                <svg id="agua-chevron" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.agua.*') ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div id="agua-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.agua.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.agua.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.agua.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.agua.index') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span>Listar Registros</span>
                </a>
                <a href="{{ route('co-admin.agua.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.agua.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Novo Registro</span>
                </a>
            </div>
        </div>
        @endif

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Pocos') && Route::has('co-admin.pocos.index'))
        <div class="space-y-1" data-sidebar-menu="pocos">
            <button type="button" onclick="toggleSidebarSubmenu('pocos')" class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.pocos.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.pocos.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                <x-module-icon module="pocos" class="w-5 h-5 {{ request()->routeIs('co-admin.pocos.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" />
            </div>
                <span class="flex-1 text-left">Poços</span>
                <svg id="pocos-chevron" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.pocos.*') ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div id="pocos-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.pocos.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.pocos.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.pocos.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.pocos.index') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span>Listar Poços</span>
                </a>
                <a href="{{ route('co-admin.pocos.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.pocos.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Novo Poço</span>
                </a>
            </div>
        </div>
        @endif

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Estradas') && Route::has('co-admin.estradas.index'))
        <div class="space-y-1" data-sidebar-menu="estradas">
            <button type="button" onclick="toggleSidebarSubmenu('estradas')" class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.estradas.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.estradas.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                <x-module-icon module="estradas" class="w-5 h-5 {{ request()->routeIs('co-admin.estradas.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" />
            </div>
                <span class="flex-1 text-left">Estradas</span>
                <svg id="estradas-chevron" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.estradas.*') ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div id="estradas-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.estradas.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.estradas.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.estradas.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.estradas.index') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span>Listar Estradas</span>
                </a>
                <a href="{{ route('co-admin.estradas.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.estradas.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Nova Estrada</span>
                </a>
            </div>
        </div>
        @endif

        <!-- Separador -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    Recursos Humanos
                </h3>
            </div>
        </div>

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Funcionarios') && Route::has('co-admin.funcionarios.index'))
        <div class="space-y-1" data-sidebar-menu="funcionarios">
            <button type="button" onclick="toggleSidebarSubmenu('funcionarios')" class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.funcionarios.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.funcionarios.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                <x-module-icon module="funcionarios" class="w-5 h-5 {{ request()->routeIs('co-admin.funcionarios.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" />
            </div>
                <span class="flex-1 text-left">Funcionários</span>
                <svg id="funcionarios-chevron" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.funcionarios.*') ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div id="funcionarios-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.funcionarios.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.funcionarios.*') ? 'max-height: 300px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.funcionarios.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.funcionarios.index') && !request()->routeIs('co-admin.funcionarios.status.*') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 6.75h12M8.25 12h12m-12 5.25h12M3.75 6.75h.007v.008H3.75V6.75zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zM3.75 12h.007v.008H3.75V12zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm-.375 5.25h.007v.008H3.75v-.008zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                    </svg>
                    <span>Listar Todos</span>
                </a>
                <a href="{{ route('co-admin.funcionarios.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.funcionarios.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zM4 19.235v-.11a6.375 6.375 0 0112.75 0v.109A12.318 12.318 0 0110.374 21c-2.331 0-4.512-.645-6.374-1.766z" />
                    </svg>
                    <span>Novo Funcionário</span>
                </a>
                <div class="my-2 border-t border-gray-200 dark:border-gray-700"></div>
                @if(Route::has('co-admin.funcionarios.status.index'))
                <a href="{{ route('co-admin.funcionarios.status.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.funcionarios.status.*') ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>Monitorar Status</span>
                </a>
                @endif
            </div>
        </div>
        @endif

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Equipes') && Route::has('co-admin.equipes.index'))
        <div class="space-y-1" data-sidebar-menu="equipes">
            <button type="button" onclick="toggleSidebarSubmenu('equipes')" class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.equipes.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.equipes.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                <x-module-icon module="equipes" class="w-5 h-5 {{ request()->routeIs('co-admin.equipes.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" />
            </div>
                <span class="flex-1 text-left">Equipes</span>
                <svg id="equipes-chevron" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.equipes.*') ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div id="equipes-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.equipes.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.equipes.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.equipes.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.equipes.index') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                    </svg>
                    <span>Listar Equipes</span>
                </a>
                <a href="{{ route('co-admin.equipes.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.equipes.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Nova Equipe</span>
                </a>
            </div>
        </div>
        @endif

        <!-- Separador -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.75 7.5h16.5m-1.8-10H5.55c-.512 0-.96.384-1.05.888L3.75 7.5h16.5l-1.8-10.112c-.09-.504-.538-.888-1.05-.888z" />
                    </svg>
                    Estoque
                </h3>
            </div>
        </div>

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Materiais') && Route::has('co-admin.materiais.index'))
        <div class="space-y-1" data-sidebar-menu="materiais">
            <button type="button" onclick="toggleSidebarSubmenu('materiais')" class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.materiais.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.materiais.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                <x-module-icon module="materiais" class="w-5 h-5 {{ request()->routeIs('co-admin.materiais.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" />
            </div>
                <span class="flex-1 text-left">Materiais</span>
                <svg id="materiais-chevron" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.materiais.*') ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div id="materiais-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.materiais.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.materiais.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.materiais.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.materiais.index') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.75 7.5h16.5m-1.8-10H5.55c-.512 0-.96.384-1.05.888L3.75 7.5h16.5l-1.8-10.112c-.09-.504-.538-.888-1.05-.888z" />
                    </svg>
                    <span>Estoque</span>
                </a>
                <a href="{{ route('co-admin.materiais.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.materiais.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                    <span>Novo Material</span>
                </a>
            </div>
        </div>
        @endif

        <!-- Separador -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    Relatórios
                </h3>
            </div>
        </div>

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Relatorios') && Route::has('co-admin.relatorios.index'))
        <div class="space-y-1" data-sidebar-menu="relatorios">
            <button type="button" onclick="toggleSidebarSubmenu('relatorios')" class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.relatorios.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                <x-module-icon module="relatorios" class="w-5 h-5 {{ request()->routeIs('co-admin.relatorios.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" />
            </div>
                <span class="flex-1 text-left">Relatórios</span>
                <svg id="relatorios-chevron" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.relatorios.*') ? 'rotate-180' : '' }}" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                </svg>
            </button>
            <div id="relatorios-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.relatorios.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.relatorios.*') ? 'max-height: 800px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.relatorios.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.index') && !request()->routeIs('co-admin.relatorios.index.*') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span>Painel Geral</span>
                </a>
                <div class="my-2 border-t border-gray-200 dark:border-gray-700"></div>
                <p class="px-3 py-1 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Por Módulo</p>
                @if(Route::has('co-admin.relatorios.demandas'))
                <a href="{{ route('co-admin.relatorios.demandas') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.demandas') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-amber-500 flex-shrink-0"></span>
                    <span>Demandas</span>
                </a>
                @endif
                @if(Route::has('co-admin.relatorios.ordens'))
                <a href="{{ route('co-admin.relatorios.ordens') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.ordens') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0"></span>
                    <span>Ordens de Serviço</span>
                </a>
                @endif
                @if(Route::has('co-admin.relatorios.materiais'))
                <a href="{{ route('co-admin.relatorios.materiais') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.materiais') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-purple-500 flex-shrink-0"></span>
                    <span>Materiais</span>
                </a>
                @endif
                @if(Route::has('co-admin.relatorios.equipes'))
                <a href="{{ route('co-admin.relatorios.equipes') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.equipes') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 flex-shrink-0"></span>
                    <span>Equipes</span>
                </a>
                @endif
                @if(Route::has('co-admin.relatorios.infraestrutura'))
                <a href="{{ route('co-admin.relatorios.infraestrutura') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.infraestrutura') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-teal-500 flex-shrink-0"></span>
                    <span>Infraestrutura</span>
                </a>
                @endif
                @if(Route::has('co-admin.relatorios.geral'))
                <a href="{{ route('co-admin.relatorios.geral') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.geral') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-green-500 flex-shrink-0"></span>
                    <span>Relatório Geral</span>
                </a>
                @endif
                <div class="my-2 border-t border-gray-200 dark:border-gray-700"></div>
                <p class="px-3 py-1 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Análises</p>
                @if(Route::has('co-admin.relatorios.analise.temporal'))
                <a href="{{ route('co-admin.relatorios.analise.temporal') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.analise.temporal') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-cyan-500 flex-shrink-0"></span>
                    <span>Temporal</span>
                </a>
                @endif
                @if(Route::has('co-admin.relatorios.analise.geografica'))
                <a href="{{ route('co-admin.relatorios.analise.geografica') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.analise.geografica') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-indigo-500 flex-shrink-0"></span>
                    <span>Geográfica</span>
                </a>
                @endif
                @if(Route::has('co-admin.relatorios.analise.performance'))
                <a href="{{ route('co-admin.relatorios.analise.performance') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.analise.performance') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-orange-500 flex-shrink-0"></span>
                    <span>Performance</span>
                </a>
                @endif
                <div class="my-2 border-t border-gray-200 dark:border-gray-700"></div>
                <p class="px-3 py-1 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Outros</p>
                @if(Route::has('co-admin.relatorios.notificacoes'))
                <a href="{{ route('co-admin.relatorios.notificacoes') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.notificacoes') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-pink-500 flex-shrink-0"></span>
                    <span>Notificações</span>
                </a>
                @endif
                @if(Route::has('co-admin.relatorios.auditoria'))
                <a href="{{ route('co-admin.relatorios.auditoria') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.auditoria') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-slate-500 flex-shrink-0"></span>
                    <span>Auditoria</span>
                </a>
                @endif
                @if(Route::has('co-admin.relatorios.usuarios'))
                <a href="{{ route('co-admin.relatorios.usuarios') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.usuarios') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-rose-500 flex-shrink-0"></span>
                    <span>Usuários</span>
                </a>
                @endif
            </div>
        </div>
        @endif

        <!-- Separador -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                    </svg>
                    Comunicação
                </h3>
            </div>
        </div>

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Chat') && Route::has('co-admin.chat.index'))
        <a href="{{ route('co-admin.chat.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.chat.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.chat.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                <svg class="w-5 h-5 {{ request()->routeIs('co-admin.chat.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                </svg>
            </div>
            <span class="flex-1">Chat</span>
        </a>
        @endif
    </div>

    <!-- Footer Sidebar -->
    <div class="flex-shrink-0 p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
        <div class="text-center">
            <p class="text-xs font-semibold text-gray-600 dark:text-gray-400">VERTEXSEMAGRI</p>
            <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">v1.0.0</p>
        </div>
    </div>
</nav>

<script>
/**
 * Toggle para submenus colapsáveis do sidebar
 * @param {string} menuId - ID do menu (ex: 'demandas')
 */
function toggleSidebarSubmenu(menuId) {
    const submenu = document.getElementById(menuId + '-submenu');
    const chevron = document.getElementById(menuId + '-chevron');

    if (!submenu) return;

    const isExpanded = submenu.style.maxHeight && submenu.style.maxHeight !== '0px';

    if (isExpanded) {
        // Fechar
        submenu.style.maxHeight = '0px';
        submenu.style.opacity = '0';
        if (chevron) chevron.classList.remove('rotate-180');
    } else {
        // Abrir
        submenu.style.maxHeight = submenu.scrollHeight + 'px';
        submenu.style.opacity = '1';
        if (chevron) chevron.classList.add('rotate-180');
    }
}

// Inicializar submenus que devem estar abertos (baseado na rota atual)
document.addEventListener('DOMContentLoaded', function() {
    // Verificar todos os submenus e ajustar max-height para os que estão abertos
    const openSubmenus = document.querySelectorAll('[id$="-submenu"]');
    openSubmenus.forEach(function(submenu) {
        if (submenu.style.opacity === '1' || submenu.classList.contains('expanded')) {
            submenu.style.maxHeight = submenu.scrollHeight + 'px';
        }
    });
});
</script>
