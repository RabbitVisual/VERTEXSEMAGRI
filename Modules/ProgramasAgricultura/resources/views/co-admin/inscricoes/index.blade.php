@extends('Co-Admin.layouts.app')

@section('title', 'Inscrições em Eventos')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <x-icon name="document-text" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                Inscrições em Eventos
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('co-admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Dashboard</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white">Inscrições</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('co-admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
            <a href="{{ route('co-admin.inscricoes.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 dark:shadow-none">
                <x-icon name="plus" class="w-5 h-5" />
                Nova Inscrição
            </a>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6 mb-6">
    <form method="GET" action="{{ route('co-admin.inscricoes.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-2">
            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Buscar</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-icon name="magnifying-glass" class="h-5 w-5 text-gray-400" />
                </div>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       placeholder="Nome ou CPF do participante...">
            </div>
        </div>
        <div>
            <label for="evento_id" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Evento</label>
            <select name="evento_id" id="evento_id" class="block w-full py-2 pl-3 pr-10 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                <option value="">Todos os Eventos</option>
                @foreach($eventos as $ev)
                    <option value="{{ $ev->id }}" {{ request('evento_id') == $ev->id ? 'selected' : '' }}>{{ $ev->titulo }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                Filtrar
            </button>
        </div>
    </form>
</div>

<!-- Tabela de Inscrições -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
            <thead class="bg-gray-50 dark:bg-slate-900/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Participante</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Evento</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                @forelse($inscricoes as $inscricao)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $inscricao->pessoa->nom_pessoa }}</div>
                        <div class="text-xs text-gray-500 dark:text-slate-400">{{ $inscricao->pessoa->num_cpf_pessoa }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm text-gray-900 dark:text-white font-medium">{{ $inscricao->evento->titulo ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-500">{{ $inscricao->evento->data_inicio->format('d/m/Y') }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusMap = [
                                'confirmada' => ['label' => 'Confirmada', 'class' => 'bg-emerald-100 text-emerald-800'],
                                'presente' => ['label' => 'Presente', 'class' => 'bg-indigo-100 text-indigo-800'],
                                'ausente' => ['label' => 'Ausente', 'class' => 'bg-amber-100 text-amber-800'],
                                'cancelada' => ['label' => 'Cancelada', 'class' => 'bg-red-100 text-red-800'],
                            ];
                            $status = $statusMap[$inscricao->status] ?? ['label' => $inscricao->status, 'class' => 'bg-gray-100 text-gray-800'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status['class'] }}">
                            {{ $status['label'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('co-admin.inscricoes.show', $inscricao->id) }}" class="text-indigo-600 hover:text-indigo-900 transition-colors" title="Ver detalhes">
                                <x-icon name="eye" class="w-5 h-5" />
                            </a>
                            <form action="{{ route('co-admin.inscricoes.destroy', $inscricao->id) }}" method="POST" class="inline" onsubmit="return confirm('Remover esta inscrição?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 transition-colors" title="Remover">
                                    <x-icon name="trash" class="w-5 h-5" />
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                        Nenhuma inscrição encontrada.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($inscricoes->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/30">
        {{ $inscricoes->links() }}
    </div>
    @endif
</div>
@endsection
