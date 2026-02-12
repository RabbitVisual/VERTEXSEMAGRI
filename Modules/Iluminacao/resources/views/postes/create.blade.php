@extends('Co-Admin.layouts.app')

@section('title', 'Novo Poste')

@section('content')
<div class="space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 p-8 shadow-sm">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-64 h-64 bg-indigo-500/5 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400 shadow-inner border border-indigo-100 dark:border-indigo-800/50">
                    <x-icon name="plus" class="w-7 h-7" />
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Novo <span class="text-indigo-600 dark:text-indigo-400">Poste</span>
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1 italic">Cadastro técnico de ativo no inventário</p>
                </div>
            </div>

            <x-iluminacao::button href="{{ route('co-admin.iluminacao.postes.index') }}" variant="outline" icon="arrow-left">
                Voltar Inventário
            </x-iluminacao::button>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8">
            <form action="{{ route('co-admin.iluminacao.postes.store') }}" method="POST" class="space-y-8" id="poste-form">
                @csrf

                <!-- Section: Identificação -->
                <x-iluminacao::card>
                    <div class="flex items-center gap-3 mb-8 pb-4 border-b border-slate-100 dark:border-slate-700/50">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <x-icon name="id-card" class="w-5 h-5" />
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Identificação & Localização</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-iluminacao::form.input label="Código do Ativo / Plaqueta" name="codigo" required placeholder="Ex: NEO-12345" icon="barcode" value="{{ old('codigo') }}" />

                        <x-iluminacao::form.input label="Logradouro" name="logradouro" required placeholder="Ex: Av. Principal, S/N" icon="map-pin" value="{{ old('logradouro') }}" />

                        <div class="md:col-span-1">
                            <x-iluminacao::form.input label="Bairro / Comunidade" name="bairro" placeholder="Ex: Centro" icon="map" value="{{ old('bairro') }}" />
                        </div>

                        <div class="md:col-span-1">
                            <x-iluminacao::form.select label="Tipo de Poste" name="tipo_poste" icon="utility-pole">
                                <option value="circular" {{ old('tipo_poste') == 'circular' ? 'selected' : '' }}>Circular</option>
                                <option value="duplo_t" {{ old('tipo_poste') == 'duplo_t' ? 'selected' : '' }}>Duplo T</option>
                                <option value="madeira" {{ old('tipo_poste') == 'madeira' ? 'selected' : '' }}>Madeira</option>
                                <option value="ornamental" {{ old('tipo_poste') == 'ornamental' ? 'selected' : '' }}>Ornamental</option>
                                <option value="outro" {{ old('tipo_poste') == 'outro' ? 'selected' : '' }}>Outro/Especial</option>
                            </x-iluminacao::form.select>
                        </div>
                    </div>
                </x-iluminacao::card>

                <!-- Section: Técnica -->
                <x-iluminacao::card>
                    <div class="flex items-center gap-3 mb-8 pb-4 border-b border-slate-100 dark:border-slate-700/50">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                            <x-icon name="microchip" class="w-5 h-5" />
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Especificações Técnicas</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <x-iluminacao::form.select label="Tipo de Lâmpada" name="tipo_lampada" icon="lightbulb">
                            <option value="">Selecione...</option>
                            <option value="led" {{ old('tipo_lampada') == 'led' ? 'selected' : '' }}>LED</option>
                            <option value="sodio" {{ old('tipo_lampada') == 'sodio' ? 'selected' : '' }}>Vapor de Sódio</option>
                            <option value="mercurio" {{ old('tipo_lampada') == 'mercurio' ? 'selected' : '' }}>Vapor de Mercúrio</option>
                            <option value="vapor_metalico" {{ old('tipo_lampada') == 'vapor_metalico' ? 'selected' : '' }}>Vapor Metálico</option>
                            <option value="mista" {{ old('tipo_lampada') == 'mista' ? 'selected' : '' }}>Mista</option>
                        </x-iluminacao::form.select>

                        <x-iluminacao::form.input label="Potência (Watts)" name="potencia" type="number" placeholder="Ex: 50" icon="bolt" value="{{ old('potencia') }}" />

                        <x-iluminacao::form.input label="ID do Transformador (Trafo)" name="trafo" placeholder="Ex: TR-001" icon="plug" value="{{ old('trafo') }}" />

                        <div class="flex flex-col justify-end pb-1">
                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input type="checkbox" name="barramento" value="1" class="sr-only peer" {{ old('barramento') ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none dark:bg-slate-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                                <span class="ml-3 text-sm font-bold text-slate-600 dark:text-slate-400 uppercase tracking-widest group-hover:text-indigo-500 transition-colors">Possui Barramento?</span>
                            </label>
                        </div>
                    </div>
                </x-iluminacao::card>

                <!-- Section: Georreferenciamento -->
                @include('iluminacao::partials.coordinates', ['latitude' => old('latitude'), 'longitude' => old('longitude')])

                <!-- Actions -->
                <div class="flex items-center justify-end gap-4 p-8 bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 shadow-sm">
                    <x-iluminacao::button href="{{ route('co-admin.iluminacao.postes.index') }}" variant="outline" size="lg">
                        Cancelar
                    </x-iluminacao::button>
                    <x-iluminacao::button type="submit" variant="primary" size="lg" icon="check">
                        Salvar Poste
                    </x-iluminacao::button>
                </div>
            </form>
        </div>

        <!-- Sidebar Tips -->
        <div class="lg:col-span-4 space-y-6">
            <x-iluminacao::card header="Estado de Conservação">
                <div class="space-y-4">
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1 px-1">Condição Física</label>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach(['bom' => 'Bom', 'regular' => 'Regular', 'ruim' => 'Ruim', 'critico' => 'Crítico'] as $val => $label)
                            <label class="relative flex items-center p-3 rounded-2xl border border-slate-200 dark:border-slate-700 cursor-pointer group hover:bg-slate-50 dark:hover:bg-slate-900/50 transition-all has-[:checked]:ring-2 has-[:checked]:ring-indigo-500/20 has-[:checked]:border-indigo-500 has-[:checked]:bg-indigo-50/30 dark:has-[:checked]:bg-indigo-900/10">
                                <input type="radio" name="condicao" value="{{ $val }}" form="poste-form" class="sr-only peer" {{ old('condicao', 'bom') == $val ? 'checked' : '' }}>
                                <div class="w-full flex flex-col items-center gap-2 peer-checked:text-indigo-600 dark:peer-checked:text-indigo-400">
                                    <span class="text-xs font-bold uppercase tracking-tighter text-slate-500 transition-colors group-hover:text-slate-700 dark:group-hover:text-slate-300 peer-checked:text-inherit">{{ $label }}</span>
                                    <div class="w-2.5 h-2.5 rounded-full bg-slate-200 dark:bg-slate-800 transition-all group-hover:scale-125 peer-checked:bg-current peer-checked:ring-4 peer-checked:ring-indigo-500/20"></div>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-700/50 space-y-4">
                    <x-iluminacao::form.textarea label="Observações de Campo" name="observacoes" rows="4" placeholder="Algum detalhe relevante sobre o poste?" icon="align-left" value="{{ old('observacoes') }}" />
                </div>
            </x-iluminacao::card>

            <x-iluminacao::card class="bg-indigo-600 border-none text-white overflow-hidden relative group">
                <div class="absolute -right-4 -top-4 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10">
                    <h4 class="text-lg font-bold mb-3 flex items-center gap-2 italic">
                        <x-icon name="circle-info" class="w-5 h-5 text-indigo-200" />
                        Dica Técnica
                    </h4>
                    <p class="text-sm text-indigo-100 leading-relaxed opacity-90 font-medium">
                        O cadastro preciso das coordenadas e do tipo de poste ajuda na logística das equipes de manutenção e no cálculo de carga da rede.
                    </p>
                </div>
            </x-iluminacao::card>
        </div>
    </div>
</div>
@endsection
