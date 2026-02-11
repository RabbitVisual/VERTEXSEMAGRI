<div class="h-full flex flex-col bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800">
    <!-- Brand Section -->
    <div class="h-24 flex items-center gap-4 px-8 border-b border-slate-100 dark:border-slate-800 bg-gradient-to-br from-emerald-500/5 to-teal-500/5">
        <div class="w-12 h-12 bg-gradient-to-br from-emerald-600 to-teal-700 rounded-2xl flex items-center justify-center text-white shadow-xl shadow-emerald-600/20">
            <x-icon name="wheat-awn" style="duotone" class="w-7 h-7" />
        </div>
        <div class="flex flex-col">
            <h2 class="text-xl font-black text-slate-800 dark:text-white tracking-tighter leading-none">VERTEX</h2>
            <span class="text-[9px] font-black text-emerald-600 dark:text-emerald-500 uppercase tracking-[0.3em] mt-1.5 italic">Campo Panel v3</span>
        </div>
        <button @click="sidebarOpen = false" class="lg:hidden ml-auto w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-400">
            <x-icon name="xmark" class="w-5 h-5" />
        </button>
    </div>

    <!-- Navigation Menu -->
    <nav class="flex-1 overflow-y-auto pt-8 pb-4 px-4 space-y-8 scrollbar-hide">
        <!-- Main Actions -->
        <div class="space-y-2">
            <h3 class="px-6 text-[10px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-[0.3em] mb-4 flex items-center gap-2 italic">
                <span class="w-4 h-px bg-slate-200 dark:bg-slate-800"></span>
                Operacional
            </h3>

            <a href="{{ route('campo.dashboard') }}" class="group flex items-center gap-4 px-6 py-4 rounded-2xl transition-all duration-300 {{ request()->routeIs('campo.dashboard') ? 'bg-emerald-600 text-white shadow-xl shadow-emerald-600/20' : 'text-slate-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 hover:text-emerald-600' }}">
                <x-icon name="grid-2-plus" style="{{ request()->routeIs('campo.dashboard') ? 'solid' : 'duotone' }}" class="w-5 h-5 group-hover:scale-110 transition-transform" />
                <span class="text-[11px] font-black uppercase tracking-widest">Dash Intelligence</span>
            </a>

            @if(\Nwidart\Modules\Facades\Module::isEnabled('Ordens'))
            <a href="{{ route('campo.ordens.index') }}" class="group flex items-center gap-4 px-6 py-4 rounded-2xl transition-all duration-300 {{ request()->routeIs('campo.ordens.*') ? 'bg-emerald-600 text-white shadow-xl shadow-emerald-600/20' : 'text-slate-500 hover:bg-emerald-50 dark:hover:bg-emerald-900/10 hover:text-emerald-600' }}">
                <x-icon name="list-check" style="{{ request()->routeIs('campo.ordens.*') ? 'solid' : 'duotone' }}" class="w-5 h-5 group-hover:scale-110 transition-transform" />
                <span class="text-[11px] font-black uppercase tracking-widest">Ordens Táticas</span>
                @if(isset($pendingTasks) && $pendingTasks > 0)
                <span class="ml-auto w-5 h-5 flex items-center justify-center rounded-full bg-rose-500 text-white text-[8px] font-black animate-pulse shadow-lg">
                    {{ $pendingTasks }}
                </span>
                @endif
            </a>
            @endif
        </div>

        <!-- Logistics -->
        <div class="space-y-2">
            <h3 class="px-6 text-[10px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-[0.3em] mb-4 flex items-center gap-2 italic">
                <span class="w-4 h-px bg-slate-200 dark:bg-slate-800"></span>
                Logística / Materiais
            </h3>

            @if(\Nwidart\Modules\Facades\Module::isEnabled('Materiais'))
            <a href="{{ route('campo.materiais.solicitacoes.index') }}" class="group flex items-center gap-4 px-6 py-4 rounded-2xl transition-all duration-300 {{ request()->routeIs('campo.materiais.*') ? 'bg-amber-500 text-white shadow-xl shadow-amber-500/20' : 'text-slate-500 hover:bg-amber-50 dark:hover:bg-amber-900/10 hover:text-amber-600' }}">
                <x-icon name="box-open" style="{{ request()->routeIs('campo.materiais.*') ? 'solid' : 'duotone' }}" class="w-5 h-5 group-hover:scale-110 transition-transform" />
                <span class="text-[11px] font-black uppercase tracking-widest">Suprimentos</span>
            </a>
            @endif

            @if(\Nwidart\Modules\Facades\Module::isEnabled('Chat'))
            <a href="{{ route('campo.chat.page') }}" class="group flex items-center gap-4 px-6 py-4 rounded-2xl transition-all duration-300 {{ request()->routeIs('campo.chat.*') ? 'bg-blue-600 text-white shadow-xl shadow-blue-600/20' : 'text-slate-500 hover:bg-blue-50 dark:hover:bg-blue-900/10 hover:text-blue-600' }}">
                <x-icon name="messages" style="{{ request()->routeIs('campo.chat.*') ? 'solid' : 'duotone' }}" class="w-5 h-5 group-hover:scale-110 transition-transform" />
                <span class="text-[11px] font-black uppercase tracking-widest">Comunicação</span>
            </a>
            @endif
        </div>

        <!-- Configs -->
        <div class="space-y-2">
            <h3 class="px-6 text-[10px] font-black text-slate-400 dark:text-slate-600 uppercase tracking-[0.3em] mb-4 flex items-center gap-2 italic">
                <span class="w-4 h-px bg-slate-200 dark:bg-slate-800"></span>
                Autoproteção
            </h3>

            <a href="{{ route('campo.profile.index') }}" class="group flex items-center gap-4 px-6 py-4 rounded-2xl transition-all duration-300 {{ request()->routeIs('campo.profile.*') ? 'bg-slate-800 text-white shadow-xl shadow-slate-800/20' : 'text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-800' }}">
                <x-icon name="user-gear" style="{{ request()->routeIs('campo.profile.*') ? 'solid' : 'duotone' }}" class="w-5 h-5 group-hover:scale-110 transition-transform" />
                <span class="text-[11px] font-black uppercase tracking-widest">Configurar Conta</span>
            </a>
        </div>
    </nav>

    <!-- Sidebar Footer -->
    <div class="p-6 bg-slate-50/50 dark:bg-slate-950/50 border-t border-slate-100 dark:border-slate-800">
        <div class="premium-card p-5 bg-gradient-to-br from-slate-900 to-slate-800 dark:from-slate-800 dark:to-slate-900 text-white border-none shadow-2xl relative overflow-hidden group">
            <x-icon name="shield-halved" class="absolute -right-4 -bottom-4 w-24 h-24 text-white/5 group-hover:rotate-12 transition-transform duration-700" />
            <div class="relative z-10 flex flex-col gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                    <span class="text-[9px] font-black uppercase tracking-widest text-emerald-500 italic">Sistema Seguro</span>
                </div>
                <p class="text-[10px] font-bold text-slate-400 leading-tight uppercase tracking-tighter italic">Criptografia AES-256 Ativa em todas as comunicações de campo.</p>
                <div class="text-[10px] font-black text-white mt-2">ID: {{ str_pad(Auth::id(), 4, '0', STR_PAD_LEFT) }}</div>
            </div>
        </div>
    </div>
</div>
