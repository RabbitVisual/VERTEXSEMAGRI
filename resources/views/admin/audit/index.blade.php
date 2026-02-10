@extends('admin.layouts.admin')

@section('title', 'Logs de Auditoria')

@section('content')
<div class="space-y-6 md:space-y-8 font-poppins pb-12" x-data="{
    showCleanModal: false,
    cleanPeriod: '90',
    cleanPeriodLabel: '90 dias'
}">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50/50 dark:bg-indigo-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon name="clipboard-list" style="duotone" class="w-7 h-7 md:w-8 md:h-8" />
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        Logs de Auditoria
                    </h1>
                    <p class="text-sm md:text-base text-gray-500 dark:text-gray-400 font-medium">Rastreie todas as atividades e alterações no sistema.</p>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <button @click="showCleanModal = true" class="group inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold text-red-600 bg-red-50 hover:bg-red-600 hover:text-white rounded-xl dark:bg-red-900/20 dark:text-red-400 dark:hover:bg-red-900/40 transition-all duration-300 shadow-sm border border-red-100 dark:border-red-900/30">
                    <x-icon name="trash-can" style="duotone" class="w-5 h-5 transition-transform group-hover:shake" />
                    Manutenção de Logs
                </button>
            </div>
        </div>
    </div>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach([
            ['label' => 'Hoje', 'value' => $stats['today'], 'icon' => 'calendar-day', 'color' => 'blue', 'gradient' => 'from-blue-500 to-blue-600'],
            ['label' => 'Esta Semana', 'value' => $stats['week'], 'icon' => 'calendar-week', 'color' => 'indigo', 'gradient' => 'from-indigo-500 to-indigo-600'],
            ['label' => 'Este Mês', 'value' => $stats['month'], 'icon' => 'calendar', 'color' => 'purple', 'gradient' => 'from-purple-500 to-purple-600'],
            ['label' => 'Total Geral', 'value' => $stats['total'], 'icon' => 'database', 'color' => 'slate', 'gradient' => 'from-slate-600 to-slate-700']
        ] as $stat)
        <div class="group relative bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br {{ $stat['gradient'] }} rounded-xl flex items-center justify-center text-white shadow-lg shadow-{{ $stat['color'] }}-200 dark:shadow-none transition-transform group-hover:scale-110">
                    <x-icon name="{{ $stat['icon'] }}" style="duotone" class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-wider">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-black text-gray-900 dark:text-white mt-1">{{ number_format($stat['value'], 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r {{ $stat['gradient'] }} opacity-0 group-hover:opacity-100 transition-opacity rounded-b-2xl"></div>
        </div>
        @endforeach
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 md:p-8">
        <h3 class="text-sm font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-6 flex items-center gap-2">
            <x-icon name="filter" style="duotone" class="w-4 h-4 text-indigo-500" />
            Filtros Avançados
        </h3>

        <form action="{{ route('admin.audit.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
            <div class="space-y-2">
                <label for="user_id" class="text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Usuário</label>
                <select name="user_id" id="user_id" class="w-full bg-gray-50 dark:bg-slate-900 border-none rounded-xl focus:ring-2 focus:ring-indigo-500/50 text-sm font-medium p-3 dark:text-white transition-all shadow-inner">
                    <option value="">Todos os Usuários</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ ($filters['user_id'] ?? '') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="space-y-2">
                <label for="module" class="text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Módulo</label>
                <select name="module" id="module" class="w-full bg-gray-50 dark:bg-slate-900 border-none rounded-xl focus:ring-2 focus:ring-indigo-500/50 text-sm font-medium p-3 dark:text-white transition-all shadow-inner">
                    <option value="">Todos os Módulos</option>
                    @foreach($modules as $module)
                        <option value="{{ $module }}" {{ ($filters['module'] ?? '') == $module ? 'selected' : '' }}>{{ ucfirst($module) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="lg:col-span-2 space-y-2">
                <label for="search" class="text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Termo de Pesquisa</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                        <x-icon name="magnifying-glass" class="w-4 h-4" />
                    </div>
                    <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" class="w-full bg-gray-50 dark:bg-slate-900 border-none rounded-xl focus:ring-2 focus:ring-indigo-500/50 text-sm font-medium pl-11 p-3 dark:text-white transition-all shadow-inner" placeholder="Ação, descrição ou ID...">
                </div>
            </div>
            <div class="flex items-end gap-3">
                <button type="submit" class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl text-sm px-6 py-3 transition-all shadow-lg shadow-indigo-200 dark:shadow-none hover:scale-[1.02] active:scale-95 border-b-4 border-indigo-800">
                    Aplicar
                </button>
                <a href="{{ route('admin.audit.index') }}" class="inline-flex items-center justify-center w-12 h-[44px] bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-600 dark:text-gray-300 rounded-xl transition-all shadow-sm">
                    <x-icon name="rotate-right" class="w-5 h-5" />
                </a>
            </div>
        </form>
    </div>

    <!-- Tabela de Logs -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden transition-all">
        <div class="overflow-x-auto min-h-[400px]">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-900/50">
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest pl-8">Data & Hora</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Responsável</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Ação Realizada</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Módulo</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Descrição</th>
                        <th class="px-6 py-5 text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest text-center pr-8">Detalhes</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-700/50">
                    @forelse($logs as $log)
                    <tr class="group hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10 transition-colors">
                        <td class="px-6 py-5 whitespace-nowrap pl-8 border-l-4 border-transparent hover:border-indigo-500 transition-all">
                            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $log->created_at->format('d/m/Y') }}</span>
                            <span class="text-xs font-medium text-gray-400 dark:text-gray-500 block">{{ $log->created_at->format('H:i:s') }}</span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-100 to-indigo-200 dark:from-indigo-900/40 dark:to-indigo-800/20 flex items-center justify-center text-indigo-700 dark:text-indigo-300 font-black shadow-sm ring-2 ring-white dark:ring-slate-800">
                                    {{ $log->user ? strtoupper(substr($log->user->name, 0, 1)) : 'S' }}
                                </div>
                                <div>
                                    <span class="text-sm font-bold text-gray-900 dark:text-white block">{{ $log->user->name ?? 'Sistema' }}</span>
                                    <span class="text-[10px] font-bold text-gray-400 uppercase tracking-tighter">{{ $log->ip_address ?? 'Local' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @php
                                $actionColor = match(true) {
                                    Str::contains($log->action, 'create') => 'emerald',
                                    Str::contains($log->action, 'update') => 'blue',
                                    Str::contains($log->action, 'delete') => 'red',
                                    default => 'slate'
                                };
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-[10px] font-black uppercase tracking-widest bg-{{ $actionColor }}-100 text-{{ $actionColor }}-700 dark:bg-{{ $actionColor }}-900/30 dark:text-{{ $actionColor }}-300 border border-{{ $actionColor }}-200 dark:border-{{ $actionColor }}-800/50">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="px-6 py-5 whitespace-nowrap">
                            <span class="text-sm font-semibold text-gray-600 dark:text-gray-400">{{ ucfirst($log->module ?? 'Global') }}</span>
                        </td>
                        <td class="px-6 py-5">
                            <p class="text-sm text-gray-500 dark:text-gray-400 max-w-xs truncate font-medium">{{ $log->description }}</p>
                        </td>
                        <td class="px-6 py-5 text-center pr-8">
                            <a href="{{ route('admin.audit.show', $log->id) }}" class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-white dark:bg-slate-700 text-indigo-600 dark:text-indigo-400 shadow-sm border border-gray-100 dark:border-slate-600 hover:bg-indigo-600 hover:text-white dark:hover:bg-indigo-500 dark:hover:text-white transition-all duration-300 hover:scale-110 active:scale-95">
                                <x-icon name="eye" style="duotone" class="w-5 h-5" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center justify-center max-w-sm mx-auto">
                                <div class="w-24 h-24 bg-slate-50 dark:bg-slate-900/50 rounded-full flex items-center justify-center mb-6 ring-8 ring-slate-50/50 dark:ring-slate-900/20">
                                    <x-icon name="search" style="duotone" class="w-12 h-12 text-slate-300 dark:text-slate-700" />
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">Nenhum evento registrado</h3>
                                <p class="text-gray-500 dark:text-gray-400 font-medium">Não encontramos logs de auditoria com os critérios selecionados.</p>
                                <a href="{{ route('admin.audit.index') }}" class="mt-6 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 font-bold transition-colors">Limpar todos os filtros</a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
        <div class="px-8 py-6 bg-slate-50 dark:bg-slate-900/30 border-t border-gray-100 dark:border-slate-700">
            {{ $logs->appends(request()->query())->links() }}
        </div>
        @endif
    </div>

    <!-- Modal de Limpeza Premium (Alpine.js) -->
    <div x-show="showCleanModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm"
         style="display: none;">

        <div @click.away="showCleanModal = false"
             class="bg-white dark:bg-slate-800 w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden border border-gray-100 dark:border-slate-700 transition-all transform"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-y-12 scale-95"
             x-transition:enter-end="translate-y-0 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-y-0 scale-100"
             x-transition:leave-end="translate-y-12 scale-95">

            <div class="p-8 text-center">
                <div class="w-20 h-20 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-6 text-red-600 dark:text-red-400 ring-8 ring-red-50 dark:ring-red-900/10">
                    <x-icon name="trash-can-clock" style="duotone" class="w-10 h-10 animate-bounce" />
                </div>

                <h2 class="text-2xl font-black text-gray-900 dark:text-white mb-2">Limpeza de Auditoria</h2>
                <p class="text-gray-500 dark:text-gray-400 font-medium mb-8">Escolha o período de preservação. Todos os logs anteriores ao período selecionado serão removidos permanentemente.</p>

                <div class="space-y-4 mb-8">
                    <label class="block text-left text-xs font-black text-gray-400 uppercase tracking-widest ml-1">Periodo de Preservação</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach([
                            ['days' => '7', 'label' => '7 dias'],
                            ['days' => '30', 'label' => '30 dias'],
                            ['days' => '90', 'label' => '90 dias'],
                            ['days' => '180', 'label' => '6 meses'],
                            ['days' => '365', 'label' => '1 ano'],
                            ['days' => '0', 'label' => 'Limpar Tudo']
                        ] as $option)
                        <button @click="cleanPeriod = '{{ $option['days'] }}'; cleanPeriodLabel = '{{ $option['label'] }}'"
                                :class="cleanPeriod === '{{ $option['days'] }}' ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-200 dark:shadow-none border-indigo-600' : 'bg-gray-50 dark:bg-slate-900 text-gray-700 dark:text-gray-300 border-gray-100 dark:border-slate-700'"
                                class="flex items-center justify-center p-4 rounded-2xl border-2 font-bold text-sm transition-all hover:scale-[1.03] active:scale-95">
                            {{ $option['label'] }}
                        </button>
                        @endforeach
                    </div>
                </div>

                <div class="bg-amber-50 dark:bg-amber-900/20 rounded-2xl p-4 border border-amber-100 dark:border-amber-900/30 flex items-start gap-4 mb-8 text-left">
                    <x-icon name="triangle-exclamation" class="w-5 h-5 text-amber-600 dark:text-amber-400 flex-shrink-0 mt-1" />
                    <div>
                        <p class="text-sm font-bold text-amber-800 dark:text-amber-300">Atenção!</p>
                        <p class="text-xs font-medium text-amber-700 dark:text-amber-400">Esta ação não pode ser desfeita. <span x-text="cleanPeriod === '0' ? 'TODOS os logs serão excluídos.' : 'Logs anteriores a ' + cleanPeriodLabel + ' serão deletados.'"></span></p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <button @click="showCleanModal = false" class="px-6 py-4 bg-gray-100 hover:bg-gray-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-gray-600 dark:text-gray-300 font-bold rounded-2xl transition-all">
                        Cancelar
                    </button>
                    <form action="{{ route('admin.audit.clean') }}" method="POST">
                        @csrf
                        <input type="hidden" name="days" :value="cleanPeriod">
                        <button type="submit" class="w-full px-6 py-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-2xl transition-all shadow-lg shadow-red-200 dark:shadow-none hover:scale-[1.03] active:scale-95 border-b-4 border-red-800">
                            Confirmar Exclusão
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes shake {
        0%, 100% { transform: rotate(0deg); }
        25% { transform: rotate(5deg); }
        75% { transform: rotate(-5deg); }
    }
    .group-hover\:shake {
        animation: shake 0.5s infinite;
    }
</style>
@endsection
