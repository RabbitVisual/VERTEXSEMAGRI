@extends('admin.layouts.admin')

@section('title', $material->nome . ' - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-module-icon module="Materiais" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>{{ $material->nome }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Materiais</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">{{ $material->nome }}</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.materiais.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
            <a href="{{ route('materiais.show', $material->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors">
                <x-icon name="eye" class="w-5 h-5" />
                Ver no Painel Padrão
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <div class="flex items-center">
            <x-icon name="circle-check" class="w-5 h-5 mr-3" />
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Estatísticas do Material -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Entradas Total</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($estatisticas['entradas_total'] ?? 0, 2, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-emerald-100 rounded-lg dark:bg-emerald-900/30">
                    <x-icon name="arrow-right-to-bracket" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Saídas Total</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($estatisticas['saidas_total'] ?? 0, 2, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-red-100 rounded-lg dark:bg-red-900/30">
                    <x-icon name="arrow-right-from-bracket" class="w-6 h-6 text-red-600 dark:text-red-400" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Saldo Atual</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ number_format($estatisticas['saldo_atual'] ?? 0, 2, ',', '.') }}</p>
                </div>
                <div class="p-3 bg-indigo-100 rounded-lg dark:bg-indigo-900/30">
                    <x-icon name="scale-balanced" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ordens de Serviço</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticas['total_os'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-amber-100 rounded-lg dark:bg-amber-900/30">
                    <x-icon name="hammer" class="w-6 h-6 text-amber-600 dark:text-amber-400" />
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Informações do Material - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon name="circle-info" class="w-5 h-5 text-gray-500" />
                Informações do Material
            </h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Código</label>
                    <p class="text-sm text-gray-900 dark:text-white font-medium">{{ $material->codigo }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nome</label>
                    <p class="text-sm text-gray-900 dark:text-white">{{ $material->nome }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Categoria</label>
                    <p class="text-sm text-gray-900 dark:text-white">{{ $material->subcategoria->categoria->nome ?? '-' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                    @php
                        $statusClass = $material->ativo ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                    @endphp
                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClass }}">{{ $material->ativo ? 'Ativo' : 'Inativo' }}</span>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Quantidade em Estoque</label>
                    <p class="text-sm text-gray-900 dark:text-white font-semibold">
                        <span class="{{ $material->estaComEstoqueBaixo() ? 'text-red-600 dark:text-red-400' : '' }}">
                            {{ number_format($material->quantidade_estoque ?? 0, 2, ',', '.') }} {{ $material->unidade_medida ?? '' }}
                        </span>
                        @if($material->estaComEstoqueBaixo())
                            <span class="ml-2 px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">Estoque Baixo</span>
                        @endif
                    </p>
                </div>
                @if($material->quantidade_minima)
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Quantidade Mínima</label>
                    <p class="text-sm text-gray-900 dark:text-white">{{ number_format($material->quantidade_minima, 2, ',', '.') }} {{ $material->unidade_medida ?? '' }}</p>
                </div>
                @endif
                @if($material->valor_unitario)
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Valor Unitário</label>
                    <p class="text-sm text-gray-900 dark:text-white font-medium">R$ {{ number_format($material->valor_unitario, 2, ',', '.') }}</p>
                </div>
                @endif
                @if(isset($estatisticas['valor_total_estoque']))
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Valor Total do Estoque</label>
                    <p class="text-sm text-gray-900 dark:text-white font-semibold">R$ {{ number_format($estatisticas['valor_total_estoque'], 2, ',', '.') }}</p>
                </div>
                @endif
                @if($material->fornecedor)
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Fornecedor</label>
                    <p class="text-sm text-gray-900 dark:text-white">{{ $material->fornecedor }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Ordens de Serviço Recentes - Flowbite Card -->
    @if(isset($ordensRecentes) && $ordensRecentes->count() > 0)
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon name="hammer" class="w-5 h-5 text-gray-500" />
                Ordens de Serviço Utilizando este Material
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Número OS</th>
                        <th scope="col" class="px-6 py-3">Demanda</th>
                        <th scope="col" class="px-6 py-3">Equipe</th>
                        <th scope="col" class="px-6 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ordensRecentes as $ordem)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $ordem->numero }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $ordem->demanda->codigo ?? '-' }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ $ordem->equipe->nome ?? '-' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <a href="{{ route('admin.ordens.show', $ordem->id) }}" class="inline-flex items-center text-emerald-600 hover:text-emerald-900 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors">
                                <x-icon name="eye" class="w-5 h-5" />
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Movimentações Recentes - Flowbite Card -->
    @if($material->movimentacoes && $material->movimentacoes->count() > 0)
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon name="clock-rotate-left" class="w-5 h-5 text-gray-500" />
                Histórico de Movimentações
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Data</th>
                        <th scope="col" class="px-6 py-3">Tipo</th>
                        <th scope="col" class="px-6 py-3">Quantidade</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Motivo</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($material->movimentacoes as $movimentacao)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400">
                            {{ $movimentacao->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $tipoClass = $movimentacao->tipo === 'entrada' ? 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300';
                            @endphp
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $tipoClass }}">{{ ucfirst($movimentacao->tipo) }}</span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400 font-medium">
                            {{ number_format($movimentacao->quantidade, 2, ',', '.') }} {{ $material->unidade_medida ?? '' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusCores = [
                                    'reservado' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                                    'confirmado' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                                    'cancelado' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300',
                                ];
                                $statusClass = $statusCores[$movimentacao->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                            @endphp
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClass }}">{{ ucfirst($movimentacao->status) }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $movimentacao->motivo }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
