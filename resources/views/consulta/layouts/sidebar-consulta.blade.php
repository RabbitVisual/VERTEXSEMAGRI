<nav class="flex flex-col h-full bg-slate-800 dark:bg-slate-900 border-r border-slate-700">
    <style>
        nav::-webkit-scrollbar {
            width: 6px;
        }
        nav::-webkit-scrollbar-track {
            background: rgb(30 41 59);
            border-radius: 3px;
        }
        nav::-webkit-scrollbar-thumb {
            background: rgb(71 85 105);
            border-radius: 3px;
        }
        nav::-webkit-scrollbar-thumb:hover {
            background: rgb(100 116 139);
        }
    </style>
    
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between p-4 lg:p-6 border-b border-slate-700">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-md">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </div>
            <div>
                <h2 class="text-sm font-bold text-slate-200">Menu Consulta</h2>
                <p class="text-xs text-slate-400">Somente Leitura</p>
            </div>
        </div>
        <!-- Close button mobile -->
        <button onclick="toggleConsultaSidebar()" class="lg:hidden p-2 rounded-lg text-slate-400 hover:text-slate-200 hover:bg-slate-700">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    <!-- Navigation - Scrollable -->
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('consulta.dashboard') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all duration-200 {{ request()->routeIs('consulta.dashboard*') ? 'bg-blue-500/20 text-blue-300 shadow-sm border border-blue-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.dashboard*') ? 'bg-blue-500' : 'bg-slate-700 group-hover:bg-blue-500/20' }} transition-colors">
                <svg class="w-5 h-5 {{ request()->routeIs('consulta.dashboard*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-3.75v3.75m-3 .75h3.75m-3.75 0h-3.75" />
                </svg>
            </div>
            <span class="flex-1">Dashboard</span>
            @if(request()->routeIs('consulta.dashboard*'))
            <div class="w-1.5 h-1.5 rounded-full bg-blue-400"></div>
            @endif
        </a>

        <!-- Operacional -->
        <div class="pt-4 mt-4 border-t border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .414-.336.75-.75.75h-4.5a.75.75 0 01-.75-.75v-4.25m0 0l-4.5-4.5m4.5 4.5l4.5-4.5M3.75 19.5h4.5a.75.75 0 00.75-.75v-4.25m0 0L8.25 9.75m-4.5 4.5l4.5 4.5" />
                    </svg>
                    Operacional
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Demandas') && Route::has('consulta.demandas.index'))
                <a href="{{ route('consulta.demandas.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('consulta.demandas.*') ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.demandas.*') ? 'bg-blue-500' : 'bg-slate-700 group-hover:bg-blue-500/20' }} transition-colors">
                        <x-module-icon module="demandas" class="w-5 h-5 {{ request()->routeIs('consulta.demandas.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" />
                    </div>
                    <span class="flex-1">Demandas</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Ordens') && Route::has('consulta.ordens.index'))
                <a href="{{ route('consulta.ordens.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('consulta.ordens.*') ? 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.ordens.*') ? 'bg-indigo-500' : 'bg-slate-700 group-hover:bg-indigo-500/20' }} transition-colors">
                        <x-module-icon module="ordens" class="w-5 h-5 {{ request()->routeIs('consulta.ordens.*') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}" />
                    </div>
                    <span class="flex-1">Ordens de Serviço</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Localidades') && Route::has('consulta.localidades.index'))
                <a href="{{ route('consulta.localidades.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('consulta.localidades.*') ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.localidades.*') ? 'bg-amber-500' : 'bg-slate-700 group-hover:bg-amber-500/20' }} transition-colors">
                        <x-module-icon module="localidades" class="w-5 h-5 {{ request()->routeIs('consulta.localidades.*') ? 'text-white' : 'text-slate-400 group-hover:text-amber-400' }}" />
                    </div>
                    <span class="flex-1">Localidades</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Pessoas') && Route::has('consulta.pessoas.index'))
                <a href="{{ route('consulta.pessoas.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('consulta.pessoas.*') ? 'bg-purple-500/20 text-purple-300 border border-purple-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.pessoas.*') ? 'bg-purple-500' : 'bg-slate-700 group-hover:bg-purple-500/20' }} transition-colors">
                        <x-module-icon module="pessoas" class="w-5 h-5 {{ request()->routeIs('consulta.pessoas.*') ? 'text-white' : 'text-slate-400 group-hover:text-purple-400' }}" />
                    </div>
                    <span class="flex-1">Pessoas - CadÚnico</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Infraestrutura -->
        <div class="pt-4 mt-4 border-t border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008V14.25m.75 3.75h.008v.008h-.008V18m-3.75-3.75h.008v.008h-.008V14.25m.75 3.75h.008v.008h-.008V18" />
                    </svg>
                    Infraestrutura
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Iluminacao') && Route::has('consulta.iluminacao.index'))
                <a href="{{ route('consulta.iluminacao.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('consulta.iluminacao.*') ? 'bg-yellow-500/20 text-yellow-300 border border-yellow-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.iluminacao.*') ? 'bg-yellow-500' : 'bg-slate-700 group-hover:bg-yellow-500/20' }} transition-colors">
                        <x-module-icon module="iluminacao" class="w-5 h-5 {{ request()->routeIs('consulta.iluminacao.*') ? 'text-white' : 'text-slate-400 group-hover:text-yellow-400' }}" />
                    </div>
                    <span class="flex-1">Iluminação</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Agua') && Route::has('consulta.agua.index'))
                <a href="{{ route('consulta.agua.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('consulta.agua.*') ? 'bg-cyan-500/20 text-cyan-300 border border-cyan-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.agua.*') ? 'bg-cyan-500' : 'bg-slate-700 group-hover:bg-cyan-500/20' }} transition-colors">
                        <x-module-icon module="agua" class="w-5 h-5 {{ request()->routeIs('consulta.agua.*') ? 'text-white' : 'text-slate-400 group-hover:text-cyan-400' }}" />
                    </div>
                    <span class="flex-1">Água</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Pocos') && Route::has('consulta.pocos.index'))
                <a href="{{ route('consulta.pocos.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('consulta.pocos.*') ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.pocos.*') ? 'bg-blue-500' : 'bg-slate-700 group-hover:bg-blue-500/20' }} transition-colors">
                        <x-module-icon module="pocos" class="w-5 h-5 {{ request()->routeIs('consulta.pocos.*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" />
                    </div>
                    <span class="flex-1">Poços</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Estradas') && Route::has('consulta.estradas.index'))
                <a href="{{ route('consulta.estradas.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('consulta.estradas.*') ? 'bg-orange-500/20 text-orange-300 border border-orange-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.estradas.*') ? 'bg-orange-500' : 'bg-slate-700 group-hover:bg-orange-500/20' }} transition-colors">
                        <x-module-icon module="estradas" class="w-5 h-5 {{ request()->routeIs('consulta.estradas.*') ? 'text-white' : 'text-slate-400 group-hover:text-orange-400' }}" />
                    </div>
                    <span class="flex-1">Estradas</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Recursos Humanos -->
        <div class="pt-4 mt-4 border-t border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                    </svg>
                    Recursos Humanos
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Funcionarios') && Route::has('consulta.funcionarios.index'))
                <a href="{{ route('consulta.funcionarios.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('consulta.funcionarios.*') ? 'bg-indigo-500/20 text-indigo-300 border border-indigo-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.funcionarios.*') ? 'bg-indigo-500' : 'bg-slate-700 group-hover:bg-indigo-500/20' }} transition-colors">
                        <x-module-icon module="funcionarios" class="w-5 h-5 {{ request()->routeIs('consulta.funcionarios.*') ? 'text-white' : 'text-slate-400 group-hover:text-indigo-400' }}" />
                    </div>
                    <span class="flex-1">Funcionários</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Equipes') && Route::has('consulta.equipes.index'))
                <a href="{{ route('consulta.equipes.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('consulta.equipes.*') ? 'bg-violet-500/20 text-violet-300 border border-violet-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.equipes.*') ? 'bg-violet-500' : 'bg-slate-700 group-hover:bg-violet-500/20' }} transition-colors">
                        <x-module-icon module="equipes" class="w-5 h-5 {{ request()->routeIs('consulta.equipes.*') ? 'text-white' : 'text-slate-400 group-hover:text-violet-400' }}" />
                    </div>
                    <span class="flex-1">Equipes</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Gestão de Recursos -->
        <div class="pt-4 mt-4 border-t border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.75 7.5h16.5m-1.8-10H5.55c-.512 0-.96.384-1.05.888L3.75 7.5h16.5l-1.8-10.112c-.09-.504-.538-.888-1.05-.888z" />
                    </svg>
                    Gestão de Recursos
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Materiais') && Route::has('consulta.materiais.index'))
                <a href="{{ route('consulta.materiais.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('consulta.materiais.*') ? 'bg-teal-500/20 text-teal-300 border border-teal-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.materiais.*') ? 'bg-teal-500' : 'bg-slate-700 group-hover:bg-teal-500/20' }} transition-colors">
                        <x-module-icon module="materiais" class="w-5 h-5 {{ request()->routeIs('consulta.materiais.*') ? 'text-white' : 'text-slate-400 group-hover:text-teal-400' }}" />
                    </div>
                    <span class="flex-1">Materiais</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Políticas Públicas -->
        @if(\Nwidart\Modules\Facades\Module::isEnabled('ProgramasAgricultura') && Route::has('consulta.programas.index'))
        <div class="pt-4 mt-4 border-t border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 001.5-.189m-1.5.189a6.01 6.01 0 01-1.5-.189m3.75 7.478a12.06 12.06 0 01-4.5 0m4.5 0a12.05 12.05 0 004.5 0m0 0a12.05 12.05 0 00-4.5 0m4.5 0v5.25M9 18v-5.25m0 0a6.01 6.01 0 00-1.5-.189M9 12.75a6.01 6.01 0 011.5-.189m-1.5.189a6.01 6.01 0 00-1.5-.189m1.5.189v5.25m0 0a12.05 12.05 0 01-4.5 0m4.5 0v5.25" />
                    </svg>
                    Políticas Públicas
                </h3>
            </div>
            <div class="space-y-1">
                <a href="{{ route('consulta.programas.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('consulta.programas.*') ? 'bg-amber-500/20 text-amber-300 border border-amber-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.programas.*') ? 'bg-amber-500' : 'bg-slate-700 group-hover:bg-amber-500/20' }} transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('consulta.programas.*') ? 'text-white' : 'text-slate-400 group-hover:text-amber-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                    </div>
                    <span class="flex-1">Programas</span>
                </a>
            </div>
        </div>
        @endif

        <!-- Relatórios -->
        @if(\Nwidart\Modules\Facades\Module::isEnabled('Relatorios') && Route::has('consulta.relatorios.index'))
        <div class="pt-4 mt-4 border-t border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                    </svg>
                    Relatórios
                </h3>
            </div>
            <div class="space-y-1">
                <a href="{{ route('consulta.relatorios.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('consulta.relatorios.*') ? 'bg-pink-500/20 text-pink-300 border border-pink-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.relatorios.*') ? 'bg-pink-500' : 'bg-slate-700 group-hover:bg-pink-500/20' }} transition-colors">
                        <x-module-icon module="relatorios" class="w-5 h-5 {{ request()->routeIs('consulta.relatorios.*') ? 'text-white' : 'text-slate-400 group-hover:text-pink-400' }}" />
                    </div>
                    <span class="flex-1">Relatórios</span>
                </a>
            </div>
        </div>
        @endif

        <!-- Monitoramento -->
        <div class="pt-4 mt-4 border-t border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    Monitoramento
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Notificacoes') && Route::has('consulta.notificacoes.index'))
                <a href="{{ route('consulta.notificacoes.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('consulta.notificacoes.*') ? 'bg-orange-500/20 text-orange-300 border border-orange-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.notificacoes.*') ? 'bg-orange-500' : 'bg-slate-700 group-hover:bg-orange-500/20' }} transition-colors">
                        <x-module-icon module="notificacoes" class="w-5 h-5 {{ request()->routeIs('consulta.notificacoes.*') ? 'text-white' : 'text-slate-400 group-hover:text-orange-400' }}" />
                    </div>
                    <span class="flex-1">Notificações</span>
                </a>
                @endif
            </div>
        </div>

        <!-- Conta -->
        <div class="pt-4 mt-4 border-t border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-2">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                    </svg>
                    Conta
                </h3>
            </div>
            <div class="space-y-1">
                <a href="{{ route('consulta.profile') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm transition-all duration-200 {{ request()->routeIs('consulta.profile*') ? 'bg-blue-500/20 text-blue-300 border border-blue-500/30' : 'text-slate-300 hover:bg-slate-700/50' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('consulta.profile*') ? 'bg-blue-500' : 'bg-slate-700 group-hover:bg-blue-500/20' }} transition-colors">
                        <svg class="w-5 h-5 {{ request()->routeIs('consulta.profile*') ? 'text-white' : 'text-slate-400 group-hover:text-blue-400' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <span class="flex-1">Meu Perfil</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Footer Sidebar -->
    <div class="flex-shrink-0 p-4 border-t border-slate-700 bg-slate-900/50">
        <div class="text-center">
            <div class="flex items-center justify-center gap-2 mb-1">
                <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <p class="text-xs font-semibold text-slate-400">MODO CONSULTA</p>
            </div>
            <p class="text-xs text-slate-600">Somente Leitura</p>
        </div>
    </div>
</nav>

