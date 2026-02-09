@extends('Co-Admin.layouts.app')

@section('title', 'Dossiê do Poço: ' . ($poco->codigo ?? $poco->id))

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white flex items-center gap-3 mb-2 uppercase tracking-tight">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg text-white">
                    <x-icon name="faucet-drip" style="duotone" class="w-6 h-6 md:w-7 md:h-7" />
                </div>
                <span>Poço <span class="text-blue-600">{{ $poco->codigo ?? '#' . $poco->id }}</span></span>
            </h1>
            <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400">
                <a href="{{ route('pocos.index') }}" class="hover:text-blue-600 transition-colors">Poços</a>
                <x-icon name="chevron-right" class="w-2.5 h-2.5" />
                <span class="text-blue-600">Dossiê Técnico</span>
            </nav>
        </div>
        <div class="flex flex-wrap items-center gap-3">
             <a href="{{ route('pocos.print', $poco) }}" target="_blank" class="inline-flex items-center gap-2 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-emerald-600 bg-emerald-50 hover:bg-emerald-600 hover:text-white rounded-xl transition-all dark:bg-emerald-900/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-900/30">
                <x-icon name="print" style="duotone" class="w-4 h-4" />
                Imprimir
            </a>
            <a href="{{ route('pocos.edit', $poco) }}" class="inline-flex items-center gap-2 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-amber-600 bg-amber-50 hover:bg-amber-600 hover:text-white rounded-xl transition-all dark:bg-amber-900/10 dark:text-amber-400 border border-amber-100 dark:border-amber-900/30">
                <x-icon name="pen-to-square" style="duotone" class="w-4 h-4" />
                Editar
            </a>
            <a href="{{ route('pocos.index') }}" class="inline-flex items-center gap-2 px-6 py-3 text-[10px] font-black uppercase tracking-widest text-slate-500 bg-gray-50 border border-gray-100 hover:bg-gray-100 rounded-xl transition-all dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700">
                <x-icon name="arrow-left" class="w-4 h-4" />
                Voltar
            </a>
        </div>
    </div>

    <!-- Alerta de Status Crítico -->
    @if($poco->status === 'bomba_queimada' || $poco->status === 'manutencao')
    <div class="p-6 bg-rose-50 dark:bg-rose-900/10 border border-rose-100 dark:border-rose-900/20 rounded-3xl flex items-center gap-5 animate-shake">
        <div class="w-14 h-14 rounded-2xl bg-white dark:bg-slate-900 flex items-center justify-center text-rose-600 shadow-sm border border-rose-50">
            <x-icon name="triangle-exclamation" style="duotone" class="w-7 h-7" />
        </div>
        <div>
            <h4 class="text-xs font-black text-rose-900 dark:text-rose-300 uppercase tracking-widest mb-1 px-1">Alerta Operacional</h4>
            <p class="text-[11px] text-rose-800/80 dark:text-rose-400/80 font-bold uppercase tracking-tight leading-relaxed">Este poço encontra-se em estado de <strong>{{ strtoupper($poco->status_texto) }}</strong>. Verifique o cronograma de manutenção ou ordens de serviço pendentes.</p>
        </div>
    </div>
    @endif

    <div x-data="{ activeTab: 'detalhes' }" class="space-y-8">
        <!-- Navegação de Abas Premium -->
        <div class="flex items-center gap-3 p-1.5 bg-gray-100 dark:bg-slate-900/50 rounded-[2rem] w-fit border border-gray-200 dark:border-slate-800 shadow-inner overflow-hidden">
            <button @click="activeTab = 'detalhes'"
                :class="activeTab === 'detalhes' ? 'bg-white dark:bg-slate-800 text-blue-600 shadow-xl border-gray-200 dark:border-slate-700' : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 border-transparent hover:bg-white/50 dark:hover:bg-slate-800/50'"
                class="flex items-center gap-2 px-8 py-3 text-[10px] font-black uppercase tracking-[0.2em] rounded-[1.5rem] transition-all border duration-300">
                <x-icon name="circle-info" style="duotone" class="w-4 h-4" />
                Dossiê
            </button>
            <button @click="activeTab = 'demandas'"
                :class="activeTab === 'demandas' ? 'bg-white dark:bg-slate-800 text-blue-600 shadow-xl border-gray-200 dark:border-slate-700' : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 border-transparent hover:bg-white/50 dark:hover:bg-slate-800/50'"
                class="flex items-center gap-2 px-8 py-3 text-[10px] font-black uppercase tracking-[0.2em] rounded-[1.5rem] transition-all border relative duration-300">
                <x-icon name="clipboard-list" style="duotone" class="w-4 h-4" />
                Gestão
                @if(isset($demandas) && $demandas->count() > 0)
                <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-rose-500 text-[10px] font-black text-white ring-4 ring-gray-100 dark:ring-slate-900/50 animate-bounce">
                    {{ $demandas->count() }}
                </span>
                @endif
            </button>
             <button @click="activeTab = 'tecnico'"
                :class="activeTab === 'tecnico' ? 'bg-white dark:bg-slate-800 text-blue-600 shadow-xl border-gray-200 dark:border-slate-700' : 'text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 border-transparent hover:bg-white/50 dark:hover:bg-slate-800/50'"
                class="flex items-center gap-2 px-8 py-3 text-[10px] font-black uppercase tracking-[0.2em] rounded-[1.5rem] transition-all border duration-300">
                <x-icon name="microchip" style="duotone" class="w-4 h-4" />
                Técnico
            </button>
        </div>

        <!-- Conteúdo das Abas -->
        <div class="space-y-8">
            <!-- Abas: Detalhes do Dossiê -->
            <div x-show="activeTab === 'detalhes'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="lg:col-span-2 space-y-8">
                    <div class="premium-card overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                            <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                                <x-icon name="location-pin-lock" style="duotone" class="w-5 text-blue-500" />
                                Identificação Geográfica
                            </h2>
                            <span class="px-4 py-1.5 bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 rounded-xl text-[9px] font-black uppercase tracking-widest border border-blue-100 dark:border-blue-900/30">Lançado em {{ $poco->created_at->format('d/m/Y') }}</span>
                        </div>
                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10 mb-10">
                                <div class="space-y-1.5">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Código Patrimonial</p>
                                    <p class="text-2xl font-black text-gray-900 dark:text-white tracking-widest">{{ $poco->codigo ?? 'AGU-N/D' }}</p>
                                </div>
                                <div class="space-y-1.5">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Localidade Atendida</p>
                                    <p class="text-lg font-black text-gray-700 dark:text-slate-300 uppercase tracking-tighter">{{ $poco->localidade->nome ?? 'Área não mapeada' }}</p>
                                </div>
                                <div class="space-y-1.5">
                                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em]">Estado Operacional</p>
                                    @php
                                        $statusClass = $poco->status === 'ativo' ? 'text-emerald-500' : 'text-rose-500';
                                    @endphp
                                    <div class="flex items-center gap-2 {{ $statusClass }}">
                                        <div class="w-2.5 h-2.5 rounded-full bg-current animate-pulse shadow-[0_0_10px_current]"></div>
                                        <p class="text-lg font-black uppercase tracking-widest">{{ $poco->status_texto }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-[0.15em] px-1">Endereço de Referência</p>
                                <div class="p-5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-3xl flex items-center gap-4">
                                    <div class="p-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm text-blue-500">
                                        <x-icon name="map-location-dot" style="duotone" class="w-6 h-6" />
                                    </div>
                                    <p class="text-xs font-black text-gray-700 dark:text-slate-300 uppercase tracking-tight leading-relaxed">{{ $poco->endereco }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Mapa e Localização -->
                    <div class="premium-card overflow-hidden">
                        <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                            <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                                <x-icon name="satellite" style="duotone" class="w-5 text-indigo-500" />
                                Monitoramento Geoespacial
                            </h2>
                        </div>
                        <div class="h-[400px] w-full relative">
                            <x-map
                                :latitude="$poco->latitude"
                                :longitude="$poco->longitude"
                                :nome-mapa="$poco->codigo ?? 'Poço sem código'"
                                icon-type="poco"
                                height="100%"
                                :zoom="15"
                                :readonly="true"
                            />
                            <div class="absolute bottom-6 left-6 right-6 z-[1000]">
                                <div class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md p-5 rounded-3xl shadow-2xl border border-white/20 flex flex-wrap gap-8 justify-center">
                                    <div class="text-center group">
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Latitude</p>
                                        <p class="text-xs font-black text-gray-900 dark:text-white font-mono group-hover:text-blue-500 transition-colors">{{ $poco->latitude ?? 'Não definida' }}</p>
                                    </div>
                                    <div class="w-px h-8 bg-gray-100 dark:bg-slate-800"></div>
                                    <div class="text-center group">
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Longitude</p>
                                        <p class="text-xs font-black text-gray-900 dark:text-white font-mono group-hover:text-blue-500 transition-colors">{{ $poco->longitude ?? 'Não definida' }}</p>
                                    </div>
                                    <div class="w-px h-8 bg-gray-100 dark:bg-slate-800"></div>
                                    <div class="text-center">
                                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Precisão Estimada</p>
                                        <p class="text-xs font-black text-emerald-500 font-mono">+/- 5.0m</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Painel Lateral: Resumo Rápido -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Card de Equipe -->
                    <div class="premium-card p-8 bg-gradient-to-br from-white to-blue-50/30 dark:from-slate-800 dark:to-slate-900/50">
                        <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2 mb-6">
                            <x-icon name="user-gear" style="duotone" class="w-5 text-blue-500" />
                            Responsabilidade
                        </h2>

                        <div class="flex items-center gap-4 p-5 bg-white dark:bg-slate-900 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-800 mb-6">
                            <div class="w-14 h-14 rounded-2xl bg-blue-600 flex items-center justify-center text-white shadow-lg shadow-blue-500/20">
                                <x-icon name="screwdriver-wrench" class="w-7 h-7" />
                            </div>
                            <div>
                                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-0.5 px-0.5">Equipe Técnica</p>
                                <p class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight">{{ $poco->equipeResponsavel->nome ?? 'Setor Público' }}</p>
                            </div>
                        </div>

                        <div class="space-y-4">
                             <div class="flex items-center justify-between text-[11px] font-bold uppercase tracking-tight px-1">
                                <span class="text-slate-400">Última Revisão:</span>
                                <span class="text-gray-900 dark:text-white">{{ $poco->ultima_manutencao ? $poco->ultima_manutencao->format('d/m/Y') : 'N/D' }}</span>
                            </div>
                            <div class="flex items-center justify-between text-[11px] font-bold uppercase tracking-tight px-1 text-rose-500">
                                <span class="text-slate-400">Próxima Revisão:</span>
                                <span>{{ $poco->proxima_manutencao ? $poco->proxima_manutencao->format('d/m/Y') : 'N/D' }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Registros de Notas -->
                    <div class="premium-card p-8">
                         <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2 mb-6">
                            <x-icon name="comment-dots" style="duotone" class="w-5 text-amber-500" />
                            Logs & Notas
                        </h2>
                        <div class="p-6 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-100 dark:border-slate-800 rounded-3xl min-h-[150px]">
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 font-bold uppercase tracking-tight leading-relaxed italic">
                                {{ $poco->observacoes ?? 'Sem anotações complementares registradas para este ativo.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Abas: Demandas e Gestão -->
            <div x-show="activeTab === 'demandas'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="space-y-8">
                <div class="premium-card p-8 text-center py-20">
                     <div class="w-20 h-20 bg-gray-50 dark:bg-slate-900 rounded-full flex items-center justify-center text-gray-200 dark:text-slate-800 mx-auto mb-6 scale-125">
                        <x-icon name="list-check" style="duotone" class="w-10 h-10" />
                    </div>
                    <h3 class="text-lg font-black text-gray-900 dark:text-white uppercase tracking-tight">Histórico de Ordens de Serviço</h3>
                    <p class="text-[11px] text-slate-400 font-bold uppercase tracking-widest mt-2">Módulo de manutenção está processando os dados deste ativo.</p>
                </div>
            </div>

            <!-- Abas: Especificações Técnicas -->
            <div x-show="activeTab === 'tecnico'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                 <!-- Engenharia do Poço -->
                <div class="premium-card overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
                        <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <x-icon name="bore-hole" style="duotone" class="w-5 text-blue-500" />
                            Perfuração
                        </h2>
                    </div>
                    <div class="p-8 space-y-6">
                        <div class="flex justify-between items-center group">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Profundidade</span>
                            <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight group-hover:text-blue-500 transition-colors">{{ $poco->profundidade_metros }} MT</span>
                        </div>
                        <div class="flex justify-between items-center group">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Vazão Nominal</span>
                            <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight group-hover:text-blue-500 transition-colors">{{ $poco->vazao_litros_hora }} L/H</span>
                        </div>
                        <div class="flex justify-between items-center group">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Diâmetro do Tubo</span>
                            <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight group-hover:text-blue-500 transition-colors">{{ $poco->diametro ?? 'N/D' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Sistema de Bombeamento -->
                <div class="premium-card overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
                        <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <x-icon name="bolt" style="duotone" class="w-5 text-amber-500" />
                            Sistema Elétrico
                        </h2>
                    </div>
                    <div class="p-8 space-y-6">
                         <div class="flex justify-between items-center group">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Modelo da Bomba</span>
                            <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight group-hover:text-amber-500 transition-colors">{{ $poco->tipo_bomba ?? 'Desconhecido' }}</span>
                        </div>
                        <div class="flex justify-between items-center group">
                            <span class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Potência Instalada</span>
                            <span class="text-sm font-black text-gray-900 dark:text-white uppercase tracking-tight group-hover:text-amber-500 transition-colors">{{ $poco->potencia_bomba ?? 'N/D' }} HP/CV</span>
                        </div>
                    </div>
                </div>

                <!-- Resumo Operacional -->
                <div class="premium-card bg-slate-900 text-white p-8 flex flex-col justify-center items-center text-center space-y-4">
                     <div class="w-16 h-16 rounded-full bg-blue-600/20 flex items-center justify-center text-blue-500 border border-blue-500/30">
                        <x-icon name="wave-pulse" class="w-8 h-8 font-black" />
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-1">Índice de Saúde</p>
                        <p class="text-4xl font-black tracking-tighter">94<span class="text-xl text-blue-600">%</span></p>
                    </div>
                    <p class="text-[9px] font-bold text-slate-500 uppercase tracking-widest">Analítico Baseado em Histórico</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
