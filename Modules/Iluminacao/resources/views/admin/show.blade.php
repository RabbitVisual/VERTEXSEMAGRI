@extends('admin.layouts.admin')

@section('title', 'Ponto de Luz #' . $ponto->codigo . ' - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="lightbulb" style="duotone" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Detalhes: #{{ $ponto->codigo }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <a href="{{ route('admin.iluminacao.index') }}" class="hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">Iluminação</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <span class="text-gray-900 dark:text-white font-medium">Ponto #{{ $ponto->codigo }}</span>
            </nav>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('iluminacao.show', $ponto->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-all shadow-sm">
                <x-icon name="eye" style="duotone" class="w-5 h-5 text-gray-500" />
                Ver no Painel Público
            </a>
        </div>
    </div>

    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-2xl bg-green-50 dark:bg-slate-800 dark:text-green-400 border border-green-100 dark:border-green-900/30 flex items-center gap-3">
        <x-icon name="circle-check" style="duotone" class="w-5 h-5" />
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Coluna da Esquerda: Dados Principais -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informações Técnicas -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/20">
                    <h3 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-icon name="circle-info" style="duotone" class="w-5 h-5 text-yellow-600" />
                        Informações Técnicas
                    </h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Localidade</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $ponto->localidade->nome ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Endereço</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $ponto->endereco }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Tipo de Lâmpada</p>
                        <span class="px-2 py-1 bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 rounded-lg text-xs font-bold">{{ ucfirst($ponto->tipo_lampada) }}</span>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Potência</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $ponto->potencia }}W</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Barramento</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $ponto->barramento ? 'Sim' : 'Não' }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider font-semibold mb-1">Transformador (Trafo)</p>
                        <p class="text-gray-900 dark:text-white font-medium">{{ $ponto->trafo ?? 'Não informado' }}</p>
                    </div>
                </div>
            </div>

            <!-- Demandas Recentes -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/20 flex items-center justify-between">
                    <h3 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-icon name="clipboard-list" style="duotone" class="w-5 h-5 text-yellow-600" />
                        Demandas Relacionadas
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 text-xs font-semibold uppercase">
                            <tr>
                                <th class="px-6 py-3">Data</th>
                                <th class="px-6 py-3">Serviço</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-right">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                            @forelse($demandasRelacionadas as $demanda)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-all">
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-400 whitespace-nowrap">{{ $demanda->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $demanda->servico }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 rounded-full text-[10px] font-bold uppercase {{ $demanda->status == 'concluida' ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400' : 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' }}">
                                        {{ $demanda->status }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.demandas.show', $demanda->id) }}" class="text-yellow-600 hover:text-yellow-700 flex justify-end">
                                        <x-icon name="arrow-up-right-from-square" class="w-4 h-4" />
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 italic">Nenhuma demanda registrada para este ponto.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Coluna da Direita: Status e Ações -->
        <div class="space-y-6">
            <!-- Status Card -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 p-6 text-center">
                <div class="inline-flex p-4 rounded-3xl bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-800/50 mb-4">
                    <x-icon name="lightbulb" style="duotone" class="w-10 h-10 text-yellow-500" />
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1">Status Atual</h2>
                @php
                    $stMap = [
                        'funcionando' => ['label' => 'Operacional', 'color' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400'],
                        'com_defeito' => ['label' => 'Com Defeito', 'color' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400'],
                        'desligado' => ['label' => 'Desativado', 'color' => 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-400'],
                    ];
                    $st = $stMap[$ponto->status] ?? ['label' => 'N/A', 'color' => 'bg-gray-100'];
                @endphp
                <p class="inline-flex px-4 py-1.5 rounded-full font-bold text-sm {{ $st['color'] }}">{{ $st['label'] }}</p>

                <div class="mt-8 pt-6 border-t border-gray-100 dark:border-slate-700 text-left">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Ações do Administrador</h4>
                    <div class="grid grid-cols-2 gap-3">
                         <button class="flex flex-col items-center justify-center p-3 rounded-xl border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition-all text-gray-600 dark:text-gray-400">
                            <x-icon name="pen-to-square" style="duotone" class="w-6 h-6 mb-1 text-gray-400" />
                            <span class="text-[10px] font-bold">Editar</span>
                        </button>
                        <button class="flex flex-col items-center justify-center p-3 rounded-xl border border-gray-200 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition-all text-gray-600 dark:text-gray-400">
                            <x-icon name="history" style="duotone" class="w-6 h-6 mb-1 text-gray-400" />
                            <span class="text-[10px] font-bold">Histórico</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Localização no Mapa (Placeholder) -->
             <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden group">
                 <div class="h-48 bg-slate-200 dark:bg-slate-700 flex items-center justify-center relative">
                    <x-icon name="map-location-dot" style="duotone" class="w-12 h-12 text-gray-400 group-hover:scale-110 transition-transform" />
                    <div class="absolute bottom-2 left-2 px-2 py-1 bg-white/80 dark:bg-slate-800/80 backdrop-blur rounded text-[10px] font-bold text-gray-600 dark:text-gray-300">
                        LAT: {{ $ponto->latitude ?? 'N/A' }} / LON: {{ $ponto->longitude ?? 'N/A' }}
                    </div>
                 </div>
                 <div class="p-4 text-center">
                    <a href="https://www.google.com/maps?q={{ $ponto->latitude }},{{ $ponto->longitude }}" target="_blank" class="text-xs font-bold text-yellow-600 hover:text-yellow-700 flex items-center justify-center gap-1">
                        <x-icon name="location-dot" class="w-3 h-3" />
                        Ver no Google Maps
                    </a>
                 </div>
             </div>
        </div>
    </div>

    <!-- Ordens de Serviço Relacionadas -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/20 flex items-center justify-between">
            <h3 class="font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon name="toolbox" style="duotone" class="w-5 h-5 text-yellow-600" />
                Ordens de Serviço Relacionadas
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="bg-gray-50 dark:bg-slate-900/50 text-gray-500 dark:text-gray-400 text-xs font-semibold uppercase">
                    <tr>
                        <th class="px-6 py-3">Número</th>
                        <th class="px-6 py-3">Equipe</th>
                        <th class="px-6 py-3">Prioridade</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3">Conclusão</th>
                        <th class="px-6 py-3 text-right">Ação</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    @forelse($ordensRelacionadas as $ordem)
                    <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-all">
                        <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">{{ $ordem->numero }}</td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">{{ $ordem->equipe->nome ?? 'S/E' }}</td>
                        <td class="px-6 py-4">
                             @php
                                $priMap = [
                                    'baixa' => 'bg-gray-100 text-gray-700 dark:bg-slate-700 dark:text-gray-400',
                                    'media' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400',
                                    'alta' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400',
                                    'urgente' => 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400',
                                ];
                                $pr = $priMap[$ordem->prioridade] ?? 'bg-slate-100 text-slate-700';
                            @endphp
                            <span class="px-2 py-0.5 rounded-full text-[10px] font-bold uppercase {{ $pr }}">
                                {{ $ordem->prioridade }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                            {{ ucfirst(str_replace('_', ' ', $ordem->status)) }}
                        </td>
                         <td class="px-6 py-4 text-gray-600 dark:text-gray-400">
                            {{ $ordem->data_conclusao ? $ordem->data_conclusao->format('d/m/Y') : '-' }}
                        </td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.ordens.show', $ordem->id) }}" class="p-2 text-yellow-600 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg hover:bg-yellow-600 hover:text-white flex justify-end">
                                <x-icon name="eye" style="duotone" class="w-4 h-4" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-500 dark:text-gray-400 italic">Nenhuma O.S. ativa para este ponto.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
