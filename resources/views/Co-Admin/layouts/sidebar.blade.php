<nav class="flex flex-col h-full bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700">
    <!-- Header Sidebar -->
    <div class="flex items-center justify-between p-4 lg:p-6 border-b border-gray-200 dark:border-gray-700">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                <x-icon name="grid-2" class="w-6 h-6 text-white" />
            </div>
            <div class="flex flex-col">
                <span class="text-sm font-bold text-gray-900 dark:text-white leading-tight">Painel</span>
                <span class="text-xs font-medium text-indigo-600 dark:text-indigo-400">Co-Administrativo</span>
            </div>
        </div>
    </div>

    <!-- Navigation Menu -->
    <div class="flex-1 overflow-y-auto py-4 px-3 custom-scrollbar">
        <div class="space-y-1">
            <a href="{{ route('co-admin.dashboard') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.dashboard') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
                <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.dashboard') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                    <x-icon name="chart-mixed" class="w-5 h-5 {{ request()->routeIs('co-admin.dashboard') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" />
                </div>
                <span class="font-medium">Dashboard</span>
            </a>
        </div>

        <!-- Módulos do Sistema -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <x-icon name="cubes" class="w-3.5 h-3.5" />
                    Módulos do Sistema
                </h3>
            </div>
        </div>

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Demandas') && Route::has('co-admin.demandas.index'))
        <div class="space-y-1" data-sidebar-menu="demandas">
            <button type="button" onclick="toggleSidebarSubmenu('demandas')" class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.demandas.*') ? 'bg-amber-50 dark:bg-amber-900/20 text-amber-600 dark:text-amber-400 border border-amber-200 dark:border-amber-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.demandas.*') ? 'bg-amber-500 dark:bg-amber-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-amber-100 dark:group-hover:bg-amber-900/30' }} transition-colors">
                <x-module-icon module="demandas" class="w-5 h-5 {{ request()->routeIs('co-admin.demandas.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-amber-600 dark:group-hover:text-amber-400' }}" />
            </div>
                <span class="flex-1 text-left">Demandas</span>
                <x-icon id="demandas-chevron" name="chevron-down" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.demandas.*') ? 'rotate-180' : '' }}" />
            </button>
            <div id="demandas-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.demandas.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.demandas.*') ? 'max-height: 500px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.demandas.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.demandas.index') && !request()->has('status') ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="list" class="w-4 h-4 flex-shrink-0" />
                    <span>Listar Todas</span>
                </a>
                <a href="{{ route('co-admin.demandas.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.demandas.create') ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="plus" class="w-4 h-4 flex-shrink-0" />
                    <span>Nova Demanda</span>
                </a>
                <div class="my-2 border-t border-gray-200 dark:border-gray-700"></div>
                <p class="px-3 py-1 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Por Status</p>
                <a href="{{ route('co-admin.demandas.index', ['status' => 'aberta']) }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request('status') === 'aberta' ? 'bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-amber-500 flex-shrink-0"></span>
                    <span>Abertas</span>
                </a>
                <a href="{{ route('co-admin.demandas.index', ['status' => 'em_andamento']) }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request('status') === 'em_andamento' ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-blue-500 flex-shrink-0"></span>
                    <span>Em Andamento</span>
                </a>
                <a href="{{ route('co-admin.demandas.index', ['status' => 'concluida']) }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request('status') === 'concluida' ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 flex-shrink-0"></span>
                    <span>Concluídas</span>
                </a>
                @if(Route::has('co-admin.demandas.relatorio.abertas.pdf'))
                <div class="my-2 border-t border-gray-200 dark:border-gray-700"></div>
                <a href="{{ route('co-admin.demandas.relatorio.abertas.pdf') }}" target="_blank" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50">
                    <x-icon name="file-pdf" class="w-4 h-4 flex-shrink-0 text-red-500" />
                    <span>Relatório PDF</span>
                    <x-icon name="arrow-up-right-from-square" class="w-3 h-3 ml-auto text-gray-400" />
                </a>
                @endif
            </div>
        </div>
        @endif

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Ordens') && Route::has('co-admin.ordens.index'))
        <div class="space-y-1" data-sidebar-menu="ordens">
            <button type="button" onclick="toggleSidebarSubmenu('ordens')" class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.ordens.*') ? 'bg-blue-50 dark:bg-blue-900/20 text-blue-600 dark:text-blue-400 border border-blue-200 dark:border-blue-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.ordens.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/30' }} transition-colors">
                <x-module-icon module="ordens" class="w-5 h-5 {{ request()->routeIs('co-admin.ordens.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-400' }}" />
            </div>
                <span class="flex-1 text-left">Ordens de Serviço</span>
                <x-icon id="ordens-chevron" name="chevron-down" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.ordens.*') ? 'rotate-180' : '' }}" />
            </button>
            <div id="ordens-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.ordens.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.ordens.*') ? 'max-height: 400px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.ordens.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.ordens.index') && !request()->has('status') ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="list" class="w-4 h-4 flex-shrink-0" />
                    <span>Listar Todas</span>
                </a>
                <a href="{{ route('co-admin.ordens.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.ordens.create') ? 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="plus" class="w-4 h-4 flex-shrink-0" />
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
                @if(Route::has('co-admin.ordens.relatorio.demandas-dia.pdf'))
                <div class="my-2 border-t border-gray-200 dark:border-gray-700"></div>
                <a href="{{ route('co-admin.ordens.relatorio.demandas-dia.pdf') }}" target="_blank" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50">
                    <x-icon name="file-pdf" class="w-4 h-4 flex-shrink-0 text-red-500" />
                    <span>Relatório do Dia</span>
                    <x-icon name="arrow-up-right-from-square" class="w-3 h-3 ml-auto text-gray-400" />
                </a>
                @endif
            </div>
        </div>
        @endif

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Localidades') && Route::has('co-admin.localidades.index'))
        <div class="space-y-1" data-sidebar-menu="localidades">
            <button type="button" onclick="toggleSidebarSubmenu('localidades')" class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.localidades.*') ? 'bg-emerald-50 dark:bg-emerald-900/20 text-emerald-600 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.localidades.*') ? 'bg-emerald-500 dark:bg-emerald-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-emerald-100 dark:group-hover:bg-emerald-900/30' }} transition-colors">
                <x-module-icon module="localidades" class="w-5 h-5 {{ request()->routeIs('co-admin.localidades.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-emerald-600 dark:group-hover:text-emerald-400' }}" />
            </div>
                <span class="flex-1 text-left">Localidades</span>
                <x-icon id="localidades-chevron" name="chevron-down" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.localidades.*') ? 'rotate-180' : '' }}" />
            </button>
            <div id="localidades-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.localidades.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.localidades.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.localidades.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.localidades.index') ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="list" class="w-4 h-4 flex-shrink-0" />
                    <span>Listar Todas</span>
                </a>
                <a href="{{ route('co-admin.localidades.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.localidades.create') ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="plus" class="w-4 h-4 flex-shrink-0" />
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
                <span class="flex-1 text-left">Pessoas</span>
                <x-icon id="pessoas-chevron" name="chevron-down" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.pessoas.*') ? 'rotate-180' : '' }}" />
            </button>
            <div id="pessoas-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.pessoas.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.pessoas.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.pessoas.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.pessoas.index') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="magnifying-glass" class="w-4 h-4 flex-shrink-0" />
                    <span>Buscar Pessoas</span>
                </a>
                <a href="{{ route('co-admin.pessoas.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.pessoas.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="user-plus" class="w-4 h-4 flex-shrink-0" />
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
                <x-icon id="iluminacao-chevron" name="chevron-down" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.iluminacao.*') ? 'rotate-180' : '' }}" />
            </button>
            <div id="iluminacao-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.iluminacao.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.iluminacao.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.iluminacao.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.iluminacao.index') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="list" class="w-4 h-4 flex-shrink-0" />
                    <span>Listar Pontos</span>
                </a>
                <a href="{{ route('co-admin.iluminacao.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.iluminacao.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="plus" class="w-4 h-4 flex-shrink-0" />
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
                <x-icon id="agua-chevron" name="chevron-down" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.agua.*') ? 'rotate-180' : '' }}" />
            </button>
            <div id="agua-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.agua.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.agua.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.agua.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.agua.index') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="list" class="w-4 h-4 flex-shrink-0" />
                    <span>Listar Registros</span>
                </a>
                <a href="{{ route('co-admin.agua.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.agua.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="plus" class="w-4 h-4 flex-shrink-0" />
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
                <x-icon id="pocos-chevron" name="chevron-down" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.pocos.*') ? 'rotate-180' : '' }}" />
            </button>
            <div id="pocos-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.pocos.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.pocos.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.pocos.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.pocos.index') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="list" class="w-4 h-4 flex-shrink-0" />
                    <span>Listar Poços</span>
                </a>
                <a href="{{ route('co-admin.pocos.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.pocos.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="plus" class="w-4 h-4 flex-shrink-0" />
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
                <x-icon id="estradas-chevron" name="chevron-down" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.estradas.*') ? 'rotate-180' : '' }}" />
            </button>
            <div id="estradas-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.estradas.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.estradas.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.estradas.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.estradas.index') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="list" class="w-4 h-4 flex-shrink-0" />
                    <span>Listar Estradas</span>
                </a>
                <a href="{{ route('co-admin.estradas.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.estradas.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="plus" class="w-4 h-4 flex-shrink-0" />
                    <span>Nova Estrada</span>
                </a>
            </div>
        </div>
        @endif

        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <x-icon name="users" class="w-3.5 h-3.5" />
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
                <x-icon id="funcionarios-chevron" name="chevron-down" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.funcionarios.*') ? 'rotate-180' : '' }}" />
            </button>
            <div id="funcionarios-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.funcionarios.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.funcionarios.*') ? 'max-height: 300px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.funcionarios.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.funcionarios.index') && !request()->routeIs('co-admin.funcionarios.status.*') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="list" class="w-4 h-4 flex-shrink-0" />
                    <span>Listar Todos</span>
                </a>
                <a href="{{ route('co-admin.funcionarios.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.funcionarios.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="user-plus" class="w-4 h-4 flex-shrink-0" />
                    <span>Novo Funcionário</span>
                </a>
                <div class="my-2 border-t border-gray-200 dark:border-gray-700"></div>
                @if(Route::has('co-admin.funcionarios.status.index'))
                <a href="{{ route('co-admin.funcionarios.status.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.funcionarios.status.*') ? 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="circle-check" class="w-4 h-4 flex-shrink-0 text-emerald-500" />
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
                <x-icon id="equipes-chevron" name="chevron-down" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.equipes.*') ? 'rotate-180' : '' }}" />
            </button>
            <div id="equipes-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.equipes.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.equipes.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.equipes.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.equipes.index') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="users" class="w-4 h-4 flex-shrink-0" />
                    <span>Listar Equipes</span>
                </a>
                <a href="{{ route('co-admin.equipes.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.equipes.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="plus" class="w-4 h-4 flex-shrink-0" />
                    <span>Nova Equipe</span>
                </a>
            </div>
        </div>
        @endif

        <!-- Separador -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <x-icon name="boxes-stacked" class="w-3.5 h-3.5" />
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
                <x-icon id="materiais-chevron" name="chevron-down" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.materiais.*') ? 'rotate-180' : '' }}" />
            </button>
            <div id="materiais-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.materiais.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.materiais.*') ? 'max-height: 200px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.materiais.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.materiais.index') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="boxes-stacked" class="w-4 h-4 flex-shrink-0" />
                    <span>Estoque</span>
                </a>
                <a href="{{ route('co-admin.materiais.create') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.materiais.create') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="plus" class="w-4 h-4 flex-shrink-0" />
                    <span>Novo Material</span>
                </a>
            </div>
        </div>
        @endif

        <!-- Separador -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <x-icon name="chart-column" class="w-3.5 h-3.5" />
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
                <x-icon id="relatorios-chevron" name="chevron-down" class="w-4 h-4 transition-transform duration-300 {{ request()->routeIs('co-admin.relatorios.*') ? 'rotate-180' : '' }}" />
            </button>
            <div id="relatorios-submenu" class="ml-4 pl-4 border-l-2 border-gray-200 dark:border-gray-700 space-y-1 overflow-hidden transition-all duration-300 ease-in-out {{ request()->routeIs('co-admin.relatorios.*') ? '' : 'max-h-0 opacity-0' }}" style="{{ request()->routeIs('co-admin.relatorios.*') ? 'max-height: 800px; opacity: 1;' : '' }}">
                <a href="{{ route('co-admin.relatorios.index') }}" class="group flex items-center gap-3 px-3 py-2 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.index') && !request()->routeIs('co-admin.relatorios.index.*') ? 'bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 font-medium' : 'text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700/50' }}">
                    <x-icon name="home-chimney" class="w-4 h-4 flex-shrink-0" />
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
                    <x-icon name="message-dots" class="w-3.5 h-3.5" />
                    Comunicação
                </h3>
            </div>
        </div>

        @if(\Nwidart\Modules\Facades\Module::isEnabled('Chat') && Route::has('co-admin.chat.index'))
        <a href="{{ route('co-admin.chat.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('co-admin.chat.*') ? 'bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.chat.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-gray-700 group-hover:bg-indigo-100 dark:group-hover:bg-indigo-900/30' }} transition-colors">
                <x-icon name="message-dots" class="w-5 h-5 {{ request()->routeIs('co-admin.chat.*') ? 'text-white' : 'text-gray-500 dark:text-gray-400 group-hover:text-indigo-600 dark:group-hover:text-indigo-400' }}" />
            </div>
            <span class="flex-1">Chat</span>
        </a>
        @endif
    </div>

    <!-- Footer Sidebar -->
    <div class="flex-shrink-0 p-4 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
        <div class="text-center">
            <div class="flex items-center justify-center gap-2 mb-1">
                <x-icon name="shield-check" class="w-4 h-4 text-gray-400 dark:text-gray-500" />
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">VERTEXSEMAGRI</p>
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500">v1.0.26</p>
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
