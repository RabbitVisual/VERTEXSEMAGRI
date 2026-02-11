<aside class="flex flex-col h-full bg-white dark:bg-slate-800 border-r border-gray-200 dark:border-slate-700">
    <style>
        aside::-webkit-scrollbar { width: 6px; }
        aside::-webkit-scrollbar-track { background: rgb(241 245 249); border-radius: 3px; }
        aside::-webkit-scrollbar-thumb { background: rgb(203 213 225); border-radius: 3px; }
        aside::-webkit-scrollbar-thumb:hover { background: rgb(148 163 184); }
        .dark aside::-webkit-scrollbar-track { background: rgb(30 41 59); }
        .dark aside::-webkit-scrollbar-thumb { background: rgb(71 85 105); }
        .dark aside::-webkit-scrollbar-thumb:hover { background: rgb(100 116 139); }
    </style>

    <div class="flex items-center justify-between p-4 lg:p-6 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-lg flex items-center justify-center shadow-md">
                <x-icon name="grid-2" class="w-6 h-6 text-white" style="duotone" />
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Painel Co-Admin</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">Gestão Operacional</p>
            </div>
        </div>
        <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-slate-700 dark:hover:text-gray-300">
            <x-icon name="xmark" class="w-5 h-5" style="duotone" />
            <span class="sr-only">Fechar menu</span>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-1">

        <a href="{{ route('co-admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('co-admin.dashboard*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.dashboard*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                <x-icon name="chart-mixed" class="w-5 h-5 {{ request()->routeIs('co-admin.dashboard*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
            </div>
            <span class="flex-1">Dashboard</span>
        </a>

        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <x-icon name="arrows-repeat" class="w-3.5 h-3.5" style="duotone" />
                    Operacional
                </h3>
            </div>
            <div class="space-y-1">

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Demandas') && Route::has('co-admin.demandas.index'))
                <div x-data="{ open: {{ request()->routeIs('co-admin.demandas.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.demandas.*') ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.demandas.*') ? 'bg-amber-500 dark:bg-amber-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                                <x-module-icon module="Demandas" class="w-5 h-5 {{ request()->routeIs('co-admin.demandas.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                            </div>
                            <span class="flex-1 text-left">Demandas</span>
                        </div>
                        <x-icon name="chevron-down" class="w-4 h-4 transition-transform" x-bind:class="{ 'rotate-180': open }" style="duotone" />
                    </button>
                    <div x-show="open" x-collapse class="pl-14 space-y-1">
                        <a href="{{ route('co-admin.demandas.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('co-admin.demandas.index') ? 'text-amber-700 dark:text-amber-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                             Listar Todas
                        </a>
                        <a href="{{ route('co-admin.demandas.create') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('co-admin.demandas.create') ? 'text-amber-700 dark:text-amber-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                             Nova Demanda
                        </a>
                        @if(Route::has('co-admin.demandas.relatorio.abertas.pdf'))
                        <a href="{{ route('co-admin.demandas.relatorio.abertas.pdf') }}" target="_blank" class="block px-3 py-2 rounded-lg text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 group">
                             <span class="flex items-center gap-2">
                                <x-icon name="file-pdf" class="w-4 h-4" style="duotone" /> Relatório PDF
                             </span>
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Ordens') && Route::has('co-admin.ordens.index'))
                <div x-data="{ open: {{ request()->routeIs('co-admin.ordens.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.ordens.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.ordens.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                                <x-module-icon module="Ordens" class="w-5 h-5 {{ request()->routeIs('co-admin.ordens.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                            </div>
                            <span class="flex-1 text-left">Ordens de Serviço</span>
                        </div>
                        <x-icon name="chevron-down" class="w-4 h-4 transition-transform" x-bind:class="{ 'rotate-180': open }" style="duotone" />
                    </button>
                    <div x-show="open" x-collapse class="pl-14 space-y-1">
                        <a href="{{ route('co-admin.ordens.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('co-admin.ordens.index') ? 'text-blue-700 dark:text-blue-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                             Listar Ordens
                        </a>
                        <a href="{{ route('co-admin.ordens.create') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('co-admin.ordens.create') ? 'text-blue-700 dark:text-blue-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                             Nova Ordem
                        </a>
                        @if(Route::has('co-admin.ordens.relatorio.demandas-dia.pdf'))
                        <a href="{{ route('co-admin.ordens.relatorio.demandas-dia.pdf') }}" target="_blank" class="block px-3 py-2 rounded-lg text-sm text-gray-600 dark:text-gray-400 hover:text-red-600 dark:hover:text-red-400 group">
                             <span class="flex items-center gap-2">
                                <x-icon name="file-pdf" class="w-4 h-4" style="duotone" /> Relatório do Dia
                             </span>
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Localidades') && Route::has('co-admin.localidades.index'))
                <a href="{{ route('co-admin.localidades.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.localidades.*') ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.localidades.*') ? 'bg-amber-500 dark:bg-amber-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="Localidades" class="w-5 h-5 {{ request()->routeIs('co-admin.localidades.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Localidades</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Pessoas') && Route::has('co-admin.pessoas.index'))
                <div x-data="{ open: {{ request()->routeIs('co-admin.pessoas.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.pessoas.*') ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.pessoas.*') ? 'bg-purple-500 dark:bg-purple-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                                <x-module-icon module="Pessoas" class="w-5 h-5 {{ request()->routeIs('co-admin.pessoas.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                            </div>
                            <span class="flex-1 text-left">Pessoas</span>
                        </div>
                        <x-icon name="chevron-down" class="w-4 h-4 transition-transform" x-bind:class="{ 'rotate-180': open }" style="duotone" />
                    </button>
                    <div x-show="open" x-collapse class="pl-14 space-y-1">
                        <a href="{{ route('co-admin.pessoas.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('co-admin.pessoas.index') ? 'text-purple-700 dark:text-purple-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                             Buscar/Listar
                        </a>
                        <a href="{{ route('co-admin.pessoas.create') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('co-admin.pessoas.create') ? 'text-purple-700 dark:text-purple-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                             Cadastrar Nova
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <x-icon name="building" class="w-3.5 h-3.5" style="duotone" />
                    Infraestrutura
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Iluminacao') && Route::has('co-admin.iluminacao.index'))
                <a href="{{ route('co-admin.iluminacao.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.iluminacao.*') ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.iluminacao.*') ? 'bg-yellow-500 dark:bg-yellow-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="Iluminacao" class="w-5 h-5 {{ request()->routeIs('co-admin.iluminacao.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Iluminação</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Agua') && Route::has('co-admin.agua.index'))
                <a href="{{ route('co-admin.agua.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.agua.*') ? 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.agua.*') ? 'bg-cyan-500 dark:bg-cyan-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="Agua" class="w-5 h-5 {{ request()->routeIs('co-admin.agua.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Água</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Pocos') && Route::has('co-admin.pocos.index'))
                <a href="{{ route('co-admin.pocos.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.pocos.*') ? 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.pocos.*') ? 'bg-cyan-500 dark:bg-cyan-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="Pocos" class="w-5 h-5 {{ request()->routeIs('co-admin.pocos.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Poços</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Estradas') && Route::has('co-admin.estradas.index'))
                <a href="{{ route('co-admin.estradas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.estradas.*') ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.estradas.*') ? 'bg-amber-500 dark:bg-amber-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="Estradas" class="w-5 h-5 {{ request()->routeIs('co-admin.estradas.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Estradas</span>
                </a>
                @endif
            </div>
        </div>

        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <x-icon name="users" class="w-3.5 h-3.5" style="duotone" />
                    Recursos Humanos
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Funcionarios') && Route::has('co-admin.funcionarios.index'))
                <div x-data="{ open: {{ request()->routeIs('co-admin.funcionarios.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.funcionarios.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.funcionarios.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                                <x-module-icon module="Funcionarios" class="w-5 h-5 {{ request()->routeIs('co-admin.funcionarios.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                            </div>
                            <span class="flex-1 text-left">Funcionários</span>
                        </div>
                        <x-icon name="chevron-down" class="w-4 h-4 transition-transform" x-bind:class="{ 'rotate-180': open }" style="duotone" />
                    </button>
                    <div x-show="open" x-collapse class="pl-14 space-y-1">
                        <a href="{{ route('co-admin.funcionarios.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('co-admin.funcionarios.index') && !request()->routeIs('co-admin.funcionarios.status.*') ? 'text-indigo-700 dark:text-indigo-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                             Listar Todos
                        </a>
                        <a href="{{ route('co-admin.funcionarios.create') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('co-admin.funcionarios.create') ? 'text-indigo-700 dark:text-indigo-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                             Cadastrar
                        </a>
                        @if(Route::has('co-admin.funcionarios.status.index'))
                        <a href="{{ route('co-admin.funcionarios.status.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('co-admin.funcionarios.status.*') ? 'text-indigo-700 dark:text-indigo-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                             Monitorar Status
                        </a>
                        @endif
                    </div>
                </div>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Equipes') && Route::has('co-admin.equipes.index'))
                <a href="{{ route('co-admin.equipes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.equipes.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.equipes.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="Equipes" class="w-5 h-5 {{ request()->routeIs('co-admin.equipes.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Equipes</span>
                </a>
                @endif
            </div>
        </div>

        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <x-icon name="boxes-stacked" class="w-3.5 h-3.5" style="duotone" />
                    Estoque
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Materiais') && Route::has('co-admin.materiais.index'))
                <div x-data="{ open: {{ request()->routeIs('co-admin.materiais.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.materiais.*') ? 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.materiais.*') ? 'bg-teal-500 dark:bg-teal-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                                <x-module-icon module="Materiais" class="w-5 h-5 {{ request()->routeIs('co-admin.materiais.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                            </div>
                            <span class="flex-1 text-left">Materiais</span>
                        </div>
                        <x-icon name="chevron-down" class="w-4 h-4 transition-transform" x-bind:class="{ 'rotate-180': open }" style="duotone" />
                    </button>
                    <div x-show="open" x-collapse class="pl-14 space-y-1">
                        <a href="{{ route('co-admin.materiais.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('co-admin.materiais.index') ? 'text-teal-700 dark:text-teal-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                             Listar Estoque
                        </a>
                        <a href="{{ route('co-admin.materiais.create') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('co-admin.materiais.create') ? 'text-teal-700 dark:text-teal-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                             Novo Material
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <x-icon name="landmark" class="w-3.5 h-3.5" style="duotone" />
                    Políticas Públicas
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('ProgramasAgricultura') && Route::has('co-admin.programas.index'))
                <a href="{{ route('co-admin.programas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.programas.*') ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.programas.*') ? 'bg-green-500 dark:bg-green-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="ProgramasAgricultura" class="w-5 h-5 {{ request()->routeIs('co-admin.programas.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Programas</span>
                </a>
                <a href="{{ route('co-admin.eventos.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.eventos.*') ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.eventos.*') ? 'bg-green-500 dark:bg-green-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="calendar" class="w-5 h-5 {{ request()->routeIs('co-admin.eventos.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Eventos</span>
                </a>
                <a href="{{ route('co-admin.beneficiarios.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.beneficiarios.*') ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.beneficiarios.*') ? 'bg-green-500 dark:bg-green-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="users" class="w-5 h-5 {{ request()->routeIs('co-admin.beneficiarios.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Beneficiários</span>
                </a>
                @endif
            </div>
        </div>

        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-slate-700">
            <div class="px-3 mb-3">
                <h3 class="text-xs font-bold uppercase tracking-wider text-gray-500 dark:text-gray-400 flex items-center gap-2">
                    <x-icon name="chart-line" class="w-3.5 h-3.5" style="duotone" />
                    Inteligência
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Relatorios') && Route::has('co-admin.relatorios.index'))
                <div x-data="{ open: {{ request()->routeIs('co-admin.relatorios.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.relatorios.*') ? 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.relatorios.*') ? 'bg-pink-500 dark:bg-pink-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                                <x-module-icon module="Relatorios" class="w-5 h-5 {{ request()->routeIs('co-admin.relatorios.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                            </div>
                            <span class="flex-1 text-left">Relatórios</span>
                        </div>
                        <x-icon name="chevron-down" class="w-4 h-4 transition-transform" x-bind:class="{ 'rotate-180': open }" style="duotone" />
                    </button>
                    <div x-show="open" x-collapse class="pl-14 space-y-1">
                        <a href="{{ route('co-admin.relatorios.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('co-admin.relatorios.index') ? 'text-pink-700 dark:text-pink-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                             Painel Geral
                        </a>

                        <div class="px-3 py-1 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-2">Operacional</div>
                        @if(Route::has('co-admin.relatorios.demandas'))
                        <a href="{{ route('co-admin.relatorios.demandas') }}" class="block px-3 py-2 rounded-lg text-sm hover:text-gray-900 dark:hover:text-white">Demandas</a>
                        @endif
                        @if(Route::has('co-admin.relatorios.ordens'))
                        <a href="{{ route('co-admin.relatorios.ordens') }}" class="block px-3 py-2 rounded-lg text-sm hover:text-gray-900 dark:hover:text-white">Ordens de Serviço</a>
                        @endif
                        @if(Route::has('co-admin.relatorios.equipes'))
                        <a href="{{ route('co-admin.relatorios.equipes') }}" class="block px-3 py-2 rounded-lg text-sm hover:text-gray-900 dark:hover:text-white">Equipes</a>
                        @endif

                        <div class="px-3 py-1 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-2">Estoque</div>
                        @if(Route::has('co-admin.relatorios.materiais'))
                        <a href="{{ route('co-admin.relatorios.materiais') }}" class="block px-3 py-2 rounded-lg text-sm hover:text-gray-900 dark:hover:text-white">Materiais</a>
                        @endif
                        @if(Route::has('co-admin.relatorios.movimentacoes_materiais'))
                        <a href="{{ route('co-admin.relatorios.movimentacoes_materiais') }}" class="block px-3 py-2 rounded-lg text-sm hover:text-gray-900 dark:hover:text-white">Movimentações</a>
                        @endif

                        <div class="px-3 py-1 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mt-2">Análises</div>
                        @if(Route::has('co-admin.relatorios.analise.geografica'))
                        <a href="{{ route('co-admin.relatorios.analise.geografica') }}" class="block px-3 py-2 rounded-lg text-sm hover:text-gray-900 dark:hover:text-white">Geográfica</a>
                        @endif
                        @if(Route::has('co-admin.relatorios.analise.performance'))
                        <a href="{{ route('co-admin.relatorios.analise.performance') }}" class="block px-3 py-2 rounded-lg text-sm hover:text-gray-900 dark:hover:text-white">Performance</a>
                        @endif
                    </div>
                </div>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Chat') && Route::has('co-admin.chat.index'))
                <a href="{{ route('co-admin.chat.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.chat.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.chat.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="Chat" class="w-5 h-5 {{ request()->routeIs('co-admin.chat.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Atendimento Online</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Notificacoes') && Route::has('co-admin.notificacoes.index'))
                <a href="{{ route('co-admin.notificacoes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('co-admin.notificacoes.*') ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('co-admin.notificacoes.*') ? 'bg-orange-500 dark:bg-orange-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="Notificacoes" class="w-5 h-5 {{ request()->routeIs('co-admin.notificacoes.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Notificações</span>
                </a>
                @endif
            </div>
        </div>

    </div>

    <div class="flex-shrink-0 p-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
        <div class="text-center">
            <div class="flex items-center justify-center gap-2 mb-1">
                <x-icon name="shield-check" class="w-4 h-4 text-gray-400 dark:text-gray-500" style="duotone" />
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">VERTEXSEMAGRI</p>
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500">v1.0.26</p>
        </div>
    </div>
</aside>