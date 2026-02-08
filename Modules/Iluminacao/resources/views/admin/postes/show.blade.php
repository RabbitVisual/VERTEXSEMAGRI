@extends('admin.layouts.admin')

@section('title', 'Detalhes do Poste')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Poste {{ $poste->codigo }}</h1>
        <a href="{{ route('admin.iluminacao.postes.index') }}" class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">Voltar</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informações Técnicas</h3>
            <dl class="grid grid-cols-1 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo de Lâmpada</dt>
                    <dd class="text-sm text-gray-900 dark:text-white">{{ ucfirst($poste->tipo_lampada ?? '-') }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Potência</dt>
                    <dd class="text-sm text-gray-900 dark:text-white">{{ $poste->potencia ? $poste->potencia . 'W' : '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Trafo</dt>
                    <dd class="text-sm text-gray-900 dark:text-white">{{ $poste->trafo ?? 'Não' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Barramento</dt>
                    <dd class="text-sm text-gray-900 dark:text-white">{{ $poste->barramento ? 'Sim' : 'Não' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Localização</h3>
            <dl class="grid grid-cols-1 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Logradouro</dt>
                    <dd class="text-sm text-gray-900 dark:text-white">{{ $poste->logradouro ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Bairro</dt>
                    <dd class="text-sm text-gray-900 dark:text-white">{{ $poste->bairro ?? '-' }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Coordenadas</dt>
                    <dd class="text-sm text-gray-900 dark:text-white">
                        {{ $poste->latitude }}, {{ $poste->longitude }}
                    </dd>
                </div>
            </dl>
        </div>
    </div>
</div>
@endsection
