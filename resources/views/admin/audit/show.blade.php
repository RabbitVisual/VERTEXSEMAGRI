@extends('admin.layouts.admin')

@section('title', 'Detalhes do Log')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.audit.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Logs de Auditoria</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">Detalhes</span>
            </nav>
        </div>
        <a href="{{ route('admin.audit.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:text-gray-300 dark:bg-slate-700 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
            <x-icon name="arrow-left" class="w-5 h-5" />
            Voltar
        </a>
    </div>

    <!-- Informações do Log - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Informações do Log</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                    <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400 w-48">Data/Hora:</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                    </tr>
                    <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Usuário:</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $log->user->name ?? 'Sistema' }}</td>
                    </tr>
                    <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Ação:</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-800 dark:bg-slate-700 dark:text-gray-300">{{ $log->action }}</span>
                        </td>
                    </tr>
                    <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Módulo:</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $log->module ?? '-' }}</td>
                    </tr>
                    <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Model:</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $log->model_type ?? '-' }}</td>
                    </tr>
                    <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Model ID:</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $log->model_id ?? '-' }}</td>
                    </tr>
                    <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">Descrição:</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $log->description ?? '-' }}</td>
                    </tr>
                    <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">IP:</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-mono">{{ $log->ip_address ?? '-' }}</td>
                    </tr>
                    <tr class="bg-white dark:bg-slate-800 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-500 dark:text-gray-400">User Agent:</td>
                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-white font-mono text-xs break-all">{{ $log->user_agent ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    @if($log->old_values || $log->new_values)
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        @if($log->old_values)
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                    Valores Antigos
                </h3>
            </div>
            <div class="p-6">
                <pre class="p-4 bg-gray-50 dark:bg-slate-900 rounded-lg overflow-x-auto text-xs font-mono text-gray-800 dark:text-gray-300 border border-gray-200 dark:border-slate-700">{{ json_encode($log->old_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </div>
        @endif

        @if($log->new_values)
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Valores Novos
                </h3>
            </div>
            <div class="p-6">
                <pre class="p-4 bg-gray-50 dark:bg-slate-900 rounded-lg overflow-x-auto text-xs font-mono text-gray-800 dark:text-gray-300 border border-gray-200 dark:border-slate-700">{{ json_encode($log->new_values, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </div>
        @endif
    </div>
    @endif
</div>
@endsection
