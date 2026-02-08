@extends('Co-Admin.layouts.app')

@section('title', 'Ordens de Serviço')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="Ordens" class="w-6 h-6" />
                Ordens de Serviço
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Gerenciamento de ordens de serviço</p>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('ordens.relatorio.demandas-dia.pdf') }}" target="_blank" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-green-600 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:bg-green-500 dark:hover:bg-green-600 transition-all duration-200">
                <x-icon name="eye" class="w-5 h-5" />
                        </x-ordens::button>
                        <x-ordens::button href="{{ route('ordens.print', $ordem) }}" target="_blank" variant="outline" size="sm">
                            <x-ordens::icon name="printer" class="w-4 h-4" />
                        </x-ordens::button>
                        <x-ordens::button href="{{ route('ordens.edit', $ordem) }}" variant="outline" size="sm">
                            <x-icon name="file-pdf" class="w-5 h-5" />
                    <p class="text-gray-500 dark:text-gray-400 mb-4">Nenhuma ordem de serviço encontrada</p>
                    <x-ordens::button href="{{ route('ordens.create') }}" variant="primary">
                        <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Criar Primeira OS
                    </x-ordens::button>
                </td>
            </tr>
        @endforelse
    </x-ordens::data-table>
</div>
@endsection
