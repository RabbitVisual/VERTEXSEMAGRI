@extends('admin.layouts.admin')

@section('title', 'Detalhes da Atualização')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="eye" class="w-5 h-5" />
                </div>
                <span>Detalhes da Atualização</span>
            </h1>
            <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">
                {{ $update['original_name'] ?? 'N/A' }}
            </p>
        </div>
        <a href="{{ route('admin.updates.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 dark:text-gray-300 dark:bg-slate-700 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
            <x-icon name="arrow-left" class="w-5 h-5" />
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
                                <x-icon name="file-pdf" class="w-5 h-5" />
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

