<nav class="sticky top-0 z-30 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md border-b border-gray-200 dark:border-gray-700 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16 md:h-20">
            <!-- Left Section: Logo + Mobile Menu -->
            <div class="flex items-center gap-4">
                <!-- Mobile menu button -->
                <button type="button" @click="sidebarOpen = !sidebarOpen" class="lg:hidden inline-flex items-center justify-center p-2 rounded-lg text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500 transition-all duration-200">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <!-- Logo -->
                <a href="{{ route('campo.dashboard') }}" class="flex items-center gap-3 hover:opacity-80 transition-opacity group">
                    <div class="relative">
                        <img src="{{ asset('images/logo-vertex-semagri.svg') }}" alt="Vertex SEMAGRI" class="h-10 md:h-12 w-auto transition-transform group-hover:scale-105">
                    </div>
                    <div class="hidden sm:block">
                        <div class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Painel</div>
                        <div class="text-sm font-bold text-gray-900 dark:text-white">Campo</div>
                    </div>
                </a>
            </div>

            <!-- Right Section: Actions -->
            <div class="flex items-center gap-2 sm:gap-4">
                @auth
                    <!-- Connection Status Badge - HyperUI Badge Style -->
                    <div id="connection-status" class="connection-badge online">
                        <span class="status-dot"></span>
                        <span class="hidden sm:inline">Online</span>
                    </div>

                    <!-- Sync Button - HyperUI Button Style -->
                    <button type="button" onclick="sincronizarAgora()" class="relative w-10 h-10 md:w-11 md:h-11 rounded-lg bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 flex items-center justify-center transition-all duration-300 hover:scale-105 active:scale-95 shadow-sm" title="Sincronizar dados">
                        <svg id="sync-indicator" class="w-5 h-5 text-orange-500 hidden" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" id="sync-icon-default" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                        <span id="pending-count-badge" class="pending-badge hidden">0</span>
                    </button>

                    <!-- Theme toggle - HyperUI Toggle Style -->
                    <button type="button" id="themeToggle" onclick="toggleTheme()" class="relative w-10 h-10 md:w-11 md:h-11 rounded-lg bg-gray-100 dark:bg-slate-700 hover:bg-gray-200 dark:hover:bg-slate-600 flex items-center justify-center transition-all duration-300 hover:scale-105 active:scale-95 shadow-sm group" aria-label="Alternar tema">
                        <span id="sunIcon" class="absolute transition-all duration-300 opacity-0 scale-0">
                            <svg class="w-5 h-5 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773l-1.591-1.591M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                            </svg>
                        </span>
                        <span id="moonIcon" class="absolute transition-all duration-300 opacity-0 scale-0">
                            <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                            </svg>
                        </span>
                    </button>

                    <!-- User menu - HyperUI Dropdown Style -->
                    <div class="relative" x-data="{ open: false }" @click.away="open = false">
                        <button @click="open = !open" type="button" class="flex items-center gap-2 sm:gap-3 p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition-all duration-200 active:scale-95">
                            @if(Auth::user()->photo)
                                <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="{{ Auth::user()->name }}" class="h-8 w-8 md:h-9 md:w-9 rounded-full ring-2 ring-gray-200 dark:ring-gray-700 shadow-sm">
                            @else
                                <div class="h-8 w-8 md:h-9 md:w-9 rounded-full bg-gradient-to-br from-indigo-500 to-indigo-600 flex items-center justify-center text-white font-semibold text-sm md:text-base ring-2 ring-gray-200 dark:ring-gray-700 shadow-sm">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                                </div>
                            @endif
                            <div class="hidden sm:block text-left">
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400">Funcionário de Campo</div>
                            </div>
                            <svg class="hidden sm:block h-4 w-4 text-gray-400 transition-transform" :class="{'rotate-180': open}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>

                        <!-- Dropdown menu - HyperUI Dropdown -->
                        <div x-show="open"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95"
                             class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-xl shadow-xl py-2 z-50 border border-gray-200 dark:border-gray-700 backdrop-blur-sm"
                             style="display: none;">
                            <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="{{ route('campo.profile.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0012 15.75a7.488 7.488 0 00-5.982 2.975m11.963 0a9 9 0 10-11.963 0m11.963 0A8.966 8.966 0 0112 21a8.966 8.966 0 01-5.982-2.275M15 9.75a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Meu Perfil
                            </a>
                            <button type="button" onclick="handleLogout()" class="w-full text-left flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" />
                                </svg>
                                Sair
                            </button>
                        </div>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>
