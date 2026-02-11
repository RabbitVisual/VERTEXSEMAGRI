@extends('Co-Admin.layouts.app')

@section('title', 'Programas - Agricultura')

@section('content')
<!-- Page Header -->
<div class="mb-8 pb-4 border-b border-gray-200 dark:border-slate-700">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <x-icon name="leaf" class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
                Meus Programas
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400">
                <a href="{{ route('co-admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">Dashboard</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white">Programas</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('co-admin.dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2 border-2 border-gray-300 dark:border-slate-600 text-gray-700 dark:text-slate-300 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
            <a href="{{ route('co-admin.programas.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-lg shadow-indigo-200 dark:shadow-none">
                <x-icon name="plus" class="w-5 h-5" />
                Novo Programa
            </a>
        </div>
    </div>
</div>

<!-- Filtros -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 p-6 mb-6">
    <form method="GET" action="{{ route('co-admin.programas.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="md:col-span-3">
            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-slate-300 mb-1">Buscar</label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-icon name="magnifying-glass" class="h-5 w-5 text-gray-400" />
                </div>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-900 text-gray-900 dark:text-white focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                       placeholder="Nome ou código do programa...">
            </div>
        </div>
        <div class="flex items-end">
            <button type="submit" class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                Filtrar
            </button>
        </div>
    </form>
</div>

<!-- Tabela de Programas -->
<div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
            <thead class="bg-gray-50 dark:bg-slate-900/50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Código</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Programa</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Vagas</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 dark:text-slate-400 uppercase tracking-wider">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                @forelse($programas as $programa)
                <tr class="hover:bg-gray-50 dark:hover:bg-slate-700/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-slate-300">
                            {{ $programa->codigo }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold text-gray-900 dark:text-white">{{ $programa->nome }}</div>
                        <div class="text-xs text-gray-500 dark:text-slate-400 truncate max-w-xs">{{ $programa->tipo_texto }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-2">
                            <div class="w-16 bg-gray-200 dark:bg-slate-700 rounded-full h-2 overflow-hidden">
                                @php
                                    $percent = $programa->vagas_disponiveis > 0
                                        ? ($programa->vagas_preenchidas / $programa->vagas_disponiveis) * 100
                                        : 0;
                                    $percent = min(100, $percent);
                                @endphp
                                <div class="bg-indigo-600 h-full" style="width: {{ $percent }}%"></div>
                            </div>
                            <span class="text-xs font-medium text-gray-700 dark:text-slate-300">
                                @if($programa->vagas_disponiveis)
                                    {{ $programa->vagas_preenchidas }}/{{ $programa->vagas_disponiveis }}
                                @else
                                    Ilimitado
                                @endif
                            </span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @php
                            $statusMap = [
                                'ativo' => ['label' => 'Ativo', 'class' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400'],
                                'suspenso' => ['label' => 'Suspenso', 'class' => 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-400'],
                                'encerrado' => ['label' => 'Encerrado', 'class' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400'],
                            ];
                            $status = $statusMap[$programa->status] ?? ['label' => $programa->status, 'class' => 'bg-gray-100 text-gray-800'];
                        @endphp
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $status['class'] }}">
                            {{ $status['label'] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        <div class="flex items-center justify-end gap-3">
                            <a href="{{ route('co-admin.programas.show', $id ?? $programa->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors" title="Ver detalhes">
                                <x-icon name="eye" class="w-5 h-5" />
                            </a>
                            <a href="{{ route('co-admin.programas.edit', $id ?? $programa->id) }}" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors" title="Editar">
                                <x-icon name="pencil" class="w-5 h-5" />
                            </a>
                            <form action="{{ route('co-admin.programas.destroy', $id ?? $programa->id) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja excluir este programa?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors" title="Excluir">
                                    <x-icon name="trash" class="w-5 h-5" />
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 dark:bg-slate-700 rounded-full flex items-center justify-center mx-auto mb-4">
                            <x-icon name="leaf" class="w-8 h-8 text-gray-400" />
                        </div>
                        <p class="text-gray-900 dark:text-white font-semibold">Nenhum programa encontrado</p>
                        <p class="text-gray-500 dark:text-slate-400 text-sm">Você ainda não gerencia nenhum programa ou a busca não retornou resultados.</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($programas->hasPages())
    <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/30">
        {{ $programas->links() }}
    </div>
    @endif
</div>
@endsection
