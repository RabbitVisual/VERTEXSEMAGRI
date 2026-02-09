<nav class="fixed top-0 z-[60] w-full bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-gray-100 dark:border-slate-800">
    <div class="px-6 py-3">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-6">
                <!-- Mobile Toggle -->
                <button onclick="toggleSidebar()" class="p-2.5 text-slate-500 rounded-2xl lg:hidden hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors border border-gray-100 dark:border-slate-800">
                    <x-icon name="bars-staggered" class="w-6 h-6" />
                </button>

                <!-- Brand -->
                <a href="{{ route('lider-comunidade.dashboard') }}" class="flex items-center gap-4 group">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-600 to-indigo-700 flex items-center justify-center text-white shadow-lg group-hover:rotate-6 transition-transform">
                        <x-icon name="v" class="w-7 h-7 font-black" />
                    </div>
                    <div class="hidden sm:block">
                        <span class="block text-lg font-black text-gray-900 dark:text-white leading-none uppercase tracking-tight">Vertex Agri</span>
                        <span class="block text-[9px] font-black text-blue-600 uppercase tracking-[0.2em] mt-1">Painel Líder Distrital</span>
                    </div>
                </a>
            </div>

            <div class="flex items-center gap-4">
                <!-- User Profile Quick View -->
                <div class="hidden md:flex items-center gap-3 pl-2 pr-5 py-2 bg-gray-50 dark:bg-slate-950 rounded-2xl border border-gray-100 dark:border-slate-800">
                    <div class="w-9 h-9 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center text-blue-600 shadow-sm border border-blue-50 dark:border-blue-900/20">
                        <x-icon name="user-tie" style="duotone" class="w-5 h-5" />
                    </div>
                    <div class="flex flex-col">
                        <span class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ Auth::user()->name ?? 'Líder' }}</span>
                        <span class="text-[8px] font-black text-slate-400 uppercase tracking-widest">Agente Ativo</span>
                    </div>
                </div>

                <!-- Action Group -->
                <div class="flex items-center gap-2 border-l border-gray-100 dark:border-slate-800 ml-2 pl-4">
                    <!-- Theme Toggle -->
                    <button type="button" onclick="window.toggleTheme && window.toggleTheme()" class="p-2.5 text-slate-500 rounded-2xl hover:bg-gray-100 dark:text-slate-400 dark:hover:bg-slate-800 transition-all border border-transparent dark:hover:border-slate-800" title="Alternar Visão">
                        <x-icon name="circle-half-stroke" style="duotone" class="w-5 h-5" />
                    </button>

                    <!-- Exit -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="p-2.5 text-rose-500 bg-rose-50 dark:bg-rose-900/10 rounded-2xl hover:bg-rose-500 hover:text-white transition-all border border-rose-100 dark:border-rose-900/20 hover:border-rose-500 shadow-sm" title="Finalizar Sessão">
                            <x-icon name="power-off" class="w-5 h-5" />
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>
