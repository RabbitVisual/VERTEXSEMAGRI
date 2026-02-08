@extends('admin.layouts.admin')

@section('title', $evento->titulo . ' - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                    </svg>
                </div>
                <span>{{ $evento->titulo }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">Admin</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <a href="{{ route('admin.eventos.index') }}" class="hover:text-yellow-600 dark:hover:text-yellow-400 transition-colors">Eventos</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">{{ $evento->codigo }}</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.eventos.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Voltar
            </a>
            <a href="{{ route('admin.eventos.edit', $evento->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-yellow-600 rounded-lg hover:bg-yellow-700 focus:ring-4 focus:ring-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-700 dark:focus:ring-yellow-800 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
                Editar
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <div class="flex items-center">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Informações do Evento -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do Evento</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Código</dt>
                            <dd class="text-sm text-gray-900 dark:text-white font-medium">{{ $evento->codigo }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</dt>
                            <dd class="text-sm">
                                @php
                                    $statusColors = [
                                        'agendado' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                        'em_andamento' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                                        'concluido' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                                        'cancelado' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                    ];
                                    $statusClass = $statusColors[$evento->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                @endphp
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClass }}">{{ $evento->status_texto }}</span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $evento->tipo_texto }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Visibilidade</dt>
                            <dd class="text-sm">
                                @if($evento->publico)
                                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300">Público</span>
                                @else
                                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Privado</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Início</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $evento->data_inicio->format('d/m/Y') }}</dd>
                        </div>
                        @if($evento->data_fim)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Término</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $evento->data_fim->format('d/m/Y') }}</dd>
                        </div>
                        @endif
                        @if($evento->hora_inicio)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Horário</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">
                                {{ $evento->hora_inicio->format('H:i') }}
                                @if($evento->hora_fim)
                                    às {{ $evento->hora_fim->format('H:i') }}
                                @endif
                            </dd>
                        </div>
                        @endif
                        @if($evento->localidade)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Localidade</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $evento->localidade->nome }}</dd>
                        </div>
                        @endif
                        @if($evento->endereco)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Endereço</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $evento->endereco }}</dd>
                        </div>
                        @endif
                        @if($evento->vagas_totais)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Vagas</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $evento->vagas_preenchidas }}/{{ $evento->vagas_totais }}</dd>
                        </div>
                        @endif
                        @if($evento->data_limite_inscricao)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Data Limite Inscrição</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $evento->data_limite_inscricao->format('d/m/Y') }}</dd>
                        </div>
                        @endif
                    </dl>
                    @if($evento->descricao)
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Descrição</dt>
                        <dd class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $evento->descricao }}</dd>
                    </div>
                    @endif
                    @if($evento->publico_alvo)
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Público-Alvo</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $evento->publico_alvo }}</dd>
                    </div>
                    @endif
                    @if($evento->conteudo_programatico)
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Conteúdo Programático</dt>
                        <dd class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $evento->conteudo_programatico }}</dd>
                    </div>
                    @endif
                    @if($evento->instrutor_palestrante)
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Instrutor/Palestrante</dt>
                        <dd class="text-sm text-gray-900 dark:text-white">{{ $evento->instrutor_palestrante }}</dd>
                    </div>
                    @endif
                    @if($evento->materiais_necessarios)
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Materiais Necessários</dt>
                        <dd class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $evento->materiais_necessarios }}</dd>
                    </div>
                    @endif
                    @if($evento->observacoes)
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Observações</dt>
                        <dd class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $evento->observacoes }}</dd>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Estatísticas -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Estatísticas</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total de Inscrições</dt>
                            <dd class="text-2xl font-bold text-yellow-600 dark:text-yellow-400">{{ $evento->inscricoes_count }}</dd>
                        </div>
                        @if($evento->inscricao_aberta)
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300">Inscrições Abertas</span>
                        @else
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Inscrições Fechadas</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($inscricoes->count() > 0)
    <!-- Tabela de Inscrições - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Inscrições</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">CPF</th>
                        <th scope="col" class="px-6 py-3">Nome</th>
                        <th scope="col" class="px-6 py-3">Localidade</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Data</th>
                        <th scope="col" class="px-6 py-3 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inscricoes as $inscricao)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ substr($inscricao->cpf, 0, 3) }}.***.***-**</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $inscricao->pessoa->nom_pessoa ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $inscricao->localidade->nome ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'confirmada' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                                    'presente' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                                    'ausente' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                                    'cancelada' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                ];
                                $statusClass = $statusColors[$inscricao->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                            @endphp
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClass }}">{{ ucfirst($inscricao->status) }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $inscricao->data_inscricao->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.inscricoes.show', $inscricao->id) }}" class="inline-flex items-center text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 transition-colors" title="Ver detalhes">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if($inscricoes->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
            {{ $inscricoes->links() }}
        </div>
        @endif
    </div>
    @endif
</div>
@endsection
