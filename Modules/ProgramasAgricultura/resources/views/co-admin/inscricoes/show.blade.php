@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes da Inscrição - Agricultura')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <x-icon name="clipboard-check" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                Inscrição de {{ $inscricao->pessoa->nom_pessoa }}
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('co-admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Dashboard</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('co-admin.inscricoes.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Inscrições</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white">Detalhes da Inscrição</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('co-admin.inscricoes.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors font-semibold">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
            <button onclick="window.print()" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-slate-700 text-gray-700 dark:text-slate-200 rounded-lg hover:bg-gray-200 dark:hover:bg-slate-600 transition-colors font-bold">
                <x-icon name="print" class="w-5 h-5" />
                Imprimir Comprovante
            </button>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Coluna de Informações do Participante -->
    <div class="lg:col-span-1 space-y-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="font-bold text-gray-900 dark:text-white flex items-center gap-2 uppercase tracking-wider text-xs">
                    <x-icon name="user" class="w-4 h-4 text-indigo-500" />
                    Participante
                </h3>
            </div>
            <div class="p-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-1">{{ $inscricao->pessoa->nom_pessoa }}</h2>
                <p class="text-sm font-medium text-gray-500 mb-4">{{ $inscricao->pessoa->num_cpf_pessoa }}</p>

                <div class="space-y-3 pt-4 border-t border-gray-50 dark:border-slate-700">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase mb-1">Localidade de Origem</p>
                        <p class="text-sm text-gray-900 dark:text-white font-semibold italic">{{ $inscricao->localidade->nome ?? 'Não informada' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Card -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6">
            <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-3">Status da Inscrição</p>
            @php
                $statusColors = [
                    'confirmada' => 'bg-emerald-100 text-emerald-800',
                    'presente' => 'bg-blue-100 text-blue-800',
                    'ausente' => 'bg-amber-100 text-amber-800',
                    'cancelada' => 'bg-red-100 text-red-800',
                ];
            @endphp
            <div class="px-4 py-2 rounded-lg text-center font-bold uppercase tracking-widest text-lg {{ $statusColors[$inscricao->status] ?? 'bg-gray-100 text-gray-800' }}">
                {{ $inscricao->status }}
            </div>
            <p class="mt-4 text-xs text-gray-500 italic text-center">
                Inscrito em: {{ $inscricao->data_inscricao ? $inscricao->data_inscricao->format('d/m/Y H:i') : '-' }}
            </p>
        </div>
    </div>

    <!-- Coluna de Detalhes do Evento -->
    <div class="lg:col-span-2 space-y-6">
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="p-6 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="font-bold text-gray-900 dark:text-white flex items-center gap-2 uppercase tracking-wider text-xs">
                    <x-icon name="calendar-days" class="w-4 h-4 text-indigo-500" />
                    Evento / Curso
                </h3>
            </div>
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">{{ $inscricao->evento->titulo }}</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase mb-1">Data e Hora</p>
                        <p class="text-base text-gray-900 dark:text-white font-semibold">
                            {{ $inscricao->evento->data_inicio->format('d/m/Y \à\s H:i') }}
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-bold text-gray-400 uppercase mb-1">Local</p>
                        <p class="text-base text-gray-900 dark:text-white font-semibold">
                            {{ $inscricao->evento->localidade->nome ?? 'Não definido' }}
                        </p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-xs font-bold text-gray-400 uppercase mb-1">Endereço</p>
                        <p class="text-base text-gray-900 dark:text-white font-semibold italic">
                            {{ $inscricao->evento->endereco ?: 'Não informado' }}
                        </p>
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-gray-100 dark:border-slate-700">
                    <p class="text-xs font-bold text-gray-400 uppercase mb-2">Observações da Inscrição</p>
                    <div class="p-4 bg-gray-50 dark:bg-slate-900/50 rounded-lg border border-gray-100 dark:border-slate-700 text-sm text-gray-700 dark:text-slate-300 italic">
                        {{ $inscricao->observacoes ?: 'Nenhuma observação registrada.' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Ações do Co-Admin -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6 flex flex-col sm:flex-row gap-4 items-center justify-between">
            <div class="text-sm text-gray-500 font-medium italic">
                Operador resp.: {{ $inscricao->evento->user_id_criador ? 'Admin/Co-Admin' : 'Sistema' }}
            </div>
            <div class="flex gap-3 w-full sm:w-auto">
                <form action="{{ route('co-admin.inscricoes.destroy', $inscricao->id) }}" method="POST" onsubmit="return confirm('Deseja realmente cancelar esta inscrição?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-red-50 text-red-600 border border-red-200 rounded-lg hover:bg-red-100 transition-colors font-bold uppercase tracking-wider text-xs">
                        Cancelar Inscrição
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
