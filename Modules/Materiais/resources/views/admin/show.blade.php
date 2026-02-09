@extends('admin.layouts.admin')

@section('title', $material->nome . ' - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="boxes-stacked" style="duotone" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>{{ $material->nome }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <a href="{{ route('admin.materiais.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Materiais</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <span class="text-gray-900 dark:text-white font-medium">{{ $material->nome }}</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.materiais.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <x-icon name="arrow-left" style="duotone" class="w-5 h-5" />
                Voltar
            </a>
            <a href="{{ route('materiais.show', $material->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors">
                <x-icon name="eye" style="duotone" class="w-5 h-5" />
                Ver no Painel Padrão
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <div class="flex items-center">
            <x-icon name="circle-check" style="duotone" class="w-4 h-4 me-3" />
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Estatísticas do Material -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Entradas Acumuladas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($estatisticas['entradas_total'] ?? 0, 2, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800/50">
                    <x-icon name="arrow-right-to-bracket" style="duotone" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Saídas Acumuladas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($estatisticas['saidas_total'] ?? 0, 2, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-red-50 dark:bg-red-900/20 rounded-xl border border-red-100 dark:border-red-800/50">
                    <x-icon name="arrow-right-from-bracket" style="duotone" class="w-6 h-6 text-red-600 dark:text-red-400" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Estoque Disponível</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($estatisticas['saldo_atual'] ?? 0, 2, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800/50">
                    <x-icon name="scale-balanced" style="duotone" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Uso em O.S.</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['total_os'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800/50">
                    <x-icon name="hammer" style="duotone" class="w-6 h-6 text-amber-600 dark:text-amber-400" />
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Detalhes do Registro -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-slate-700/50 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <x-icon name="circle-info" style="duotone" class="w-4 h-4 text-emerald-500" />
                        Propriedades do Material
                    </h3>
                    @if($material->ativo)
                        <span class="px-2.5 py-1 text-[10px] font-black uppercase rounded-lg border bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50">Ativo</span>
                    @else
                        <span class="px-2.5 py-1 text-[10px] font-black uppercase rounded-lg border bg-red-50 text-red-700 border-red-100 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800/50">Inativo</span>
                    @endif
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Código de Patrimônio/SKU</label>
                            <p class="text-base font-bold text-gray-900 dark:text-white bg-slate-50 dark:bg-slate-900 px-4 py-2 rounded-xl border border-dashed border-slate-200 dark:border-slate-700">
                                {{ $material->codigo }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Categoria de Inventário</label>
                            <p class="text-base font-bold text-emerald-600 dark:text-emerald-400">
                                {{ $material->subcategoria->categoria->nome ?? 'NÃO CATEGORIZADO' }}
                            </p>
                        </div>

                        <div class="md:col-span-2 space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Descrição Completa</label>
                            <p class="text-lg font-bold text-gray-900 dark:text-white leading-tight">
                                {{ $material->nome }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status do Inventário</label>
                            @php
                                $baixoEstoque = $material->estaComEstoqueBaixo();
                            @endphp
                            <div class="flex items-center gap-2 mt-2">
                                <span class="text-xl font-black {{ $baixoEstoque ? 'text-red-600' : 'text-gray-900 dark:text-white' }}">
                                    {{ number_format($material->quantidade_estoque ?? 0, 2, ',', '.') }}
                                </span>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">{{ $material->unidade_medida ?? 'UN' }}</span>
                                @if($baixoEstoque)
                                    <span class="px-2 py-0.5 text-[9px] font-black uppercase rounded bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200 border border-red-200 dark:border-red-800/50">STOCK LOW</span>
                                @endif
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Reserva de Segurança</label>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">
                                {{ $material->quantidade_minima ? number_format($material->quantidade_minima, 2, ',', '.') . ' ' . ($material->unidade_medida ?? 'UN') : 'NÃO DEFINIDA' }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Avaliação Unitária</label>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">
                                R$ {{ number_format($material->valor_unitario ?? 0, 2, ',', '.') }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Valor do Estoque</label>
                            <p class="text-sm font-bold text-emerald-600 dark:text-emerald-400">
                                R$ {{ number_format(($material->quantidade_estoque ?? 0) * ($material->valor_unitario ?? 0), 2, ',', '.') }}
                            </p>
                        </div>

                        @if($material->fornecedor)
                        <div class="md:col-span-2 space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Fornecedor Preferencial</label>
                            <p class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-icon name="truck-field" class="w-4 h-4 text-slate-400" />
                                {{ $material->fornecedor }}
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Ordens de Serviço Recentemente Associadas -->
            @if(isset($ordensRecentes) && $ordensRecentes->count() > 0)
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-slate-700/50 bg-gray-50/50 dark:bg-slate-900/50">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <x-icon name="hammer" style="duotone" class="w-4 h-4 text-amber-500" />
                        Uso em Ordens de Serviço
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-slate-400 uppercase bg-slate-50/30 dark:bg-slate-900/30">
                            <tr>
                                <th class="px-6 py-4 font-bold tracking-widest">Nº Ordem</th>
                                <th class="px-6 py-4 font-bold tracking-widest">Responsável</th>
                                <th class="px-6 py-4 font-bold tracking-widest">Qtd Utilizada</th>
                                <th class="px-6 py-4 font-bold tracking-widest text-right">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            @foreach($ordensRecentes as $ordem)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900 dark:text-white">{{ $ordem->numero }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400 font-medium">{{ $ordem->equipe->nome ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm font-black text-gray-900 dark:text-white">
                                        @php
                                            $pivot = $ordem->pivot ?? null;
                                            $quantidadeAsso = $pivot ? $pivot->quantidade : 0;
                                        @endphp
                                        {{ number_format($quantidadeAsso, 2, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.ordens.show', $ordem->id) }}" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg hover:bg-blue-100 transition-all">
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
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-slate-700/50 bg-gray-50/50 dark:bg-slate-900/50">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <x-icon name="clock-rotate-left" style="duotone" class="w-4 h-4 text-emerald-500" />
                        Histórico de Fluxo de Estoque
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-slate-400 uppercase bg-slate-50/30 dark:bg-slate-900/30">
                            <tr>
                                <th class="px-6 py-4 font-bold tracking-widest">Data Realização</th>
                                <th class="px-6 py-4 font-bold tracking-widest">Tipo</th>
                                <th class="px-6 py-4 font-bold tracking-widest">Volume</th>
                                <th class="px-6 py-4 font-bold tracking-widest">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            @foreach($material->movimentacoes as $movimentacao)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500 font-bold uppercase tracking-tighter">
                                    {{ $movimentacao->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $isEntrada = $movimentacao->tipo === 'entrada';
                                    @endphp
                                    <span class="flex items-center gap-1.5 font-black text-[10px] uppercase tracking-wider {{ $isEntrada ? 'text-emerald-600' : 'text-red-500' }}">
                                        <x-icon name="{{ $isEntrada ? 'circle-arrow-up' : 'circle-arrow-down' }}" class="w-3.5 h-3.5" />
                                        {{ $movimentacao->tipo }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap font-black text-gray-900 dark:text-white">
                                    {{ $isEntrada ? '+' : '-' }} {{ number_format($movimentacao->quantidade, 2, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap uppercase text-[10px] font-bold text-slate-400">
                                    {{ $movimentacao->status }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- Meta / Context Information -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-200 dark:border-slate-700/50">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 dark:border-slate-700/50 pb-4">Gestão de Garantia</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 shrink-0 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600">
                            <x-icon name="shield-check" style="duotone" class="w-5 h-5" />
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900 dark:text-white mb-1">Qualidade Assegurada</p>
                            <p class="text-[11px] text-slate-500 leading-relaxed font-bold uppercase">Material em Conformidade</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-emerald-900 rounded-3xl p-8 text-white relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-500 flex items-center justify-center shadow-lg shadow-emerald-500/20">
                        <x-icon name="warehouse" style="duotone" class="w-6 h-6 text-white" />
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-2">Controle Logístico</h4>
                        <p class="text-xs text-emerald-200 leading-relaxed">A gestão rigorosa de insumos garante que as ordens de serviço sejam executadas sem atrasos por falta de material.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
