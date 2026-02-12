@extends('Co-Admin.layouts.app')

@section('title', 'Detalhes do Poste')

@section('content')
<div class="space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 p-8 shadow-sm">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 shadow-inner border border-indigo-100 dark:border-indigo-800/50">
                    <x-icon name="utility-pole" class="w-7 h-7" />
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Poste <span class="text-indigo-600 dark:text-indigo-400">#{{ $poste->codigo }}</span>
                    </h1>
                    <nav class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-widest mt-1">
                        <a href="{{ route('co-admin.iluminacao.postes.index') }}" class="hover:text-indigo-500 transition-colors">Inventário</a>
                        <x-icon name="chevron-right" class="w-2.5 h-2.5" />
                        <span class="text-slate-500">Detalhes do Ativo</span>
                    </nav>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <x-iluminacao::button href="{{ route('co-admin.iluminacao.postes.edit', $poste->id) }}" variant="outline" icon="pen-to-square">
                    Editar Cadastro
                </x-iluminacao::button>
                <x-iluminacao::button href="{{ route('co-admin.iluminacao.postes.index') }}" variant="outline" icon="arrow-left">
                    Voltar
                </x-iluminacao::button>
            </div>
        </div>
    </div>

    <!-- Details Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Info Column -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Technical Specs -->
            <x-iluminacao::card>
                <div class="flex items-center gap-3 mb-8 pb-4 border-b border-slate-100 dark:border-slate-700/50">
                    <x-icon name="microchip" class="w-5 h-5 text-indigo-500" />
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">Especificações Técnicas</h3>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/40 border border-slate-100 dark:border-slate-800/50">
                        <div class="w-12 h-12 rounded-xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-amber-500">
                            <x-icon name="lightbulb" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Iluminação</p>
                            <p class="text-base font-bold text-slate-700 dark:text-slate-200">
                                {{ $poste->tipo_lampada ? ucfirst($poste->tipo_lampada) : 'Não definido' }}
                                <span class="text-xs font-medium text-slate-400 ml-1">({{ $poste->potencia ?? '0' }}W)</span>
                            </p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/40 border border-slate-100 dark:border-slate-800/50">
                        <div class="w-12 h-12 rounded-xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-blue-500">
                            <x-icon name="tower-broadcast" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Tipo de Estrutura</p>
                            <p class="text-base font-bold text-slate-700 dark:text-slate-200">{{ ucfirst($poste->tipo_poste ?? 'Circular') }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/40 border border-slate-100 dark:border-slate-800/50">
                        <div class="w-12 h-12 rounded-xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-purple-500">
                            <x-icon name="plug" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Transformador (Trafo)</p>
                            <p class="text-base font-bold text-slate-700 dark:text-slate-200 font-mono">{{ $poste->trafo ?? 'Sem ID Vinculado' }}</p>
                        </div>
                    </div>

                    <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 dark:bg-slate-900/40 border border-slate-100 dark:border-slate-800/50">
                        <div class="w-12 h-12 rounded-xl bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-emerald-500">
                            <x-icon name="diagram-project" class="w-6 h-6" />
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Barramento</p>
                            <p class="text-base font-bold text-slate-700 dark:text-slate-200">{{ $poste->barramento ? 'Sim, Instalado' : 'Não Possui' }}</p>
                        </div>
                    </div>
                </div>
            </x-iluminacao::card>

            <!-- Observations -->
            <x-iluminacao::card>
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100 dark:border-slate-700/50">
                    <x-icon name="align-left" class="w-5 h-5 text-indigo-500" />
                    <h3 class="text-lg font-bold text-slate-800 dark:text-white">Observações Técnicas</h3>
                </div>
                <div class="p-6 rounded-2xl bg-slate-50 dark:bg-slate-900/40 border border-dashed border-slate-200 dark:border-slate-700">
                    <p class="text-sm text-slate-600 dark:text-slate-400 leading-relaxed italic">
                        {{ $poste->observacoes ?? 'Nenhuma observação técnica cadastrada para este ativo.' }}
                    </p>
                </div>
            </x-iluminacao::card>
        </div>

        <!-- Sidebar Info -->
        <div class="space-y-8">
            <!-- Map Card -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 shadow-sm overflow-hidden group">
                <div class="h-64 relative">
                    <x-map
                        :latitude="$poste->latitude"
                        :longitude="$poste->longitude"
                        height="256px"
                        zoom="16"
                        icon-type="ponto_luz"
                        static
                    />
                    <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent pointer-events-none"></div>
                    <div class="absolute bottom-4 left-4 right-4 flex justify-between items-end">
                        <div class="px-3 py-1.5 bg-white/90 dark:bg-slate-900/90 backdrop-blur-md rounded-xl shadow-lg border border-white/20">
                            <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Coordenadas</p>
                            <p class="text-xs font-mono font-bold text-indigo-600 dark:text-indigo-400">{{ $poste->latitude }}, {{ $poste->longitude }}</p>
                        </div>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ $poste->latitude }},{{ $poste->longitude }}"
                           target="_blank"
                           class="w-10 h-10 rounded-xl bg-indigo-600 text-white flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
                            <x-icon name="location-arrow" class="w-5 h-5" />
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 flex items-center gap-2">
                        <x-icon name="map-pin" class="w-3 h-3 text-rose-500" />
                        Endereço Registrado
                    </p>
                    <p class="text-sm font-bold text-slate-700 dark:text-slate-200 mb-1 italic leading-snug">{{ $poste->logradouro }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $poste->bairro ?? 'Bairro não especificado' }}</p>
                </div>
            </div>

            <!-- Health/Status Card -->
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 shadow-sm p-6">
                <h4 class="text-xs font-black text-slate-400 uppercase tracking-widest mb-6">Status de Conservação</h4>

                @php
                    $hColor = match($poste->condicao) {
                        'bom' => 'emerald',
                        'regular' => 'amber',
                        'ruim' => 'orange',
                        'critico' => 'rose',
                        default => 'slate'
                    };
                    $hLabel = match($poste->condicao) {
                        'bom' => 'Excelente Estado',
                        'regular' => 'Estado Regular',
                        'ruim' => 'Necessita Manutenção',
                        'critico' => 'Troca Emergencial',
                        default => 'Desconhecido'
                    };
                @endphp

                <div class="flex flex-col items-center text-center">
                    <div class="relative w-24 h-24 mb-4">
                        <div class="absolute inset-0 rounded-full border-4 border-{{ $hColor }}-100 dark:border-{{ $hColor }}-900/30"></div>
                        <div class="absolute inset-0 rounded-full border-4 border-{{ $hColor }}-500 border-t-transparent animate-spin-slow"></div>
                        <div class="absolute inset-0 flex items-center justify-center text-{{ $hColor }}-600">
                           <x-icon name="shield-check" class="w-10 h-10" />
                        </div>
                    </div>
                    <p class="text-lg font-black text-{{ $hColor }}-600 dark:text-{{ $hColor }}-400 uppercase tracking-tight">{{ $hLabel }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium italic">Última inspeção automática via sistema</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
