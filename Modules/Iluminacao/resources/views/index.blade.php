@extends('Co-Admin.layouts.app')

@section('title', 'Pontos de Luz')

@section('content')
<div class="space-y-8 animate-fade-in">

    <!-- Premium Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 p-8 shadow-sm">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-indigo-600 flex items-center justify-center text-white shadow-xl shadow-indigo-500/20">
                    <x-icon name="lightbulb-on" class="w-8 h-8" />
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Pontos de Luz
                    </h1>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="flex items-center px-2 py-0.5 rounded-full bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 text-xs font-bold uppercase tracking-wider border border-indigo-100 dark:border-indigo-800/50">
                            Módulo de Iluminação
                        </span>
                        <span class="text-slate-400 dark:text-slate-500">•</span>
                        <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Gestão inteligente da rede pública</p>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <div class="flex items-center gap-2 p-1 bg-slate-50 dark:bg-slate-900/50 rounded-xl border border-slate-200 dark:border-slate-700">
                    <a href="{{ route('iluminacao.export-neoenergia') }}"
                       @click="loading = true; setTimeout(() => loading = false, 3000)"
                       class="inline-flex items-center px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 rounded-lg transition-all duration-200">
                        <x-icon name="arrow-down-tray" class="w-4 h-4 mr-2 text-indigo-500" />
                        Exportar Neoenergia
                    </a>

                    <div class="w-px h-6 bg-slate-200 dark:border-slate-700"></div>

                    <form action="{{ route('iluminacao.import-neoenergia') }}" method="POST" enctype="multipart/form-data" @submit="loading = true">
                        @csrf
                        <label class="cursor-pointer inline-flex items-center px-4 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 hover:bg-white dark:hover:bg-slate-800 rounded-lg transition-all duration-200">
                            <x-icon name="file-import" class="w-4 h-4 mr-2 text-emerald-500" />
                            <span>Importar CSV</span>
                            <input type="file" name="file" accept=".csv,.txt" class="hidden" onchange="this.form.submit()">
                        </label>
                    </form>
                </div>

                <x-iluminacao::button href="{{ route('iluminacao.create') }}" variant="primary" size="lg" icon="plus" class="shadow-xl">
                    Novo Ponto
                </x-iluminacao::button>
            </div>
        </div>
    </div>

    <!-- Alert System -->
    @if(session('warning') || session('success') || session('error'))
        <div class="animate-slide-up">
            @if(session('warning'))
                <x-iluminacao::alert type="warning" dismissible>
                    {!! session('warning') !!}
                </x-iluminacao::alert>
            @endif

            @if(session('success'))
                <x-iluminacao::alert type="success" dismissible>
                    {{ session('success') }}
                </x-iluminacao::alert>
            @endif

            @if(session('error'))
                <x-iluminacao::alert type="danger" dismissible>
                    {{ session('error') }}
                </x-iluminacao::alert>
            @endif
        </div>
    @endif

    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 animate-slide-up">
        <x-iluminacao::stat-card
            title="Total Geral"
            :value="$stats['total']"
            icon="lightbulb"
            color="primary"
            subtitle="Pontos cadastrados" />

        <x-iluminacao::stat-card
            title="Operacionais"
            :value="$stats['funcionando']"
            icon="circle-check"
            color="success"
            subtitle="Em pleno funcionamento" />

        <x-iluminacao::stat-card
            title="Com Defeito"
            :value="$stats['com_defeito']"
            icon="triangle-exclamation"
            color="warning"
            subtitle="Aguardando manutenção" />

        <x-iluminacao::stat-card
            title="Desligados"
            :value="$stats['desligado']"
            icon="bolt-slash"
            color="danger"
            subtitle="Fora de operação" />
    </div>

    <!-- Main Content Area with Filters & Table -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 shadow-sm overflow-hidden animate-slide-up" style="animation-delay: 100ms">
        <!-- Intelligent Filter Bar -->
        <div class="p-6 border-b border-slate-200 dark:border-slate-700/50 bg-slate-50/50 dark:bg-slate-900/20">
            <x-iluminacao::filter-bar
                action="{{ route('iluminacao.index') }}"
                :filters="[
                    [
                        'name' => 'status',
                        'label' => 'Status do Ponto',
                        'type' => 'select',
                        'options' => [
                            '' => 'Todos os Status',
                            'funcionando' => 'Operacional',
                            'com_defeito' => 'Em Manutenção',
                            'desligado' => 'Desativado',
                        ],
                        'value' => $filters['status'] ?? ''
                    ],
                    [
                        'name' => 'localidade_id',
                        'label' => 'Região / Localidade',
                        'type' => 'select',
                        'options' => $localidades->pluck('nome', 'id')->prepend('Todas as Localidades', '')->toArray(),
                        'value' => $filters['localidade_id'] ?? ''
                    ],
                    [
                        'name' => 'tipo_lampada',
                        'label' => 'Tecnologia',
                        'type' => 'text',
                        'value' => $filters['tipo_lampada'] ?? '',
                        'placeholder' => 'Ex: LED, Vapor de Sódio'
                    ]
                ]"
                search-placeholder="Pesquisar por código, endereço, trafo ou referências..."
                :search-value="$filters['search'] ?? ''"
            />
        </div>

        <!-- Premium Data Table -->
        <div class="overflow-x-auto">
            @if($pontos->count() > 0)
                <table class="w-full text-sm text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-900/40 border-b border-slate-200 dark:border-slate-700/50">
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Ponto de Luz</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Localização</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider text-center">Tecnologia / Potência</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider text-center">Status Operacional</th>
                            <th scope="col" class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider text-right">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-700/50">
                        @foreach($pontos as $ponto)
                            <tr class="group hover:bg-slate-50 dark:hover:bg-slate-900/40 transition-colors duration-200">
                                <td class="px-6 py-5 whitespace-nowrap">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-400 font-bold text-xs ring-1 ring-slate-200 dark:ring-slate-600 group-hover:scale-110 transition-transform">
                                            PL
                                        </div>
                                        <div>
                                            <span class="block text-base font-bold text-slate-900 dark:text-white">{{ $ponto->codigo }}</span>
                                            <span class="block text-xs text-slate-400 font-medium">Cadastrado em {{ $ponto->created_at->format('d/m/Y') }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-semibold text-slate-700 dark:text-slate-300 flex items-center gap-1">
                                            <x-icon name="map-location-dot" class="w-3.5 h-3.5 text-indigo-500" />
                                            {{ $ponto->localidade->nome ?? 'Área não definida' }}
                                        </span>
                                        <span class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 max-w-[200px] truncate" title="{{ $ponto->endereco }}">
                                            {{ $ponto->endereco }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <div class="inline-flex flex-col items-center p-2 rounded-lg bg-slate-100 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700">
                                        <span class="text-sm font-bold text-slate-700 dark:text-slate-200">{{ $ponto->tipo_lampada ?? 'Não informado' }}</span>
                                        @if($ponto->potencia)
                                            <span class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-tighter mt-0.5">{{ $ponto->potencia }} Watts</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    @php
                                        $variantMapping = [
                                            'funcionando' => 'success',
                                            'com_defeito' => 'warning',
                                            'desligado' => 'danger'
                                        ];
                                        $iconMapping = [
                                            'funcionando' => 'circle-check',
                                            'com_defeito' => 'circle-exclamation',
                                            'desligado' => 'circle-xmark'
                                        ];
                                        $labelMapping = [
                                            'funcionando' => 'Operacional',
                                            'com_defeito' => 'Em Alerta',
                                            'desligado' => 'Inativo'
                                        ];
                                    @endphp
                                    <x-iluminacao::badge :variant="$variantMapping[$ponto->status] ?? 'default'" size="lg">
                                        <x-icon :name="$iconMapping[$ponto->status] ?? 'question'" class="w-3 h-3 mr-1.5" />
                                        {{ $labelMapping[$ponto->status] ?? ucfirst($ponto->status) }}
                                    </x-iluminacao::badge>
                                </td>
                                <td class="px-6 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <a href="{{ route('iluminacao.show', $ponto) }}"
                                           class="p-2 rounded-lg bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-100 dark:hover:bg-indigo-900/50 transition-colors"
                                           title="Ver Detalhes">
                                            <x-icon name="eye" class="w-5 h-5" />
                                        </a>
                                        <a href="{{ route('iluminacao.edit', $ponto) }}"
                                           class="p-2 rounded-lg bg-amber-50 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 hover:bg-amber-100 dark:hover:bg-amber-900/50 transition-colors"
                                           title="Editar Registro">
                                            <x-icon name="pen-to-square" class="w-5 h-5" />
                                        </a>
                                        <form action="{{ route('iluminacao.destroy', $ponto) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja remover este registro permanentemente?');">
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
                <!-- Elegant Empty State -->
                <div class="flex flex-col items-center justify-center py-20 px-6">
                    <div class="w-24 h-24 rounded-full bg-slate-100 dark:bg-slate-900 flex items-center justify-center text-slate-300 dark:text-slate-700 mb-6">
                        <x-icon name="lightbulb-slash" class="w-12 h-12" />
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">Nenhum Ponto Encontrado</h3>
                    <p class="text-slate-500 dark:text-slate-400 text-center max-w-sm mb-8">
                        Não existem registros para os filtros selecionados. Tente ajustar sua busca ou cadastre um novo ponto de luz.
                    </p>
                    <x-iluminacao::button href="{{ route('iluminacao.create') }}" variant="primary" icon="plus">
                        Adicionar Primeiro Ponto
                    </x-iluminacao::button>
                </div>
            @endif
        </div>

        <!-- Modern Pagination -->
        @if($pontos->hasPages())
            <div class="px-6 py-6 border-t border-slate-200 dark:border-slate-700/50 bg-slate-50/30 dark:bg-slate-900/10">
                {{ $pontos->appends($filters)->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
