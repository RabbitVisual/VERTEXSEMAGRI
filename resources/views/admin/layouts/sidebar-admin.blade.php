<aside class="flex flex-col h-full bg-white dark:bg-slate-800 border-r border-gray-200 dark:border-slate-700">
    <style>
        aside::-webkit-scrollbar {
            width: 6px;
        }
        aside::-webkit-scrollbar-track {
            background: rgb(241 245 249);
            border-radius: 3px;
        }
        aside::-webkit-scrollbar-thumb {
            background: rgb(203 213 225);
            border-radius: 3px;
        }
        aside::-webkit-scrollbar-thumb:hover {
            background: rgb(148 163 184);
        }
        .dark aside::-webkit-scrollbar-track {
            background: rgb(30 41 59);
        }
        .dark aside::-webkit-scrollbar-thumb {
            background: rgb(71 85 105);
        }
        .dark aside::-webkit-scrollbar-thumb:hover {
            background: rgb(100 116 139);
        }
    </style>

    <!-- Sidebar Header -->
    <div class="flex items-center justify-between p-4 lg:p-6 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center shadow-md">
                <x-icon name="eye" class="w-5 h-5" />
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Menu Admin</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">Navegação</p>
            </div>
        </div>
        <!-- Close button mobile -->
        <button onclick="toggleAdminSidebar()" class="lg:hidden p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-slate-700 dark:hover:text-gray-300">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
            <span class="sr-only">Fechar menu</span>
        </button>
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
            @if(request()->routeIs('admin.dashboard*'))
            <span class="inline-flex items-center justify-center w-2 h-2 p-1 bg-emerald-500 rounded-full"></span>
            @endif
        </a>

        <!-- Operacional -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .414-.336.75-.75.75h-4.5a.75.75 0 01-.75-.75v-4.25m0 0l-4.5-4.5m4.5 4.5l4.5-4.5M3.75 19.5h4.5a.75.75 0 00.75-.75v-4.25m0 0L8.25 9.75m-4.5 4.5l4.5 4.5" />
                    </svg>
                    Operacional
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Demandas') && Route::has('admin.demandas.index'))
                <a href="{{ route('admin.demandas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.demandas.*') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.demandas.*') ? 'bg-emerald-500 dark:bg-emerald-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="demandas" class="w-5 h-5 {{ request()->routeIs('admin.demandas.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Demandas</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Ordens') && Route::has('admin.ordens.index'))
                <a href="{{ route('admin.ordens.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.ordens.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.ordens.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="ordens" class="w-5 h-5 {{ request()->routeIs('admin.ordens.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Ordens de Serviço</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Localidades') && Route::has('admin.localidades.index'))
                <a href="{{ route('admin.localidades.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.localidades.*') ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.localidades.*') ? 'bg-amber-500 dark:bg-amber-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="localidades" class="w-5 h-5 {{ request()->routeIs('admin.localidades.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Localidades</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Pessoas') && Route::has('admin.pessoas.index'))
                <a href="{{ route('admin.pessoas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.pessoas.*') ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.pessoas.*') ? 'bg-purple-500 dark:bg-purple-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="pessoas" class="w-5 h-5 {{ request()->routeIs('admin.pessoas.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Pessoas - CadÚnico</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Infraestrutura -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008V14.25m.75 3.75h.008v.008h-.008V18m-3.75-3.75h.008v.008h-.008V14.25m.75 3.75h.008v.008h-.008V18" />
                    </svg>
                    Infraestrutura
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Iluminacao'))
                    @if(Route::has('admin.iluminacao.index'))
                    <a href="{{ route('admin.iluminacao.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.iluminacao.index*') ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.iluminacao.index*') ? 'bg-yellow-500 dark:bg-yellow-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                            <x-module-icon module="iluminacao" class="w-5 h-5 {{ request()->routeIs('admin.iluminacao.index*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                        </div>
                        <span class="flex-1">Iluminação</span>
                    </a>
                    @endif

                    @if(Route::has('admin.iluminacao.postes.index'))
                    <a href="{{ route('admin.iluminacao.postes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.iluminacao.postes.*') ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                        <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.iluminacao.postes.*') ? 'bg-yellow-500 dark:bg-yellow-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                            <svg class="w-5 h-5 {{ request()->routeIs('admin.iluminacao.postes.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m4.5 0a12.05 12.05 0 004.5 0m0 0a12.05 12.05 0 00-4.5 0m4.5 0v5.25M9 18v-5.25m0 0a6.01 6.01 0 00-1.5-.189M9 12.75a6.01 6.01 0 011.5-.189m-1.5.189a6.01 6.01 0 00-1.5-.189m1.5.189v5.25m0 0a12.05 12.05 0 01-4.5 0m4.5 0v5.25" />
                            </svg>
                        </div>
                        <span class="flex-1">Postes (Neoenergia)</span>
                    </a>
                    @endif
                @endif


                @if(\Nwidart\Modules\Facades\Module::isEnabled('Agua') && Route::has('admin.agua.index'))
                <a href="{{ route('admin.agua.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.agua.*') ? 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.agua.*') ? 'bg-cyan-500 dark:bg-cyan-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="agua" class="w-5 h-5 {{ request()->routeIs('admin.agua.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Água</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Pocos') && Route::has('admin.pocos.index'))
                <a href="{{ route('admin.pocos.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.pocos.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.pocos.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="pocos" class="w-5 h-5 {{ request()->routeIs('admin.pocos.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Poços</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Pocos') && Route::has('admin.lideres-comunidade.index'))
                <a href="{{ route('admin.lideres-comunidade.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.lideres-comunidade.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.lideres-comunidade.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.lideres-comunidade.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-9 6v-8.25M9 21l9-6 9 6M9 21V12.75m9 8.25V12.75m-9 8.25h-3m12 0h-3M15.75 6.75h-3m-12 0h-3m12 0v3m-12-3v3"/>
                        </svg>
                    </div>
                    <span class="flex-1">Líderes de Comunidade</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Estradas') && Route::has('admin.estradas.index'))
                <a href="{{ route('admin.estradas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.estradas.*') ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.estradas.*') ? 'bg-orange-500 dark:bg-orange-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="estradas" class="w-5 h-5 {{ request()->routeIs('admin.estradas.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Estradas</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Recursos Humanos -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    Recursos Humanos
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Funcionarios') && Route::has('admin.funcionarios.index'))
                <a href="{{ route('admin.funcionarios.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.funcionarios.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.funcionarios.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="funcionarios" class="w-5 h-5 {{ request()->routeIs('admin.funcionarios.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Funcionários</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Equipes') && Route::has('admin.equipes.index'))
                <a href="{{ route('admin.equipes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.equipes.*') ? 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.equipes.*') ? 'bg-violet-500 dark:bg-violet-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="equipes" class="w-5 h-5 {{ request()->routeIs('admin.equipes.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Equipes</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Gestão de Recursos -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.75 7.5h16.5m-1.8-10H5.55c-.512 0-.96.384-1.05.888L3.75 7.5h16.5l-1.8-10.112c-.09-.504-.538-.888-1.05-.888z" />
                    </svg>
                    Gestão de Recursos
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Materiais') && Route::has('admin.materiais.index'))
                <a href="{{ route('admin.materiais.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.materiais.index') || request()->routeIs('admin.materiais.show') ? 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.materiais.index') || request()->routeIs('admin.materiais.show') ? 'bg-teal-500 dark:bg-teal-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="materiais" class="w-5 h-5 {{ request()->routeIs('admin.materiais.index') || request()->routeIs('admin.materiais.show') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Materiais</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Materiais') && Route::has('admin.materiais.solicitar.create'))
                <a href="{{ route('admin.materiais.solicitar.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.materiais.solicitar.*') ? 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.materiais.solicitar.*') ? 'bg-teal-500 dark:bg-teal-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.materiais.solicitar.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <span class="flex-1">Solicitar Materiais</span>
                </a>
                <a href="{{ route('admin.materiais.solicitacoes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.materiais.solicitacoes.*') ? 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.materiais.solicitacoes.*') ? 'bg-teal-500 dark:bg-teal-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.materiais.solicitacoes.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <span class="flex-1">Solicitações Registradas</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Materiais') && Route::has('admin.materiais.categorias.index'))
                <a href="{{ route('admin.materiais.categorias.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.materiais.categorias.*') ? 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.materiais.categorias.*') ? 'bg-teal-500 dark:bg-teal-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.materiais.categorias.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25A2.25 2.25 0 0113.5 18v-2.25z" />
                        </svg>
                    </div>
                    <span class="flex-1">Categorias de Materiais</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Políticas Públicas -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m4.5 0a12.05 12.05 0 004.5 0m0 0a12.05 12.05 0 00-4.5 0m4.5 0v5.25M9 18v-5.25m0 0a6.01 6.01 0 00-1.5-.189M9 12.75a6.01 6.01 0 011.5-.189m-1.5.189a6.01 6.01 0 00-1.5-.189m1.5.189v5.25m0 0a12.05 12.05 0 01-4.5 0m4.5 0v5.25" />
                    </svg>
                    Políticas Públicas
                </h3>
            </div>
            <div class="space-y-1">
                @if(Route::has('admin.programas.index'))
                <a href="{{ route('admin.programas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.programas.*') ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.programas.*') ? 'bg-amber-500 dark:bg-amber-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="document-text" class="w-5 h-5 {{ request()->routeIs('admin.programas.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Programas</span>
                </a>
                @endif

                @if(Route::has('admin.eventos.index'))
                <a href="{{ route('admin.eventos.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.eventos.*') ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.eventos.*') ? 'bg-yellow-500 dark:bg-yellow-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="calendar" class="w-5 h-5 {{ request()->routeIs('admin.eventos.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Eventos</span>
                </a>
                @endif

                @if(Route::has('admin.beneficiarios.index'))
                <a href="{{ route('admin.beneficiarios.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.beneficiarios.*') ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.beneficiarios.*') ? 'bg-green-500 dark:bg-green-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="user-group" class="w-5 h-5 {{ request()->routeIs('admin.beneficiarios.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Beneficiários</span>
                </a>
                @endif

                @if(Route::has('admin.inscricoes.index'))
                <a href="{{ route('admin.inscricoes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.inscricoes.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.inscricoes.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="clipboard-document-check" class="w-5 h-5 {{ request()->routeIs('admin.inscricoes.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Inscrições</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('CAF') && Route::has('caf.cadastrador.index'))
                <a href="{{ route('caf.cadastrador.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('caf.cadastrador.*') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('caf.cadastrador.*') ? 'bg-emerald-500 dark:bg-emerald-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="document-duplicate" class="w-5 h-5 {{ request()->routeIs('caf.cadastrador.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Cadastros CAF</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('CAF') && Route::has('admin.caf.index'))
                <a href="{{ route('admin.caf.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.caf.*') ? 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.caf.*') ? 'bg-cyan-500 dark:bg-cyan-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="clipboard-document-list" class="w-5 h-5 {{ request()->routeIs('admin.caf.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Gerenciar CAF</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Relatórios -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    Relatórios
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Relatorios') && Route::has('relatorios.index'))
                <a href="{{ route('relatorios.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('relatorios.*') ? 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('relatorios.*') ? 'bg-pink-500 dark:bg-pink-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="relatorios" class="w-5 h-5 {{ request()->routeIs('relatorios.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Relatórios</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Gestão Administrativa -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                    </svg>
                    Gestão Administrativa
                </h3>
            </div>
            <div class="space-y-1">
                @if(Route::has('admin.users.index'))
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.users.*') ? 'bg-emerald-500 dark:bg-emerald-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="people" class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Usuários</span>
                </a>
                @endif

                @if(Route::has('admin.roles.index'))
                <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.roles.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.roles.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="shield-lock" class="w-5 h-5 {{ request()->routeIs('admin.roles.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Roles</span>
                </a>
                @endif

                @if(Route::has('admin.permissions.index'))
                <a href="{{ route('admin.permissions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.permissions.*') ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.permissions.*') ? 'bg-amber-500 dark:bg-amber-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="key" class="w-5 h-5 {{ request()->routeIs('admin.permissions.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Permissões</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Sistema -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Sistema
                </h3>
            </div>
            <div class="space-y-1">
                @if(Route::has('admin.modules.index'))
                <a href="{{ route('admin.modules.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.modules.*') ? 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.modules.*') ? 'bg-violet-500 dark:bg-violet-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="boxes" class="w-5 h-5 {{ request()->routeIs('admin.modules.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Módulos</span>
                </a>
                @endif

                @if(Route::has('admin.config.index'))
                <a href="{{ route('admin.config.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.config.*') ? 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.config.*') ? 'bg-slate-500 dark:bg-slate-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="gear" class="w-5 h-5 {{ request()->routeIs('admin.config.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Configurações</span>
                </a>
                @endif

                @if(Route::has('admin.api.index'))
                <a href="{{ route('admin.api.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.api.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.api.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.api.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 16.875h3.375m0 0h3.375m-3.375 0V13.5m0 3.375v3.375M6 10.5h2.25a2.25 2.25 0 002.25-2.25V6a2.25 2.25 0 00-2.25-2.25H6A2.25 2.25 0 003.75 6v2.25A2.25 2.25 0 006 10.5zm0 9.75h2.25A2.25 2.25 0 0010.5 18v-2.25a2.25 2.25 0 00-2.25-2.25H6a2.25 2.25 0 00-2.25 2.25V18A2.25 2.25 0 006 20.25zm9.75-9.75H18a2.25 2.25 0 002.25-2.25V6A2.25 2.25 0 0018 3.75h-2.25A2.25 2.25 0 0013.5 6v2.25a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </div>
                    <span class="flex-1">Gerenciar API</span>
                </a>
                @endif

                @if(Route::has('admin.backup.index'))
                <a href="{{ route('admin.backup.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.backup.*') ? 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.backup.*') ? 'bg-cyan-500 dark:bg-cyan-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="database" class="w-5 h-5 {{ request()->routeIs('admin.backup.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Backup</span>
                </a>
                @endif

                @if(Route::has('admin.updates.index'))
                <a href="{{ route('admin.updates.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.updates.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.updates.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.updates.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                        </svg>
                    </div>
                    <span class="flex-1">Atualizações</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Homepage') && Route::has('admin.homepage.index'))
                <a href="{{ route('admin.homepage.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.homepage.*') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.homepage.*') ? 'bg-emerald-500 dark:bg-emerald-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.homepage.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                        </svg>
                    </div>
                    <span class="flex-1">Homepage</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Blog') && Route::has('admin.blog.index'))
                <a href="{{ route('admin.blog.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.blog.*') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.blog.*') ? 'bg-emerald-500 dark:bg-emerald-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.blog.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                    </div>
                    <span class="flex-1">Blog</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Avisos') && Route::has('admin.avisos.index'))
                <a href="{{ route('admin.avisos.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.avisos.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.avisos.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="Avisos" class="w-5 h-5 {{ request()->routeIs('admin.avisos.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Avisos e Banners</span>
                </a>
                @endif

                @if(Route::has('admin.carousel.index'))
                <a href="{{ route('admin.carousel.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.carousel.*') ? 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.carousel.*') ? 'bg-pink-500 dark:bg-pink-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.carousel.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                        </svg>
                    </div>
                    <span class="flex-1">Carousel</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Monitoramento -->
        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Monitoramento
                </h3>
            </div>
            <div class="space-y-1">
                @if(Route::has('admin.audit.index'))
                <a href="{{ route('admin.audit.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.audit.*') ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.audit.*') ? 'bg-red-500 dark:bg-red-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="journal-text" class="w-5 h-5 {{ request()->routeIs('admin.audit.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Logs de Auditoria</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Notificacoes') && Route::has('admin.notificacoes.index'))
                <a href="{{ route('admin.notificacoes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.notificacoes.*') ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.notificacoes.*') ? 'bg-orange-500 dark:bg-orange-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="notificacoes" class="w-5 h-5 {{ request()->routeIs('admin.notificacoes.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Notificações</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Chat') && Route::has('admin.chat.index'))
                <a href="{{ route('admin.chat.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.chat.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.chat.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <svg class="w-5 h-5 {{ request()->routeIs('admin.chat.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H8.25m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0H12m4.125 0a.375.375 0 11-.75 0 .375.375 0 01.75 0zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 01-2.555-.337A5.972 5.972 0 015.41 20.97a5.969 5.969 0 01-.474-.065 4.48 4.48 0 00.978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25z" />
                        </svg>
                    </div>
                    <span class="flex-1">Chat</span>
                </a>
                @endif
            </div>
        </div>
    </div>

    <!-- Footer Sidebar -->
    <div class="flex-shrink-0 p-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
        <div class="text-center">
            <div class="flex items-center justify-center gap-2 mb-1">
                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z" />
                </svg>
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">VERTEXSEMAGRI</p>
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500">v1.0.0</p>
        </div>
    </div>
</aside>
