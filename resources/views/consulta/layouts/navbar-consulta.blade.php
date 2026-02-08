<nav class="fixed top-0 left-0 right-0 z-50 h-16 bg-gradient-to-r from-blue-700 to-indigo-800 dark:from-blue-800 dark:to-indigo-900 shadow-lg border-b border-blue-600 dark:border-blue-700">
    <div class="flex items-center justify-between h-full px-4 sm:px-6 lg:px-8">
        <!-- Left Section: Mobile Menu + Logo -->
        <div class="flex items-center gap-4">
            <!-- Mobile menu button -->
            <button id="sidebarToggle" type="button" class="lg:hidden text-white/90 hover:text-white hover:bg-white/10 p-2 rounded-lg transition-colors">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            <!-- Logo and Brand -->
            <a href="{{ route('consulta.dashboard') }}" class="flex items-center gap-3 text-white hover:opacity-90 transition-opacity">
                <img src="{{ asset('images/logo-icon.svg') }}" alt="Logo" class="h-8 w-8 md:h-10 md:w-10">
                <div class="hidden sm:block">
                    <div class="text-xs font-semibold text-white/80 uppercase tracking-wider">Painel</div>
                    <div class="text-sm md:text-base font-bold text-white flex items-center gap-2">
                        Consulta
                        <span class="text-xs bg-blue-500/30 px-2 py-0.5 rounded-full border border-blue-400/50">Somente Leitura</span>
                    </div>
                </div>
            </a>
        </div>

        <!-- Right Section: Actions -->
        <div class="flex items-center gap-2 sm:gap-4">
            <!-- Dashboard Geral Link -->
            <a href="{{ route('consulta.dashboard') }}" class="hidden lg:flex items-center gap-2 text-white/90 hover:text-white hover:bg-white/10 px-3 py-2 rounded-lg transition-colors" title="Dashboard Consulta">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3v11.25A2.25 2.25 0 006 16.5h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0118 16.5h-2.25m-7.5 0h7.5m-7.5 0l-1 3m8.5-3l1 3m0 0l.5 1.5m-.5-1.5h-9.5m0 0l-.5 1.5M9 11.25v1.5M12 9v3.75m3-3.75v3.75m-3 .75h3.75m-3.75 0h-3.75" />
                </svg>
                <span class="hidden xl:inline text-sm font-medium">Dashboard Geral</span>
            </a>

            <!-- Notificações Dropdown -->
            @if(Route::has('consulta.notificacoes.index'))
            @php
                $unreadCount = \Illuminate\Support\Facades\DB::table('notifications')
                    ->where('user_id', auth()->id())
                    ->where('is_read', false)
                    ->count();

                $recentNotifications = \Illuminate\Support\Facades\DB::table('notifications')
                    ->where('user_id', auth()->id())
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
            @endphp
            <div class="relative" data-dropdown>
                <button data-dropdown-trigger type="button" class="relative p-2 rounded-lg text-white/90 hover:text-white hover:bg-white/10 transition-colors">
                    <svg class="h-5 w-5 md:h-6 md:w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>
                    @if($unreadCount > 0)
                    <span class="absolute top-1 right-1 h-4 w-4 bg-red-500 rounded-full flex items-center justify-center">
                        <span class="text-[10px] font-bold text-white">{{ $unreadCount > 9 ? '9+' : $unreadCount }}</span>
                    </span>
                    @endif
                </button>
                <div data-dropdown-menu class="hidden absolute right-0 mt-2 w-80 bg-white dark:bg-slate-800 rounded-xl shadow-xl z-50 border border-gray-200 dark:border-slate-700">
                    <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700 flex items-center justify-between">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white">Notificações</h3>
                        @if($unreadCount > 0)
                        <span class="text-xs font-semibold text-red-600 dark:text-red-400 bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded-full">
                            {{ $unreadCount }} não lida{{ $unreadCount > 1 ? 's' : '' }}
                        </span>
                        @endif
                    </div>
                    <div class="max-h-96 overflow-y-auto">
                        @forelse($recentNotifications as $notification)
                        <a href="{{ $notification->action_url ?? route('consulta.notificacoes.index') }}" class="block px-4 py-3 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors border-b border-gray-100 dark:border-slate-700 {{ !$notification->is_read ? 'bg-blue-50/50 dark:bg-blue-900/10' : '' }}">
                            <div class="flex items-start gap-3">
                                <div class="flex-shrink-0 mt-1">
                                    @php
                                        $iconColors = [
                                            'info' => 'text-blue-500',
                                            'success' => 'text-emerald-500',
                                            'warning' => 'text-amber-500',
                                            'error' => 'text-red-500',
                                            'system' => 'text-slate-500',
                                        ];
                                        $iconColor = $iconColors[$notification->type] ?? 'text-slate-500';
                                    @endphp
                                    <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-slate-700 flex items-center justify-center {{ $iconColor }}">
                                        @if($notification->type === 'success')
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        @elseif($notification->type === 'warning')
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                                            </svg>
                                        @elseif($notification->type === 'error')
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                                            </svg>
                                        @else
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-2">
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white line-clamp-1">{{ $notification->title }}</p>
                                        @if(!$notification->is_read)
                                        <span class="flex-shrink-0 w-2 h-2 bg-blue-500 rounded-full mt-1.5"></span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mt-1 line-clamp-2">{{ $notification->message }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}</p>
                                </div>
                            </div>
                        </a>
                        @empty
                        <div class="px-4 py-8 text-center">
                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-500 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                            </svg>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nenhuma notificação</p>
                        </div>
                        @endforelse
                    </div>
                    <div class="border-t border-gray-200 dark:border-slate-700 px-4 py-3">
                        <a href="{{ route('consulta.notificacoes.index') }}" class="block text-center text-sm font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                            Ver todas as notificações
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Theme Toggle -->
            <button id="themeToggle" type="button" class="relative w-10 h-10 md:w-11 md:h-11 rounded-lg bg-white/10 hover:bg-white/20 flex items-center justify-center transition-all duration-300 hover:scale-105 group" aria-label="Alternar tema">
                <span id="sunIcon" class="absolute transition-all duration-300 opacity-0 scale-0">
                    <svg class="w-5 h-5 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773l-1.591-1.591M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                    </svg>
                </span>
                <span id="moonIcon" class="absolute transition-all duration-300 opacity-0 scale-0">
                    <svg class="w-5 h-5 text-blue-300" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                    </svg>
                </span>
            </button>

            <!-- User Dropdown -->
            <div class="relative" data-dropdown>
                <button data-dropdown-trigger type="button" class="flex items-center gap-2 sm:gap-3 text-white/90 hover:text-white hover:bg-white/10 px-2 sm:px-3 py-2 rounded-lg transition-colors">
                    @if(auth()->user()->photo)
                        <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 md:w-9 md:h-9 rounded-full border-2 border-white/30 object-cover">
                    @else
                        <div class="w-8 h-8 md:w-9 md:h-9 rounded-full bg-white/20 flex items-center justify-center font-semibold text-white text-sm md:text-base">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="hidden lg:block text-left">
                        <div class="text-sm font-semibold text-white">{{ auth()->user()->name }}</div>
                        <div class="text-xs text-white/70">Consulta</div>
                    </div>
                    <svg class="hidden lg:block h-4 w-4 text-white/70" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <div data-dropdown-menu class="hidden absolute right-0 mt-2 w-56 bg-white dark:bg-slate-800 rounded-xl shadow-xl py-2 z-50 border border-gray-200 dark:border-slate-700">
                    <div class="px-4 py-3 border-b border-gray-200 dark:border-slate-700">
                        <div class="flex items-center gap-3">
                            @if(auth()->user()->photo)
                                <img src="{{ asset('storage/' . auth()->user()->photo) }}" alt="{{ auth()->user()->name }}" class="w-10 h-10 rounded-full border-2 border-gray-200 dark:border-slate-600 object-cover">
                            @else
                                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center font-semibold text-white">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="font-semibold text-gray-900 dark:text-white">{{ auth()->user()->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ auth()->user()->email }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="py-2">
                        <a href="{{ route('consulta.profile') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-slate-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            Perfil
                        </a>
                    </div>
                    <div class="border-t border-gray-200 dark:border-slate-700 py-2">
                        <button type="button" onclick="handleLogout()" class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                            </svg>
                            Sair
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>

