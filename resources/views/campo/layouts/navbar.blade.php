<nav class="h-16 md:h-20 lg:h-24 bg-white/70 dark:bg-slate-900/70 backdrop-blur-xl border-b border-slate-200 dark:border-slate-800 flex items-center justify-between px-4 md:px-8 z-30 sticky top-0">
    <!-- Left: Menu Trigger & Context -->
    <div class="flex items-center gap-4">
        <button @click="sidebarOpen = true" class="lg:hidden w-10 h-10 flex items-center justify-center rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 hover:bg-emerald-500 hover:text-white transition-all shadow-sm active:scale-90">
            <x-icon name="bars-staggered" style="duotone" class="w-5 h-5" />
        </button>

        <div class="hidden sm:flex flex-col">
            <span class="text-[10px] font-black text-emerald-600 dark:text-emerald-500 uppercase tracking-[0.3em] leading-none mb-1">Status Operacional</span>
            <div class="flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_theme(colors.emerald.500)]"></span>
                <span class="text-xs font-black text-slate-700 dark:text-slate-200 uppercase tracking-tighter">Conectado ao Satélite</span>
            </div>
        </div>
    </div>

    <!-- Center: Search or Mini Dashboard (Optional) -->
    <div class="hidden lg:flex items-center px-4 py-2 bg-slate-100 dark:bg-slate-950 rounded-2xl border border-slate-200 dark:border-slate-800 min-w-[300px]">
        <x-icon name="magnifying-glass" class="w-4 h-4 text-slate-400 mr-3" />
        <input type="text" placeholder="PESQUISAR O.S OU MATERIAL..." class="bg-transparent border-none text-[10px] font-black uppercase tracking-widest text-slate-600 focus:ring-0 w-full placeholder:text-slate-400">
    </div>

    <!-- Right: Actions & Profile -->
    <div class="flex items-center gap-3 md:gap-4">
        <!-- Theme Toggle -->
        <button onclick="toggleTheme()" class="w-10 h-10 md:w-12 md:h-12 flex items-center justify-center rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-500 hover:text-emerald-500 transition-all shadow-sm active:scale-90 group relative">
            <x-icon name="sun-bright" style="duotone" class="w-5 h-5 dark:hidden group-hover:rotate-45" />
            <x-icon name="moon-stars" style="duotone" class="w-5 h-5 hidden dark:block group-hover:-rotate-12" />
        </button>

        <!-- Profile Dropdown -->
        <div class="relative" x-data="{ open: false }">
            <button @click="open = !open" class="flex items-center gap-3 p-1.5 md:p-2 bg-slate-100 dark:bg-slate-800 rounded-2xl border border-slate-200 dark:border-slate-800 hover:border-emerald-500/30 transition-all active:scale-95 group">
                <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 flex items-center justify-center text-white font-black text-sm shadow-lg group-hover:rotate-3 transition-transform">
                    @if(Auth::user()->photo)
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" class="w-full h-full object-cover rounded-xl">
                    @else
                        {{ substr(Auth::user()->name, 0, 1) }}
                    @endif
                </div>
                <div class="hidden md:flex flex-col text-left">
                    <span class="text-xs font-black text-slate-700 dark:text-slate-200 uppercase tracking-tighter leading-none">{{ explode(' ', Auth::user()->name)[0] }}</span>
                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest mt-1">Nível Campo</span>
                </div>
                <x-icon name="chevron-down" class="hidden md:block w-3 h-3 text-slate-400 group-hover:text-emerald-500 transition-all" x-bind:class="open ? 'rotate-180' : ''" />
            </button>

            <!-- Premium Dropdown Menu -->
            <div x-show="open"
                 @click.away="open = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                 class="absolute right-0 mt-3 w-64 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl shadow-2xl z-50 overflow-hidden py-2">

                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1 italic">Agente Identificado</p>
                    <p class="text-sm font-black text-slate-800 dark:text-white truncate uppercase">{{ Auth::user()->name }}</p>
                </div>

                <div class="p-2 space-y-1">
                    <a href="{{ route('campo.profile.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-2xl text-slate-600 dark:text-slate-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 hover:text-emerald-600 transition-all group">
                        <x-icon name="user-vneck" style="duotone" class="w-5 h-5 group-hover:scale-110 transition-transform" />
                        <span class="text-[10px] font-black uppercase tracking-widest">Acessar Perfil</span>
                    </a>

                    <form method="POST" action="{{ route('logout') }}" id="logout-form">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-4 px-4 py-3 rounded-2xl text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-all group">
                            <x-icon name="power-off" style="duotone" class="w-5 h-5 group-hover:rotate-12" />
                            <span class="text-[10px] font-black uppercase tracking-widest">Encerrar Sessão</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
    function toggleTheme() {
        const html = document.documentElement;
        const currentTheme = html.classList.contains('dark') ? 'light' : 'dark';
        html.classList.toggle('dark');
        localStorage.setItem('theme', currentTheme);
    }
</script>
