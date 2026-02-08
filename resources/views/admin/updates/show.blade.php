@extends('admin.layouts.admin')

@section('title', 'Detalhes da Atualização')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 md:w-7 md:h-7 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <span>Detalhes da Atualização</span>
            </h1>
            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">
                {{ $update['original_name'] ?? 'N/A' }}
            </p>
        </div>
        <a href="{{ route('admin.updates.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:text-gray-300 dark:bg-slate-700 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
            </svg>
            Voltar
        </a>
    </div>

    <!-- Update Info - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Informações da Atualização</h2>
        </div>
        <div class="p-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Informações da Atualização</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Status</p>
                @php
                    $statusColors = [
                        'uploaded' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                        'applying' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300',
                        'applied' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                        'failed' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300',
                        'rolled_back' => 'bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-300',
                    ];
                    $statusColor = $statusColors[$update['status']] ?? 'bg-gray-100 text-gray-800';
                    $statusLabels = [
                        'uploaded' => 'Enviado',
                        'applying' => 'Aplicando',
                        'applied' => 'Aplicado',
                        'failed' => 'Falhou',
                        'rolled_back' => 'Revertido',
                    ];
                    $statusLabel = $statusLabels[$update['status']] ?? $update['status'];
                @endphp
                <p class="text-lg font-semibold mt-1">
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                        {{ $statusLabel }}
                    </span>
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Data de Criação</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                    {{ isset($update['created_at']) ? \Carbon\Carbon::parse($update['created_at'])->format('d/m/Y H:i:s') : 'N/A' }}
                </p>
            </div>
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Tamanho do Arquivo</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                    {{ isset($update['size']) ? number_format($update['size'] / 1024, 2) . ' KB' : 'N/A' }}
                </p>
            </div>
            @if(isset($update['applied_at']))
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Data de Aplicação</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                    {{ \Carbon\Carbon::parse($update['applied_at'])->format('d/m/Y H:i:s') }}
                </p>
            </div>
            @endif
            @if(isset($update['files_applied']))
            <div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Arquivos Aplicados</p>
                <p class="text-lg font-semibold text-gray-900 dark:text-white mt-1">
                    {{ count($update['files_applied']) }} arquivo(s)
                </p>
            </div>
            @endif
            @if(isset($update['options']))
            <div class="md:col-span-2">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Opções Selecionadas</p>
                <div class="flex flex-wrap gap-3">
                    @if(isset($update['options']['create_backup']) && $update['options']['create_backup'])
                        @if(isset($update['backup_file']) && !empty($update['backup_file']))
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-800 dark:text-emerald-300 rounded-lg text-xs font-medium">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Backup criado
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 rounded-lg text-xs font-medium">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Backup será criado ao aplicar
                            </span>
                        @endif
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-amber-100 dark:bg-amber-900/30 text-amber-800 dark:text-amber-300 rounded-lg text-xs font-medium">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                            </svg>
                            Backup não será criado
                        </span>
                    @endif
                    @if(isset($update['options']['auto_apply']) && $update['options']['auto_apply'])
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-800 dark:text-indigo-300 rounded-lg text-xs font-medium">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                            </svg>
                            Aplicação automática
                        </span>
                    @endif
                </div>
            </div>
            @endif
            @if(isset($update['backup_file']) && !empty($update['backup_file']))
            <div class="md:col-span-2">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Informações do Backup</p>
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-emerald-900 dark:text-emerald-200">
                                Backup disponível para rollback
                            </p>
                            <p class="text-xs text-emerald-700 dark:text-emerald-300 mt-1">
                                Arquivo: <code class="bg-emerald-100 dark:bg-emerald-900/50 px-1.5 py-0.5 rounded">{{ $update['backup_file'] }}</code>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @elseif(isset($update['options']['create_backup']) && $update['options']['create_backup'] && $update['status'] === 'uploaded')
            <div class="md:col-span-2">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">Informações do Backup</p>
                <div class="p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex items-start gap-2">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mt-0.5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-blue-900 dark:text-blue-200">
                                Backup será criado automaticamente
                            </p>
                            <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">
                                O backup será criado automaticamente quando você aplicar esta atualização. Isso permite reverter mudanças se necessário.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        </div>
    </div>

    <!-- Actions - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Ações</h2>
        </div>
        <div class="p-6">
            <div class="flex flex-wrap gap-3">
                @if($update['status'] === 'uploaded')
                    <form action="{{ route('admin.updates.apply', $update['id']) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors" onclick="return confirm('Tem certeza que deseja aplicar esta atualização?')">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Aplicar Atualização
                        </button>
                    </form>
                @endif
                @if($update['status'] === 'applied' && $backup && $backup['exists'])
                    <form action="{{ route('admin.updates.rollback', $update['id']) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-amber-600 rounded-lg hover:bg-amber-700 focus:ring-4 focus:ring-amber-300 dark:bg-amber-600 dark:hover:bg-amber-700 dark:focus:ring-amber-800 transition-colors" onclick="return confirm('Tem certeza que deseja reverter esta atualização?')">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                            </svg>
                            Reverter Atualização
                        </button>
                    </form>
                    <a href="{{ route('admin.updates.download-backup', $update['id']) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5v-12.75" />
                        </svg>
                        Baixar Backup
                    </a>
                @endif
                <form action="{{ route('admin.updates.destroy', $update['id']) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja deletar esta atualização?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                        Deletar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Files List - Flowbite Card -->
    @if(!empty($files))
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Arquivos Aplicados ({{ count($files) }})</h2>
        </div>
        <div class="p-6">
            <div class="space-y-2 max-h-96 overflow-y-auto">
                @foreach($files as $file)
                    <div class="flex items-center gap-2 text-sm text-gray-700 dark:text-gray-300 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50">
                        <svg class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                        </svg>
                        <code class="text-xs">{{ $file }}</code>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Error Info - Flowbite Alert -->
    @if(isset($update['error']))
    <div class="flex items-start p-4 text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800" role="alert">
        <svg class="flex-shrink-0 w-5 h-5 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94 8.28 7.22z" clip-rule="evenodd"/>
        </svg>
        <div class="ml-3 flex-1">
            <h3 class="text-sm font-semibold mb-1">Erro na Aplicação</h3>
            <p class="text-sm">{{ $update['error'] }}</p>
        </div>
    </div>
    @endif
</div>
@endsection

