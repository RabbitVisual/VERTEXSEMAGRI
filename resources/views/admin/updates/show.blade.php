@extends('admin.layouts.admin')

@section('title', 'Detalhes da Atualização')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12 font-sans">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="box-open" class="w-6 h-6 md:w-7 md:h-7 text-white" style="duotone" />
                </div>
                <span>Detalhes do <span class="text-indigo-600 dark:text-indigo-400">Pacote</span></span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <a href="{{ route('admin.updates.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Atualizações</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <span class="text-gray-900 dark:text-white font-medium">Visualizar</span>
            </nav>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.updates.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-gray-700 dark:text-gray-200 bg-white dark:bg-slate-800 border border-gray-300 dark:border-slate-600 rounded-xl hover:bg-gray-50 dark:hover:bg-slate-700 focus:ring-4 focus:ring-gray-100 dark:focus:ring-slate-700 transition-all shadow-sm">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
            @if($update['status'] === 'uploaded' || $update['status'] === 'failed')
                 <form action="{{ route('admin.updates.apply', $update['id']) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja aplicar esta atualização? O sistema pode ficar indisponível por alguns segundos.');">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:focus:ring-emerald-800 transition-all shadow-md shadow-emerald-500/20 active:scale-95 group">
                        <x-icon name="bolt" class="w-5 h-5 group-hover:scale-110 transition-transform" />
                        Aplicar Agora
                    </button>
                </form>
            @endif
             <form action="{{ route('admin.updates.destroy', $update['id']) }}" method="POST" class="inline-block" onsubmit="return confirm('Tem certeza que deseja excluir este pacote de atualização?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 text-sm font-bold text-rose-600 bg-rose-50 rounded-xl hover:bg-rose-100 border border-rose-200 focus:ring-4 focus:ring-rose-100 transition-all shadow-sm active:scale-95 group dark:bg-rose-900/20 dark:text-rose-400 dark:border-rose-900/30 dark:hover:bg-rose-900/40">
                    <x-icon name="trash" class="w-5 h-5" />
                </button>
            </form>
        </div>
    </div>

    <!-- Error Alert -->
    @if(isset($update['error']))
    <div class="mb-6 rounded-2xl bg-rose-50 dark:bg-rose-900/10 border border-rose-100 dark:border-rose-900/30 p-4 animate-shake">
        <div class="flex items-start gap-3">
            <x-icon name="circle-exclamation" class="w-6 h-6 text-rose-500 mt-0.5" />
            <div>
                <h3 class="text-sm font-bold text-rose-800 dark:text-rose-400 mb-1">Erro na Aplicação</h3>
                <p class="text-sm text-rose-700 dark:text-rose-300">{{ $update['error'] }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Info -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700 flex items-center justify-between bg-gray-50/50 dark:bg-slate-900/50">
                    <h2 class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider flex items-center gap-2">
                        <x-icon name="file-zipper" style="duotone" class="w-5 h-5 text-indigo-500" />
                        Conteúdo do Pacote
                    </h2>
                    <span class="text-xs font-medium text-slate-500">
                        {{ isset($files) ? count($files) : 0 }} arquivos encontrados
                    </span>
                </div>

                <div class="max-h-[500px] overflow-y-auto p-0">
                    @if(isset($files) && count($files) > 0)
                        <table class="w-full text-sm text-left">
                            <tbody class="divide-y divide-gray-100 dark:divide-slate-700">
                                @foreach($files as $file)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                    <td class="px-6 py-3">
                                        <div class="flex items-center gap-3">
                                            <x-icon name="file-code" class="w-4 h-4 text-slate-400" />
                                            <span class="font-mono text-xs text-slate-600 dark:text-slate-400 break-all">{{ $file }}</span>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="p-8 text-center text-slate-500">
                            <p>Nenhum arquivo listado ou erro ao ler o pacote.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Details -->
        <div class="lg:col-span-1 space-y-6">
            <!-- Status Card -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl p-6 shadow-sm border border-gray-100 dark:border-slate-700 relative overflow-hidden">
                <h3 class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-4">Status Atual</h3>
                 @php
                    $statusColors = [
                        'uploaded' => 'bg-blue-50 text-blue-600 dark:bg-blue-900/20 dark:text-blue-400 border-blue-100 dark:border-blue-900/30',
                        'applying' => 'bg-yellow-50 text-yellow-600 dark:bg-yellow-900/20 dark:text-yellow-400 border-yellow-100 dark:border-yellow-900/30',
                        'applied' => 'bg-emerald-50 text-emerald-600 dark:bg-emerald-900/20 dark:text-emerald-400 border-emerald-100 dark:border-emerald-900/30',
                        'failed' => 'bg-rose-50 text-rose-600 dark:bg-rose-900/20 dark:text-rose-400 border-rose-100 dark:border-rose-900/30',
                        'rolled_back' => 'bg-gray-50 text-gray-600 dark:bg-gray-900/20 dark:text-gray-400 border-gray-200 dark:border-gray-700',
                    ];
                    $statusIcons = [
                        'uploaded' => 'cloud-arrow-up',
                        'applying' => 'spinner',
                        'applied' => 'check-circle',
                        'failed' => 'circle-exclamation',
                        'rolled_back' => 'rotate-left',
                    ];
                    $statusLabels = [
                        'uploaded' => 'Pronto para Aplicar',
                        'applying' => 'Instalando...',
                        'applied' => 'Instalado com Sucesso',
                        'failed' => 'Falha na Instalação',
                        'rolled_back' => 'Revertido',
                    ];
                    $statusKey = $update['status'] ?? 'uploaded';
                @endphp

                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center {{ $statusColors[$statusKey] }} border">
                        <x-icon name="{{ $statusIcons[$statusKey] }}" class="w-6 h-6 {{ $statusKey === 'applying' ? 'animate-spin' : '' }}" />
                    </div>
                    <div>
                        <p class="font-bold text-gray-900 dark:text-white">{{ $statusLabels[$statusKey] }}</p>
                        <p class="text-xs text-slate-400">
                             {{ isset($update['updated_at']) ? \Carbon\Carbon::parse($update['updated_at'])->diffForHumans() : '' }}
                        </p>
                    </div>
                </div>

                <div class="space-y-4 pt-4 border-t border-gray-100 dark:border-slate-700">
                    <div>
                        <p class="text-xs text-slate-500 mb-1">Arquivo</p>
                        <p class="font-bold text-sm text-gray-900 dark:text-white truncate">{{ $update['original_name'] }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                             <p class="text-xs text-slate-500 mb-1">Tamanho</p>
                             <p class="font-bold text-sm text-gray-900 dark:text-white">{{ number_format($update['size'] / 1024, 2) }} KB</p>
                        </div>
                        <div>
                             <p class="text-xs text-slate-500 mb-1">Data</p>
                             <p class="font-bold text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($update['created_at'])->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Backup Card -->
            @if(isset($update['options']['create_backup']) && $update['options']['create_backup'])
            <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-3xl p-6 border border-indigo-100 dark:border-indigo-900/30">
                <div class="flex items-center gap-3 mb-4">
                     <div class="p-2 bg-white dark:bg-indigo-900/40 rounded-lg text-indigo-600 dark:text-indigo-400 shadow-sm">
                        <x-icon name="shield-check" class="w-5 h-5" />
                    </div>
                    <h3 class="font-bold text-indigo-900 dark:text-indigo-200">Backup de Segurança</h3>
                </div>

                @if(isset($backup) && $backup)
                    <div class="bg-white dark:bg-slate-800 rounded-xl p-4 border border-indigo-100 dark:border-indigo-900/30 mb-4">
                        <div class="flex items-center gap-3">
                            <x-icon name="file-zipper" class="w-5 h-5 text-indigo-500" />
                            <div class="overflow-hidden">
                                <p class="text-xs font-bold text-indigo-900 dark:text-indigo-300 truncate">{{ basename($backup) }}</p>
                                <p class="text-[10px] text-slate-500">Backup automático pré-instalação</p>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('admin.updates.downloadBackup', $update['id']) }}" class="block w-full py-2.5 text-center text-xs font-bold text-indigo-600 bg-white border border-indigo-200 rounded-lg hover:bg-indigo-50 transition-colors uppercase tracking-wide shadow-sm">
                        Baixar Backup
                    </a>
                @else
                    <p class="text-sm text-indigo-800 dark:text-indigo-300">Backup configurado para ser criado antes da instalação.</p>
                @endif
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
