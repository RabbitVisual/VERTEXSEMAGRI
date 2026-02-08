@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes da OS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Ordens" class="w-6 h-6" />
                OS: <span class="text-indigo-600 dark:text-indigo-400">{{ $ordem->numero }}</span>
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Detalhes completos da ordem de serviço</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-ordens::button href="{{ route('ordens.print', $ordem) }}" target="_blank" variant="success">
                <x-ordens::icon name="printer" class="w-4 h-4 mr-2" />
                Imprimir
            </x-ordens::button>
            <x-ordens::button href="{{ route('ordens.edit', $ordem) }}" variant="primary">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                </svg>
                Editar
            </x-ordens::button>
            <x-ordens::button href="{{ route('ordens.index') }}" variant="outline">
                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Voltar
            </x-ordens::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-ordens::alert type="success" dismissible>
            {{ session('success') }}
        </x-ordens::alert>
    @endif

    <!-- Tabs Navigation -->
    <div class="border-b border-gray-200 dark:border-gray-700">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <button data-tab-target="detalhes" class="border-b-2 border-indigo-500 text-indigo-600 dark:text-indigo-400 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                Detalhes
            </button>
            <button data-tab-target="timeline" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                Timeline
            </button>
            <button data-tab-target="relacionamentos" class="border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-400 dark:hover:text-gray-300 whitespace-nowrap py-4 px-1 text-sm font-medium">
                <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.19 8.688a4.5 4.5 0 011.242 7.244l-4.5 4.5a4.5 4.5 0 01-6.364-6.364l1.757-1.757m13.35-.622l1.757-1.757a4.5 4.5 0 00-6.364-6.364l-4.5 4.5a4.5 4.5 0 001.242 7.244" />
                </svg>
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
                    <x-ordens::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                Informações da OS
                            </h3>
                        </x-slot>

                        <div class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Número</label>
                                    <div class="text-xl font-semibold text-indigo-600 dark:text-indigo-400">{{ $ordem->numero }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                    <div>
                                        @php
                                            $statusVariants = [
                                                'pendente' => 'warning',
                                                'em_execucao' => 'info',
                                                'concluida' => 'success',
                                                'cancelada' => 'danger'
                                            ];
                                            $statusVariant = $statusVariants[$ordem->status] ?? 'default';
                                        @endphp
                                        <x-ordens::badge :variant="$statusVariant" size="lg">
                                            {{ $ordem->status_texto }}
                                        </x-ordens::badge>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo de Serviço</label>
                                    <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $ordem->tipo_servico }}</div>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Prioridade</label>
                                    <div>
                                        @php
                                            $prioridadeVariants = [
                                                'baixa' => 'gray',
                                                'media' => 'info',
                                                'alta' => 'warning',
                                                'urgente' => 'danger'
                                            ];
                                            $prioridadeVariant = $prioridadeVariants[$ordem->prioridade] ?? 'default';
                                        @endphp
                                        <x-ordens::badge :variant="$prioridadeVariant" size="lg">
                                            {{ $ordem->prioridade_texto }}
                                        </x-ordens::badge>
                                    </div>
                                </div>
                            </div>

                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Descrição</label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $ordem->descricao }}</p>
                                </div>
                            </div>

                            @if($ordem->observacoes)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-2">Observações</label>
                                <div class="p-4 bg-gray-50 dark:bg-gray-900/50 rounded-lg border border-gray-200 dark:border-gray-700">
                                    <p class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $ordem->observacoes }}</p>
                                </div>
                            </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Abertura</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                                        </svg>
                                        {{ $ordem->data_abertura->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                @if($ordem->data_inicio)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Início</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <svg class="w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                        </svg>
                                        {{ $ordem->data_inicio->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                @endif
                                @if($ordem->data_conclusao)
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Conclusão</label>
                                    <div class="text-sm text-gray-900 dark:text-white flex items-center gap-1">
                                        <svg class="w-4 h-4 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        {{ $ordem->data_conclusao->format('d/m/Y H:i') }}
                                    </div>
                                </div>
                                @endif
                            </div>

                            @if($ordem->tempo_execucao)
                            <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tempo de Execução</label>
                                <div class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    {{ number_format($ordem->tempo_execucao / 60, 1) }} horas
                                </div>
                            </div>
                            @endif
                        </div>
                    </x-ordens::card>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1 space-y-6">
                    <!-- Estatísticas -->
                    @if(isset($estatisticas))
                    <x-ordens::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 013 19.875v-6.75zM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V8.625zM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 01-1.125-1.125V4.125z" />
                                </svg>
                                Estatísticas
                            </h3>
                        </x-slot>

                        <div class="space-y-3">
                            @if($estatisticas['tempo_decorrido'] !== null)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tempo Decorrido</label>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ number_format($estatisticas['tempo_decorrido'] / 60, 1) }} horas</div>
                            </div>
                            @endif
                            @if($ordem->tempo_execucao_formatado)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tempo de Execução</label>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $ordem->tempo_execucao_formatado }}</div>
                            </div>
                            @endif
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Pode Iniciar</label>
                                <div>
                                    @if($estatisticas['pode_iniciar'])
                                        <x-ordens::badge variant="success">Sim</x-ordens::badge>
                                    @else
                                        <x-ordens::badge variant="gray">Não</x-ordens::badge>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Pode Concluir</label>
                                <div>
                                    @if($estatisticas['pode_concluir'])
                                        <x-ordens::badge variant="success">Sim</x-ordens::badge>
                                    @else
                                        <x-ordens::badge variant="gray">Não</x-ordens::badge>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </x-ordens::card>
                    @endif

                    <!-- Ações Rápidas -->
                    <x-ordens::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                                </svg>
                                Ações Rápidas
                            </h3>
                        </x-slot>

                        <div class="space-y-3">
                            <x-ordens::button href="{{ route('ordens.print', $ordem) }}" target="_blank" variant="success" class="w-full">
                                <x-ordens::icon name="printer" class="w-4 h-4 mr-2" />
                                Imprimir OS
                            </x-ordens::button>

                            @if(isset($estatisticas))
                                @if($estatisticas['pode_iniciar'])
                                    <form action="{{ route('ordens.iniciar', $ordem) }}" method="POST" class="w-full">
                                        @csrf
                                        <x-ordens::button type="submit" variant="info" class="w-full">
                                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                                            </svg>
                                            Iniciar Execução
                                        </x-ordens::button>
                                    </form>
                                @endif
                                @if($estatisticas['pode_concluir'])
                                    <form action="{{ route('ordens.concluir', $ordem) }}" method="POST" class="w-full">
                                        @csrf
                                        <x-ordens::button type="submit" variant="success" class="w-full">
                                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            Concluir OS
                                        </x-ordens::button>
                                    </form>
                                @endif
                            @endif

                            <x-ordens::button href="{{ route('ordens.edit', $ordem) }}" variant="primary" class="w-full">
                                <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                                Editar OS
                            </x-ordens::button>

                            @if(isset($estatisticas) && $estatisticas['pode_cancelar'])
                            <form action="{{ route('ordens.update', $ordem) }}" method="POST" class="w-full" onsubmit="return confirm('Deseja realmente cancelar esta OS?')">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="cancelada">
                                <input type="hidden" name="demanda_id" value="{{ $ordem->demanda_id }}">
                                <input type="hidden" name="equipe_id" value="{{ $ordem->equipe_id }}">
                                <input type="hidden" name="tipo_servico" value="{{ $ordem->tipo_servico }}">
                                <input type="hidden" name="descricao" value="{{ $ordem->descricao }}">
                                <input type="hidden" name="prioridade" value="{{ $ordem->prioridade }}">
                                <x-ordens::button type="submit" variant="warning" class="w-full">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9.75 9.75l4.5 4.5m0-4.5l-4.5 4.5M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Cancelar
                                </x-ordens::button>
                            </form>
                            @endif

                            <form action="{{ route('ordens.destroy', $ordem) }}" method="POST" class="w-full" onsubmit="return confirm('Deseja realmente deletar esta OS?')">
                                @csrf
                                @method('DELETE')
                                <x-ordens::button type="submit" variant="danger" class="w-full">
                                    <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                    Deletar
                                </x-ordens::button>
                            </form>
                        </div>
                    </x-ordens::card>

                    <!-- Informações do Sistema -->
                    <x-ordens::card>
                        <x-slot name="header">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                                </svg>
                                Informações
                            </h3>
                        </x-slot>

                        <div class="space-y-3 text-sm">
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado por</label>
                                <div class="text-sm text-gray-900 dark:text-white">
                                    @if($ordem->usuarioAbertura)
                                        <div class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                                            </svg>
                                            {{ $ordem->usuarioAbertura->name }}
                                        </div>
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500">N/A</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $ordem->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @if($ordem->updated_at)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Atualizado em</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $ordem->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                            @endif
                        </div>
                    </x-ordens::card>
                </div>
            </div>
        </div>

        <!-- Tab Timeline -->
        <div data-tab-panel="timeline" class="hidden">
            <x-ordens::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Timeline de Progresso
                    </h3>
                </x-slot>

                <div class="relative pl-8">
                    <!-- OS Criada -->
                    <div class="relative pb-8">
                        <div class="absolute left-0 top-0 w-6 h-6 rounded-full bg-indigo-500 flex items-center justify-center z-10">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-10">
                            <h4 class="text-base font-semibold text-gray-900 dark:text-white">OS Criada</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                {{ $ordem->data_abertura->format('d/m/Y H:i') }}
                            </p>
                            @if($ordem->usuarioAbertura)
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Por: {{ $ordem->usuarioAbertura->name }}</p>
                            @endif
                        </div>
                        @if($ordem->data_inicio || $ordem->data_conclusao)
                            <div class="absolute left-3 top-6 w-0.5 h-full bg-indigo-500"></div>
                        @else
                            <div class="absolute left-3 top-6 w-0.5 h-full bg-gray-300 dark:bg-gray-600"></div>
                        @endif
                    </div>

                    <!-- Execução Iniciada -->
                    @if($ordem->data_inicio)
                    <div class="relative pb-8">
                        <div class="absolute left-0 top-0 w-6 h-6 rounded-full bg-blue-500 flex items-center justify-center z-10">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                            </svg>
                        </div>
                        <div class="ml-10">
                            <h4 class="text-base font-semibold text-gray-900 dark:text-white">Execução Iniciada</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                {{ $ordem->data_inicio->format('d/m/Y H:i') }}
                            </p>
                            @if($ordem->usuarioExecucao)
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Por: {{ $ordem->usuarioExecucao->name }}</p>
                            @endif
                        </div>
                        @if($ordem->data_conclusao)
                            <div class="absolute left-3 top-6 w-0.5 h-full bg-blue-500"></div>
                        @else
                            <div class="absolute left-3 top-6 w-0.5 h-full bg-gray-300 dark:bg-gray-600"></div>
                        @endif
                    </div>
                    @else
                    <div class="relative pb-8">
                        <div class="absolute left-0 top-0 w-6 h-6 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center z-10">
                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5.25 5.653c0-.856.917-1.398 1.667-.986l11.54 6.348a1.125 1.125 0 010 1.971l-11.54 6.347a1.125 1.125 0 01-1.667-.985V5.653z" />
                            </svg>
                        </div>
                        <div class="ml-10">
                            <h4 class="text-base font-semibold text-gray-500 dark:text-gray-400">Execução Iniciada</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Aguardando início</p>
                        </div>
                        <div class="absolute left-3 top-6 w-0.5 h-full bg-gray-300 dark:bg-gray-600"></div>
                    </div>
                    @endif

                    <!-- OS Concluída -->
                    @if($ordem->data_conclusao)
                    <div class="relative">
                        <div class="absolute left-0 top-0 w-6 h-6 rounded-full bg-emerald-500 flex items-center justify-center z-10">
                            <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-10">
                            <h4 class="text-base font-semibold text-gray-900 dark:text-white">OS Concluída</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                {{ $ordem->data_conclusao->format('d/m/Y H:i') }}
                            </p>
                            @if($ordem->tempo_execucao)
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Tempo: {{ number_format($ordem->tempo_execucao / 60, 1) }} horas</p>
                            @endif
                        </div>
                    </div>
                    @else
                    <div class="relative">
                        <div class="absolute left-0 top-0 w-6 h-6 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center z-10">
                            <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-10">
                            <h4 class="text-base font-semibold text-gray-500 dark:text-gray-400">OS Concluída</h4>
                            <p class="text-sm text-gray-500 dark:text-gray-500 mt-1">Aguardando conclusão</p>
                        </div>
                    </div>
                    @endif
                </div>
            </x-ordens::card>
        </div>

        <!-- Tab Relacionamentos -->
        <div data-tab-panel="relacionamentos" class="hidden">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Demanda -->
                <x-ordens::card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Demanda
                        </h3>
                    </x-slot>

                    <div class="space-y-3">
                        @if($ordem->demanda)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código</label>
                                <div class="text-base font-semibold text-indigo-600 dark:text-indigo-400">
                                    {{ $ordem->demanda->codigo ?? '#' . $ordem->demanda->id }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Solicitante</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ $ordem->demanda->solicitante_nome }}</div>
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status</label>
                                <div>
                                    @php
                                        $demandaStatusVariants = [
                                            'aberta' => 'info',
                                            'em_andamento' => 'warning',
                                            'concluida' => 'success',
                                            'cancelada' => 'danger'
                                        ];
                                        $demandaStatusVariant = $demandaStatusVariants[$ordem->demanda->status] ?? 'default';
                                    @endphp
                                    <x-ordens::badge :variant="$demandaStatusVariant">
                                        {{ $ordem->demanda->status_texto ?? ucfirst($ordem->demanda->status) }}
                                    </x-ordens::badge>
                                </div>
                            </div>
                            <x-ordens::button href="{{ route('demandas.show', $ordem->demanda->id) }}" variant="outline" class="w-full">
                                Ver Demanda
                                <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </x-ordens::button>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">Nenhuma demanda vinculada</p>
                        @endif
                    </div>
                </x-ordens::card>

                <!-- Equipe -->
                <x-ordens::card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                            </svg>
                            Equipe
                        </h3>
                    </x-slot>

                    <div class="space-y-3">
                        @if($ordem->equipe)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Nome</label>
                                <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $ordem->equipe->nome }}</div>
                                @if($ordem->equipe->codigo)
                                    <x-ordens::badge variant="gray" class="mt-1">{{ $ordem->equipe->codigo }}</x-ordens::badge>
                                @endif
                            </div>
                            @if($ordem->equipe->tipo)
                            <div>
                                <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</label>
                                <div class="text-sm text-gray-900 dark:text-white">{{ ucfirst($ordem->equipe->tipo) }}</div>
                            </div>
                            @endif
                            <x-ordens::button href="{{ route('equipes.show', $ordem->equipe->id) }}" variant="outline" class="w-full">
                                Ver Equipe
                                <svg class="w-4 h-4 ml-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3" />
                                </svg>
                            </x-ordens::button>
                        @else
                            <p class="text-gray-500 dark:text-gray-400 text-center py-4">Nenhuma equipe atribuída</p>
                        @endif
                    </div>
                </x-ordens::card>
            </div>

            @if($ordem->materiais && $ordem->materiais->count() > 0)
            <div class="mt-6">
                <x-ordens::card>
                    <x-slot name="header">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 7.5l-.625 10.632a2.25 2.25 0 01-2.247 2.118H6.622a2.25 2.25 0 01-2.247-2.118L3.75 7.5M10 11.25h4M3.375 7.5h17.25c.621 0 1.125-.504 1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125z" />
                            </svg>
                            Materiais Utilizados
                        </h3>
                    </x-slot>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Material</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Quantidade</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Unidade</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($ordem->materiais as $ordemMaterial)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $ordemMaterial->material->nome ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ formatar_quantidade($ordemMaterial->quantidade, $ordemMaterial->material->unidade_medida ?? null) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                            {{ $ordemMaterial->material->unidade_medida ?? 'N/A' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </x-ordens::card>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabButtons = document.querySelectorAll('[data-tab-target]');
    const tabPanels = document.querySelectorAll('[data-tab-panel]');

    function showTab(targetId) {
        // Hide all panels
        tabPanels.forEach(panel => {
            panel.classList.add('hidden');
        });

        // Remove active state from all buttons
        tabButtons.forEach(button => {
            button.classList.remove('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
            button.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300');
        });

        // Show target panel
        const targetPanel = document.querySelector(`[data-tab-panel="${targetId}"]`);
        if (targetPanel) {
            targetPanel.classList.remove('hidden');
        }

        // Activate target button
        const targetButton = document.querySelector(`[data-tab-target="${targetId}"]`);
        if (targetButton) {
            targetButton.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-700', 'hover:border-gray-300', 'dark:text-gray-400', 'dark:hover:text-gray-300');
            targetButton.classList.add('border-indigo-500', 'text-indigo-600', 'dark:text-indigo-400');
        }
    }

    // Add click handlers
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-tab-target');
            showTab(targetId);
        });
    });
});
</script>
@endpush
@endsection
