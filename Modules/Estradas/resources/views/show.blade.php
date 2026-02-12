@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes do Trecho')

@section('content')
<div class="space-y-6">
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
                            <x-icon module="estradas" class="w-10 h-10 text-white" />
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <x-badge variant="info" class="bg-indigo-500/10 text-indigo-400 border-indigo-500/20">#{{ $trecho->codigo ?? 'PREM-' . $trecho->id }}</x-badge>
                            <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Infraestrutura</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">
                            {{ $trecho->nome }}
                        </h1>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <x-estradas::button href="{{ route('estradas.edit', $trecho) }}" variant="primary" size="lg" class="shadow-xl bg-indigo-600 hover:bg-indigo-700 border-b-4 border-indigo-800 active:border-b-0 active:translate-y-1 transition-all">
                        <x-icon name="pencil" class="w-5 h-5 mr-2" />
                        Editar Dados
                    </x-estradas::button>
                    <x-estradas::button href="{{ route('estradas.index') }}" variant="secondary" size="lg" class="shadow-xl">
                        <x-icon name="arrow-left" class="w-5 h-5 mr-2" />
                        Voltar
                    </x-estradas::button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-estradas::alert type="success" dismissible>
            {{ session('success') }}
        </x-estradas::alert>
    @endif

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button data-tab-target="detalhes" class="border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-estradas::icon name="circle-info" class="w-4 h-4 inline mr-2" />
                Detalhes
            </button>
            <button data-tab-target="relacionamentos" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <x-estradas::icon name="link" class="w-4 h-4 inline mr-2" />
                Relacionamentos
            </button>
        </nav>
    </div>

    <!-- Tabs Content -->
    <div>
        <!-- Tab Detalhes -->
        <div data-tab-panel="detalhes">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Informações Principais -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Card: Informações Básicas -->
                    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden mb-8">
                        <div class="p-8 border-b border-gray-100 dark:border-slate-700/50">
                            <div class="flex items-center gap-4 mb-1">
                                <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center border border-indigo-100 dark:border-indigo-800">
                                    <x-icon name="circle-info" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">Informações do Trecho</h3>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Dados principais de identificação</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código</label>
                                    <div class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">{{ $trecho->codigo ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Condição</label>
                                    <div>
                                        @php
                                            $condicaoColors = [
                                                'boa' => 'success',
                                                'regular' => 'info',
                                                'ruim' => 'warning',
                                                'pessima' => 'danger'
                                            ];
                                            $condicaoIcons = [
                                                'boa' => 'circle-check',
                                                'regular' => 'circle-info',
                                                'ruim' => 'triangle-exclamation',
                                                'pessima' => 'circle-xmark'
                                            ];
                                        @endphp
                                        <x-estradas::badge :variant="$condicaoColors[$trecho->condicao] ?? 'secondary'">
                                            <x-estradas::icon :name="$condicaoIcons[$trecho->condicao] ?? 'circle-question'" class="w-3 h-3 mr-1" />
                                            {{ ucfirst($trecho->condicao) }}
                                        </x-estradas::badge>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nome</label>
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $trecho->nome }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                                    <div>
                                        <x-estradas::badge variant="info">
                                            {{ ucfirst($trecho->tipo) }}
                                        </x-estradas::badge>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Localidade</label>
                                <div>
                                    @if($trecho->localidade)
                                        <a href="{{ route('localidades.show', $trecho->localidade->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline inline-flex items-center gap-1">
                                            <x-estradas::icon name="location-dot" class="w-4 h-4" />
                                            <strong>{{ $trecho->localidade->nome }}</strong>
                                            @if($trecho->localidade->codigo)
                                                <span class="text-gray-500">({{ $trecho->localidade->codigo }})</span>
                                            @endif
                                        </a>
                                    @else
                                        <span class="text-gray-400">N/A</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card: Características Físicas -->
                    @if($trecho->extensao_km || $trecho->largura_metros || $trecho->tipo_pavimento || $trecho->tem_ponte)
                    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden mb-8">
                        <div class="p-8 border-b border-gray-100 dark:border-slate-700/50">
                            <div class="flex items-center gap-4 mb-1">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center border border-blue-100 dark:border-blue-800">
                                    <x-icon name="ruler-combined" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">Características Físicas</h3>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Dimensões e especificações técnicas</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-8">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                @if($trecho->extensao_km)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Extensão</label>
                                    <div class="text-base font-semibold text-gray-900 dark:text-white flex items-center gap-1">
                                        <x-estradas::icon name="ruler" class="w-4 h-4" />
                                        {{ number_format($trecho->extensao_km, 2, ',', '.') }} km
                                    </div>
                                </div>
                                @endif
                                @if($trecho->largura_metros)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Largura</label>
                                    <div class="text-sm text-gray-900 dark:text-white">{{ number_format($trecho->largura_metros, 2, ',', '.') }} m</div>
                                </div>
                                @endif
                                @if($trecho->tipo_pavimento)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo de Pavimento</label>
                                    <div>
                                        <x-estradas::badge variant="secondary">
                                            {{ ucfirst($trecho->tipo_pavimento) }}
                                        </x-estradas::badge>
                                    </div>
                                </div>
                                @endif
                            </div>

                            @if($trecho->tem_ponte)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Pontes</label>
                                <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                    <x-estradas::icon name="bridge" class="w-4 h-4" />
                                    <strong>{{ $trecho->numero_pontes ?? 0 }} ponte(s)</strong>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Card: Manutenção e Observações -->
                    @if($trecho->ultima_manutencao || $trecho->proxima_manutencao || $trecho->observacoes)
                    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                        <div class="p-8 border-b border-gray-100 dark:border-slate-700/50">
                            <div class="flex items-center gap-4 mb-1">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center border border-amber-100 dark:border-amber-800">
                                    <x-icon name="screwdriver-wrench" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                                </div>
                                <div>
                                    <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">Manutenção e Notas</h3>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Registros e observações do trecho</p>
                                </div>
                            </div>
                        </div>

                        <div class="p-8">
                            @if($trecho->ultima_manutencao || $trecho->proxima_manutencao)
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @if($trecho->ultima_manutencao)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Última Manutenção</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <x-estradas::icon name="calendar" class="w-4 h-4" />
                                        {{ $trecho->ultima_manutencao->format('d/m/Y') }}
                                    </div>
                                </div>
                                @endif
                                @if($trecho->proxima_manutencao)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Próxima Manutenção</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <x-estradas::icon name="calendar-days" class="w-4 h-4" />
                                        {{ $trecho->proxima_manutencao->format('d/m/Y') }}
                                    </div>
                                </div>
                                @endif
                            </div>
                            @endif

                            @if($trecho->observacoes)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Observações</label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $trecho->observacoes }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Card: Estatísticas -->
                    @if(isset($estatisticas))
                    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100 dark:border-slate-700/50">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center border border-blue-100 dark:border-blue-800">
                                    <x-icon name="chart-column" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                                </div>
                                <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight text-sm">Resumo Geral</h3>
                            </div>
                        </div>

                        <div class="p-6 space-y-4">
                            <div class="grid grid-cols-2 gap-3">
                                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-200 dark:border-blue-800">
                                    <div class="text-2xl font-black text-blue-900 dark:text-blue-200">{{ $estatisticas['total_demandas'] ?? 0 }}</div>
                                    <div class="text-[10px] font-bold text-blue-700 dark:text-blue-300 uppercase tracking-widest">Demandas</div>
                                </div>
                                <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl border border-indigo-200 dark:border-indigo-800">
                                    <div class="text-2xl font-black text-indigo-900 dark:text-indigo-200">{{ $estatisticas['total_ordens'] ?? 0 }}</div>
                                    <div class="text-[10px] font-bold text-indigo-700 dark:text-indigo-300 uppercase tracking-widest">Ordens</div>
                                </div>
                            </div>
                            @if(isset($estatisticas['dias_sem_manutencao']) && $estatisticas['dias_sem_manutencao'] !== null)
                            <div class="pt-3 border-t border-gray-100 dark:border-slate-700/50">
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Dias sem Manutenção</label>
                                <div class="text-lg font-black text-slate-900 dark:text-white">{{ $estatisticas['dias_sem_manutencao'] }} dias</div>
                            </div>
                            @endif
                            @if(isset($estatisticas['precisa_manutencao']) && $estatisticas['precisa_manutencao'])
                            <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl border border-amber-200 dark:border-amber-800">
                                <div class="flex items-center gap-2">
                                    <x-icon name="triangle-exclamation" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                                    <span class="text-xs font-black text-amber-900 dark:text-amber-200 uppercase">Manutenção Necessária</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Card: Ações Rápidas -->
                    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100 dark:border-slate-700/50">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center border border-amber-100 dark:border-amber-800">
                                    <x-icon name="bolt" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                                </div>
                                <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight text-sm">Ações Rápidas</h3>
                            </div>
                        </div>

                        <div class="p-6 space-y-3">
                            <x-estradas::button href="{{ route('estradas.edit', $trecho) }}" variant="secondary" size="lg" class="w-full justify-start shadow-sm border border-slate-200 dark:border-slate-700">
                                <x-icon name="pencil" class="w-5 h-5 mr-3 text-indigo-500" />
                                Editar Trecho
                            </x-estradas::button>
                            @if(Route::has('demandas.create'))
                            <x-estradas::button href="{{ route('demandas.create', ['tipo' => 'estrada', 'localidade_id' => $trecho->localidade_id]) }}" variant="secondary" size="lg" class="w-full justify-start shadow-sm border border-slate-200 dark:border-slate-700">
                                <x-icon name="plus" class="w-5 h-5 mr-3 text-emerald-500" />
                                Criar Demanda
                            </x-estradas::button>
                            @endif
                            <form action="{{ route('estradas.destroy', $trecho) }}" method="POST" onsubmit="return confirm('Deseja realmente deletar este trecho?')" class="w-full pt-3 border-t border-slate-100 dark:border-slate-700/50">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="w-full flex items-center justify-center px-4 py-3 text-sm font-black text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-xl transition-all uppercase tracking-widest">
                                    <x-icon name="trash" class="w-4 h-4 mr-2" />
                                    Deletar Trecho
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Card: Informações -->
                    <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                        <div class="p-6 border-b border-gray-100 dark:border-slate-700/50">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-900/30 flex items-center justify-center border border-slate-100 dark:border-slate-800">
                                    <x-icon name="magnifying-glass" class="w-5 h-5 text-slate-600 dark:text-slate-400" />
                                </div>
                                <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight text-sm">Metadados</h3>
                            </div>
                        </div>

                        <div class="p-6 space-y-4">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Identificador</label>
                                <div class="text-base font-black text-slate-900 dark:text-white">#{{ $trecho->id }}</div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Criado em</label>
                                <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $trecho->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @if($trecho->updated_at)
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Última atualização</label>
                                <div class="text-sm font-bold text-slate-900 dark:text-white">{{ $trecho->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tab Relacionamentos -->
        <div data-tab-panel="relacionamentos" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Card: Localidade -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-slate-700/50">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center border border-indigo-100 dark:border-indigo-800">
                                <x-icon name="location-dot" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                            </div>
                            <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight text-sm">Localidade</h3>
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        @if($trecho->localidade)
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Nome Administrativo</label>
                                    <div class="text-lg font-black text-slate-900 dark:text-white">{{ $trecho->localidade->nome }}</div>
                                    @if($trecho->localidade->codigo)
                                        <span class="inline-flex items-center px-2 py-0.5 mt-1 rounded text-xs font-bold bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600">{{ $trecho->localidade->codigo }}</span>
                                    @endif
                                </div>
                                <div class="grid grid-cols-2 gap-4 pt-4 border-t border-slate-100 dark:border-slate-700/50">
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Tipo</label>
                                        <div class="font-bold text-slate-700 dark:text-slate-300">
                                            {{ ucfirst(str_replace('_', ' ', $trecho->localidade->tipo ?? 'N/A')) }}
                                        </div>
                                    </div>
                                    @if($trecho->localidade->cidade)
                                    <div>
                                        <label class="block text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest mb-1">Cidade/UF</label>
                                        <div class="font-bold text-slate-700 dark:text-slate-300">
                                            {{ $trecho->localidade->cidade }}{{ $trecho->localidade->estado ? ', '.$trecho->localidade->estado : '' }}
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            <x-estradas::button href="{{ route('localidades.show', $trecho->localidade->id) }}" variant="secondary" size="lg" class="w-full shadow-sm border border-slate-200 dark:border-slate-700">
                                Ver Detalhes da Localidade
                                <x-icon name="arrow-right" class="w-4 h-4 ml-2 text-indigo-500" />
                            </x-estradas::button>
                        @else
                            <div class="py-12 text-center">
                                <div class="w-16 h-16 rounded-full bg-slate-50 dark:bg-slate-900/50 flex items-center justify-center border border-dashed border-slate-200 dark:border-slate-700 mx-auto mb-4">
                                    <x-icon name="map-pin" class="w-8 h-8 text-slate-300 dark:text-slate-600" />
                                </div>
                                <p class="text-sm font-bold text-slate-400 uppercase tracking-widest">Nenhuma localidade vinculada</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Card: Demandas Relacionadas -->
                @if(isset($trecho->demandas) && $trecho->demandas->count() > 0)
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-slate-700/50">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 flex items-center justify-center border border-emerald-100 dark:border-emerald-800">
                                <x-icon name="file-lines" class="w-5 h-5 text-emerald-600 dark:text-emerald-400" />
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight text-sm">Demandas Ativas</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">{{ $trecho->demandas->count() }} solicitações encontradas</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-3">
                        @foreach($trecho->demandas->take(5) as $demanda)
                            <div class="group relative p-4 bg-slate-50 dark:bg-slate-900/30 rounded-2xl border border-slate-100 dark:border-slate-800 hover:border-indigo-200 dark:hover:border-indigo-800 transition-all duration-300">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="text-sm font-black text-slate-900 dark:text-white mb-1 tracking-tight">{{ $demanda->solicitante_nome }}</div>
                                        <div class="text-[11px] font-bold text-slate-500 dark:text-slate-400 leading-tight mb-3">{{ Str::limit($demanda->motivo, 80) }}</div>
                                        <div class="flex items-center gap-2">
                                            @php
                                                $statusVariant = $demanda->status === 'aberta' ? 'warning' : ($demanda->status === 'concluida' ? 'success' : 'info');
                                            @endphp
                                            <x-badge :variant="$statusVariant" class="text-[10px] uppercase font-black tracking-widest px-2 py-0.5">
                                                {{ $demanda->status }}
                                            </x-badge>
                                            @if(Route::has('demandas.show'))
                                            <a href="{{ route('demandas.show', $demanda->id) }}" class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                                                Detalhes
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-none mb-1">Data</div>
                                        <div class="text-xs font-bold text-slate-900 dark:text-slate-100 italic">{{ $demanda->created_at?->format('d/m/y') ?? '--/--/--' }}</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if($trecho->demandas->count() > 5)
                            <div class="pt-2 text-center">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    + {{ $trecho->demandas->count() - 5 }} outras demandas registradas
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Card: Ordens de Serviço Relacionadas -->
                @if(isset($trecho->ordensServico) && $trecho->ordensServico->count() > 0)
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-slate-700/50">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-orange-50 dark:bg-orange-900/30 flex items-center justify-center border border-orange-100 dark:border-orange-800">
                                <x-icon name="clipboard-check" class="w-5 h-5 text-orange-600 dark:text-orange-400" />
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight text-sm">Ordens de Serviço</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">{{ $trecho->ordensServico->count() }} execuções vinculadas</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 space-y-3">
                        @foreach($trecho->ordensServico->take(5) as $ordem)
                            <div class="group relative p-4 bg-slate-50 dark:bg-slate-900/30 rounded-2xl border border-slate-100 dark:border-slate-800 hover:border-orange-200 dark:hover:border-orange-800 transition-all duration-300">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex-1">
                                        <div class="text-sm font-black text-slate-900 dark:text-white mb-1 tracking-tight">{{ $ordem->numero }}</div>
                                        <div class="text-[11px] font-bold text-slate-500 dark:text-slate-400 leading-tight mb-3 italic">{{ $ordem->tipo_servico }}</div>
                                        <div class="flex items-center gap-2">
                                            @php
                                                $osStatusVariant = $ordem->status === 'concluida' ? 'success' : ($ordem->status === 'em_execucao' ? 'warning' : 'info');
                                            @endphp
                                            <x-badge :variant="$osStatusVariant" class="text-[10px] uppercase font-black tracking-widest px-2 py-0.5">
                                                {{ $ordem->status_texto ?? $ordem->status }}
                                            </x-badge>
                                            @if(Route::has('ordens.show'))
                                            <a href="{{ route('ordens.show', $ordem->id) }}" class="text-[10px] font-black text-indigo-600 dark:text-indigo-400 uppercase tracking-widest hover:text-indigo-700 dark:hover:text-indigo-300 transition-colors">
                                                Acessar OS
                                            </a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-none mb-1 text-[9px]">Prioridade</div>
                                        <div class="px-2 py-0.5 rounded text-[9px] font-black bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 uppercase tracking-tighter">Normal</div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if($trecho->ordensServico->count() > 5)
                            <div class="pt-2 text-center">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    + {{ $trecho->ordensServico->count() - 5 }} ordens registradas
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Card: Histórico de Manutenções -->
                @if(isset($trecho->historicoManutencoes) && $trecho->historicoManutencoes->count() > 0)
                <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-slate-700/50">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-900/30 flex items-center justify-center border border-slate-100 dark:border-slate-800">
                                <x-icon name="screwdriver-wrench" class="w-5 h-5 text-slate-600 dark:text-slate-400" />
                            </div>
                            <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight text-sm">Histórico de Manutenções</h3>
                        </div>
                    </div>

                    <div class="p-6 space-y-3">
                        @foreach($trecho->historicoManutencoes->take(5) as $manutencao)
                            <div class="p-4 bg-slate-50 dark:bg-slate-900/30 rounded-2xl border border-slate-100 dark:border-slate-800 flex items-center justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-2 h-2 rounded-full bg-indigo-500 shadow-[0_0_10px_rgba(99,102,241,0.5)]"></div>
                                    <div>
                                        <div class="text-sm font-black text-slate-900 dark:text-white tracking-tight leading-none mb-1">{{ $manutencao->tipo ?? 'Manutenção Geral' }}</div>
                                        <div class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest italic">Intervenção registrada</div>
                                    </div>
                                </div>
                                @if($manutencao->data)
                                    <div class="text-right">
                                        <div class="text-[10px] font-black text-slate-400 dark:text-slate-500 uppercase tracking-widest leading-none mb-1">Execução</div>
                                        <div class="text-xs font-bold text-slate-900 dark:text-slate-100 italic">{{ $manutencao->data->format('d/m/Y') }}</div>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('[data-tab-target]');
    const tabPanels = document.querySelectorAll('[data-tab-panel]');

    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            const targetTab = button.getAttribute('data-tab-target');

            // Remove active state from all buttons and panels
            tabButtons.forEach(btn => {
                btn.classList.remove('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
                btn.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            });
            tabPanels.forEach(panel => {
                panel.classList.add('hidden');
            });

            // Add active state to clicked button and corresponding panel
            button.classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            button.classList.add('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            document.querySelector(`[data-tab-panel="${targetTab}"]`).classList.remove('hidden');
        });
    });
});
</script>
@endpush
@endsection
