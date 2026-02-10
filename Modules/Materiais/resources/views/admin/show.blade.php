@extends('admin.layouts.admin')

@section('title', $material->nome . ' - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in font-poppins pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-64 h-64 bg-emerald-50/50 dark:bg-emerald-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-emerald-500 to-emerald-700 rounded-2xl flex items-center justify-center shadow-lg shadow-emerald-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon name="boxes-stacked" style="duotone" class="w-7 h-7 md:w-8 md:h-8" />
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-1 leading-tight">
                        {{ $material->nome }}
                    </h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <a href="{{ route('admin.materiais.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors font-bold">Materiais</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                        <span class="text-gray-900 dark:text-white">{{ $material->codigo }}</span>
                    </nav>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.materiais.index') }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 transition-all duration-300 shadow-sm active:scale-95">
                    <x-icon name="arrow-left" style="duotone" class="w-5 h-5" />
                    Listagem
                </a>
                <a href="{{ route('materiais.show', $material->id) }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all duration-300 active:scale-95 border-b-4 border-emerald-800">
                    <x-icon name="eye" style="duotone" class="w-5 h-5" />
                    Painel Público
                </a>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 mb-6 text-sm text-emerald-800 rounded-2xl bg-emerald-50 border border-emerald-100 dark:bg-emerald-900/20 dark:text-emerald-400 dark:border-emerald-800/50 flex items-center gap-3 animate-slide-in">
        <x-icon name="circle-check" class="w-5 h-5" style="duotone" />
        <span class="font-bold tracking-tight">{{ session('success') }}</span>
    </div>
    @endif

    <!-- Painel de Indicadores do Material -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach([
            ['label' => 'Entradas Acumuladas', 'value' => $estatisticas['entradas_total'] ?? 0, 'icon' => 'arrow-right-to-bracket', 'color' => 'emerald', 'gradient' => 'from-emerald-500 to-emerald-600', 'suffix' => $material->unidade_medida],
            ['label' => 'Saídas Acumuladas', 'value' => $estatisticas['saidas_total'] ?? 0, 'icon' => 'arrow-right-from-bracket', 'color' => 'red', 'gradient' => 'from-red-500 to-red-600', 'suffix' => $material->unidade_medida],
            ['label' => 'Estoque Disponível', 'value' => $estatisticas['saldo_atual'] ?? 0, 'icon' => 'scale-balanced', 'color' => 'indigo', 'gradient' => 'from-indigo-500 to-indigo-600', 'suffix' => $material->unidade_medida],
            ['label' => 'Uso em O.S.', 'value' => $estatisticas['total_os'] ?? 0, 'icon' => 'hammer', 'color' => 'amber', 'gradient' => 'from-amber-500 to-amber-600', 'suffix' => 'OS']
        ] as $stat)
        <div class="group relative bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br {{ $stat['gradient'] }} rounded-xl flex items-center justify-center text-white shadow-lg shadow-{{ $stat['color'] }}-200 dark:shadow-none transition-transform group-hover:scale-110">
                    <x-icon name="{{ $stat['icon'] }}" style="duotone" class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">{{ $stat['label'] }}</p>
                    <div class="flex items-center gap-1.5 mt-0.5">
                        <p class="text-2xl font-black text-gray-900 dark:text-white">
                            {{ formatar_quantidade($stat['value'], $stat['suffix']) }}
                        </p>
                        <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">{{ $stat['suffix'] }}</span>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r {{ $stat['gradient'] }} opacity-0 group-hover:opacity-100 transition-opacity rounded-b-2xl"></div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Detalhes do Registro -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700/50 bg-gray-50/30 dark:bg-slate-900/30 flex items-center justify-between">
                    <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                        <x-icon name="circle-info" style="duotone" class="w-4 h-4 text-emerald-500" />
                        Informações do Ativo
                    </h3>
                    @if($material->ativo)
                        <div class="flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400 font-black text-[10px] uppercase tracking-widest px-3 py-1 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg border border-emerald-100 dark:border-emerald-800/50">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50 animate-pulse"></div>
                            Disponível
                        </div>
                    @else
                        <div class="flex items-center gap-1.5 text-red-600 dark:text-red-400 font-black text-[10px] uppercase tracking-widest px-3 py-1 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-100 dark:border-red-800/50">
                            <div class="w-2 h-2 rounded-full bg-red-500 shadow-sm shadow-red-500/50"></div>
                            Retirado
                        </div>
                    @endif
                </div>
                <div class="p-8 md:p-10">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-10">
                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Identificador / SKU</label>
                            <div class="relative group">
                                <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-emerald-500 to-emerald-600 rounded-full h-full opacity-50"></div>
                                <p class="text-lg font-black text-gray-900 dark:text-white pl-4 tracking-tight">
                                    {{ $material->codigo }}
                                </p>
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Classificação Estrutural</label>
                            <p class="text-base font-bold text-emerald-600 dark:text-emerald-400 flex items-center gap-2">
                                <x-icon name="tag" class="w-4 h-4" />
                                {{ $material->subcategoria->categoria->nome ?? 'ESPECÍFICO' }}
                            </p>
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Nomenclature Oficial</label>
                            <p class="text-2xl font-black text-gray-900 dark:text-white leading-[1.1] tracking-tight">
                                {{ $material->nome }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest font-poppins">Saldo em Almoxarifado</label>
                            @php
                                $baixoEstoque = $material->estaComEstoqueBaixo();
                            @endphp
                            <div class="flex items-baseline gap-2">
                                <span class="text-3xl font-black {{ $baixoEstoque ? 'text-red-500' : 'text-gray-900 dark:text-white' }}">
                                    {{ formatar_quantidade($material->quantidade_estoque ?? 0, $material->unidade_medida) }}
                                </span>
                                <span class="text-xs font-black text-slate-400 uppercase tracking-widest">{{ $material->unidade_medida ?? 'UN' }}</span>
                                @if($baixoEstoque)
                                    <span class="ml-2 px-2 py-0.5 text-[9px] font-black uppercase rounded bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 border border-red-200 animate-pulse tracking-tighter">ESTOQUE CRÍTICO</span>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Limite Mínimo de Alerta</label>
                            <p class="text-base font-black text-gray-900 dark:text-white">
                                {{ $material->quantidade_minima ? formatar_quantidade($material->quantidade_minima, $material->unidade_medida) . ' ' . strtoupper($material->unidade_medida ?? 'UN') : 'NÃO CONFIGURADO' }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Preço de Aquisição (Unit)</label>
                            <p class="text-base font-black text-gray-900 dark:text-white flex items-center gap-1">
                                <span class="text-xs font-bold text-slate-400">R$</span>
                                {{ number_format($material->valor_unitario ?? 0, 2, ',', '.') }}
                            </p>
                        </div>

                        <div class="space-y-2">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Capitalização de Estoque</label>
                            <p class="text-lg font-black text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                                <span class="text-xs font-bold opacity-60">R$</span>
                                {{ number_format(($material->quantidade_estoque ?? 0) * ($material->valor_unitario ?? 0), 2, ',', '.') }}
                            </p>
                        </div>

                        @if($material->fornecedor)
                        <div class="md:col-span-2 space-y-2 pt-4 mt-4 border-t border-dashed border-gray-100 dark:border-slate-700">
                            <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Parceiro de Fornecimento</label>
                            <div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-900 p-4 rounded-2xl border border-gray-100 dark:border-slate-700">
                                <div class="w-10 h-10 rounded-xl bg-white dark:bg-slate-800 flex items-center justify-center text-slate-400 shadow-sm">
                                    <x-icon name="truck-field" style="duotone" class="w-5 h-5" />
                                </div>
                                <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">
                                    {{ $material->fornecedor }}
                                </p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Ordens de Serviço Recentemente Associadas -->
            @if(isset($ordensRecentes) && $ordensRecentes->count() > 0)
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700/50 bg-gray-50/30 dark:bg-slate-900/30 flex items-center justify-between">
                    <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                        <x-icon name="hammer" style="duotone" class="w-4 h-4 text-amber-500" />
                        Histórico de Utilização (O.S)
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] text-slate-400 uppercase tracking-widest bg-slate-50/50 dark:bg-slate-900/50 font-black">
                            <tr>
                                <th class="px-6 py-4">Protocolo de Ordem</th>
                                <th class="px-6 py-4">Equipe Operacional</th>
                                <th class="px-6 py-4">Carga Utilizada</th>
                                <th class="px-6 py-4 text-right">Controle</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-slate-700/50 font-medium">
                            @foreach($ordensRecentes as $ordem)
                            <tr class="hover:bg-amber-50/30 dark:hover:bg-amber-900/5 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-black text-gray-900 dark:text-white group-hover:text-amber-600 transition-colors tracking-tight">
                                        #{{ $ordem->numero }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-tight">{{ $ordem->equipe->nome ?? 'EQUIPE GERAL' }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $pivot = $ordem->pivot ?? null;
                                        $quantidadeAsso = $pivot ? $pivot->quantidade : 0;
                                    @endphp
                                    <div class="flex items-center gap-1.5 font-black text-gray-900 dark:text-white">
                                        {{ formatar_quantidade($quantidadeAsso, $material->unidade_medida) }}
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $material->unidade_medida }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.ordens.show', $ordem->id) }}" class="inline-flex items-center justify-center w-9 h-9 text-amber-600 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-xl hover:bg-amber-600 hover:text-white transition-all active:scale-95 shadow-sm">
                                        <x-icon name="eye" style="duotone" class="w-4 h-4" />
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Log de Movimentações -->
            @if($material->movimentacoes && $material->movimentacoes->count() > 0)
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700/50 bg-gray-50/30 dark:bg-slate-900/30 flex items-center justify-between">
                    <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                        <x-icon name="clock-rotate-left" style="duotone" class="w-4 h-4 text-emerald-500" />
                        Fluxo de Movimentação Cronológica
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="text-[10px] text-slate-400 uppercase tracking-widest bg-slate-50/50 dark:bg-slate-900/50 font-black">
                            <tr>
                                <th class="px-6 py-4 tracking-tighter">Instantâneo / Data</th>
                                <th class="px-6 py-4">Operação</th>
                                <th class="px-6 py-4">Variação</th>
                                <th class="px-6 py-4">Validado</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 dark:divide-slate-700/50 font-medium">
                            @foreach($material->movimentacoes as $movimentacao)
                            <tr class="hover:bg-emerald-50/20 dark:hover:bg-emerald-900/5 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-xs font-black text-gray-900 dark:text-white tracking-tight">{{ $movimentacao->created_at->format('d/m/Y') }}</span>
                                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">{{ $movimentacao->created_at->format('H:i:s') }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php $isEntrada = $movimentacao->tipo === 'entrada'; @endphp
                                    <span class="inline-flex items-center gap-1.5 font-black text-[10px] uppercase tracking-widest px-2.5 py-1 rounded-lg {{ $isEntrada ? 'bg-emerald-50 text-emerald-700 border border-emerald-100 dark:bg-emerald-900/30' : 'bg-red-50 text-red-700 border border-red-100 dark:bg-red-900/30' }}">
                                        <x-icon name="{{ $isEntrada ? 'circle-plus' : 'circle-minus' }}" class="w-3.5 h-3.5" />
                                        {{ $movimentacao->tipo }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-base font-black tracking-tight {{ $isEntrada ? 'text-emerald-600' : 'text-red-500' }}">
                                        {{ $isEntrada ? '+' : '-' }} {{ formatar_quantidade($movimentacao->quantidade, $material->unidade_medida) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">{{ $movimentacao->status ?? 'EFETIVADA' }}</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- Meta / Context Information Side -->
        <div class="space-y-6">
            <!-- Glass Card: Quality -->
            <div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-xl rounded-3xl p-8 shadow-sm border border-gray-100 dark:border-slate-700/50 relative overflow-hidden group">
                <div class="absolute -right-12 -bottom-12 w-40 h-40 bg-indigo-50 dark:bg-indigo-900/10 rounded-full group-hover:scale-125 transition-transform duration-700"></div>

                <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8 border-b border-gray-100 dark:border-slate-700/50 pb-4">Conformidade e Qualidade</h4>

                <div class="space-y-8 relative z-10">
                    <div class="flex gap-4">
                        <div class="w-12 h-12 shrink-0 rounded-2xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 shadow-sm transition-transform group-hover:rotate-6">
                            <x-icon name="shield-check" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-sm font-black text-gray-900 dark:text-white leading-none mb-1">Padrão de Qualidade</p>
                            <p class="text-[11px] text-slate-500 dark:text-gray-400 font-bold uppercase tracking-tight">Material Verificado e Apto para Uso</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-12 h-12 shrink-0 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shadow-sm transition-transform group-hover:-rotate-6">
                            <x-icon name="clipboard-check" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-sm font-black text-gray-900 dark:text-white leading-none mb-1">Rastreabilidade</p>
                            <p class="text-[11px] text-slate-500 dark:text-gray-400 font-bold uppercase tracking-tight">Cadeia de Custódia Totalmente Ativa</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Promotion Card: Logistics -->
            <div class="bg-gradient-to-br from-indigo-900 to-slate-900 rounded-3xl p-8 text-white relative overflow-hidden group shadow-2xl shadow-indigo-500/10">
                <div class="absolute right-0 top-0 w-32 h-32 bg-emerald-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-indigo-500/10 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>

                <div class="relative z-10 space-y-6">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center shadow-lg shadow-emerald-500/20 transform group-hover:scale-110 transition-transform">
                        <x-icon name="warehouse" style="duotone" class="w-7 h-7 text-white" />
                    </div>
                    <div>
                        <h4 class="text-xl font-black mb-3 leading-tight tracking-tight">Inteligência de Suprimentos</h4>
                        <p class="text-xs text-indigo-100/70 leading-relaxed font-medium">A gestão preditiva de estoque evita interrupções operacionais e otimiza o capital público investido em insumos e ferramentas.</p>
                    </div>
                    <div class="pt-4 flex items-center gap-2">
                        <div class="h-1 flex-1 bg-white/10 rounded-full overflow-hidden">
                            <div class="h-full bg-emerald-400 w-full animate-pulse-slow"></div>
                        </div>
                        <span class="text-[9px] font-black uppercase tracking-widest text-emerald-400">Sistema Seguro</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
