@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes do Beneficiário - Agricultura')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <x-icon name="user-check" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                {{ $beneficiario->pessoa->nom_pessoa }}
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('co-admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Dashboard</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('co-admin.beneficiarios.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Beneficiários</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white">Ficha do Beneficiário</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('co-admin.beneficiarios.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors font-semibold">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors font-bold">
                <x-icon name="print" class="w-5 h-5" />
                Imprimir Ficha
            </button>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Informações de Perfil -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="p-8 text-center bg-gray-50 dark:bg-slate-900/50 border-b border-gray-100 dark:border-slate-700">
                <div class="w-24 h-24 bg-indigo-100 dark:bg-indigo-900/30 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white dark:border-slate-800 shadow-sm">
                    <x-icon name="user" class="w-12 h-12 text-indigo-600 dark:text-indigo-400" />
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $beneficiario->pessoa->nom_pessoa }}</h2>
                <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">{{ $beneficiario->pessoa->num_cpf_pessoa }}</p>
                <div class="mt-4">
                    <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider {{
                        $beneficiario->status == 'aprovado' || $beneficiario->status == 'beneficiado'
                        ? 'bg-emerald-100 text-emerald-800'
                        : 'bg-amber-100 text-amber-800'
                    }}">
                        {{ $beneficiario->status }}
                    </span>
                </div>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase mb-1">Data de Nascimento</p>
                    <p class="text-sm text-gray-900 dark:text-white font-semibold italic">
                        {{ $beneficiario->pessoa->dat_nascimento_pessoa ? date('d/m/Y', strtotime($beneficiario->pessoa->dat_nascimento_pessoa)) : 'Não informado' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase mb-1">Localidade</p>
                    <p class="text-sm text-gray-900 dark:text-white font-semibold italic">{{ $beneficiario->localidade->nome ?? 'Não definida' }}</p>
                </div>
                <div class="pt-4 border-t border-gray-100 dark:border-slate-700">
                    <a href="{{ route('co-admin.pessoas.show', $beneficiario->pessoa_id) }}" class="text-sm text-indigo-600 hover:text-indigo-900 font-bold flex items-center gap-2">
                        Ver Perfil Completo
                        <x-icon name="arrow-up-right-from-square" class="w-4 h-4" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Detalhes do Benefício -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-slate-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-2">
                    <x-icon name="leaf" class="w-5 h-5 text-indigo-500" />
                    Dados do Programa
                </h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-1">Programa</p>
                    <p class="text-lg text-gray-900 dark:text-white font-bold">{{ $beneficiario->programa->nome }}</p>
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 uppercase mb-1">Data da Inscrição</p>
                    <p class="text-lg text-gray-900 dark:text-white font-semibold">
                        {{ $beneficiario->data_inscricao ? $beneficiario->data_inscricao->format('d/m/Y') : '-' }}
                    </p>
                </div>
                <div class="md:col-span-2">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-1">Observações</p>
                    <div class="p-4 bg-gray-50 dark:bg-slate-900/50 rounded-lg border border-gray-100 dark:border-slate-700 text-sm text-gray-700 dark:text-slate-300 italic">
                        {{ $beneficiario->observacoes ?: 'Nenhuma observação registrada.' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações do Co-Admin -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6 flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div class="text-sm text-gray-500 italic">
                Última alteração em: {{ $beneficiario->updated_at->format('d/m/Y H:i') }}
            </div>
            <div class="flex gap-3 w-full sm:w-auto">
                <form action="{{ route('co-admin.beneficiarios.destroy', $beneficiario->id) }}" method="POST" onsubmit="return confirm('Deseja realmente remover este beneficiário do programa?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 border-2 border-red-500 text-red-500 rounded-lg hover:bg-red-50 transition-colors font-bold">
                        Remover do Programa
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
