@extends('admin.layouts.admin')

@section('title', 'Programa ' . $programa->nome . ' - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-amber-500 to-amber-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v17.25m0 0c-1.472 0-2.882.265-4.185.75M12 20.25c1.472 0 2.882.265 4.185.75M18.75 4.97A48.224 48.224 0 0012 4.5c-2.291 0-4.545.16-6.75.47m13.5 0c1.01.143 2.01.317 3 .52m-3-.52l-2.25 2.25m0 0l-2.25 2.25M18.75 4.97l-2.25 2.25M18.75 4.97l2.25 2.25M9.75 4.97l-2.25 2.25M9.75 4.97L12 7.22m-2.25 2.25L12 7.22" />
                    </svg>
                </div>
                <span>{{ $programa->nome }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Admin</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <a href="{{ route('admin.programas.index') }}" class="hover:text-amber-600 dark:hover:text-amber-400 transition-colors">Programas</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">{{ $programa->codigo }}</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.programas.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Voltar
            </a>
            <a href="{{ route('admin.programas.edit', $programa->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 focus:ring-4 focus:ring-amber-300 dark:bg-amber-600 dark:hover:bg-amber-700 dark:focus:ring-amber-800 transition-colors">
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
        <!-- Informações do Programa -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do Programa</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Código</dt>
                            <dd class="text-sm text-gray-900 dark:text-white font-medium">{{ $programa->codigo }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</dt>
                            <dd class="text-sm">
                                @php
                                    $statusColors = [
                                        'ativo' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                                        'suspenso' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                                        'encerrado' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                    ];
                                    $statusClass = $statusColors[$programa->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                @endphp
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClass }}">{{ $programa->status_texto }}</span>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $programa->tipo_texto }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Visibilidade</dt>
                            <dd class="text-sm">
                                @if($programa->publico)
                                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300">Público</span>
                                @else
                                    <span class="px-2.5 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">Privado</span>
                                @endif
                            </dd>
                        </div>
                        @if($programa->data_inicio)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Início</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $programa->data_inicio->format('d/m/Y') }}</dd>
                        </div>
                        @endif
                        @if($programa->data_fim)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Término</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $programa->data_fim->format('d/m/Y') }}</dd>
                        </div>
                        @endif
                        @if($programa->vagas_disponiveis)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Vagas</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $programa->vagas_preenchidas }}/{{ $programa->vagas_disponiveis }}</dd>
                        </div>
                        @endif
                        @if($programa->orgao_responsavel)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Órgão Responsável</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $programa->orgao_responsavel }}</dd>
                        </div>
                        @endif
                    </dl>
                    @if($programa->descricao)
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Descrição</dt>
                        <dd class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $programa->descricao }}</dd>
                    </div>
                    @endif
                    @if($programa->requisitos)
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Requisitos</dt>
                        <dd class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $programa->requisitos }}</dd>
                    </div>
                    @endif
                    @if($programa->documentos_necessarios)
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Documentos Necessários</dt>
                        <dd class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $programa->documentos_necessarios }}</dd>
                    </div>
                    @endif
                    @if($programa->beneficios)
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Benefícios</dt>
                        <dd class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $programa->beneficios }}</dd>
                    </div>
                    @endif
                    @if($programa->observacoes)
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Observações</dt>
                        <dd class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $programa->observacoes }}</dd>
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
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Total de Beneficiários</dt>
                            <dd class="text-2xl font-bold text-amber-600 dark:text-amber-400">{{ $programa->beneficiarios_count }}</dd>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($beneficiarios->count() > 0)
    <!-- Tabela de Beneficiários - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Beneficiários</h3>
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
                    @foreach($beneficiarios as $beneficiario)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ substr($beneficiario->cpf, 0, 3) }}.***.***-**</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $beneficiario->pessoa->nom_pessoa ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $beneficiario->localidade->nome ?? '-' }}</td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'inscrito' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'aprovado' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                                    'beneficiado' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                                    'rejeitado' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                ];
                                $statusClass = $statusColors[$beneficiario->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                            @endphp
                            <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClass }}">{{ ucfirst($beneficiario->status) }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $beneficiario->data_inscricao->format('d/m/Y') }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('admin.beneficiarios.show', $beneficiario->id) }}" class="inline-flex items-center text-amber-600 hover:text-amber-900 dark:text-amber-400 dark:hover:text-amber-300 transition-colors" title="Ver detalhes">
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
        @if($beneficiarios->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
            {{ $beneficiarios->links() }}
        </div>
        @endif
    </div>
    @endif
</div>
@endsection
