@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes da Demanda')

@section('content')
<div class="space-y-8">
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
                            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-full">Detalhes</span>
                            <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Protocolo: {{ $demanda->codigo ?? '#' . $demanda->id }}</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">
                            Visualizar <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-blue-400">Demanda</span>
                        </h1>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <x-demandas::button href="{{ route('demandas.print', $demanda) }}" target="_blank" variant="secondary" size="lg" class="shadow-xl">
                        <x-icon name="print" class="w-5 h-5 mr-2" />
                        Imprimir
                    </x-demandas::button>
                    <x-demandas::button href="{{ route('demandas.edit', $demanda) }}" variant="primary" size="lg" class="shadow-xl bg-indigo-600 hover:bg-indigo-700 border-b-4 border-indigo-800 active:border-b-0 active:translate-y-1">
                        <x-icon name="pencil" class="w-5 h-5 mr-2" />
                        Editar Registro
                    </x-demandas::button>
                    <x-demandas::button href="{{ route('demandas.index') }}" variant="secondary" size="lg" class="shadow-xl">
                        <x-icon name="arrow-left" class="w-5 h-5 mr-2" />
                        Voltar
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
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </x-demandas::alert>
    @endif

    @if(session('error'))
        <x-demandas::alert type="danger" dismissible>
            <div class="flex items-center gap-2">
                <x-icon name="circle-xmark" class="w-5 h-5" />
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </x-demandas::alert>
    @endif

    <!-- Tabs Navigation -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl p-1 shadow-sm border border-slate-200 dark:border-slate-700/50 mb-8 inline-flex w-full sm:w-auto">
        <nav class="flex flex-wrap gap-1 w-full sm:w-auto" aria-label="Tabs">
            <button data-tab-target="detalhes" class="flex-1 sm:flex-none px-6 py-3 text-sm font-black uppercase tracking-wider rounded-2xl transition-all duration-300 bg-indigo-600 text-white shadow-lg active-tab">
                <x-icon name="circle-info" class="w-4 h-4 inline mr-2" />
                Detalhes
            </button>
            <button data-tab-target="relacionamentos" class="flex-1 sm:flex-none px-6 py-3 text-sm font-bold uppercase tracking-wider rounded-2xl transition-all duration-300 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700">
                <x-icon name="link" class="w-4 h-4 inline mr-2" />
                Relacionamentos
            </button>
            @if(method_exists($demanda, 'getHistory'))
            <button data-tab-target="historico" class="flex-1 sm:flex-none px-6 py-3 text-sm font-bold uppercase tracking-wider rounded-2xl transition-all duration-300 text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-700">
                <x-icon name="clock" class="w-4 h-4 inline mr-2" />
                Histórico
            </button>
			@endif
        </nav>
    </div>

    <!-- Tabs Content -->
    <div>
        <!-- Tab Detalhes -->
        <div data-tab-panel="detalhes" class="hidden">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Informações Principais -->
                <div class="lg:col-span-2 space-y-6">
                    <x-demandas::card class="mb-6 overflow-hidden">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-500/10 rounded-xl">
                                    <x-icon name="circle-info" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                                </div>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider">
                                    Conteúdo da Demanda
                                </h3>
                            </div>
                        </x-slot>

                        <div class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código</label>
                                    <div class="text-xl font-semibold text-indigo-600 dark:text-indigo-400">{{ $demanda->codigo ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                    <div>
                                        @php
                                            $statusVariants = ['aberta' => 'info', 'em_andamento' => 'warning', 'concluida' => 'success', 'cancelada' => 'danger'];
                                            $statusVariant = $statusVariants[$demanda->status] ?? 'default';
                                        @endphp
                                        <x-demandas::badge :variant="$statusVariant">
                                            {{ $demanda->status_texto }}
                                        </x-demandas::badge>
                                    </div>
                                </div>
                            </div>

                            <hr class="border-gray-200 dark:border-gray-700">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Solicitante</label>
                                    <div class="text-gray-900 dark:text-white">
                                        <div class="font-semibold">
                                            {{ $demanda->solicitante_nome }}
                                            @if($demanda->solicitante_apelido)
                                                <span class="text-indigo-600 dark:text-indigo-400 font-normal text-sm">({{ $demanda->solicitante_apelido }})</span>
                                            @endif
                                        </div>
                                        @if($demanda->solicitante_telefone)
                                            <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-1 mt-1">
                                                <x-icon name="phone" class="w-4 h-4" />
                                                {{ $demanda->solicitante_telefone }}
                                            </div>
                                        @endif
                                        @if($demanda->solicitante_email)
                                            <div class="text-sm text-gray-600 dark:text-gray-400 flex items-center gap-1 mt-1">
                                                <x-icon name="envelope" class="w-4 h-4" />
                                                {{ $demanda->solicitante_email }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Localidade</label>
                                    <div>
                                        @if($demanda->localidade)
                                            <a href="{{ route('localidades.show', $demanda->localidade->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 flex items-center gap-1">
                                                <x-icon name="location-dot" class="w-4 h-4" />
                                                <span class="font-semibold">{{ $demanda->localidade->nome }}</span>
                                                @if($demanda->localidade->codigo)
                                                    <span class="text-gray-500 dark:text-gray-400">({{ $demanda->localidade->codigo }})</span>
                                                @endif
                                            </a>
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr class="border-gray-200 dark:border-gray-700">

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                                    <div class="flex items-center gap-2">
                                        @php
                                            $tipoModules = [
                                                'agua' => 'Agua',
                                                'luz' => 'Iluminacao',
                                                'estrada' => 'Estradas',
                                                'poco' => 'Pocos'
                                            ];
                                            $tipoModule = $tipoModules[$demanda->tipo] ?? 'Demandas';
                                        @endphp
                                        <x-icon module="{{ $tipoModule }}" class="w-5 h-5 text-gray-600 dark:text-gray-400" />
                                        <span class="font-semibold text-gray-900 dark:text-white">{{ $demanda->tipo_texto }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Prioridade</label>
                                    <div>
                                        @php
                                            $prioridadeVariants = ['baixa' => 'secondary', 'media' => 'info', 'alta' => 'warning', 'urgente' => 'danger'];
                                            $prioridadeVariant = $prioridadeVariants[$demanda->prioridade] ?? 'default';
                                        @endphp
                                        <x-demandas::badge :variant="$prioridadeVariant">
                                            {{ $demanda->prioridade_texto }}
                                        </x-demandas::badge>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado por</label>
                                    <div class="flex items-center gap-1 text-gray-900 dark:text-white">
                                        @if($demanda->usuario)
                                            <x-icon name="user" class="w-4 h-4" />
                                            {{ $demanda->usuario->name }}
                                        @else
                                            <span class="text-gray-500 dark:text-gray-400">N/A</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr class="border-gray-200 dark:border-gray-700">

                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Motivo</label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <strong class="text-gray-900 dark:text-white">{{ $demanda->motivo }}</strong>
                                </div>
                            </div>

                            @if($demanda->descricao)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Descrição</label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white whitespace-pre-wrap">{{ $demanda->descricao }}</div>
                            </div>
                            @endif

                            @if($demanda->observacoes)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Observações</label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700 text-gray-900 dark:text-white whitespace-pre-wrap">{{ $demanda->observacoes }}</div>
                            </div>
                            @endif

                            @if($demanda->ordemServico && $demanda->ordemServico->materiais && $demanda->ordemServico->materiais->count() > 0)
                            <hr class="border-gray-200 dark:border-gray-700">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Materiais Relacionados (OS #{{ $demanda->ordemServico->numero }})</label>
                                <div class="space-y-2">
                                    @foreach($demanda->ordemServico->materiais as $ordemMaterial)
                                        <div class="p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                            <div class="flex items-center justify-between">
                                                <div class="flex-1">
                                                    <p class="font-medium text-gray-900 dark:text-white">{{ $ordemMaterial->material->nome ?? 'N/A' }}</p>
                                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                                        Quantidade: {{ formatar_quantidade($ordemMaterial->quantidade, $ordemMaterial->material->unidade_medida ?? null) }} {{ $ordemMaterial->material->unidade_medida ?? '' }}
                                                        @php
                                                            $isConcluida = $demanda->status === 'concluida' || ($demanda->ordemServico && $demanda->ordemServico->status === 'concluida');
                                                            $statusReserva = $ordemMaterial->status_reserva;
                                                        @endphp
                                                        @if($isConcluida)
                                                            <x-demandas::badge variant="secondary" class="ml-2">Utilizado</x-demandas::badge>
                                                        @elseif($statusReserva === 'reservado')
                                                            <x-demandas::badge variant="info" class="ml-2">Reservado</x-demandas::badge>
                                                        @elseif($statusReserva === 'confirmado')
                                                            <x-demandas::badge variant="success" class="ml-2">Confirmado</x-demandas::badge>
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <hr class="border-gray-200 dark:border-gray-700">

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Abertura</label>
                                    <div class="flex items-center gap-1 text-gray-900 dark:text-white">
                                        <x-icon name="calendar" class="w-4 h-4" />
                                        @if($demanda->data_abertura)
                                            {{ is_string($demanda->data_abertura) ? \Carbon\Carbon::parse($demanda->data_abertura)->format('d/m/Y H:i') : $demanda->data_abertura->format('d/m/Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                                @if($demanda->data_conclusao)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Conclusão</label>
                                    <div class="flex items-center gap-1 text-emerald-600 dark:text-emerald-400">
                                        <x-icon name="circle-check" class="w-4 h-4" />
                                        @if($demanda->data_conclusao)
                                            {{ is_string($demanda->data_conclusao) ? \Carbon\Carbon::parse($demanda->data_conclusao)->format('d/m/Y H:i') : $demanda->data_conclusao->format('d/m/Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </x-demandas::card>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Card de Estatísticas -->
                    @if(isset($estatisticas))
                    <x-demandas::card class="mb-6 overflow-hidden">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-500/10 rounded-xl">
                                    <x-icon name="chart-simple" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                                </div>
                                <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider">
                                    Indicadores
                                </h3>
                            </div>
                        </x-slot>
                        <div class="space-y-4">
                            @if($estatisticas['dias_aberta'] !== null)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Dias Aberta</label>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ $estatisticas['dias_aberta'] }} dias</div>
                            </div>
                            @endif
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tem OS</label>
                                <div>
                                    @if($estatisticas['tem_os'])
                                        <x-demandas::badge variant="success">
                                            <x-icon name="circle-check" class="w-3 h-3 mr-1" />
                                            Sim
                                        </x-demandas::badge>
                                    @else
                                        <x-demandas::badge variant="secondary">
                                            <x-icon name="circle-xmark" class="w-3 h-3 mr-1" />
                                            Não
                                        </x-demandas::badge>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </x-demandas::card>
                    @endif

                    <!-- Card de Ações Rápidas -->
                    <x-demandas::card class="rounded-xl shadow-lg">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                    <x-icon name="bolt" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Ações Rápidas
                                </h3>
                            </div>
                        </x-slot>
                        <div class="space-y-3">
                            <x-demandas::button href="{{ route('demandas.print', $demanda) }}" target="_blank" variant="primary" class="w-full">
                                <x-icon name="print" class="w-4 h-4 mr-2" />
                                Imprimir Demanda
                            </x-demandas::button>
                            @if(isset($estatisticas) && $estatisticas['pode_criar_os'] && Route::has('ordens.create'))
                                <x-demandas::button href="{{ route('ordens.create', ['demanda_id' => $demanda->id]) }}" variant="primary" class="w-full">
                                    <x-icon name="file-circle-plus" class="w-4 h-4 mr-2" />
                                    Criar OS
                                </x-demandas::button>
                            @elseif($demanda->ordemServico)
                                <x-demandas::button href="{{ route('ordens.show', $demanda->ordemServico->id) }}" variant="primary" class="w-full">
                                    <x-icon name="file-lines" class="w-4 h-4 mr-2" />
                                    Ver OS
                                </x-demandas::button>
                            @endif
                            <x-demandas::button href="{{ route('demandas.edit', $demanda) }}" variant="primary" class="w-full">
                                <x-icon name="pencil" class="w-4 h-4 mr-2" />
                                Editar Demanda
                            </x-demandas::button>
                            @if($demanda->solicitante_email && filter_var($demanda->solicitante_email, FILTER_VALIDATE_EMAIL))
                            <form action="{{ route('demandas.reenviar-email', $demanda) }}" method="POST" class="w-full" onsubmit="return confirm('Deseja realmente reenviar o email de confirmação para {$demanda->solicitante_email}?')">
                                @csrf
                                <x-demandas::button type="submit" variant="info" class="w-full">
                                    <x-icon name="envelope" class="w-4 h-4 mr-2" />
                                    Reenviar Email
                                    <span class="text-xs opacity-75 block">Para: {{ $demanda->solicitante_email }}</span>
                                </x-demandas::button>
                            </form>
                            @endif
                            @if(isset($estatisticas) && $estatisticas['pode_cancelar'])
                            <form action="{{ route('demandas.update', $demanda) }}" method="POST" onsubmit="return confirm('Deseja realmente cancelar esta demanda?')">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="cancelada">
                                <input type="hidden" name="solicitante_nome" value="{{ $demanda->solicitante_nome }}">
                                <input type="hidden" name="solicitante_apelido" value="{{ $demanda->solicitante_apelido }}">
                                <input type="hidden" name="localidade_id" value="{{ $demanda->localidade_id }}">
                                <input type="hidden" name="tipo" value="{{ $demanda->tipo }}">
                                <input type="hidden" name="prioridade" value="{{ $demanda->prioridade }}">
                                <input type="hidden" name="motivo" value="{{ $demanda->motivo }}">
                                <input type="hidden" name="descricao" value="{{ $demanda->descricao }}">
                                <input type="hidden" name="observacoes" value="{{ $demanda->observacoes }}">
                                <x-demandas::button type="submit" variant="warning" class="w-full">
                                    <x-icon name="circle-xmark" class="w-4 h-4 mr-2" />
                                    Cancelar
                                </x-demandas::button>
                            </form>
                            @endif
                            <form action="{{ route('demandas.destroy', $demanda) }}" method="POST" onsubmit="return confirm('Deseja realmente deletar esta demanda?')">
                                @csrf
                                @method('DELETE')
                                <x-demandas::button type="submit" variant="danger" class="w-full">
                                    <x-icon name="trash" class="w-4 h-4 mr-2" />
                                    Deletar
                                </x-demandas::button>
                            </form>
                        </div>
                    </x-demandas::card>

                    <!-- Card de Informações Adicionais -->
                    <x-demandas::card class="rounded-xl shadow-lg">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                    <x-icon name="circle-info" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Informações
                                </h3>
                            </div>
                        </x-slot>
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">ID</label>
                                <div class="text-sm text-gray-900 dark:text-white">#{{ $demanda->id }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">
                                    @if($demanda->created_at)
                                        {{ is_string($demanda->created_at) ? \Carbon\Carbon::parse($demanda->created_at)->format('d/m/Y H:i') : $demanda->created_at->format('d/m/Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            @if($demanda->updated_at)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Atualizado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">
                                    @if($demanda->updated_at)
                                        {{ is_string($demanda->updated_at) ? \Carbon\Carbon::parse($demanda->updated_at)->format('d/m/Y H:i') : $demanda->updated_at->format('d/m/Y H:i') }}
                                    @else
                                        -
                                    @endif
                                </div>
                            </div>
                            @endif
                        </div>
                    </x-demandas::card>
                </div>
            </div>
        </div>

        <!-- Tab Relacionamentos -->
        <div data-tab-panel="relacionamentos" class="hidden">
            <div class="space-y-6">
                {{-- Card de Interessados/Pessoas Afetadas --}}
                <x-demandas::card class="rounded-xl shadow-lg border-2 border-emerald-200 dark:border-emerald-800">
                    <x-slot name="header">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                                    <x-icon name="eye" class="w-5 h-5" />
                                Ver Todos
                            </a>
                        </div>
                    </x-slot>
                    <div>
                        @if($demanda->interessados && $demanda->interessados->count() > 0)
                            <div class="space-y-3">
                                @foreach($demanda->interessados->take(5) as $interessado)
                                    <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-900/50 rounded-lg">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold">
                                            {{ strtoupper(substr($interessado->nome, 0, 1)) }}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="font-medium text-gray-900 dark:text-white truncate">
                                                {{ $interessado->nome }}
                                                @if($interessado->apelido)
                                                    <span class="text-gray-500 dark:text-gray-400">({{ $interessado->apelido }})</span>
                                                @endif
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 flex items-center gap-2">
                                                @if($interessado->metodo_vinculo === 'solicitante_original')
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded text-xs font-medium bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300">
                                                        Solicitante Original
                                                    </span>
                                                @endif
                                                <span>{{ $interessado->data_vinculo?->format('d/m/Y') }}</span>
                                            </div>
                                        </div>
                                        @if($interessado->notificar)
                                            <span class="text-emerald-500" title="Receberá notificações">
                                                <x-icon name="bell" class="w-5 h-5" />
                                            </span>
                                        @endif
                                    </div>
                                @endforeach

                                @if($demanda->interessados->count() > 5)
                                    <div class="text-center pt-2">
                                        <a href="{{ route('demandas.interessados', $demanda->id) }}" class="text-sm text-emerald-600 dark:text-emerald-400 hover:underline">
                                            Ver mais {{ $demanda->interessados->count() - 5 }} pessoa(s)...
                                        </a>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-6">
                                <x-icon name="users-slash" class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-3" />
                                <p class="text-gray-500 dark:text-gray-400">Nenhum interessado vinculado ainda</p>
                            </div>
                        @endif
                    </div>
                </x-demandas::card>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-demandas::card class="rounded-xl shadow-lg">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                    <x-icon name="file-lines" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Ordem de Serviço
                                </h3>
                            </div>
                        </x-slot>
                        <div>
                            @if($demanda->ordemServico)
                                <div class="space-y-3">
                                    <a href="{{ route('ordens.show', $demanda->ordemServico->id) }}" class="block p-3 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        <div class="font-semibold text-indigo-600 dark:text-indigo-400">{{ $demanda->ordemServico->numero }}</div>
                                    </a>
                                </div>
                            @else
                                <p class="text-gray-500 dark:text-gray-400">Nenhuma ordem de serviço vinculada</p>
                            @endif
                        </div>
                    </x-demandas::card>
                    <x-demandas::card class="rounded-xl shadow-lg">
                        <x-slot name="header">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                    <x-icon name="location-dot" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Localidade
                                </h3>
                            </div>
                        </x-slot>
                        <div class="space-y-4">
                            @if($demanda->localidade)
                                <div>
                                    <div class="font-semibold text-gray-900 dark:text-white mb-2">{{ $demanda->localidade->nome }}</div>
                                    @if($demanda->localidade->codigo)
                                        <x-demandas::badge variant="secondary">{{ $demanda->localidade->codigo }}</x-demandas::badge>
                                    @endif
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                                    <div class="text-sm text-gray-900 dark:text-white">{{ ucfirst($demanda->localidade->tipo ?? 'N/A') }}</div>
                                </div>
                                @if($demanda->localidade->cidade)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Cidade</label>
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $demanda->localidade->cidade }}, {{ $demanda->localidade->estado ?? '' }}</div>
                                </div>
                                @endif
                                <x-demandas::button href="{{ route('localidades.show', $demanda->localidade->id) }}" variant="outline" class="w-full">
                                    Ver Localidade
                                    <x-icon name="arrow-right" class="w-4 h-4 ml-1" />
                                </x-demandas::button>
                            @else
                                <p class="text-gray-500 dark:text-gray-400">Nenhuma localidade vinculada</p>
                            @endif
                        </div>
                    </x-demandas::card>
                </div>
            </div>
        </div>

        <!-- Tab Histórico -->
        @if(method_exists($demanda, 'getHistory'))
        <div data-tab-panel="historico" class="hidden">
            @php
                $history = $demanda->getHistory();
            @endphp
            @if(isset($history) && count($history) > 0)
                <x-demandas::card class="rounded-xl shadow-lg">
                    <x-slot name="header">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-indigo-100 dark:bg-indigo-900/30 rounded-lg">
                                <x-icon name="clock" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                Histórico
                            </h3>
                        </div>
                    </x-slot>
                    <div class="space-y-4">
                        @foreach($history as $entry)
                            <div class="flex items-start gap-4 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0 last:pb-0">
                                <div class="flex-shrink-0">
                                    @php
                                        $actionIcons = [
                                            'created' => ['name' => 'circle-plus', 'color' => 'text-emerald-500'],
                                            'updated' => ['name' => 'pencil', 'color' => 'text-indigo-500'],
                                            'deleted' => ['name' => 'trash', 'color' => 'text-red-500'],
                                            'restored' => ['name' => 'rotate', 'color' => 'text-blue-500'],
                                        ];
                                        $actionLabels = [
                                            'created' => 'Criado',
                                            'updated' => 'Atualizado',
                                            'deleted' => 'Excluído',
                                            'restored' => 'Restaurado',
                                            'started' => 'Iniciado',
                                            'completed' => 'Concluído',
                                            'cancelled' => 'Cancelado',
                                            'status_changed' => 'Status Alterado',
                                        ];
                                        $icon = $actionIcons[$entry->action] ?? ['name' => 'circle-info', 'color' => 'text-gray-500'];
                                        $label = $actionLabels[$entry->action] ?? ucfirst(str_replace('_', ' ', $entry->action));
                                    @endphp
                                    <div class="p-2 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                        <x-icon :name="$icon['name']" class="w-5 h-5 {{ $icon['color'] }}" />
                                    </div>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-1">
                                        <strong class="text-gray-900 dark:text-white">{{ $label }}</strong>
                                        @if(isset($entry->created_at))
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ is_string($entry->created_at) ? \Carbon\Carbon::parse($entry->created_at)->format('d/m/Y H:i') : $entry->created_at->format('d/m/Y H:i') }}
                                            </span>
                                        @endif
                                    </div>
                                    @if(isset($entry->user_id) && $entry->user_id)
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Por: {{ $entry->user->name ?? 'Sistema' }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-demandas::card>
            @else
                <x-demandas::card class="rounded-xl shadow-lg">
                    <div class="p-12 text-center">
                        <div class="p-6 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 rounded-2xl mb-6 shadow-lg inline-block">
                            <x-icon name="clock" class="w-16 h-16 text-gray-400 dark:text-gray-500" />
                        </div>
                        <p class="text-gray-500 dark:text-gray-400">Nenhum histórico disponível</p>
                    </div>
                </x-demandas::card>
            @endif
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('[data-tab-target]');
    const tabPanels = document.querySelectorAll('[data-tab-panel]');

    function showTab(targetId) {
        tabPanels.forEach(panel => panel.classList.add('hidden'));
        tabButtons.forEach(button => {
            button.classList.remove('bg-indigo-600', 'text-white', 'shadow-lg', 'active-tab');
            button.classList.add('text-slate-500', 'hover:bg-slate-100', 'dark:hover:bg-slate-700');
        });

        const targetPanel = document.querySelector(`[data-tab-panel="${targetId}"]`);
        if (targetPanel) {
            targetPanel.classList.remove('hidden');
        }

        const targetButton = document.querySelector(`[data-tab-target="${targetId}"]`);
        if (targetButton) {
            targetButton.classList.remove('text-slate-500', 'hover:bg-slate-100', 'dark:hover:bg-slate-700');
            targetButton.classList.add('bg-indigo-600', 'text-white', 'shadow-lg', 'active-tab');
        }
    }

    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-tab-target');
            showTab(targetId);
        });
    });

    // Show default tab
    showTab('detalhes');
});
</script>
@endpush
@endsection
