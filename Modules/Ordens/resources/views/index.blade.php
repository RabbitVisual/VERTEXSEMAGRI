@extends('Co-Admin.layouts.app')

@section('title', 'Ordens de Serviço')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon module="ordens" class="w-6 h-6" />
                Ordens de Serviço
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gerenciamento de ordens de serviço</p>
        </div>
        <x-ordens::button href="{{ route('ordens.create') }}" variant="primary">
            <x-icon name="plus" class="w-5 h-5 mr-2" />
            Nova Ordem
        </x-ordens::button>
    </div>

    <!-- Data Table -->
    <x-ordens::data-table :data="$ordens" :headers="['Código', 'Demanda', 'Equipe', 'Data Início', 'Status', 'Prioridade', 'Ações']">
        @forelse($ordens as $ordem)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                        {{ $ordem->codigo }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                    @if($ordem->demanda)
                        <a href="{{ route('demandas.show', $ordem->demanda->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                            {{ $ordem->demanda->codigo }}
                        </a>
                    @else
                        <span class="text-gray-400">N/A</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    {{ $ordem->equipe ? $ordem->equipe->nome : 'Sem Equipe' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                    {{ $ordem->data_inicio ? \Carbon\Carbon::parse($ordem->data_inicio)->format('d/m/Y') : '-' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $statusColors = [
                            'pendente' => 'bg-yellow-100 text-yellow-800',
                            'em_execucao' => 'bg-blue-100 text-blue-800',
                            'concluida' => 'bg-green-100 text-green-800',
                            'cancelada' => 'bg-red-100 text-red-800',
                        ];
                    @endphp
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$ordem->status] ?? 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst(str_replace('_', ' ', $ordem->status)) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $prioridadeColors = [
                            'baixa' => 'text-gray-500',
                            'media' => 'text-yellow-600',
                            'alta' => 'text-orange-600',
                            'urgente' => 'text-red-600 font-bold',
                        ];
                    @endphp
                    <span class="text-sm {{ $prioridadeColors[$ordem->prioridade] ?? 'text-gray-500' }}">
                        {{ ucfirst($ordem->prioridade) }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('ordens.show', $ordem->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300">
                            <x-icon name="eye" class="w-5 h-5" />
                        </a>
                        <a href="{{ route('ordens.edit', $ordem->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300">
                            <x-icon name="pencil" class="w-5 h-5" />
                        </a>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-6 py-12 text-center text-gray-500 dark:text-gray-400">
                    <x-icon name="clipboard-check" class="w-12 h-12 mx-auto mb-3 text-gray-400" style="duotone" />
                    <p>Nenhuma ordem de serviço encontrada.</p>
                </td>
            </tr>
        @endforelse
    </x-ordens::data-table>
</div>
@endsection
