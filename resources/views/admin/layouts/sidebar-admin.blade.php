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
