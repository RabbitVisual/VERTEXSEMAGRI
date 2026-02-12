@extends('admin.layouts.admin')

@section('title', 'Atualizações do Sistema')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="cloud-arrow-up" class="w-6 h-6 md:w-7 md:h-7 text-white" style="duotone" />
                </div>
                <span>Central de <span class="text-indigo-600 dark:text-indigo-400">Atualizações</span></span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <span class="text-gray-900 dark:text-white font-medium">Manutenção do Sistema</span>
            </nav>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.updates.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:focus:ring-indigo-800 transition-all shadow-md shadow-indigo-500/20 active:scale-95 group">
                <x-icon name="upload" class="w-5 h-5 group-hover:translate-y-[-2px] transition-transform" />
                Enviar Atualização
            </a>
        </div>
    </div>

    <!-- System Status Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-emerald-50 dark:bg-emerald-900/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-emerald-500 uppercase tracking-wider mb-2">Versão Atual</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-3xl font-bold text-gray-900 dark:text-white">{{ $lastUpdate['version'] ?? '1.0.0' }}</span>
                    <span class="text-xs text-emerald-600 dark:text-emerald-400 font-medium flex items-center gap-1">
                        <x-icon name="check-circle" class="w-3 h-3" style="solid" />
                        Estável
                    </span>
                </div>
                <p class="text-[10px] text-slate-400 mt-1">Build: {{ $lastUpdate['build'] ?? '20240101' }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-blue-50 dark:bg-blue-900/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-blue-500 uppercase tracking-wider mb-2">Última Verificação</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-lg font-bold text-gray-900 dark:text-white">{{ now()->format('d/m/Y') }}</span>
                    <span class="text-xs text-slate-500">{{ now()->format('H:i') }}</span>
                </div>
                 <p class="text-[10px] text-slate-400 mt-1">Sistema verificado e íntegro</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 relative overflow-hidden group">
            <div class="absolute right-0 top-0 w-24 h-24 bg-purple-50 dark:bg-purple-900/10 rounded-bl-full -mr-4 -mt-4 transition-transform group-hover:scale-110"></div>
            <div class="relative z-10">
                <p class="text-xs font-bold text-purple-500 uppercase tracking-wider mb-2">Ambiente</p>
                <div class="flex items-baseline gap-2">
                    <span class="text-xl font-bold text-gray-900 dark:text-white">Laravel {{ app()->version() }}</span>
                </div>
                 <p class="text-[10px] text-slate-400 mt-1">PHP {{ phpversion() }}</p>
            </div>
        </div>
    </div>

    <!-- Update History -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-gray-50/50 dark:bg-slate-900/50">
            <h2 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider flex items-center gap-2">
                <x-icon name="clock-rotate-left" style="duotone" class="w-5 h-5 text-indigo-500" />
                Histórico de Atualizações
            </h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 dark:bg-slate-900/50 dark:text-slate-400">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-bold">Versão / Arquivo</th>
                        <th scope="col" class="px-6 py-4 font-bold">Data de Aplicação</th>
                        <th scope="col" class="px-6 py-4 font-bold">Status</th>
                        <th scope="col" class="px-6 py-4 font-bold text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                    @forelse($updates as $update)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                                    <x-icon name="file-zipper" style="duotone" class="w-5 h-5" />
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white">{{ $update['original_name'] }}</div>
                                    <div class="text-xs text-slate-500">{{ number_format($update['size'] / 1024, 2) }} KB</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="text-slate-600 dark:text-slate-400 font-medium">
                                {{ \Carbon\Carbon::parse($update['created_at'])->format('d/m/Y') }}
                            </div>
                            <div class="text-xs text-slate-500">
                                {{ \Carbon\Carbon::parse($update['created_at'])->format('H:i') }}
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            @php
                                $statusColors = [
                                    'applied' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/30 dark:text-emerald-400 border-emerald-100 dark:border-emerald-900/20',
                                    'failed' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-400 border-rose-100 dark:border-rose-900/20',
                                    'pending' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400 border-amber-100 dark:border-amber-900/20',
                                    'rolled_back' => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-300 border-slate-200 dark:border-slate-600',
                                    'uploaded' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400 border-blue-100 dark:border-blue-900/20',
                                ];
                                $statusIcons = [
                                    'applied' => 'check-circle',
                                    'failed' => 'circle-exclamation',
                                    'pending' => 'clock',
                                    'rolled_back' => 'rotate-left',
                                    'uploaded' => 'upload',
                                ];
                                $statusKey = $update['status'] ?? 'pending';
                            @endphp
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold border {{ $statusColors[$statusKey] ?? $statusColors['pending'] }}">
                                <x-icon name="{{ $statusIcons[$statusKey] ?? 'circle' }}" class="w-3 h-3" />
                                {{ strtoupper($update['status']) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right">
                             <a href="{{ route('admin.updates.show', $update['id']) }}" class="text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-800 dark:hover:text-indigo-300 transition-colors inline-flex items-center gap-1">
                                Detalhes
                                <x-icon name="arrow-right" class="w-4 h-4" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-slate-500">
                             <div class="w-16 h-16 bg-slate-50 dark:bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-4 text-slate-300">
                                <x-icon name="box-open" style="duotone" class="w-8 h-8" />
                            </div>
                            <p class="font-medium">Nenhum histórico de atualização encontrado.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
