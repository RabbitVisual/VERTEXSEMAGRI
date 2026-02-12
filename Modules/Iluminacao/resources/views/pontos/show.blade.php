@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes do Ponto de Luz')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 p-8 shadow-sm">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-16 h-16 rounded-2xl bg-slate-100 dark:bg-slate-700 flex items-center justify-center text-slate-600 dark:text-slate-400 shadow-inner">
                    <x-icon name="lightbulb" class="w-8 h-8" />
                </div>
                <div>
                    <div class="flex items-center gap-3">
                        <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                            Ponto <span class="text-indigo-600 dark:text-indigo-400">{{ $ponto->codigo ?? '#' . $ponto->id }}</span>
                        </h1>
                        @php
                            $statusVariant = [
                                'funcionando' => 'success',
                                'com_defeito' => 'warning',
                                'desligado' => 'danger'
                            ][$ponto->status] ?? 'default';
                        @endphp
                        <x-iluminacao::badge :variant="$statusVariant" size="lg">
                            {{ ucfirst($ponto->status) }}
                        </x-iluminacao::badge>
                    </div>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Gestão detalhada do ativo de iluminação</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <x-iluminacao::button href="{{ route('co-admin.iluminacao.edit', $ponto) }}" variant="secondary" icon="pen-to-square">
                    Editar Dados
                </x-iluminacao::button>
                <x-iluminacao::button href="{{ route('co-admin.iluminacao.index') }}" variant="outline" icon="arrow-left">
                    Voltar para Lista
                </x-iluminacao::button>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <x-iluminacao::tabs default-tab="0" :tabs="['Informações Gerais', 'Localização & Mapa', 'Demandas & Ordens', 'Histórico de Eventos']">
        <!-- Tab 0: Informações Gerais -->
        <div class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Dados do Ativo -->
                <x-iluminacao::card header="Dados do Ativo">
                    <div class="grid grid-cols-2 gap-y-6">
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Código do Ponto</span>
                            <span class="text-lg font-bold text-slate-900 dark:text-white">{{ $ponto->codigo ?? 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Status Atual</span>
                            <x-iluminacao::badge :variant="$statusVariant" size="md">{{ ucfirst($ponto->status) }}</x-iluminacao::badge>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Instalado em</span>
                            <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $ponto->data_instalacao ? $ponto->data_instalacao->format('d/m/Y') : 'Não informado' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Criação do Registro</span>
                            <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $ponto->created_at->format('d/m/Y') }}</span>
                        </div>
                    </div>
                </x-iluminacao::card>

                <!-- Especificações Técnicas -->
                <x-iluminacao::card header="Especificações Técnicas">
                    <div class="grid grid-cols-2 gap-y-6">
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Tipo de Lâmpada</span>
                            <span class="px-3 py-1 rounded-lg bg-slate-100 dark:bg-slate-900 text-slate-700 dark:text-slate-300 text-sm font-bold border border-slate-200 dark:border-slate-700">
                                {{ $ponto->tipo_lampada ?? 'N/A' }}
                            </span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Potência Nominal</span>
                            <span class="text-lg font-bold text-indigo-600 dark:text-indigo-400">{{ $ponto->potencia ? $ponto->potencia . ' Watts' : 'N/A' }}</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Estrutura (Poste)</span>
                            <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $ponto->tipo_poste ?? 'N/A' }} ({{ $ponto->altura_poste ? number_format($ponto->altura_poste, 1) . 'm' : 'Alt. N/A' }})</span>
                        </div>
                        <div>
                            <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Tipo de Fiação</span>
                            <span class="text-slate-700 dark:text-slate-300 font-medium">{{ $ponto->tipo_fiacao ?? 'N/A' }}</span>
                        </div>
                    </div>
                </x-iluminacao::card>
            </div>

            <!-- Observações Card -->
            @if($ponto->observacoes)
                <x-iluminacao::card header="Informações Adicionais / Observações">
                    <div class="bg-slate-50 dark:bg-slate-900/40 p-5 rounded-2xl border border-dashed border-slate-200 dark:border-slate-700">
                        <p class="text-slate-600 dark:text-slate-400 leading-relaxed italic text-sm">
                            {{ $ponto->observacoes }}
                        </p>
                    </div>
                </x-iluminacao::card>
            @endif
        </div>

        <!-- Tab 1: Localização & Mapa -->
        <div class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Dados de Endereço -->
                <div class="lg:col-span-1 space-y-6">
                    <x-iluminacao::card header="Endereçamento">
                        <div class="space-y-6">
                            <div>
                                <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Localidade / Distrito</span>
                                <div class="flex items-center gap-3 p-3 rounded-xl bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/50">
                                    <div class="w-10 h-10 rounded-lg bg-indigo-600 flex items-center justify-center text-white">
                                        <x-icon name="map-location-dot" class="w-5 h-5" />
                                    </div>
                                    <div>
                                        <span class="block font-bold text-slate-900 dark:text-white">{{ $ponto->localidade->nome ?? 'Área não definida' }}</span>
                                        <span class="text-[10px] font-bold text-indigo-600 dark:text-indigo-400 uppercase">Cód: {{ $ponto->localidade->codigo ?? '---' }}</span>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Endereço Completo</span>
                                <div class="text-sm text-slate-700 dark:text-slate-300 font-medium leading-relaxed">
                                    {{ $ponto->endereco }}
                                </div>
                            </div>

                            <div class="pt-4 border-t border-slate-200 dark:border-slate-700/50">
                                <div class="grid grid-cols-2 gap-4 text-center">
                                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-900/50">
                                        <span class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Latitude</span>
                                        <span class="text-xs font-mono font-bold text-slate-700 dark:text-slate-300">{{ $ponto->latitude ?? '---' }}</span>
                                    </div>
                                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-slate-900/50">
                                        <span class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Longitude</span>
                                        <span class="text-xs font-mono font-bold text-slate-700 dark:text-slate-300">{{ $ponto->longitude ?? '---' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-iluminacao::card>

                    @if($ponto->nome_mapa)
                    <x-iluminacao::card header="Referência no Mapa">
                        <div class="text-sm font-bold text-slate-700 dark:text-slate-200 flex items-center gap-2">
                            <x-icon name="bookmark" class="w-4 h-4 text-amber-500" />
                            {{ $ponto->nome_mapa }}
                        </div>
                    </x-iluminacao::card>
                    @endif
                </div>

                <!-- Mapa -->
                <div class="lg:col-span-2">
                    <x-iluminacao::card class="h-full min-h-[400px]">
                        @if($ponto->latitude && $ponto->longitude)
                             <x-map
                                latitude-field="latitude"
                                longitude-field="longitude"
                                :latitude="$ponto->latitude"
                                :longitude="$ponto->longitude"
                                :nome-mapa="$ponto->nome_mapa"
                                icon-type="ponto_luz"
                                readonly
                                height="450px"
                                center-lat="{{ $ponto->latitude }}"
                                center-lng="{{ $ponto->longitude }}"
                                zoom="16"
                            />
                        @else
                            <div class="flex flex-col items-center justify-center h-full text-slate-400 gap-3">
                                <x-icon name="map-slash" class="w-16 h-16 opacity-20" />
                                <p class="text-sm font-medium">Coordenadas geográficas não disponíveis para este ponto.</p>
                            </div>
                        @endif
                    </x-iluminacao::card>
                </div>
            </div>
        </div>

        <!-- Tab 2: Demandas & Ordens -->
        <div class="space-y-6">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Demandas Relacionadas -->
                <x-iluminacao::card header="Demandas de Reparo (Luz)">
                    @php $demandas = $ponto->demandas ?? collect([]); @endphp
                    @if($demandas->count() > 0)
                        <div class="space-y-4">
                            @foreach($demandas as $demanda)
                                <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                                            <x-icon name="clipboard-list" class="w-5 h-5" />
                                        </div>
                                        <div>
                                            <span class="block font-bold text-slate-900 dark:text-white">Demanda #{{ $demanda->codigo ?? $demanda->id }}</span>
                                            <span class="text-xs text-slate-500">{{ $demanda->created_at->format('d/m/Y') }} •
                                                <span class="font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-tighter">{{ $demanda->status }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('demandas.show', $demanda->id) }}" class="p-2 rounded-lg hover:bg-white dark:hover:bg-slate-800 transition-colors text-slate-400 hover:text-indigo-500">
                                        <x-icon name="circle-chevron-right" class="w-6 h-6" />
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10">
                            <x-icon name="folder-open" class="w-12 h-12 mx-auto text-slate-200 dark:text-slate-700 mb-3" />
                            <p class="text-slate-400 text-sm italic">Nenhuma demanda ativa para este ponto.</p>
                        </div>
                    @endif
                </x-iluminacao::card>

                <!-- Ordens de Serviço -->
                <x-iluminacao::card header="Ordens de Serviço">
                    @php $ordens = $ponto->ordensServico ?? collect([]); @endphp
                    @if($ordens->count() > 0)
                        <div class="space-y-4">
                            @foreach($ordens as $os)
                                <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                                            <x-icon name="wrench-screwdriver" class="w-5 h-5" />
                                        </div>
                                        <div>
                                            <span class="block font-bold text-slate-900 dark:text-white">OS #{{ $os->numero ?? $os->id }}</span>
                                            <span class="text-xs text-slate-500">{{ $os->data_abertura ? $os->data_abertura->format('d/m/Y') : $os->created_at->format('d/m/Y') }} •
                                                <span class="font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-tighter">{{ $os->status }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('ordens.show', $os->id) }}" class="p-2 rounded-lg hover:bg-white dark:hover:bg-slate-800 transition-colors text-slate-400 hover:text-emerald-500">
                                        <x-icon name="circle-chevron-right" class="w-6 h-6" />
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10">
                            <x-icon name="folder-open" class="w-12 h-12 mx-auto text-slate-200 dark:text-slate-700 mb-3" />
                            <p class="text-slate-400 text-sm italic">Nenhuma OS em andamento ou vinculada.</p>
                        </div>
                    @endif
                </x-iluminacao::card>
            </div>
        </div>

        <!-- Tab 3: Histórico de Eventos -->
        <div class="space-y-6">
            <x-iluminacao::card header="Linha do Tempo (Log de Eventos)">
                <div class="relative space-y-8 before:absolute before:inset-0 before:ml-5 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 dark:before:via-slate-700 before:to-transparent">
                    @php $historico = $ponto->historico ?? collect([]); @endphp
                    @forelse($historico as $evento)
                        <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                            <!-- Dot -->
                            <div class="flex items-center justify-center w-10 h-10 rounded-full border-4 border-white dark:border-slate-800 bg-indigo-500 text-white shadow shadow-indigo-500/20 shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 overflow-hidden">
                                <x-icon name="check-double" class="w-5 h-5" />
                            </div>
                            <!-- Box -->
                            <div class="w-[calc(100%-4rem)] md:w-[calc(50%-2.5rem)] p-6 rounded-3xl bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700/50 shadow-sm">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="px-2.5 py-1 rounded-md bg-slate-100 dark:bg-slate-900 text-[10px] font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest border border-slate-200 dark:border-slate-700">
                                        {{ $evento->tipo_evento }}
                                    </span>
                                    <time class="text-xs font-bold text-indigo-500">{{ $evento->data_evento ? $evento->data_evento->format('d/m/Y H:i') : $evento->created_at->format('d/m/Y H:i') }}</time>
                                </div>
                                <div class="text-sm font-medium text-slate-700 dark:text-slate-300 leading-relaxed mb-3">
                                    {{ $evento->descricao }}
                                </div>
                                <div class="flex items-center gap-2 text-[11px] text-slate-400">
                                    <x-icon name="user" class="w-3 h-3" />
                                    <span>Operador: <span class="text-slate-600 dark:text-slate-400 font-bold uppercase">{{ $evento->usuario->name ?? 'Sistema / Automático' }}</span></span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col items-center justify-center py-16 text-slate-400">
                            <x-icon name="timeline" class="w-16 h-16 opacity-10 mb-4" />
                            <p class="text-sm font-medium">Nenhum evento registrado no histórico deste ponto.</p>
                        </div>
                    @endforelse
                </div>
            </x-iluminacao::card>
        </div>
    </x-iluminacao::tabs>
</div>
@endsection
