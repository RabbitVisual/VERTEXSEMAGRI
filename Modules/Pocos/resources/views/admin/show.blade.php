@extends('admin.layouts.admin')

@section('title', 'Poço #' . $poco->codigo . ' - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="bore-hole" style="duotone" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Poço #{{ $poco->codigo }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <a href="{{ route('admin.pocos.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Poços</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <span class="text-gray-900 dark:text-white font-medium">#{{ $poco->codigo }}</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.pocos.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <x-icon name="arrow-left" style="duotone" class="w-5 h-5" />
                Voltar
            </a>
            <a href="{{ route('pocos.show', $poco->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                <x-icon name="eye" style="duotone" class="w-5 h-5" />
                Ver no Painel Padrão
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <div class="flex items-center">
            <x-icon name="circle-check" style="duotone" class="w-4 h-4 me-3" />
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Estatísticas do Poço -->
    @if(isset($estatisticasPoco))
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 md:gap-6 mb-8">
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Demandas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticasPoco['total_demandas'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-100 dark:border-indigo-800/50">
                    <x-icon name="clipboard-list" style="duotone" class="w-6 h-6 text-indigo-600 dark:text-indigo-400" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Demandas Abertas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticasPoco['demandas_abertas'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800/50">
                    <x-icon name="clock" style="duotone" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ordens de Serviço</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticasPoco['total_ordens'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-100 dark:border-amber-800/50">
                    <x-icon name="toolbox" style="duotone" class="w-6 h-6 text-amber-600 dark:text-amber-400" />
                </div>
            </div>
        </div>
        <div class="p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-slate-800 dark:border-slate-700 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Ordens Concluídas</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mt-1">{{ $estatisticasPoco['ordens_concluidas'] ?? 0 }}</p>
                </div>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800/50">
                    <x-icon name="circle-check" style="duotone" class="w-6 h-6 text-emerald-600 dark:text-emerald-400" />
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Informações do Poço -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-slate-700/50 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <x-icon name="circle-info" style="duotone" class="w-4 h-4 text-blue-500" />
                        Ficha Técnica do Poço
                    </h3>
                    @php
                        $statusCores = [
                            'ativo' => 'bg-emerald-50 text-emerald-700 border-emerald-100 dark:bg-emerald-900/30 dark:text-emerald-400 dark:border-emerald-800/50',
                            'inativo' => 'bg-red-50 text-red-700 border-red-100 dark:bg-red-900/30 dark:text-red-400 dark:border-red-800/50',
                            'manutencao' => 'bg-amber-50 text-amber-700 border-amber-100 dark:bg-amber-900/30 dark:text-amber-400 dark:border-amber-800/50'
                        ];
                        $statusClass = $statusCores[$poco->status] ?? 'bg-slate-50 text-slate-700 border-slate-100';
                    @endphp
                    <span class="px-2.5 py-1 text-[10px] font-black uppercase rounded-lg border {{ $statusClass }}">
                        {{ $poco->status_texto ?? ucfirst($poco->status) }}
                    </span>
                </div>
                <div class="p-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Código Identificador</label>
                            <p class="text-base font-bold text-gray-900 dark:text-white bg-slate-50 dark:bg-slate-900 px-4 py-2 rounded-xl border border-dashed border-slate-200 dark:border-slate-700">
                                {{ $poco->codigo }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Localidade</label>
                            @if($poco->localidade)
                                <a href="{{ route('admin.localidades.show', $poco->localidade->id) }}" class="flex items-center gap-2 text-base font-bold text-blue-600 hover:text-blue-700 dark:text-blue-400 group">
                                    <x-icon name="map-location-dot" class="w-4 h-4 group-hover:scale-110 transition-transform" />
                                    {{ $poco->localidade->nome }}
                                </a>
                            @else
                                <p class="text-base font-medium text-gray-400">-</p>
                            @endif
                        </div>

                        <div class="md:col-span-2 space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Endereço de Localização</label>
                            <div class="flex items-start gap-3">
                                <x-icon name="location-dot" style="duotone" class="w-5 h-5 text-slate-300 mt-0.5" />
                                <p class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed font-medium">{{ $poco->endereco ?? 'Não informado' }}</p>
                            </div>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Equipe Responsável</label>
                            @if($poco->equipeResponsavel)
                                <a href="{{ route('admin.equipes.show', $poco->equipeResponsavel->id) }}" class="flex items-center gap-2 text-sm font-bold text-emerald-600 hover:text-emerald-700 dark:text-emerald-400">
                                    <x-icon name="users-gear" class="w-4 h-4" />
                                    {{ $poco->equipeResponsavel->nome }}
                                </a>
                            @else
                                <p class="text-sm font-medium text-gray-400">Nenhuma equipe definida</p>
                            @endif
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Tipo de Bomba</label>
                            <p class="text-sm font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-icon name="gears" class="w-4 h-4 text-slate-400" />
                                {{ ucfirst($poco->tipo_bomba ?? 'Não especificado') }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Profundidade do Poço</label>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">
                                {{ $poco->profundidade_metros ? number_format($poco->profundidade_metros, 2, ',', '.') . ' metros' : 'Não informado' }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Vazão Estimada</label>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">
                                {{ $poco->vazao_litros_hora ? number_format($poco->vazao_litros_hora, 2, ',', '.') . ' L/h' : 'Não informado' }}
                            </p>
                        </div>

                        <div class="space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Cronograma de Manutenção</label>
                            <div class="flex flex-col gap-2 mt-2">
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <x-icon name="calendar-check" class="w-3.5 h-3.5" />
                                    Última: <span class="font-bold text-slate-700 dark:text-slate-300">{{ $poco->ultima_manutencao ? $poco->ultima_manutencao->format('d/m/Y') : '-' }}</span>
                                </div>
                                <div class="flex items-center gap-2 text-xs text-slate-500">
                                    <x-icon name="calendar-clock" class="w-3.5 h-3.5" />
                                    Próxima:
                                    <span class="font-bold {{ isset($poco) && $poco->proxima_manutencao && $poco->proxima_manutencao->isPast() ? 'text-red-500 animate-pulse' : 'text-slate-700 dark:text-slate-300' }}">
                                        {{ $poco->proxima_manutencao ? $poco->proxima_manutencao->format('d/m/Y') : '-' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        @if($poco->observacoes)
                        <div class="md:col-span-2 space-y-1">
                            <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Observações Técnicas e Histórico</label>
                            <div class="p-4 bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 rounded-2xl text-sm text-gray-600 dark:text-gray-400 whitespace-pre-wrap leading-relaxed">
                                {{ $poco->observacoes }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Demandas Relacionadas -->
            @if(isset($demandasRelacionadas) && $demandasRelacionadas->count() > 0)
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-slate-700/50 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <x-icon name="bell" style="duotone" class="w-4 h-4 text-orange-500" />
                        Demandas Relacionadas (Poço)
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-slate-400 uppercase bg-slate-50/30 dark:bg-slate-900/30">
                            <tr>
                                <th class="px-6 py-4 font-bold tracking-widest">Código</th>
                                <th class="px-6 py-4 font-bold tracking-widest">Solicitante</th>
                                <th class="px-6 py-4 font-bold tracking-widest">Prioridade</th>
                                <th class="px-6 py-4 font-bold tracking-widest">Status</th>
                                <th class="px-6 py-4 font-bold tracking-widest text-right">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            @foreach($demandasRelacionadas as $demanda)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900 dark:text-white">{{ $demanda->codigo ?? '-' }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400 font-medium">{{ $demanda->solicitante_nome }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg border {{ $demanda->prioridade_cor_class ?? '' }}">
                                        {{ $demanda->prioridade_texto ?? ucfirst($demanda->prioridade) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2.5 py-1 text-[10px] font-bold rounded-lg border {{ $demanda->status_cor_class ?? '' }}">
                                        {{ $demanda->status_texto ?? ucfirst($demanda->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.demandas.show', $demanda->id) }}" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg hover:bg-blue-100 transition-all">
                                        <x-icon name="eye" style="duotone" class="w-4 h-4" />
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <!-- Ordens de Serviço -->
            @if(isset($ordensRelacionadas) && $ordensRelacionadas->count() > 0)
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-200 dark:border-slate-700/50 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-200 dark:border-slate-700/50 bg-gray-50/50 dark:bg-slate-900/50 flex items-center justify-between">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                        <x-icon name="toolbox" style="duotone" class="w-4 h-4 text-amber-500" />
                        Ordens de Serviço Relacionadas
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-slate-400 uppercase bg-slate-50/30 dark:bg-slate-900/30">
                            <tr>
                                <th class="px-6 py-4 font-bold tracking-widest">Número</th>
                                <th class="px-6 py-4 font-bold tracking-widest">Tipo</th>
                                <th class="px-6 py-4 font-bold tracking-widest">Equipe</th>
                                <th class="px-6 py-4 font-bold tracking-widest text-right">Ação</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700/50">
                            @foreach($ordensRelacionadas as $ordem)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors group">
                                <td class="px-6 py-4 whitespace-nowrap font-bold text-gray-900 dark:text-white">{{ $ordem->numero }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-gray-600 dark:text-gray-400">{{ $ordem->tipo_servico }}</td>
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-blue-600 dark:text-blue-400">
                                    {{ $ordem->equipe->nome ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.ordens.show', $ordem->id) }}" class="inline-flex items-center justify-center w-8 h-8 text-blue-600 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800 rounded-lg hover:bg-blue-100 transition-all">
                                        <x-icon name="eye" style="duotone" class="w-4 h-4" />
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar / Technical Meta -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-200 dark:border-slate-700/50">
                <h4 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 border-b border-slate-100 dark:border-slate-700/50 pb-4">Indicadores Técnicos</h4>
                <div class="space-y-6">
                    <div class="flex gap-4">
                        <div class="w-10 h-10 shrink-0 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center text-blue-600">
                            <x-icon name="water" style="duotone" class="w-5 h-5" />
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900 dark:text-white mb-1">Capacidade de Vazão</p>
                            <p class="text-[11px] text-slate-500 leading-relaxed font-bold">{{ $poco->vazao_litros_hora ? number_format($poco->vazao_litros_hora, 0, ',', '.') . ' L/h' : 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-10 h-10 shrink-0 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600">
                            <x-icon name="bore-hole" style="duotone" class="w-5 h-5" />
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900 dark:text-white mb-1">Tipo de Captação</p>
                            <p class="text-[11px] text-slate-500 leading-relaxed uppercase">{{ $poco->tipo_bomba ?? 'SUBMERSA' }}</p>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <div class="w-10 h-10 shrink-0 rounded-xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600">
                            <x-icon name="shield-heart" style="duotone" class="w-5 h-5" />
                        </div>
                        <div>
                            <p class="text-xs font-bold text-gray-900 dark:text-white mb-1">Saúde do Ativo</p>
                            <p class="text-[11px] text-slate-500 leading-relaxed">
                                @if($poco->status == 'ativo')
                                    Operacionalidade normal garantida pela equipe {{ $poco->equipeResponsavel->nome ?? 'técnica' }}.
                                @else
                                    Intervenção técnica necessária para reestabelecimento da operação.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-blue-900 rounded-3xl p-8 text-white relative overflow-hidden group">
                <div class="absolute -right-4 -top-4 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10 space-y-4">
                    <div class="w-12 h-12 rounded-2xl bg-blue-500 flex items-center justify-center shadow-lg shadow-blue-500/20">
                        <x-icon name="droplet-degree" style="duotone" class="w-6 h-6 text-white" />
                    </div>
                    <div>
                        <h4 class="text-lg font-bold mb-2">Monitoramento</h4>
                        <p class="text-xs text-blue-200 leading-relaxed">O monitoramento contínuo das vazões e manutenções preventivas evita paradas críticas no abastecimento das comunidades.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
