@extends('admin.layouts.admin')

@section('title', 'Detalhes do Poste - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-xl flex items-center justify-center shadow-lg text-white">
                    <x-icon name="utility-pole" style="duotone" class="w-6 h-6" />
                </div>
                <span>Ativo: #{{ $poste->codigo }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 mt-2">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <a href="{{ route('admin.iluminacao.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Iluminação</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <a href="{{ route('admin.iluminacao.postes.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Postes</a>
                <x-icon name="chevron-right" class="w-3 h-3 text-slate-400" />
                <span class="text-gray-900 dark:text-white font-medium">Detalhes</span>
            </nav>
        </div>
        <div class="flex gap-2">
             <a href="{{ route('admin.iluminacao.postes.index') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 transition-all shadow-sm">
                <x-icon name="arrow-left" class="w-4 h-4" />
                Voltar
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Detalhes Técnicos -->
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/20 flex items-center gap-2">
                    <x-icon name="microchip" style="duotone" class="w-5 h-5 text-indigo-500" />
                    <h3 class="font-bold text-gray-900 dark:text-white">Especificações Técnicas</h3>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-8">
                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-indigo-50 dark:bg-indigo-900/20 rounded-xl text-indigo-600 dark:text-indigo-400">
                            <x-icon name="bolt" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest font-bold mb-1">Potência Nominal</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $poste->potencia ?? '0' }}W</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl text-amber-600 dark:text-amber-400">
                            <x-icon name="lightbulb" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest font-bold mb-1">Tipo de Iluminação</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ ucfirst($poste->tipo_lampada ?? 'Não definido') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl text-blue-600 dark:text-blue-400">
                            <x-icon name="network-wired" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest font-bold mb-1">Trafo Associado</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $poste->trafo ?? 'S/N' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4">
                        <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl text-emerald-600 dark:text-emerald-400">
                            <x-icon name="plug" style="duotone" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest font-bold mb-1">Barramento</p>
                            <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $poste->barramento ? 'Presente' : 'Não' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Localização Detalhada -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/20 flex items-center gap-2">
                    <x-icon name="location-dot" style="duotone" class="w-5 h-5 text-indigo-500" />
                    <h3 class="font-bold text-gray-900 dark:text-white">Endereçamento & GPS</h3>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest font-bold mb-1">Logradouro</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $poste->logradouro ?? 'Não informado' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-widest font-bold mb-1">Bairro/Comunidade</p>
                            <p class="text-gray-900 dark:text-white font-medium">{{ $poste->bairro ?? 'Não informado' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar de Ações e Mapa -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
                <div class="h-48 bg-slate-200 dark:bg-slate-700 relative overflow-hidden group">
                     <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none z-10"></div>
                     <x-icon name="map-location-dot" style="duotone" class="w-16 h-16 text-gray-300 dark:text-gray-600 absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" />
                     <div class="absolute bottom-4 left-4 z-20">
                         <p class="text-white font-bold text-xs bg-indigo-600/80 backdrop-blur-sm px-2 py-1 rounded">
                             GPS: {{ $poste->latitude }}, {{ $poste->longitude }}
                         </p>
                     </div>
                </div>
                <div class="p-4 bg-gray-50/50 dark:bg-slate-900/50">
                    <a href="https://www.google.com/maps/search/?api=1&query={{ $poste->latitude }},{{ $poste->longitude }}" target="_blank" class="w-full flex items-center justify-center gap-2 py-3 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl text-sm font-bold text-gray-700 dark:text-gray-300 hover:bg-gray-50 transition-all shadow-sm">
                        <x-icon name="location-arrow" class="w-4 h-4 text-indigo-500" />
                        Navegar via Google Maps
                    </a>
                </div>
            </div>

            <!-- Ações -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-200 dark:border-slate-700 p-6">
                <h4 class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Ações do Ativo</h4>
                <div class="space-y-3">
                    <button class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-700 hover:bg-indigo-50 dark:hover:bg-indigo-900/20 hover:border-indigo-200 transition-all text-sm font-semibold text-gray-700 dark:text-gray-300 group">
                        <x-icon name="pen-to-square" style="duotone" class="w-5 h-5 text-gray-400 group-hover:text-indigo-500" />
                        Editar Cadastro
                    </button>
                    <button class="w-full flex items-center gap-3 px-4 py-3 rounded-xl border border-gray-200 dark:border-slate-700 hover:bg-red-50 dark:hover:bg-red-900/20 hover:border-red-200 transition-all text-sm font-semibold text-gray-700 dark:text-gray-300 group">
                        <x-icon name="trash-can" style="duotone" class="w-5 h-5 text-gray-400 group-hover:text-red-500" />
                        Remover Ativo
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
