@extends('Co-Admin.layouts.app')

@section('title', 'Redes de Água')

@section('content')
<div class="space-y-8 animate-fade-in">

    <!-- Premium Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 p-8 shadow-sm">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-64 h-64 bg-blue-500/5 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-blue-600 flex items-center justify-center text-white shadow-xl shadow-blue-500/20">
                    <x-icon name="droplet" class="w-8 h-8" />
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Redes de Água
                    </h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="flex items-center px-2 py-0.5 rounded-full bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-bold uppercase tracking-wider border border-blue-100 dark:border-blue-800/50">
                            Patrimônio Hídrico
                        </span>
                        <span class="text-slate-400 dark:text-slate-500">•</span>
                        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Gestão de redes e vazamentos</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <x-agua::button href="{{ route('agua.create') }}" variant="primary" size="lg" icon="plus" class="shadow-xl">
                    Nova Rede
                </x-agua::button>
            </div>
        </div>
    </div>

    <!-- Alert System -->
    @if(session('warning') || session('success') || session('error'))
        <div class="animate-slide-up">
            @if(session('warning'))
                <x-agua::alert type="warning" dismissible>
                    {!! session('warning') !!}
                </x-agua::alert>
            @endif

            @if(session('success'))
                <x-agua::alert type="success" dismissible>
                    {{ session('success') }}
                </x-agua::alert>
            @endif

            @if(session('error'))
                <x-agua::alert type="danger" dismissible>
                    {{ session('error') }}
                </x-agua::alert>
            @endif
        </div>
    @endif

    <!-- Main Content Area with Filters & Table -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 shadow-sm overflow-hidden animate-slide-up">
        <!-- Intelligent Filter Bar -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/20">
            <x-agua::filter-bar
                action="{{ route('agua.index') }}"
                :filters="[
                    [
                        'name' => 'status',
                        'label' => 'Status',
                        'type' => 'select',
                        'options' => [
                            '' => 'Todos os Status',
                            'funcionando' => 'Operacional',
                            'com_vazamento' => 'Com Vazamento',
                            'interrompida' => 'Interrompida'
                        ],
                        'value' => request('status')
                    ],
                    [
                        'name' => 'tipo_rede',
                        'label' => 'Tipo de Rede',
                        'type' => 'select',
                        'options' => [
                            '' => 'Todos os Tipos',
                            'principal' => 'Principal',
                            'secundaria' => 'Secundária',
                            'ramal' => 'Ramal'
                        ],
                        'value' => request('tipo_rede')
                    ],
                    [
                        'name' => 'localidade_id',
                        'label' => 'Localidade',
                        'type' => 'select',
                        'options' => $localidades->pluck('nome', 'id')->prepend('Todas as Localidades', '')->toArray(),
                        'value' => request('localidade_id')
                    ]
                ]"
                search-placeholder="Buscar por código ou material..."
                :search-value="request('search')"
            />
        </div>

        <!-- Premium Data Table -->
        <div class="overflow-x-auto">
            @if($redes->count() > 0)
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-900/40 border-b border-slate-200 dark:border-slate-700/50">
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Código / Localidade</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Tipo</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider text-center">Diâmetro / Extensão</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider text-center">Status</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700/50">
                        @foreach($redes as $rede)
                            <tr class="group hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-colors duration-200">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold text-xs ring-1 ring-blue-100 dark:ring-blue-800/50 group-hover:scale-110 transition-transform">
                                            RA
                                        </div>
                                        <div>
                                            <span class="block text-base font-bold text-slate-900 dark:text-white">{{ $rede->codigo ?? 'N/A' }}</span>
                                            <span class="block text-xs text-slate-400 font-medium flex items-center gap-1">
                                                <x-icon name="map-pin" class="w-3 h-3 text-indigo-500" />
                                                {{ $rede->localidade->nome ?? 'N/A' }}
                                            </span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <x-agua::badge variant="info" size="sm">
                                        {{ ucfirst($rede->tipo_rede) }}
                                    </x-agua::badge>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="inline-flex flex-col items-center p-2 rounded-lg bg-slate-100 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700">
                                        <span class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $rede->diametro ?? '-' }}</span>
                                        @if($rede->extensao_metros)
                                            <span class="text-[10px] font-bold text-blue-600 dark:text-blue-400 uppercase tracking-tighter mt-0.5">{{ number_format($rede->extensao_metros, 2, ',', '.') }} m</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $statusVariants = [
                                            'funcionando' => 'success',
                                            'com_vazamento' => 'warning',
                                            'interrompida' => 'danger'
                                        ];
                                        $statusVariant = $statusVariants[$rede->status] ?? 'default';
                                        $statusIcons = [
                                            'funcionando' => 'circle-check',
                                            'com_vazamento' => 'circle-exclamation',
                                            'interrompida' => 'circle-xmark'
                                        ];
                                        $statusLabels = [
                                            'funcionando' => 'Operacional',
                                            'com_vazamento' => 'Vazamento',
                                            'interrompida' => 'Interrompida'
                                        ];
                                    @endphp
                                    <x-agua::badge :variant="$statusVariant" size="lg">
                                        <x-icon :name="$statusIcons[$rede->status] ?? 'question'" class="w-3 h-3 mr-1.5" />
                                        {{ $statusLabels[$rede->status] ?? ucfirst($rede->status) }}
                                    </x-agua::badge>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <a href="{{ route('agua.show', $rede) }}"
                                           class="p-2 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors"
                                           title="Ver Detalhes">
                                            <x-icon name="eye" class="w-5 h-5" />
                                        </a>
                                        <a href="{{ route('agua.edit', $rede) }}"
                                           class="p-2 rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-900/50 transition-colors"
                                           title="Editar">
                                            <x-icon name="pen-to-square" class="w-5 h-5" />
                                        </a>
                                        <form action="{{ route('agua.destroy', $rede) }}" method="POST" class="inline" onsubmit="return confirm('Deseja realmente deletar esta rede?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="p-2 rounded-lg bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 hover:bg-red-100 dark:hover:bg-red-900/50 transition-colors" title="Excluir">
                                                <x-icon name="trash-can" class="w-5 h-5" />
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="flex flex-col items-center justify-center py-20 px-6">
                    <div class="w-24 h-24 rounded-full bg-slate-100 dark:bg-slate-900 flex items-center justify-center text-slate-300 dark:text-slate-700 mb-6">
                        <x-icon name="inbox" class="w-12 h-12" />
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Nenhuma Rede Encontrada</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-center max-w-sm mb-8">
                        Não existem registros para os filtros selecionados.
                    </p>
                    <x-agua::button href="{{ route('agua.create') }}" variant="primary" icon="plus">
                        Criar Primeira Rede
                    </x-agua::button>
                </div>
            @endif
        </div>

        @if(is_object($redes) && method_exists($redes, 'hasPages') && $redes->hasPages())
            <div class="px-6 py-6 border-t border-slate-200 dark:border-slate-700/50 bg-slate-50/30 dark:bg-slate-900/10">
                {{ $redes->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
