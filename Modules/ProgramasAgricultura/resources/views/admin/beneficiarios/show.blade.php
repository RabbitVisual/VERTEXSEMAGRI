@extends('admin.layouts.admin')

@section('title', 'Beneficiário - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.beneficiarios.index') }}" class="hover:text-green-600 dark:hover:text-green-400 transition-colors">Beneficiários</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">Detalhes</span>
            </nav>
        </div>
        <a href="{{ route('admin.beneficiarios.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
            <x-icon name="arrow-left" class="w-5 h-5" />
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
        <!-- Informações do Beneficiário -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do Beneficiário</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">CPF</dt>
                            <dd class="text-sm text-gray-900 dark:text-white font-medium">{{ substr($beneficiario->cpf, 0, 3) }}.***.***-**</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</dt>
                            <dd class="text-sm">
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
                            </dd>
                        </div>
                        @if($beneficiario->pessoa)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nome</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $beneficiario->pessoa->nom_pessoa }}</dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Programa</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $beneficiario->programa->nome ?? '-' }}</dd>
                        </div>
                        @if($beneficiario->localidade)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Localidade</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $beneficiario->localidade->nome }}</dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Inscrição</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $beneficiario->data_inscricao->format('d/m/Y H:i') }}</dd>
                        </div>
                    </dl>
                    @if($beneficiario->observacoes)
                    <div class="mt-4 pt-4 border-t border-gray-200 dark:border-slate-700">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Observações</dt>
                        <dd class="text-sm text-gray-900 dark:text-white whitespace-pre-line">{{ $beneficiario->observacoes }}</dd>
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
                <form action="{{ route('admin.beneficiarios.update-status', $beneficiario->id) }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Novo Status</label>
                            <select id="status" name="status" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                                <option value="inscrito" {{ $beneficiario->status == 'inscrito' ? 'selected' : '' }}>Inscrito</option>
                                <option value="aprovado" {{ $beneficiario->status == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                                <option value="beneficiado" {{ $beneficiario->status == 'beneficiado' ? 'selected' : '' }}>Beneficiado</option>
                                <option value="rejeitado" {{ $beneficiario->status == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                            </select>
                        </div>
                        <div>
                            <label for="observacoes" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Observações</label>
                            <textarea id="observacoes" name="observacoes" rows="3" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-500 focus:border-green-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">{{ $beneficiario->observacoes }}</textarea>
                        </div>
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 transition-colors">
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
