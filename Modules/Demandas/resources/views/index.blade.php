@extends('Co-Admin.layouts.app')

@section('title', 'Demandas')

@section('content')
<div x-data="offlineManager" @click.capture="handleLinkClick($event)">
    <!-- Status Bar (Offline Mode Support) -->
    <div class="mb-6 flex flex-col sm:flex-row justify-between items-center bg-white/80 dark:bg-slate-800/80 backdrop-blur-md px-6 py-4 rounded-3xl border border-slate-200 dark:border-slate-700/50 shadow-sm gap-4">
        <div class="flex items-center gap-4">
            <div class="relative flex h-3 w-3">
                <span :class="online ? 'bg-emerald-400' : 'bg-amber-400'" class="animate-ping absolute inline-flex h-full w-full rounded-full opacity-75"></span>
                <span :class="online ? 'bg-emerald-500' : 'bg-amber-500'" class="relative inline-flex rounded-full h-3 w-3"></span>
            </div>
            <div class="flex flex-col">
                <span x-text="online ? 'Conectado' : 'Modo Offline'" class="text-sm font-bold text-slate-700 dark:text-slate-200 uppercase tracking-wider"></span>
                <span x-show="lastSync" class="text-[10px] font-medium text-slate-500 dark:text-slate-400 uppercase tracking-tight" x-text="'Sincronizado: ' + lastSync"></span>
            </div>
        </div>
        <div class="flex gap-2 w-full sm:w-auto">
            <button @click="$dispatch('open-outbox')" class="flex-1 sm:flex-none px-5 py-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 rounded-2xl transition-all duration-300 flex items-center justify-center gap-2 relative group">
                <x-icon name="paper-airplane" class="w-4 h-4 transition-transform group-hover:translate-x-1" />
                <span class="text-sm font-bold">Pendências</span>
                <span x-show="queueCount > 0" x-text="queueCount" class="absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold h-5 min-w-[20px] px-1.5 rounded-full flex items-center justify-center border-2 border-white dark:border-slate-800"></span>
            </button>
            <button @click="sync()" :disabled="syncing || !online" class="flex-1 sm:flex-none px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl transition-all duration-300 disabled:opacity-50 flex items-center justify-center gap-2 group">
                <x-icon name="rotate" class="w-4 h-4" ::class="{'animate-spin': syncing}" />
                <span x-text="syncStatus" class="text-sm font-bold"></span>
            </button>
        </div>
    </div>

    <div x-show="online" class="space-y-8">
        <!-- Premium Header Area -->
        <div class="relative overflow-hidden bg-slate-900 rounded-3xl border border-slate-800 shadow-2xl mb-8">
            <!-- Decorative Elements -->
            <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-indigo-500/10 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-blue-500/10 rounded-full blur-[100px]"></div>

            <div class="relative px-8 py-10">
                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                    <div class="flex items-center gap-6">
                        <div class="relative group">
                            <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                            <div class="relative p-5 bg-slate-800/50 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl">
                                <x-icon module="demandas" class="w-10 h-10 text-white" />
                            </div>
                        </div>
                        <div>
                            <div class="flex items-center gap-3 mb-2">
                                <span class="px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-full">Gestão</span>
                                <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Módulo de Demandas</span>
                            </div>
                            <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">
                                Central de <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-blue-400">Demandas</span>
                            </h1>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <x-demandas::button href="{{ route('demandas.relatorio.abertas.pdf') }}" target="_blank" variant="secondary" size="lg" class="shadow-xl">
                            <x-icon name="file-arrow-down" class="w-5 h-5 mr-2" />
                            Relatório PDF
                        </x-demandas::button>
                        <x-demandas::button href="{{ route('demandas.create') }}" variant="primary" size="lg" class="shadow-xl border-b-4 border-indigo-700 active:border-b-0 active:translate-y-1 transition-all">
                            <x-icon name="circle-plus" class="w-5 h-5 mr-2" />
                            Nova Demanda
                        </x-demandas::button>
                    </div>
                </div>
            </div>
        </div>

    <!-- Alertas -->
    @if(session('warning'))
        <x-demandas::alert type="warning" dismissible>
            <div class="flex items-center gap-2">
                <x-icon name="triangle-exclamation" class="w-5 h-5" />
                <span class="font-medium">{!! session('warning') !!}</span>
            </div>
        </x-demandas::alert>
    @endif

    @if(session('success'))
        <x-demandas::alert type="success" dismissible>
            <div class="flex items-center gap-2">
                <x-icon name="circle-check" class="w-5 h-5" />
                <span class="font-medium">{!! session('success') !!}</span>
            </div>
        </x-demandas::alert>
    @endif

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6">
        <x-demandas::stat-card
            title="Total Geral"
            :value="$estatisticas['total'] ?? 0"
            icon="clipboard-list"
            color="primary"
            subtitle="Acumulado"
        />
        <x-demandas::stat-card
            title="Abertas"
            :value="$estatisticas['abertas'] ?? 0"
            icon="folder-open"
            color="info"
            subtitle="Pendentes"
        />
        <x-demandas::stat-card
            title="Em Curso"
            :value="$estatisticas['em_andamento'] ?? 0"
            icon="clock-rotate-left"
            color="warning"
            subtitle="Execução"
        />
        <x-demandas::stat-card
            title="Concluídas"
            :value="$estatisticas['concluidas'] ?? 0"
            icon="circle-check"
            color="success"
            subtitle="Finalizadas"
        />
        <x-demandas::stat-card
            title="Críticas"
            :value="$estatisticas['urgentes'] ?? 0"
            icon="fire"
            color="danger"
            subtitle="Urgentes"
        />
        <x-demandas::stat-card
            title="Sem OS"
            :value="$estatisticas['sem_os'] ?? 0"
            icon="file-circle-exclamation"
            color="slate"
            subtitle="Aguardando"
        />
    </div>

    <!-- Estatísticas por Tipo -->
    @if(isset($estatisticas['por_tipo']))
    <x-demandas::card class="rounded-xl shadow-lg">
        <x-slot name="header">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                    <x-icon module="demandas" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                </div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    Demandas por Tipo
                </h3>
            </div>
        </x-slot>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Água -->
            <div class="flex items-center gap-4 p-4 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg border border-indigo-200 dark:border-indigo-800 hover:shadow-md transition-shadow">
                <div class="p-3 bg-indigo-100 dark:bg-indigo-900/40 rounded-lg flex-shrink-0">
                    <x-icon module="agua" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($estatisticas['por_tipo']['agua'] ?? 0, 0, ',', '.') }}</div>
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Água</div>
                </div>
            </div>

            <!-- Iluminação -->
            <div class="flex items-center gap-4 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-lg border border-amber-200 dark:border-amber-800 hover:shadow-md transition-shadow">
                <div class="p-3 bg-amber-100 dark:bg-amber-900/40 rounded-lg flex-shrink-0">
                    <x-icon module="iluminacao" class="w-8 h-8 text-amber-600 dark:text-amber-400" />
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($estatisticas['por_tipo']['luz'] ?? 0, 0, ',', '.') }}</div>
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Iluminação</div>
                </div>
            </div>

            <!-- Estrada -->
            <div class="flex items-center gap-4 p-4 bg-violet-50 dark:bg-violet-900/20 rounded-lg border border-violet-200 dark:border-violet-800 hover:shadow-md transition-shadow">
                <div class="p-3 bg-violet-100 dark:bg-violet-900/40 rounded-lg flex-shrink-0">
                    <x-icon module="estradas" class="w-8 h-8 text-violet-600 dark:text-violet-400" />
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($estatisticas['por_tipo']['estrada'] ?? 0, 0, ',', '.') }}</div>
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Estrada</div>
                </div>
            </div>

            <!-- Poço -->
            <div class="flex items-center gap-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800 hover:shadow-md transition-shadow">
                <div class="p-3 bg-blue-100 dark:bg-blue-900/40 rounded-lg flex-shrink-0">
                    <x-icon module="pocos" class="w-8 h-8 text-blue-600 dark:text-blue-400" />
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($estatisticas['por_tipo']['poco'] ?? 0, 0, ',', '.') }}</div>
                    <div class="text-sm font-medium text-gray-600 dark:text-gray-400">Poço</div>
                </div>
            </div>
        </div>
    </x-demandas::card>
    @endif
    @endif

    <!-- Filtros -->
    @include('demandas::components.filter-bar', [
        'action' => route('demandas.index'),
        'filters' => [
            ['name' => 'status', 'label' => 'Status', 'type' => 'select', 'options' => ['' => 'Todos', 'aberta' => 'Aberta', 'em_andamento' => 'Em Andamento', 'concluida' => 'Concluída', 'cancelada' => 'Cancelada']],
            ['name' => 'tipo', 'label' => 'Tipo', 'type' => 'select', 'options' => ['' => 'Todos', 'agua' => 'Água', 'luz' => 'Luz', 'estrada' => 'Estrada', 'poco' => 'Poço']],
            ['name' => 'prioridade', 'label' => 'Prioridade', 'type' => 'select', 'options' => ['' => 'Todas', 'baixa' => 'Baixa', 'media' => 'Média', 'alta' => 'Alta', 'urgente' => 'Urgente']],
            ['name' => 'localidade_id', 'label' => 'Localidade', 'type' => 'select', 'options' => $localidades->pluck('nome', 'id')->toArray() + ['' => 'Todas']],
        ],
        'searchPlaceholder' => 'Buscar por solicitante, apelido, código ou motivo...'
    ])

    <!-- Informações de Resultados e Paginação Superior -->
    @if($demandas->total() > 0)
    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-blue-50 dark:from-blue-900/20 dark:via-indigo-900/20 dark:to-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl px-6 py-4 shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-200 dark:bg-blue-800 rounded-lg">
                    <x-icon name="circle-info" class="w-5 h-5 text-blue-700 dark:text-blue-300" />
                </div>
                <div>
                    <p class="text-sm font-semibold text-blue-900 dark:text-blue-200">
                        <span class="text-lg text-indigo-600 dark:text-indigo-400">{{ $demandas->total() }}</span>
                        {{ $demandas->total() == 1 ? 'demanda encontrada' : 'demandas encontradas' }}
                    </p>
                    @if(request()->hasAny(['search', 'status', 'tipo', 'prioridade', 'localidade_id']))
                        <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">
                            Com os filtros aplicados
                        </p>
                    @endif
                </div>
            </div>
            @if($demandas->hasPages())
            <div class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 rounded-lg border border-blue-200 dark:border-blue-700 shadow-sm">
                <x-icon name="file-lines" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                <span class="text-sm font-medium text-blue-900 dark:text-blue-200">
                    Página <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $demandas->currentPage() }}</span> de <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $demandas->lastPage() }}</span>
                </span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Main Data Table Container -->
    <x-demandas::card class="mb-8">
        <x-demandas::data-table
            :headers="['Identificação', 'Solicitante', 'Localidade', 'Tipo/Prioridade', 'Status', 'Atendimento', 'Ações']"
            :data="$demandas"
        >
            @forelse($demandas as $demanda)
                @php
                    $isHighSimilarity = ($demanda->score_similaridade_max ?? 0) > 80;
                    $rowClass = $isHighSimilarity ? 'bg-amber-50/30 dark:bg-amber-900/10' : '';
                @endphp
                <tr class="group {{ $rowClass }} hover:bg-slate-50 dark:hover:bg-slate-700/30 transition-all duration-200">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="flex flex-col">
                                <span class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider">{{ $demanda->codigo ?? 'N/A' }}</span>
                                <span class="text-[10px] font-bold text-slate-500 uppercase">{{ $demanda->created_at->format('d/m/Y') }}</span>
                            </div>
                            @if($isHighSimilarity)
                                <div class="px-2 py-0.5 bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 text-[10px] font-black uppercase rounded-full border border-amber-200 dark:border-amber-800 animate-pulse">
                                    Duplicata
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-slate-800 dark:text-slate-200 line-clamp-1">{{ $demanda->solicitante_nome }}</span>
                            @if($demanda->solicitante_telefone)
                                <span class="text-xs text-slate-500 font-medium flex items-center gap-1">
                                    <x-icon name="phone" class="w-3 h-3" />
                                    {{ $demanda->solicitante_telefone }}
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <div class="p-1.5 bg-slate-100 dark:bg-slate-800 rounded-lg">
                                <x-icon name="location-dot" class="w-3.5 h-3.5 text-slate-500" />
                            </div>
                            <span class="text-sm font-bold text-slate-600 dark:text-slate-300">
                                {{ $demanda->localidade ? $demanda->localidade->nome : 'Não informado' }}
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex flex-col gap-1.5">
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold text-slate-700 dark:text-slate-200 uppercase tracking-tight">{{ $demanda->tipo_texto }}</span>
                            </div>
                            @php
                                $prioridadeVariants = ['baixa' => 'secondary', 'media' => 'info', 'alta' => 'warning', 'urgente' => 'danger'];
                                $prioridadeVariant = $prioridadeVariants[$demanda->prioridade] ?? 'default';
                            @endphp
                            <x-demandas::badge :variant="$prioridadeVariant" size="sm" class="w-fit">
                                {{ $demanda->prioridade_texto }}
                            </x-demandas::badge>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusVariants = ['aberta' => 'info', 'em_andamento' => 'warning', 'concluida' => 'success', 'cancelada' => 'danger'];
                            $statusVariant = $statusVariants[$demanda->status] ?? 'default';
                        @endphp
                        <x-demandas::badge :variant="$statusVariant" size="lg">
                            {{ $demanda->status_texto }}
                        </x-demandas::badge>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($demanda->ordemServico)
                            <div class="flex flex-col gap-1">
                                <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">OS Vinculada</span>
                                <x-demandas::badge variant="success" size="sm" class="w-fit">
                                    {{ $demanda->ordemServico->numero }}
                                </x-demandas::badge>
                            </div>
                        @else
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest italic">Sem OS</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <!-- Action Buttons - Revealed on Hover -->
                        <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-all duration-300 transform translate-x-2 group-hover:translate-x-0">
                            <a href="{{ route('demandas.show', $demanda) }}"
                               class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-xl transition-all"
                               title="Visualizar">
                                <x-icon name="eye" class="w-5 h-5" />
                            </a>
                            <a href="{{ route('demandas.edit', $demanda) }}"
                               class="p-2 text-slate-400 hover:text-amber-600 hover:bg-amber-50 dark:hover:bg-amber-900/30 rounded-xl transition-all"
                               title="Editar">
                                <x-icon name="pencil" class="w-5 h-5" />
                            </a>
                            <a href="{{ route('demandas.print', $demanda) }}" target="_blank"
                               class="p-2 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-900/30 rounded-xl transition-all"
                               title="Imprimir">
                                <x-icon name="print" class="w-5 h-5" />
                            </a>

                            <div class="w-px h-6 bg-slate-200 dark:bg-slate-700 mx-1"></div>

                            <form action="{{ route('demandas.destroy', $demanda) }}" method="POST" class="inline" onsubmit="return confirm('Excluir permanentemente?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-xl transition-all">
                                    <x-icon name="trash" class="w-5 h-5" />
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-6 py-24 text-center">
                        <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                            <div class="p-6 bg-slate-100 dark:bg-slate-800 rounded-3xl mb-6">
                                <x-icon module="demandas" class="w-12 h-12 text-slate-300 dark:text-slate-600" />
                            </div>
                            <h3 class="text-xl font-black text-slate-900 dark:text-white mb-2 uppercase tracking-tight">Nenhuma Demanda</h3>
                            <p class="text-slate-500 dark:text-slate-400 mb-8 text-sm font-medium leading-relaxed">
                                @if(request()->hasAny(['search', 'status', 'tipo', 'prioridade', 'localidade_id']))
                                    Não encontramos registros com os filtros aplicados. Tente ajustar sua busca.
                                @else
                                    Ainda não existem demandas cadastradas. Deseja iniciar um novo registro?
                                @endif
                            </p>
                            <x-demandas::button href="{{ route('demandas.create') }}" variant="primary" size="lg" class="shadow-xl">
                                <x-icon name="plus" class="w-4 h-4 mr-2" />
                                Abrir Nova Demanda
                            </x-demandas::button>
                        </div>
                    </td>
                </tr>
            @endforelse
        </x-demandas::data-table>
    </x-demandas::card>
</div>

    <!-- Outbox Modal -->
    <div x-data="{ open: false }" @open-outbox.window="open = true" x-show="open" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50" style="display: none;">
        <div class="bg-white dark:bg-gray-800 rounded-lg max-w-lg w-full p-6 relative shadow-xl h-[80vh] flex flex-col" @click.outside="open = false">
             <div class="flex justify-between items-center mb-4">
                 <h2 class="text-xl font-bold dark:text-white flex items-center gap-2">
                     <x-icon name="folder-open" class="w-5 h-5" />
                     Fila de Envio
                 </h2>
                 <button @click="open = false" class="text-gray-500 hover:text-gray-700">&times;</button>
             </div>

             <div class="flex-1 overflow-y-auto space-y-3">
                <template x-for="item in queueItems" :key="item.id">
                    <div class="p-3 border rounded bg-gray-50 dark:bg-gray-700/50 flex items-start gap-3">
                        <div class="mt-1">
                            <x-icon name="clock" class="w-4 h-4 text-gray-400" />
                        </div>
                        <div class="flex-1">
                            <div class="flex justify-between">
                                <strong class="text-sm text-gray-800 dark:text-gray-200" x-text="item.action === 'upload_photo' ? 'Envio de Foto' : 'Atualização de Status'"></strong>
                                <span class="text-xs text-gray-500" x-text="new Date(item.timestamp).toLocaleTimeString()"></span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" x-text="'ID: ' + (item.payload.demand_id || item.payload.demandId || 'N/A')"></p>
                        </div>
                    </div>
                </template>
                <div x-show="queueItems.length === 0" class="text-center py-8 text-gray-500">
                    Nenhuma pendência na fila.
                </div>
             </div>

             <div class="mt-4 pt-4 border-t dark:border-gray-700">
                 <button @click="processQueue()" :disabled="!online || queueCount === 0" class="w-full bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 text-white py-3 rounded-lg font-semibold flex items-center justify-center gap-2">
                     <x-icon name="rotate" class="w-5 h-5" />
                     Sincronizar Agora
                 </button>
             </div>
        </div>
    </div>

@push('scripts')
<script>
function toggleDropdown(button) {
    const dropdown = button.closest('.relative');
    const menu = dropdown.querySelector('[id^="dropdown-menu-"]');
    if (menu) {
        menu.classList.toggle('hidden');
    }
}

document.addEventListener('click', function(event) {
    if (!event.target.closest('.relative[id^="export-dropdown-"]')) {
        document.querySelectorAll('[id^="dropdown-menu-"]').forEach(menu => {
            menu.classList.add('hidden');
        });
    }
});
</script>
@endpush
<div class="mb-4">                                                                <div class="mb-4 p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg border border-gray-200 dark:border-gray-600">
                        <label class="flex items-center space-x-3 cursor-pointer">
                            <input type="checkbox" x-model="imageConsent" class="form-checkbox h-5 w-5 text-indigo-600 rounded border-gray-300 focus:ring-indigo-500 dark:bg-gray-700 dark:border-gray-600">
                            <span class="text-sm text-gray-700 dark:text-gray-200 font-medium">Cidadão autorizou uso de imagem?</span>
                        </label>
                        <p x-show="!imageConsent" class="mt-2 text-xs text-amber-600 dark:text-amber-400 flex items-center">
                            <x-icon name="lock" class="w-3 h-3 mr-1" />
                            Foto será marcada como Uso Interno (LGPD)
                        </p>
                    </div>

<div class="grid grid-cols-2 gap-3 mb-4">
                        <label class="flex flex-col items-center justify-center p-3 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600 transition">
                            <x-icon name="camera" class="w-6 h-6 text-gray-400 mb-1" />
                            <span class="text-xs text-gray-500">Adicionar Foto</span>
                            <input type="file" accept="image/*" capture="environment" class="hidden" @change="capturePhoto($event)">
                        </label>

                        <button @click="toggleRadar()" class="flex flex-col items-center justify-center p-3 border border-gray-200 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-600 transition" :class="{'bg-indigo-50 border-indigo-200 dark:bg-indigo-900/30': radarActive}">
                            <x-icon name="location-dot" class="w-6 h-6 mb-1" x-bind:class="radarActive ? 'text-indigo-600' : 'text-gray-400'" />
                            <span class="text-xs" x-bind:class="radarActive ? 'text-indigo-700 font-semibold' : 'text-gray-500'" x-text="radarActive ? 'Parar Radar' : 'Ativar Radar'"></span>
                        </button>
                    </div>

                    <div x-show="radarActive" class="mb-4 p-4 bg-gray-900 rounded-lg text-center text-white relative overflow-hidden">
                        <div class="absolute inset-0 opacity-20 bg-[radial-gradient(circle,_var(--tw-gradient-stops))] from-green-500 to-transparent animate-pulse"></div>
                        <div class="relative z-10">
                            <div class="text-3xl font-bold mb-1" x-text="targetDistance ? targetDistance + 'm' : 'Calculando...'"></div>
                            <div class="text-xs text-gray-400 uppercase tracking-widest">Distância do Alvo</div>

                            <div class="mt-4 flex justify-center">
                                <div class="w-16 h-16 rounded-full border-2 border-green-500 flex items-center justify-center" :style="'transform: rotate(' + getRelativeBearing() + 'deg)'">
                                    <x-icon name="arrow-up" class="w-8 h-8 text-green-500" />
                                </div>
                            </div>
                        </div>
                    </div>

<label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Observações</label>                        <textarea x-model="selectedDemand.observacoes_temp" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm dark:bg-gray-700 dark:border-gray-600 dark:text-white" rows="3"></textarea>                    </div>                    <div class="flex gap-2">                        <button class="flex-1 bg-green-600 hover:bg-green-700 text-white py-2 rounded" @click="saveStatus()">Concluir</button>                        <button class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 rounded" @click="selectedDemand = null">Cancelar</button>                    </div>
@endsection
