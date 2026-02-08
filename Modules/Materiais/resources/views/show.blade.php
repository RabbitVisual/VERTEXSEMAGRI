@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes do Material')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 dark:from-indigo-800 dark:to-indigo-900 rounded-2xl shadow-xl p-6 md:p-8 text-white">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <x-icon module="Materiais" class="w-8 h-8 text-white" />
                </div>
                <div>
                    <h1 class="text-3xl font-bold flex items-center gap-3">
                        {{ $material->nome }}
                        @if($material->codigo)
                            <span class="text-indigo-100 dark:text-indigo-200 text-xl font-normal">({{ $material->codigo }})</span>
                        @endif
                    </h1>
                    <p class="text-indigo-100 dark:text-indigo-200 mt-2 text-sm md:text-base">
                        Detalhes completos e histórico do material
                    </p>
                </div>
            </div>
            <div class="flex flex-wrap gap-2">
                <x-materiais::button href="{{ route('materiais.edit', $material) }}" variant="outline-primary" class="!bg-white !text-indigo-600 hover:!bg-indigo-50 !border-indigo-600 shadow-lg">
                    <x-icon name="pen" class="w-5 h-5 mr-2" />
                    Editar Material
                </x-materiais::button>
                <x-materiais::button href="{{ route('materiais.index') }}" variant="outline" class="bg-white/10 text-white border-white/30 hover:bg-white/20">
                    <x-icon name="arrow-left" class="w-5 h-5 mr-2" />
                    Voltar
                </x-materiais::button>
            </div>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-materiais::alert type="success" dismissible>
            <div class="flex items-center gap-2">
                <x-icon name="circle-check" class="w-5 h-5" />
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </x-materiais::alert>
    @endif

    <!-- Tabs Navigation -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border border-gray-200 dark:border-gray-700 overflow-hidden">
        <nav class="flex space-x-1 p-1 bg-gray-50 dark:bg-gray-900/50" aria-label="Tabs">
            <button data-tab-target="detalhes" class="flex-1 border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-3 px-4 text-sm font-semibold bg-white dark:bg-gray-800 rounded-t-lg transition-colors">
                <x-icon name="circle-info" class="w-4 h-4 inline mr-2" />
                Detalhes
            </button>
            <button data-tab-target="movimentacoes" class="flex-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-3 px-4 text-sm font-medium hover:bg-white dark:hover:bg-gray-800 rounded-t-lg transition-colors">
                <x-icon name="rotate" class="w-4 h-4 inline mr-2" />
                Movimentações
            </button>
            <button data-tab-target="relacionamentos" class="flex-1 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-3 px-4 text-sm font-medium hover:bg-white dark:hover:bg-gray-800 rounded-t-lg transition-colors">
                <x-icon name="link" class="w-4 h-4 inline mr-2" />
                Relacionamentos
            </button>
        </nav>
    </div>

    <!-- Tabs Content -->
    <div>
        <!-- Tab Detalhes -->
        <div data-tab-panel="detalhes">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Informações Principais -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Informações Básicas -->
                    <x-materiais::card class="rounded-xl shadow-lg">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                    <x-icon name="circle-info" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Informações do Material
                                </h3>
                            </div>
                        </x-slot>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código</label>
                                    <div class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">{{ $material->codigo ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                    <div>
                                        @if($material->ativo)
                                            <x-materiais::badge variant="success">
                                                <x-icon name="circle-check" class="w-3 h-3 mr-1" />
                                                Ativo
                                            </x-materiais::badge>
                                        @else
                                            <x-materiais::badge variant="danger">
                                                <x-icon name="circle-xmark" class="w-3 h-3 mr-1" />
                                                Inativo
                                            </x-materiais::badge>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nome</label>
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $material->nome }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Categoria / Subcategoria</label>
                                    <div>
                                        @if($material->subcategoria)
                                            <x-materiais::badge variant="secondary">
                                                {{ $material->subcategoria->categoria->nome ?? '' }} - {{ $material->subcategoria->nome }}
                                            </x-materiais::badge>
                                        @else
                                            <x-materiais::badge variant="secondary">
                                                {{ $material->categoria_formatada }}
                                            </x-materiais::badge>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Quantidade em Estoque</label>
                                    <div class="text-base font-semibold {{ $material->quantidade_estoque <= $material->quantidade_minima ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }} flex items-center gap-1">
                                        <x-icon name="box-archive" class="w-4 h-4" />
                                        {{ formatar_quantidade($material->quantidade_estoque, $material->unidade_medida) }}
                                        <span class="text-sm text-gray-500">{{ $material->unidade_medida }}</span>
                                    </div>
                                    @if($material->quantidade_estoque <= $material->quantidade_minima)
                                        <p class="text-xs text-red-600 dark:text-red-400 mt-1 flex items-center gap-1">
                                            <x-icon name="triangle-exclamation" class="w-3 h-3" />
                                            Estoque abaixo do mínimo!
                                        </p>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Quantidade Mínima</label>
                                    <div class="text-sm text-gray-900 dark:text-white">
                                        {{ formatar_quantidade($material->quantidade_minima, $material->unidade_medida) }}
                                        <span class="text-gray-500">{{ $material->unidade_medida }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Unidade de Medida</label>
                                    <div>
                                        <x-materiais::badge variant="info">{{ $material->unidade_medida }}</x-materiais::badge>
                                    </div>
                                </div>
                            </div>

                            @if($material->valor_unitario)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Valor Unitário</label>
                                    <div class="text-lg font-semibold text-emerald-600 dark:text-emerald-400 flex items-center gap-1">
                                        <x-icon name="dollar-sign" class="w-4 h-4" />
                                        R$ {{ number_format($material->valor_unitario, 2, ',', '.') }}
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Valor Total em Estoque</label>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                        R$ {{ number_format($material->quantidade_estoque * $material->valor_unitario, 2, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if($material->fornecedor || $material->localizacao_estoque)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                @if($material->fornecedor)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Fornecedor</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <x-icon name="building" class="w-4 h-4" />
                                        {{ $material->fornecedor }}
                                    </div>
                                </div>
                                @endif
                                @if($material->localizacao_estoque)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Localização no Estoque</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <x-icon name="map-pin" class="w-4 h-4" />
                                        {{ $material->localizacao_estoque }}
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif

                            @if($material->campos_especificos && count($material->campos_especificos) > 0 && $material->subcategoria)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div class="flex items-center gap-2 mb-4">
                                    <div class="p-1.5 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                        <x-icon name="gear" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                                    </div>
                                    <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                        Informações Específicas da Categoria
                                    </h4>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @php
                                        $camposMap = $material->subcategoria->campos->keyBy('slug');
                                    @endphp
                                    @foreach($material->campos_especificos as $slug => $valor)
                                        @if(!empty($valor))
                                        @php
                                            $campo = $camposMap->get($slug);
                                            $nomeCampo = $campo ? $campo->nome : ucfirst(str_replace('_', ' ', $slug));
                                        @endphp
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">
                                                {{ $nomeCampo }}
                                            </label>
                                            <div class="text-sm text-gray-900 dark:text-white">
                                                @if(is_bool($valor))
                                                    {{ $valor ? 'Sim' : 'Não' }}
                                                @else
                                                    {{ $valor }}
                                                @endif
                                            </div>
                                        </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>
                    </x-materiais::card>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Ações Rápidas -->
                    <x-materiais::card class="rounded-xl shadow-lg">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                                    <x-icon name="bolt" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Ações Rápidas
                                </h3>
                            </div>
                        </x-slot>

                        <div class="space-y-3">
                            <x-materiais::button href="{{ route('materiais.edit', $material) }}" variant="primary" class="w-full">
                                <x-icon name="pen" class="w-4 h-4 mr-2" />
                                Editar Material
                            </x-materiais::button>
                            <button type="button" onclick="document.getElementById('modal-adicionar-estoque').classList.remove('hidden')" class="w-full px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center">
                                <x-icon name="circle-arrow-down" class="w-4 h-4 mr-2" />
                                Adicionar Estoque
                            </button>
                            <button type="button" onclick="document.getElementById('modal-remover-estoque').classList.remove('hidden')" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium transition-colors flex items-center justify-center">
                                <x-icon name="circle-arrow-up" class="w-4 h-4 mr-2" />
                                Remover Estoque
                            </button>
                            <form action="{{ route('materiais.destroy', $material) }}" method="POST" onsubmit="return confirm('Deseja realmente deletar este material?')">
                                @csrf
                                @method('DELETE')
                                <x-materiais::button type="submit" variant="danger" class="w-full">
                                    <x-icon name="trash" class="w-4 h-4 mr-2" />
                                    Deletar
                                </x-materiais::button>
                            </form>
                        </div>
                    </x-materiais::card>

                    <!-- Informações -->
                    <x-materiais::card class="rounded-xl shadow-lg">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-blue-100 dark:bg-blue-900/30 rounded-lg">
                                    <x-icon name="circle-info" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Informações do Sistema
                                </h3>
                            </div>
                        </x-slot>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">ID</label>
                                <div class="text-base font-semibold text-gray-900 dark:text-white">#{{ $material->id }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $material->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @if($material->updated_at)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Atualizado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $material->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @endif
                            @php
                                $estatisticas = $material->estatisticas;
                            @endphp
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Total de Movimentações</label>
                                <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $material->movimentacoes->count() }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Ordens de Serviço</label>
                                <div class="text-base font-semibold text-indigo-600 dark:text-indigo-400">{{ $estatisticas['total_os'] ?? 0 }}</div>
                            </div>
                        </div>
                    </x-materiais::card>

                    <!-- Status do Estoque -->
                    <x-materiais::card class="rounded-xl shadow-lg">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                                    <x-icon name="box-archive" class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Status do Estoque
                                </h3>
                            </div>
                        </x-slot>

                        <div class="space-y-4">
                            @php
                                $percentual = $material->quantidade_minima > 0
                                    ? ($material->quantidade_estoque / $material->quantidade_minima) * 100
                                    : 0;
                                $percentual = min($percentual, 100);
                                $corBarra = $material->quantidade_estoque <= $material->quantidade_minima ? 'bg-red-500' : ($percentual < 50 ? 'bg-amber-500' : 'bg-emerald-500');
                            @endphp
                            <div>
                                <div class="flex justify-between mb-2">
                                    <span class="text-xs font-medium text-gray-500 dark:text-gray-400">Estoque</span>
                                    <span class="text-xs font-medium text-gray-900 dark:text-white">{{ number_format($percentual, 0) }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-8 overflow-hidden shadow-inner">
                                    <div class="h-full {{ $corBarra }} rounded-full flex items-center justify-center text-xs font-medium text-white transition-all duration-300 shadow-sm" style="width: {{ $percentual }}%">
                                        @if($percentual > 10)
                                            {{ formatar_quantidade($material->quantidade_estoque, $material->unidade_medida) }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @if($material->quantidade_estoque <= $material->quantidade_minima)
                                <x-materiais::alert type="danger">
                                    <x-icon name="triangle-exclamation" class="w-4 h-4 mr-2" />
                                    Estoque abaixo do mínimo!
                                </x-materiais::alert>
                            @endif
                        </div>
                    </x-materiais::card>
                </div>
            </div>
        </div>

        <!-- Tab Movimentações -->
        <div data-tab-panel="movimentacoes" class="hidden">
            <x-materiais::card class="rounded-xl shadow-lg">
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-violet-100 dark:bg-violet-900/30 rounded-lg">
                            <x-icon name="rotate" class="w-5 h-5 text-violet-600 dark:text-violet-400" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Histórico de Movimentações
                        </h3>
                    </div>
                </x-slot>

                @if($material->movimentacoes && $material->movimentacoes->count() > 0)
                    @php
                        $estatisticas = $material->estatisticas;
                    @endphp
                    <div class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg border border-emerald-200 dark:border-emerald-800">
                            <div class="text-sm text-emerald-700 dark:text-emerald-300 mb-1">Total de Entradas</div>
                            <div class="text-2xl font-bold text-emerald-900 dark:text-emerald-100">{{ number_format($estatisticas['entradas_total'] ?? 0, 2, ',', '.') }} {{ $material->unidade_medida }}</div>
                        </div>
                        <div class="p-4 bg-red-50 dark:bg-red-900/20 rounded-lg border border-red-200 dark:border-red-800">
                            <div class="text-sm text-red-700 dark:text-red-300 mb-1">Total de Saídas</div>
                            <div class="text-2xl font-bold text-red-900 dark:text-red-100">{{ number_format($estatisticas['saidas_total'] ?? 0, 2, ',', '.') }} {{ $material->unidade_medida }}</div>
                        </div>
                        <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                            <div class="text-sm text-blue-700 dark:text-blue-300 mb-1">Saldo Atual</div>
                            <div class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ number_format($estatisticas['saldo_atual'] ?? 0, 2, ',', '.') }} {{ $material->unidade_medida }}</div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Tipo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Quantidade</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Valor Unit.</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Motivo</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Usuário/OS</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($material->movimentacoes()->with(['usuario', 'ordemServico'])->orderBy('created_at', 'desc')->get() as $movimentacao)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            <div class="flex items-center gap-1">
                                                <x-icon name="calendar" class="w-4 h-4" />
                                                {{ $movimentacao->created_at->format('d/m/Y H:i') }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $tipoColors = [
                                                    'entrada' => 'success',
                                                    'saida' => 'danger'
                                                ];
                                                $tipoIcons = [
                                                    'entrada' => 'arrow-down-circle',
                                                    'saida' => 'arrow-up-circle'
                                                ];
                                            @endphp
                                            <x-materiais::badge :variant="$tipoColors[$movimentacao->tipo] ?? 'secondary'">
                                                <x-icon :name="$tipoIcons[$movimentacao->tipo] ?? 'circle'" class="w-3 h-3 mr-1" />
                                                {{ ucfirst($movimentacao->tipo) }}
                                            </x-materiais::badge>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            <strong>{{ formatar_quantidade($movimentacao->quantidade, $material->unidade_medida) }}</strong>
                                            <span class="text-gray-500">{{ $material->unidade_medida }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            @if($movimentacao->valor_unitario)
                                                R$ {{ number_format($movimentacao->valor_unitario, 2, ',', '.') }}
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">
                                            {{ $movimentacao->motivo ?? 'N/A' }}
                                            @if($movimentacao->observacoes)
                                                <div class="text-xs text-gray-500 mt-1">{{ $movimentacao->observacoes }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            @if($movimentacao->usuario)
                                                {{ $movimentacao->usuario->name }}
                                            @elseif($movimentacao->user_id)
                                                Usuário #{{ $movimentacao->user_id }}
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                            @if($movimentacao->ordemServico)
                                                <div class="text-xs text-gray-500 mt-1">
                                                    OS: {{ $movimentacao->ordemServico->numero ?? 'N/A' }}
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-12">
                        <x-icon name="inbox" class="w-12 h-12 mx-auto text-gray-400 mb-3" />
                        <p class="text-gray-500 dark:text-gray-400">Nenhuma movimentação registrada</p>
                    </div>
                @endif
            </x-materiais::card>
        </div>

        <!-- Tab Relacionamentos -->
        <div data-tab-panel="relacionamentos" class="hidden">
            <x-materiais::card class="rounded-xl shadow-lg">
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                            <x-icon name="link" class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                            Ordens de Serviço que Utilizaram
                        </h3>
                    </div>
                </x-slot>

                @if($material->ordensServico && $material->ordensServico->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">OS</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Quantidade</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Valor Unitário</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($material->ordensServico->take(10) as $os)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $os->numero ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ formatar_quantidade($os->pivot->quantidade ?? 0, $material->unidade_medida) }}
                                            <span class="text-gray-500">{{ $material->unidade_medida }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            @if($os->pivot->valor_unitario)
                                                R$ {{ number_format($os->pivot->valor_unitario, 2, ',', '.') }}
                                            @else
                                                <span class="text-gray-400">N/A</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $os->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            @if(Route::has('ordens.show'))
                                                <a href="{{ route('ordens.show', $os->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-300">
                                                    <x-icon name="eye" class="w-5 h-5" />
                                                </a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($material->ordensServico->count() > 10)
                        <div class="mt-4 text-center">
                            <x-materiais::button href="{{ route('ordens.index') }}" variant="outline">
                                Ver todas as OS
                                <x-icon name="arrow-right" class="w-4 h-4 ml-2" />
                            </x-materiais::button>
                        </div>
                    @endif
                @else
                    <div class="text-center py-12">
                        <x-icon name="inbox" class="w-12 h-12 mx-auto text-gray-400 mb-3" />
                        <p class="text-gray-500 dark:text-gray-400">Este material ainda não foi utilizado em nenhuma ordem de serviço</p>
                    </div>
                @endif
            </x-materiais::card>
        </div>
    </div>
</div>

<!-- Modal Adicionar Estoque -->
<div id="modal-adicionar-estoque" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
    <div class="relative w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Adicionar Estoque</h3>
                <button onclick="document.getElementById('modal-adicionar-estoque').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <x-icon name="xmark" class="w-6 h-6" />
                </button>
            </div>
            <form action="{{ route('materiais.adicionar-estoque', $material) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quantidade</label>
                        <input type="number" name="quantidade" step="0.01" min="0.01" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Motivo</label>
                        <input type="text" name="motivo" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Valor Unitário (opcional)</label>
                        <input type="number" name="valor_unitario" step="0.01" min="0" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Observações</label>
                        <textarea name="observacoes" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"></textarea>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium">
                            Adicionar
                        </button>
                        <button type="button" onclick="document.getElementById('modal-adicionar-estoque').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-medium">
                            Cancelar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Remover Estoque -->
<div id="modal-remover-estoque" class="hidden fixed inset-0 bg-gray-900/50 backdrop-blur-sm overflow-y-auto h-full w-full z-50 flex items-center justify-center p-4">
    <div class="relative w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Remover Estoque</h3>
                <button onclick="document.getElementById('modal-remover-estoque').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                    <x-icon name="xmark" class="w-6 h-6" />
                </button>
            </div>
            <form action="{{ route('materiais.remover-estoque', $material) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Quantidade (Disponível: {{ formatar_quantidade($material->quantidade_estoque, $material->unidade_medida) }})</label>
                        <input type="number" name="quantidade" step="0.01" min="0.01" max="{{ $material->quantidade_estoque }}" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Motivo</label>
                        <input type="text" name="motivo" required class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Valor Unitário (opcional)</label>
                        <input type="number" name="valor_unitario" step="0.01" min="0" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Observações</label>
                        <textarea name="observacoes" rows="3" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white"></textarea>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="flex-1 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg font-medium">
                            Remover
                        </button>
                        <button type="button" onclick="document.getElementById('modal-remover-estoque').classList.add('hidden')" class="flex-1 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-medium">
                            Cancelar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('[data-tab-target]');
    const tabPanels = document.querySelectorAll('[data-tab-panel]');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.getAttribute('data-tab-target');

            // Remove active state from all buttons and panels
            tabButtons.forEach(btn => {
                btn.classList.remove('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
                btn.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            });
            tabPanels.forEach(panel => {
                panel.classList.add('hidden');
            });

            // Add active state to clicked button and corresponding panel
            button.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            button.classList.add('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            document.querySelector(`[data-tab-panel="${targetTab}"]`).classList.remove('hidden');
        });
    });
});
</script>
@endpush
@endsection
