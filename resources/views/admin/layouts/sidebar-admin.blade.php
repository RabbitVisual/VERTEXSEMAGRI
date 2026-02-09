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

    <!-- Sidebar Header -->
    <div class="flex items-center justify-between p-4 lg:p-6 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-lg flex items-center justify-center shadow-md">
                <x-icon name="grid-2" class="w-6 h-6 text-white" style="duotone" />
            </div>
            <div>
                <h2 class="text-sm font-bold text-gray-900 dark:text-white">Menu Admin</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400">Navegação</p>
            </div>
        </div>
        <!-- Close button mobile -->
        <button onclick="toggleAdminSidebar()" class="lg:hidden p-2 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-slate-700 dark:hover:text-gray-300">
            <x-icon name="xmark" class="w-5 h-5" style="duotone" />
            <span class="sr-only">Fechar menu</span>
        </button>
    </div>

    <!-- Navigation - Scrollable -->
    <div class="flex-1 overflow-y-auto px-3 py-4 space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 {{ request()->routeIs('admin.dashboard*') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.dashboard*') ? 'bg-emerald-500 dark:bg-emerald-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                <x-icon name="chart-pie" class="w-5 h-5 {{ request()->routeIs('admin.dashboard*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
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
                    <x-icon name="arrows-repeat" class="w-3.5 h-3.5" style="duotone" />
                    Operacional
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Demandas') && Route::has('admin.demandas.index'))
                <a href="{{ route('admin.demandas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.demandas.*') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.demandas.*') ? 'bg-emerald-500 dark:bg-emerald-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="demandas" class="w-5 h-5 {{ request()->routeIs('admin.demandas.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Demandas</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Ordens') && Route::has('admin.ordens.index'))
                <a href="{{ route('admin.ordens.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.ordens.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.ordens.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="ordens" class="w-5 h-5 {{ request()->routeIs('admin.ordens.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Ordens de Serviço</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Localidades') && Route::has('admin.localidades.index'))
                <a href="{{ route('admin.localidades.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.localidades.*') ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.localidades.*') ? 'bg-amber-500 dark:bg-amber-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="localidades" class="w-5 h-5 {{ request()->routeIs('admin.localidades.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Localidades</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Pessoas') && Route::has('admin.pessoas.index'))
                <a href="{{ route('admin.pessoas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.pessoas.*') ? 'bg-purple-100 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.pessoas.*') ? 'bg-purple-500 dark:bg-purple-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="pessoas" class="w-5 h-5 {{ request()->routeIs('admin.pessoas.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
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
                    <x-icon name="building" class="w-3.5 h-3.5" style="duotone" />
                    Infraestrutura
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Iluminacao') && Route::has('admin.iluminacao.index'))
                <div x-data="{ open: {{ request()->routeIs('admin.iluminacao.*') ? 'true' : 'false' }} }" class="space-y-1">
                    <button @click="open = !open" class="w-full flex items-center justify-between gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.iluminacao.*') ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                        <div class="flex items-center gap-3">
                            <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.iluminacao.*') ? 'bg-yellow-500 dark:bg-yellow-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                                <x-module-icon module="iluminacao" class="w-5 h-5 {{ request()->routeIs('admin.iluminacao.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                            </div>
                            <span class="flex-1 text-left">Iluminação</span>
                        </div>
                        <x-icon name="chevron-down" class="w-4 h-4 transition-transform" x-bind:class="{ 'rotate-180': open }" style="duotone" />
                    </button>
                    <div x-show="open" x-collapse class="pl-14 space-y-1">
                        <a href="{{ route('admin.iluminacao.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.iluminacao.index') || request()->routeIs('admin.iluminacao.show') ? 'text-yellow-700 dark:text-yellow-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                             Pontos de Luz
                        </a>
                        <a href="{{ route('admin.iluminacao.postes.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('admin.iluminacao.postes.*') ? 'text-yellow-700 dark:text-yellow-400 font-medium' : 'text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white' }}">
                             Postes
                        </a>
                    </div>
                </div>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Agua') && Route::has('admin.agua.index'))
                <a href="{{ route('admin.agua.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.agua.*') ? 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.agua.*') ? 'bg-cyan-500 dark:bg-cyan-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="agua" class="w-5 h-5 {{ request()->routeIs('admin.agua.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Água</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Pocos') && Route::has('admin.pocos.index'))
                <a href="{{ route('admin.pocos.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.pocos.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.pocos.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="pocos" class="w-5 h-5 {{ request()->routeIs('admin.pocos.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Poços</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Pocos') && Route::has('admin.lideres-comunidade.index'))
                <a href="{{ route('admin.lideres-comunidade.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.lideres-comunidade.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.lideres-comunidade.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="person-chalkboard" class="w-5 h-5 {{ request()->routeIs('admin.lideres-comunidade.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" style="duotone" />
                    </div>
                    <span class="flex-1">Líderes de Comunidade</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Estradas') && Route::has('admin.estradas.index'))
                <a href="{{ route('admin.estradas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.estradas.*') ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.estradas.*') ? 'bg-orange-500 dark:bg-orange-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="estradas" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.estradas.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
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
                    <x-icon name="users" class="w-3.5 h-3.5" style="duotone" />
                    Recursos Humanos
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Funcionarios') && Route::has('admin.funcionarios.index'))
                <a href="{{ route('admin.funcionarios.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.funcionarios.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.funcionarios.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="funcionarios" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.funcionarios.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Funcionários</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Equipes') && Route::has('admin.equipes.index'))
                <a href="{{ route('admin.equipes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.equipes.*') ? 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.equipes.*') ? 'bg-violet-500 dark:bg-violet-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="equipes" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.equipes.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
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
                    <x-icon name="boxes-stacked" class="w-3.5 h-3.5" style="duotone" />
                    Gestão de Recursos
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Materiais') && Route::has('admin.materiais.index'))
                <a href="{{ route('admin.materiais.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.materiais.index') || request()->routeIs('admin.materiais.show') ? 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.materiais.index') || request()->routeIs('admin.materiais.show') ? 'bg-teal-500 dark:bg-teal-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="materiais" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.materiais.index') || request()->routeIs('admin.materiais.show') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Materiais</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Materiais') && Route::has('admin.materiais.solicitar.create'))
                <a href="{{ route('admin.materiais.solicitar.create') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.materiais.solicitar.*') ? 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.materiais.solicitar.*') ? 'bg-teal-500 dark:bg-teal-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="file-lines" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.materiais.solicitar.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Solicitar Materiais</span>
                </a>
                <a href="{{ route('admin.materiais.solicitacoes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.materiais.solicitacoes.*') ? 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.materiais.solicitacoes.*') ? 'bg-teal-500 dark:bg-teal-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="file-invoice" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.materiais.solicitacoes.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Solicitações Registradas</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Materiais') && Route::has('admin.materiais.categorias.index'))
                <a href="{{ route('admin.materiais.categorias.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.materiais.categorias.*') ? 'bg-teal-100 text-teal-700 dark:bg-teal-900/30 dark:text-teal-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.materiais.categorias.*') ? 'bg-teal-500 dark:bg-teal-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="grid-2" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.materiais.categorias.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
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
                    <x-icon name="landmark" class="w-3.5 h-3.5" style="duotone" />
                    Políticas Públicas
                </h3>
            </div>
            <div class="space-y-1">
                @if(Route::has('admin.programas.index'))
                <a href="{{ route('admin.programas.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.programas.*') ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.programas.*') ? 'bg-amber-500 dark:bg-amber-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="file-lines" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.programas.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Programas</span>
                </a>
                @endif

                @if(Route::has('admin.eventos.index'))
                <a href="{{ route('admin.eventos.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.eventos.*') ? 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.eventos.*') ? 'bg-yellow-500 dark:bg-yellow-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="calendar" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.eventos.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Eventos</span>
                </a>
                @endif

                @if(Route::has('admin.beneficiarios.index'))
                <a href="{{ route('admin.beneficiarios.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.beneficiarios.*') ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.beneficiarios.*') ? 'bg-green-500 dark:bg-green-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="users" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.beneficiarios.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Beneficiários</span>
                </a>
                @endif

                @if(Route::has('admin.inscricoes.index'))
                <a href="{{ route('admin.inscricoes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.inscricoes.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.inscricoes.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="clipboard-check" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.inscricoes.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Inscrições</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('CAF') && Route::has('caf.cadastrador.index'))
                <a href="{{ route('caf.cadastrador.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('caf.cadastrador.*') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('caf.cadastrador.*') ? 'bg-emerald-500 dark:bg-emerald-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="copy" style="duotone" class="w-5 h-5 {{ request()->routeIs('caf.cadastrador.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Cadastros CAF</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('CAF') && Route::has('admin.caf.index'))
                <a href="{{ route('admin.caf.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.caf.*') ? 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.caf.*') ? 'bg-cyan-500 dark:bg-cyan-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="clipboard-list" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.caf.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
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
                    <x-icon name="chart-column" class="w-3.5 h-3.5" style="duotone" />
                    Relatórios
                </h3>
            </div>
            <div class="space-y-1">
                @if(\Nwidart\Modules\Facades\Module::isEnabled('Relatorios') && Route::has('relatorios.index'))
                <a href="{{ route('relatorios.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('relatorios.*') ? 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('relatorios.*') ? 'bg-pink-500 dark:bg-pink-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="relatorios" style="duotone" class="w-5 h-5 {{ request()->routeIs('relatorios.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
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
                    <x-icon name="shield-halved" class="w-3.5 h-3.5" style="duotone" />
                    Gestão Administrativa
                </h3>
            </div>
            <div class="space-y-1">
                @if(Route::has('admin.users.index'))
                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.users.*') ? 'bg-emerald-500 dark:bg-emerald-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="users" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.users.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Usuários</span>
                </a>
                @endif

                @if(Route::has('admin.roles.index'))
                <a href="{{ route('admin.roles.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.roles.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.roles.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="shield-halved" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.roles.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Roles</span>
                </a>
                @endif

                @if(Route::has('admin.permissions.index'))
                <a href="{{ route('admin.permissions.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.permissions.*') ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.permissions.*') ? 'bg-amber-500 dark:bg-amber-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="key" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.permissions.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
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
                    <x-icon name="gear" class="w-3.5 h-3.5" style="duotone" />
                    Sistema
                </h3>
            </div>
            <div class="space-y-1">
                @if(Route::has('admin.modules.index'))
                <a href="{{ route('admin.modules.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.modules.*') ? 'bg-violet-100 text-violet-700 dark:bg-violet-900/30 dark:text-violet-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.modules.*') ? 'bg-violet-500 dark:bg-violet-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="cubes" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.modules.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Módulos</span>
                </a>
                @endif

                @if(Route::has('admin.config.index'))
                <a href="{{ route('admin.config.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.config.*') ? 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.config.*') ? 'bg-slate-500 dark:bg-slate-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="gear" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.config.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Configurações</span>
                </a>
                @endif

                @if(Route::has('admin.api.index'))
                <a href="{{ route('admin.api.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.api.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.api.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="code" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.api.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Gerenciar API</span>
                </a>
                @endif

                @if(Route::has('admin.backup.index'))
                <a href="{{ route('admin.backup.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.backup.*') ? 'bg-cyan-100 text-cyan-700 dark:bg-cyan-900/30 dark:text-cyan-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.backup.*') ? 'bg-cyan-500 dark:bg-cyan-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="database" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.backup.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Backup</span>
                </a>
                @endif

                @if(Route::has('admin.updates.index'))
                <a href="{{ route('admin.updates.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.updates.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.updates.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="arrow-up-from-bracket" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.updates.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Atualizações</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Homepage') && Route::has('admin.homepage.index'))
                <a href="{{ route('admin.homepage.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.homepage.*') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.homepage.*') ? 'bg-emerald-500 dark:bg-emerald-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="house-chimney" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.homepage.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Homepage</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Blog') && Route::has('admin.blog.index'))
                <a href="{{ route('admin.blog.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.blog.*') ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.blog.*') ? 'bg-emerald-500 dark:bg-emerald-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="newspaper" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.blog.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Blog</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Avisos') && Route::has('admin.avisos.index'))
                <a href="{{ route('admin.avisos.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.avisos.*') ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.avisos.*') ? 'bg-indigo-500 dark:bg-indigo-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="Avisos" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.avisos.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Avisos e Banners</span>
                </a>
                @endif

                @if(Route::has('admin.carousel.index'))
                <a href="{{ route('admin.carousel.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.carousel.*') ? 'bg-pink-100 text-pink-700 dark:bg-pink-900/30 dark:text-pink-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.carousel.*') ? 'bg-pink-500 dark:bg-pink-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="images" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.carousel.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
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
                    <x-icon name="eye" class="w-3.5 h-3.5" style="duotone" />
                    Monitoramento
                </h3>
            </div>
            <div class="space-y-1">
                @if(Route::has('admin.audit.index'))
                <a href="{{ route('admin.audit.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.audit.*') ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.audit.*') ? 'bg-red-500 dark:bg-red-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="file-shield" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.audit.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Logs de Auditoria</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Notificacoes') && Route::has('admin.notificacoes.index'))
                <a href="{{ route('admin.notificacoes.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.notificacoes.*') ? 'bg-orange-100 text-orange-700 dark:bg-orange-900/30 dark:text-orange-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.notificacoes.*') ? 'bg-orange-500 dark:bg-orange-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-module-icon module="notificacoes" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.notificacoes.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
                    </div>
                    <span class="flex-1">Notificações</span>
                </a>
                @endif

                @if(\Nwidart\Modules\Facades\Module::isEnabled('Chat') && Route::has('admin.chat.index'))
                <a href="{{ route('admin.chat.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm transition-all duration-200 {{ request()->routeIs('admin.chat.*') ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 'text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-slate-700' }}">
                    <div class="flex-shrink-0 w-10 h-10 rounded-lg flex items-center justify-center {{ request()->routeIs('admin.chat.*') ? 'bg-blue-500 dark:bg-blue-600' : 'bg-gray-100 dark:bg-slate-700' }}">
                        <x-icon name="message-dots" style="duotone" class="w-5 h-5 {{ request()->routeIs('admin.chat.*') ? 'text-white' : 'text-gray-600 dark:text-gray-400' }}" />
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
                <x-icon name="shield-check" class="w-4 h-4 text-gray-400 dark:text-gray-500" style="duotone" />
                <p class="text-xs font-semibold text-gray-500 dark:text-gray-400">VERTEXSEMAGRI</p>
            </div>
            <p class="text-xs text-gray-400 dark:text-gray-500">v1.0.26</p>
        </div>
    </div>
</aside>
