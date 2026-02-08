@extends('admin.layouts.admin')

@section('title', 'Backup e Restauração')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="database" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Backup e Restauração</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">Backup</span>
            </nav>
        </div>
        <form action="{{ route('admin.backup.create') }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-lg hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-300 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-800 transition-colors">
                <x-icon name="plus" class="w-5 h-5" />
                Criar Backup
            </button>
        </form>
    </div>

    <!-- Backups Disponíveis - Flowbite Card -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Backups Disponíveis</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-slate-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Nome do Arquivo</th>
                        <th scope="col" class="px-6 py-3">Tamanho</th>
                        <th scope="col" class="px-6 py-3">Data de Criação</th>
                        <th scope="col" class="px-6 py-3">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($backups as $backup)
                    <tr class="bg-white border-b dark:bg-slate-800 dark:border-slate-700 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">{{ $backup['name'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ number_format($backup['size'] / 1024, 2) }} KB</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">{{ $backup['created_at'] }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <form action="{{ route('admin.backup.restore', $backup['name']) }}" method="POST" class="inline" onsubmit="return confirm('⚠️ ATENÇÃO: Esta ação irá substituir TODOS os dados do banco de dados atual pelos dados do backup. Tem certeza que deseja continuar?')">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors" title="Restaurar Backup">
                                        <x-icon name="rotate-left" class="w-4 h-4" />
                                        <span>Restaurar</span>
                                    </button>
                                </form>
                                <a href="{{ route('admin.backup.download', $backup['name']) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors" title="Download">
                                    <x-icon name="download" class="w-4 h-4" />
                                    Download
                                </a>
                                <form action="{{ route('admin.backup.destroy', $backup['name']) }}" method="POST" class="inline" onsubmit="return confirm('Tem certeza que deseja deletar este backup?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 text-sm font-medium text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 transition-colors" title="Deletar">
                                        <x-icon name="trash-can" class="w-4 h-4" />
                                        Deletar
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <x-icon name="database" class="w-16 h-16 text-gray-400 dark:text-gray-600 mb-4" />
                                <p class="text-sm text-gray-500 dark:text-gray-400">Nenhum backup encontrado</p>
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
