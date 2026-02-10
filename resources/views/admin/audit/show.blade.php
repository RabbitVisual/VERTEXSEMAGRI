@extends('admin.layouts.admin')

@section('title', 'Detalhes do Log')

@section('content')
<div class="space-y-6 md:space-y-8 font-poppins pb-12">
    <!-- Page Header & Navigation -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50/50 dark:bg-indigo-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon name="magnifying-glass" style="duotone" class="w-7 h-7 md:w-8 md:h-8" />
                </div>
                <div>
                    <nav class="flex items-center gap-2 mb-1">
                        <a href="{{ route('admin.audit.index') }}" class="text-xs font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-widest hover:underline transition-all">Logs de Auditoria</a>
                        <x-icon name="chevron-right" class="w-3 h-3 text-gray-400" />
                        <span class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">Detalhes do Evento</span>
                    </nav>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white">
                        Explorar Log #{{ $log->id }}
                    </h1>
                </div>
            </div>

            <a href="{{ route('admin.audit.index') }}" class="inline-flex items-center gap-2 px-6 py-3.5 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 focus:ring-4 focus:ring-indigo-100 dark:text-gray-300 dark:bg-slate-700 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-all shadow-sm">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar aos Logs
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 text-sm">

        <!-- Details Column (2/3) -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Event Overview Card -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-50 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30 flex items-center justify-between">
                    <h2 class="text-base font-bold text-gray-900 dark:text-white flex items-center gap-3">
                        <x-icon name="circle-info" style="duotone" class="w-5 h-5 text-indigo-500" />
                        Visão Geral do Evento
                    </h2>
                    <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest bg-gray-100 dark:bg-slate-700 text-gray-600 dark:text-gray-400">
                        Log #{{ $log->id }}
                    </span>
                </div>

                <div class="p-8 grid grid-cols-1 sm:grid-cols-2 gap-x-12 gap-y-8">
                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Data & Hora</label>
                        <p class="text-base font-bold text-gray-900 dark:text-white">{{ $log->created_at->format('d/m/Y H:i:s') }}</p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Ação Realizada</label>
                        <div>
                            @php
                                $actionColor = match(true) {
                                    Str::contains($log->action, 'create') => 'emerald',
                                    Str::contains($log->action, 'update') => 'blue',
                                    Str::contains($log->action, 'delete') => 'red',
                                    default => 'slate'
                                };
                            @endphp
                            <span class="inline-flex items-center px-4 py-1 rounded-lg text-xs font-black uppercase tracking-widest bg-{{ $actionColor }}-100 text-{{ $actionColor }}-700 dark:bg-{{ $actionColor }}-900/30 dark:text-{{ $actionColor }}-300 border border-{{ $actionColor }}-200 dark:border-{{ $actionColor }}-800/50">
                                {{ $log->action }}
                            </span>
                        </div>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Módulo</label>
                        <p class="text-base font-bold text-gray-900 dark:text-white capitalize">{{ $log->module ?? '-' }}</p>
                    </div>

                    <div class="space-y-1">
                        <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Modelo de Dados</label>
                        <p class="text-base font-mono font-medium text-gray-600 dark:text-gray-300 break-all">{{ $log->model_type ?? '-' }} <span class="text-indigo-500 font-bold">({{ $log->model_id ?? 'N/A' }})</span></p>
                    </div>

                    <div class="sm:col-span-2 space-y-1">
                        <label class="text-[10px] font-black text-gray-400 dark:text-gray-500 uppercase tracking-widest">Descrição do Evento</label>
                        <div class="bg-gray-50 dark:bg-slate-900/50 rounded-2xl p-4 border border-gray-100 dark:border-slate-700/50">
                            <p class="text-base font-medium text-gray-700 dark:text-gray-300">{{ $log->description ?? 'Sem descrição adicional disponível.' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Value Changes -->
            @if($log->old_values || $log->new_values)
            <div class="space-y-6">
                @if($log->old_values)
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-red-50 dark:border-red-900/10 overflow-hidden">
                    <div class="px-8 py-5 border-b border-red-50 dark:border-red-900/10 bg-red-50/30 dark:bg-red-900/10 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-900/30 flex items-center justify-center text-red-600 dark:text-red-400">
                            <x-icon name="circle-minus" style="duotone" class="w-5 h-5" />
                        </div>
                        <h3 class="text-base font-bold text-red-700 dark:text-red-400">Valores Anteriores</h3>
                    </div>
                    <div class="p-8">
                        <div class="bg-slate-900 rounded-2xl p-6 relative overflow-hidden group">
                            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-100 transition-opacity">
                                <x-icon name="code" class="w-6 h-6 text-white" />
                            </div>
                            <pre class="text-xs font-mono text-indigo-300 overflow-x-auto leading-relaxed">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                </div>
                @endif

                @if($log->new_values)
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-emerald-50 dark:border-emerald-900/10 overflow-hidden">
                    <div class="px-8 py-5 border-b border-emerald-50 dark:border-emerald-900/10 bg-emerald-50/30 dark:bg-emerald-900/10 flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
                            <x-icon name="circle-plus" style="duotone" class="w-5 h-5" />
                        </div>
                        <h3 class="text-base font-bold text-emerald-700 dark:text-emerald-400">Novos Valores</h3>
                    </div>
                    <div class="p-8">
                        <div class="bg-slate-900 rounded-2xl p-6 relative overflow-hidden group border border-emerald-500/20">
                            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-100 transition-opacity">
                                <x-icon name="code" class="w-6 h-6 text-white" />
                            </div>
                            <pre class="text-xs font-mono text-emerald-400 overflow-x-auto leading-relaxed">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            @endif
        </div>

        <!-- Metadata Column (1/3) -->
        <div class="space-y-8">
            <!-- User Info Card -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 p-8">
                <div class="flex flex-col items-center text-center">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-indigo-500 to-indigo-700 flex items-center justify-center text-white text-4xl font-black shadow-xl shadow-indigo-200 dark:shadow-none transition-transform hover:scale-105">
                            {{ $log->user ? strtoupper(substr($log->user->name, 0, 1)) : 'S' }}
                        </div>
                        <div class="absolute -bottom-2 -right-2 w-10 h-10 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center shadow-lg border-4 border-slate-50 dark:border-slate-900">
                            <x-icon name="shield-check" style="duotone" class="w-5 h-5 text-indigo-500" />
                        </div>
                    </div>

                    <h3 class="text-xl font-black text-gray-900 dark:text-white mb-1">
                        {{ $log->user->name ?? 'Sistema' }}
                    </h3>
                    <p class="text-xs font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest mb-6">
                        {{ $log->user ? 'Administrador' : 'Processo Automático' }}
                    </p>

                    <div class="w-full space-y-4 pt-6 border-t border-gray-50 dark:border-slate-700">
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-gray-400 dark:text-gray-500 uppercase">E-mail</span>
                            <span class="font-bold text-gray-700 dark:text-gray-300 italic">{{ $log->user->email ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between items-center text-xs">
                            <span class="font-bold text-gray-400 dark:text-gray-500 uppercase">ID Interno</span>
                            <span class="font-mono px-2 py-0.5 bg-gray-100 dark:bg-slate-700 rounded text-gray-900 dark:text-white">#{{ $log->user->id ?? '0' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Context Info Card -->
            <div class="bg-slate-900 rounded-3xl p-8 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-32 h-32 bg-indigo-500/10 rounded-full -ml-16 -mt-16 blur-2xl"></div>

                <h3 class="relative z-10 text-white font-bold mb-6 flex items-center gap-3">
                    <x-icon name="globe" style="duotone" class="w-5 h-5 text-indigo-400" />
                    Contexto Técnico
                </h3>

                <div class="relative z-10 space-y-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Endereço IP</label>
                        <p class="text-sm font-mono text-indigo-200 bg-indigo-500/10 p-3 rounded-xl border border-indigo-500/20 shadow-inner">
                            {{ $log->ip_address ?? 'Endereço Indisponível' }}
                        </p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black text-slate-500 uppercase tracking-widest">Dispositivo / Agente</label>
                        <div class="bg-indigo-500/10 p-4 rounded-xl border border-indigo-500/20 h-32 overflow-y-auto custom-scrollbar">
                            <p class="text-xs font-mono text-slate-400 leading-relaxed">{{ $log->user_agent ?? 'Não registrado.' }}</p>
                        </div>
                    </div>

                    <div class="pt-4">
                        <div class="flex items-center gap-2 text-[10px] font-bold text-indigo-400 uppercase tracking-wider">
                            <div class="w-1.5 h-1.5 rounded-full bg-indigo-400 animate-pulse"></div>
                            Log Registrado com Sucesso
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: rgba(255,255,255,0.02);
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(99, 102, 241, 0.2);
        border-radius: 10px;
    }
</style>
@endsection
