@extends('admin.layouts.app')

@section('title', 'Backup e Restauração')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="database" class="w-5 h-5 md:w-6 md:h-6 text-white" />
                </div>
                Backup e Restauração
            </h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm md:text-base max-w-2xl">
                Gerencie os backups do banco de dados do sistema. Crie cópias de segurança periodicamente para garantir a segurança dos dados.
            </p>
        </div>
        <form action="{{ route('admin.backup.create') }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-md transition-all hover:scale-105 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                <x-icon name="plus" class="w-5 h-5" />
                Criar Novo Backup
            </button>
        </form>
    </div>

    <!-- Alerts -->
    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400 border border-green-200 dark:border-green-800 flex items-center gap-2" role="alert">
        <x-icon name="circle-check" class="w-5 h-5 flex-shrink-0" />
        <span class="font-medium">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 border border-red-200 dark:border-red-800 flex items-center gap-2" role="alert">
        <x-icon name="triangle-exclamation" class="w-5 h-5 flex-shrink-0" />
        <span class="font-medium">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Backup List -->
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700/50 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-4 font-semibold">Arquivo</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Tamanho</th>
                        <th scope="col" class="px-6 py-4 font-semibold">Data de Criação</th>
                        <th scope="col" class="px-6 py-4 font-semibold text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($backups as $backup)
                    <tr class="bg-white hover:bg-gray-50 dark:bg-gray-800 dark:hover:bg-gray-700/50 transition-colors">
                        <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap flex items-center gap-3">
                            <x-icon name="file-sql" class="w-5 h-5 text-indigo-500" />
                            {{ $backup['name'] }}
                        </td>
                        <td class="px-6 py-4">
                            {{ number_format($backup['size'] / 1024 / 1024, 2) }} MB
                        </td>
                        <td class="px-6 py-4">
                            {{ \Carbon\Carbon::parse($backup['created_at'])->format('d/m/Y H:i:s') }}
                            <span class="text-xs text-gray-500 ml-1">({{ \Carbon\Carbon::parse($backup['created_at'])->diffForHumans() }})</span>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('admin.backup.restore', $backup['name']) }}" method="POST" class="inline" onsubmit="return confirm('ATENÇÃO: Isso irá substituir TODOS os dados atuais pelos do backup. Deseja continuar?')">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-amber-600 hover:text-amber-900 bg-amber-50 hover:bg-amber-100 dark:bg-amber-900/20 dark:text-amber-400 dark:hover:text-amber-300 dark:hover:bg-amber-900/30 rounded transition-colors" title="Restaurar este backup">
                                        <x-icon name="rotate-right" class="w-3.5 h-3.5" />
                                        Restaurar
                                    </button>
                                </form>
                                <a href="{{ route('admin.backup.download', $backup['name']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:text-blue-300 dark:hover:bg-blue-900/30 rounded transition-colors" title="Download Backup">
                                    <x-icon name="download" class="w-3.5 h-3.5" />
                                    Download
                                </a>
                                <form action="{{ route('admin.backup.destroy', $backup['name']) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja deletar permanentemente este backup?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold uppercase tracking-wider text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:text-red-400 dark:hover:text-red-300 dark:hover:bg-red-900/30 rounded transition-colors" title="Excluir Backup">
                                        <x-icon name="trash" class="w-3.5 h-3.5" />
                                        Excluir
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-full flex items-center justify-center mb-4">
                                    <x-icon name="database" class="w-8 h-8 text-gray-400 dark:text-gray-500" />
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Nenhum backup encontrado</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Crie seu primeiro backup para garantir a segurança dos dados.</p>
                                <form action="{{ route('admin.backup.create') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow transition-colors">
                                        <x-icon name="plus" class="w-4 h-4" />
                                        Criar Backup Agora
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
