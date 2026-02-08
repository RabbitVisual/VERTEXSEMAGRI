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
                <x-icon name="eye" class="w-5 h-5" />
            </div>
            <div>
                <h2 class="text-sm font-bold text-slate-200">Menu Consulta</h2>
                <p class="text-xs text-slate-400">Somente Leitura</p>
            </div>
        </div>
        <!-- Close button mobile -->
        <button onclick="toggleConsultaSidebar()" class="lg:hidden p-2 rounded-lg text-slate-400 hover:text-slate-200 hover:bg-slate-700">
            <x-icon name="eye" class="w-5 h-5" />
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
                    <x-icon name="eye" class="w-5 h-5" />
                <p class="text-xs font-semibold text-slate-400">MODO CONSULTA</p>
            </div>
            <p class="text-xs text-slate-600">Somente Leitura</p>
        </div>
    </div>
</nav>

