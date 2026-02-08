<nav class="fixed top-0 z-50 w-full bg-glass border-b border-gray-200/50 dark:border-slate-700/50">
    <div class="px-4 py-3 lg:px-6">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button data-drawer-target="drawer-navigation" data-drawer-toggle="drawer-navigation" aria-controls="drawer-navigation" class="p-2 text-gray-500 rounded-xl lg:hidden hover:bg-gray-100 dark:hover:bg-slate-700/50 transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" />
                    </svg>
                    <span class="sr-only">Menu</span>
                </button>
                <a href="{{ route('lider-comunidade.dashboard') }}" class="flex items-center gap-3">
                    <img src="{{ asset('images/logo-icon.svg') }}" alt="Logo" class="w-10 h-10 object-contain">
                    <div>
                        <span class="block text-lg font-bold text-gray-900 dark:text-white leading-tight">Painel Líder</span>
                        <span class="block text-xs font-medium text-gray-500 dark:text-slate-400 uppercase tracking-wider">Comunidade</span>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-3">
                <div class="hidden sm:flex items-center gap-3 px-4 py-2 bg-gray-100/50 dark:bg-slate-700/30 rounded-xl border border-gray-200/50 dark:border-slate-600/30">
                    <div class="w-8 h-8 rounded-lg bg-white dark:bg-slate-600 flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                    </div>
                    <span class="text-sm font-semibold text-gray-700 dark:text-slate-200">{{ Auth::user()->name ?? 'Líder' }}</span>
                </div>

                <!-- Theme Toggle -->
                <button type="button" id="darkModeToggle" onclick="toggleTheme()" class="p-2.5 text-gray-500 rounded-xl hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-slate-700/50 transition-all border border-transparent dark:hover:border-slate-700" title="Alternar tema">
                    <span id="theme-icon-sun" class="transition-all duration-300">
                        <svg class="w-6 h-6 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773l-1.591-1.591M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                        </svg>
                    </span>
                    <span id="theme-icon-moon" class="transition-all duration-300 hidden">
                        <svg class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                        </svg>
                    </span>
                </button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="p-2.5 text-red-500 bg-red-50 dark:bg-red-900/10 rounded-xl hover:bg-red-100 dark:hover:bg-red-900/20 transition-all border border-red-100 dark:border-red-900/20" title="Sair do Sistema">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>
