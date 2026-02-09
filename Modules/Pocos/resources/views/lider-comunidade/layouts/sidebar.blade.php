<aside class="flex flex-col h-full bg-white dark:bg-slate-900 border-r border-gray-100 dark:border-slate-800">
    <!-- Header/Logo Area -->
    <div class="flex items-center justify-between p-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/30 dark:bg-slate-900/50">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                <x-icon name="handshake" style="duotone" class="w-6 h-6" />
            </div>
            <div>
                <h2 class="text-xs font-black text-slate-900 dark:text-white uppercase tracking-tight">Portal Líder</h2>
                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest">Gestão de Campo</p>
            </div>
        </div>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 overflow-y-auto p-5 space-y-2 py-8">
        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em] px-3 mb-4">Navegação Principal</p>

        @php
            $links = [
                ['route' => 'lider-comunidade.dashboard', 'label' => 'Painel Central', 'icon' => 'grid-horizontal'],
                ['route' => 'lider-comunidade.usuarios.index', 'label' => 'Meus Moradores', 'icon' => 'users-rectangle'],
                ['route' => 'lider-comunidade.mensalidades.index', 'label' => 'Ciclos de Cobrança', 'icon' => 'money-bills'],
                ['route' => 'lider-comunidade.solicitacoes-baixa.index', 'label' => 'Demandas de Baixa', 'icon' => 'clipboard-check'],
                ['route' => 'lider-comunidade.relatorios.index', 'label' => 'Resumo Mensal', 'icon' => 'chart-pie-simple']
            ];
        @endphp

        @foreach($links as $link)
            @php $isActive = request()->routeIs($link['route'] . '*'); @endphp
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-3 px-4 py-3.5 rounded-2xl transition-all duration-300 group {{ $isActive ? 'bg-slate-900 dark:bg-blue-600 text-white shadow-xl shadow-slate-900/10 dark:shadow-blue-500/10' : 'text-slate-500 dark:text-slate-400 hover:bg-gray-50 dark:hover:bg-slate-800/50 hover:pl-6' }}">
                <x-icon name="{{ $link['icon'] }}"
                       style="{{ $isActive ? 'duotone' : 'light' }}"
                       class="w-5 h-5 {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-blue-500 transition-colors' }}" />

                <span class="text-[11px] font-black uppercase tracking-widest">{{ $link['label'] }}</span>

                @if($link['route'] === 'lider-comunidade.solicitacoes-baixa.index' && isset($solicitacoesPendentes) && $solicitacoesPendentes > 0)
                    <span class="ml-auto flex h-5 min-w-[20px] px-1.5 items-center justify-center bg-rose-500 text-white text-[9px] font-black rounded-lg shadow-sm animate-pulse">
                        {{ $solicitacoesPendentes }}
                    </span>
                @endif
            </a>
        @endforeach
    </nav>

    <!-- Project Branding -->
    <div class="p-6 border-t border-gray-100 dark:border-slate-800">
        <div class="p-4 bg-gray-50 dark:bg-slate-950 rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-blue-600/10 flex items-center justify-center text-blue-600">
                <x-icon name="v" class="w-4 h-4 font-black" />
            </div>
            <div class="text-[10px] font-black text-slate-400 uppercase tracking-widest italic">
                Vertex <span class="text-blue-600">Agri</span>
            </div>
        </div>
    </div>
</aside>
