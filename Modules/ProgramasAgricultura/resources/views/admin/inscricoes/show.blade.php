@extends('admin.layouts.admin')

@section('title', 'Inscrição - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h11.25c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                </div>
                <span>Inscrição em Evento</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Admin</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <a href="{{ route('admin.inscricoes.index') }}" class="hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Inscrições</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">Detalhes</span>
            </nav>
        </div>
        <a href="{{ route('admin.inscricoes.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Voltar
        </a>
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
        <!-- Informações da Inscrição -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informações da Inscrição</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">CPF</dt>
                            <dd class="text-sm text-gray-900 dark:text-white font-medium">{{ substr($inscricao->cpf, 0, 3) }}.***.***-**</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</dt>
                            <dd class="text-sm">
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
                            </dd>
                        </div>
                        @if($inscricao->pessoa)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nome</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $inscricao->pessoa->nom_pessoa }}</dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Evento</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $inscricao->evento->titulo ?? '-' }}</dd>
                        </div>
                        @if($inscricao->localidade)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Localidade</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $inscricao->localidade->nome }}</dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Inscrição</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $inscricao->data_inscricao->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                    @if($inscricao->observacoes)
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Observações</dt>
                        <dd class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $inscricao->observacoes }}</dd>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Alterar Status -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Alterar Status</h3>
                </div>
                <form action="{{ route('admin.inscricoes.update-status', $inscricao->id) }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Novo Status</label>
                            <select id="status" name="status" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="confirmada" {{ $inscricao->status == 'confirmada' ? 'selected' : '' }}>Confirmada</option>
                                <option value="presente" {{ $inscricao->status == 'presente' ? 'selected' : '' }}>Presente</option>
                                <option value="ausente" {{ $inscricao->status == 'ausente' ? 'selected' : '' }}>Ausente</option>
                                <option value="cancelada" {{ $inscricao->status == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                            </select>
                        </div>
                        <div>
                            <label for="observacoes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observações</label>
                            <textarea id="observacoes" name="observacoes" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">{{ $inscricao->observacoes }}</textarea>
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                            </svg>
                            Atualizar Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
