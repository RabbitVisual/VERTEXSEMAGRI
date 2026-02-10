@extends('Co-Admin.layouts.app')

@section('title', 'Relatório de Notificações')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-relatorios::icon name="bell" class="w-6 h-6" />
                Relatório de Notificações
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Histórico de notificações do sistema</p>
        </div>
        <x-relatorios::export-buttons route="relatorios.notificacoes" :filters="$filters" />
    </div>

    <!-- Filtros -->
    <x-relatorios::advanced-filters
        action="{{ route('relatorios.notificacoes') }}"
        :filters="$filters"
    />

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <x-relatorios::metrics-card
            title="Total Enviadas"
            :value="$stats['total'] ?? 0"
            icon="bell"
            color="primary"
        />
        <x-relatorios::metrics-card
            title="Lidas"
            :value="$stats['lidas'] ?? 0"
            icon="check-double"
            color="success"
        />
        <x-relatorios::metrics-card
            title="Não Lidas"
            :value="$stats['nao_lidas'] ?? 0"
            icon="eye-slash"
            color="warning"
        />
        <x-relatorios::metrics-card
            title="Taxa de Leitura"
            :value="$stats['taxa_leitura'] ?? '0%'"
            icon="chart-pie"
            color="info"
        />
    </div>

    <!-- Tabela -->
    <x-relatorios::card>
        <x-slot name="header">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Histórico de Envios</h3>
        </x-slot>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Data</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Título</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Destinatário</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Módulo</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($notificacoes as $notificacao)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                {{ $notificacao->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $notificacao->title }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $notificacao->user->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ ucfirst($notificacao->module_source) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($notificacao->is_read)
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-green-100 text-green-800">Lida</span>
                                @else
                                    <span class="px-2 py-1 text-xs font-medium rounded-full bg-yellow-100 text-yellow-800">Não Lida</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-sm text-gray-500 dark:text-gray-400">
                                Nenhuma notificação encontrada
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if(method_exists($notificacoes, 'links'))
            <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
                {{ $notificacoes->links() }}
            </div>
        @endif
    </x-relatorios::card>
</div>

@push('scripts')
<x-relatorios::load-assets />
@endpush
@endsection
