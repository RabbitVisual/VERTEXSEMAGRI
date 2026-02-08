<aside class="flex flex-col h-full bg-white dark:bg-slate-900 border-r border-gray-200/50 dark:border-slate-800/50">
    <div class="flex items-center justify-between p-6 border-b border-gray-100 dark:border-slate-800">
        <div class="flex items-center gap-3">
            <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center">
                <svg class="w-5 h-5 text-slate-500 dark:text-slate-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12H12m-8.25 5.25h16.5" />
                </svg>
            </div>
            <h2 class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest">Navegação</h2>
        </div>
    </div>

    <nav class="flex-1 overflow-y-auto p-4 space-y-2 custom-scrollbar">
        @php
            $links = [
                ['route' => 'lider-comunidade.dashboard', 'label' => 'Dashboard', 'icon' => 'M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25'],
                ['route' => 'lider-comunidade.usuarios.index', 'label' => 'Usuários', 'icon' => 'M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z'],
                ['route' => 'lider-comunidade.mensalidades.index', 'label' => 'Mensalidades', 'icon' => 'M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5'],
                ['route' => 'lider-comunidade.solicitacoes-baixa.index', 'label' => 'Baixas', 'icon' => 'M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h11.25c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z'],
                ['route' => 'lider-comunidade.relatorios.index', 'label' => 'Relatórios', 'icon' => 'M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z']
            ];
        @endphp

        @foreach($links as $link)
            @php $isActive = request()->routeIs($link['route'] . '*'); @endphp
            <a href="{{ route($link['route']) }}"
               class="flex items-center gap-3 p-3 rounded-xl transition-all duration-200 group {{ $isActive ? 'nav-link-active' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                <svg class="w-5 h-5 {{ $isActive ? 'text-white' : 'text-slate-400 group-hover:text-slate-600 dark:group-hover:text-slate-300' }}" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $link['icon'] }}"/>
                </svg>
                <span class="font-semibold text-sm">{{ $link['label'] }}</span>
                @if($link['route'] === 'lider-comunidade.solicitacoes-baixa.index' && isset($solicitacoesPendentes) && $solicitacoesPendentes > 0)
                    <span class="ml-auto w-5 h-5 flex items-center justify-center bg-red-500 text-white text-[10px] font-bold rounded-lg shadow-sm">
                        {{ $solicitacoesPendentes }}
                    </span>
                @endif
            </a>
        @endforeach
    </nav>
</aside>

<script>
function toggleSidebar() {
    const drawer = document.getElementById('drawer-navigation');
    drawer.classList.toggle('-translate-x-full');
}
</script>
