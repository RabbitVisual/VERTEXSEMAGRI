@extends('Co-Admin.layouts.app')

@section('title', 'Editar Poço Artesiano')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-800">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-black text-gray-900 dark:text-white flex items-center gap-3 mb-2 uppercase tracking-tight">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-600 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg text-white">
                    <x-icon name="faucet-drip" style="duotone" class="w-6 h-6 md:w-7 md:h-7" />
                </div>
                <span>Editar Poço</span>
            </h1>
            <nav class="flex items-center gap-2 text-xs font-black uppercase tracking-widest text-slate-400">
                <a href="{{ route('pocos.index') }}" class="hover:text-blue-600 transition-colors">Poços</a>
                <x-icon name="chevron-right" class="w-3 h-3" />
                <span class="text-blue-600">{{ $poco->codigo ?? 'Gestão de Ativo' }}</span>
            </nav>
        </div>
        <x-pocos::button href="{{ route('pocos.show', $poco) }}" variant="outline" class="!px-5 !py-2.5 !text-[10px] !font-black !uppercase !tracking-widest !rounded-xl !shadow-sm">
            <x-pocos::icon name="arrow-left" class="w-4 h-4 mr-2" />
            Voltar
        </x-pocos::button>
    </div>

    <form action="{{ route('pocos.update', $poco) }}" id="poco-form" method="POST" class="space-y-8">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Formulário Principal -->
            <div class="lg:col-span-2 space-y-8">
                <div class="premium-card overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
                        <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                            <x-icon name="circle-info" style="duotone" class="w-5 text-blue-500" />
                            Especificações Técnicas
                        </h2>
                    </div>

                    <div class="p-8 space-y-10">
                        <!-- Identificação -->
                        <div class="space-y-6">
                            @if($poco->codigo)
                            <div class="p-5 bg-blue-50/50 dark:bg-blue-900/10 border border-blue-100 dark:border-blue-900/20 rounded-2xl flex items-center justify-between">
                                <div>
                                    <p class="text-[9px] font-black text-blue-600/50 uppercase tracking-widest mb-1">Código do Ativo</p>
                                    <p class="text-sm font-black text-blue-900 dark:text-blue-300">{{ $poco->codigo }}</p>
                                </div>
                                <div class="px-3 py-1 bg-white dark:bg-slate-900 rounded-lg shadow-sm">
                                     <x-icon name="barcode" class="w-5 h-5 text-blue-500" />
                                </div>
                            </div>
                            @endif

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="localidade_id" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Localidade <span class="text-red-500">*</span></label>
                                    <select id="localidade_id" name="localidade_id" required
                                        class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                        @foreach($localidades as $loc)
                                            <option value="{{ $loc->id }}" {{ old('localidade_id', $poco->localidade_id) == $loc->id ? 'selected' : '' }}>
                                                {{ $loc->nome }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="endereco" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Endereço de Localização <span class="text-red-500">*</span></label>
                                    <input type="text" id="endereco" name="endereco" value="{{ old('endereco', $poco->endereco) }}" required
                                        class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="latitude" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Latitude</label>
                                    <input type="text" id="latitude" name="latitude" value="{{ old('latitude', $poco->latitude) }}"
                                        class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                </div>
                                <div>
                                    <label for="longitude" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Longitude</label>
                                    <input type="text" id="longitude" name="longitude" value="{{ old('longitude', $poco->longitude) }}"
                                        class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                </div>
                            </div>

                            <!-- Mapa Interativo -->
                            <div class="rounded-3xl overflow-hidden border border-gray-100 dark:border-slate-800 shadow-inner">
                                <x-map
                                    latitude-field="latitude"
                                    longitude-field="longitude"
                                    nome-mapa-field="nome_mapa"
                                    :latitude="old('latitude', $poco->latitude)"
                                    :longitude="old('longitude', $poco->longitude)"
                                    :nome-mapa="old('nome_mapa', $poco->nome_mapa)"
                                    icon-type="poco"
                                    height="400px"
                                    center-lat="{{ $poco->latitude ?? '-12.2336' }}"
                                    center-lng="{{ $poco->longitude ?? '-38.7454' }}"
                                    zoom="13"
                                />
                            </div>
                        </div>

                        <!-- Caracteristicas Tecnicas -->
                        <div class="space-y-6 pt-10 border-t border-gray-100 dark:border-slate-800">
                             <div class="flex items-center gap-3 mb-6">
                                <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600">
                                    <x-icon name="droplet" style="duotone" class="w-4 h-4" />
                                </div>
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-500">Engenharia e Perfuração</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="profundidade_metros" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Profundidade (Metros) <span class="text-red-500">*</span></label>
                                    <div class="relative">
                                        <input type="number" step="0.01" id="profundidade_metros" name="profundidade_metros" value="{{ old('profundidade_metros', $poco->profundidade_metros) }}" required
                                            class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase tracking-widest">MT</span>
                                    </div>
                                </div>
                                <div>
                                    <label for="vazao_litros_hora" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Vazão Estimada</label>
                                    <div class="relative">
                                        <input type="number" step="0.01" id="vazao_litros_hora" name="vazao_litros_hora" value="{{ old('vazao_litros_hora', $poco->vazao_litros_hora) }}"
                                            class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase tracking-widest">L/H</span>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="diametro" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Diâmetro do Poço</label>
                                    <input type="text" id="diametro" name="diametro" value="{{ old('diametro', $poco->diametro) }}"
                                        class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                </div>
                                <div>
                                    <label for="data_perfuracao" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Data da Perfuração</label>
                                    <input type="date" id="data_perfuracao" name="data_perfuracao" value="{{ old('data_perfuracao', $poco->data_perfuracao ? $poco->data_perfuracao->format('Y-m-d') : '') }}"
                                        class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                </div>
                            </div>
                        </div>

                        <!-- Sistema Eletrico -->
                        <div class="space-y-6 pt-10 border-t border-gray-100 dark:border-slate-800">
                             <div class="flex items-center gap-3 mb-6">
                                <div class="w-8 h-8 rounded-lg bg-orange-50 dark:bg-orange-900/20 flex items-center justify-center text-orange-600">
                                    <x-icon name="bolt-lightning" style="duotone" class="w-4 h-4" />
                                </div>
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-500">Componentes Elétricos</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="tipo_bomba" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Modelo de Bomba</label>
                                    <input type="text" id="tipo_bomba" name="tipo_bomba" value="{{ old('tipo_bomba', $poco->tipo_bomba) }}"
                                        class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                </div>
                                <div>
                                    <label for="potencia_bomba" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Potência Nominal</label>
                                    <div class="relative">
                                        <input type="number" id="potencia_bomba" name="potencia_bomba" value="{{ old('potencia_bomba', $poco->potencia_bomba) }}"
                                            class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase tracking-widest">CV/HP</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-6 pt-10 border-t border-gray-100 dark:border-slate-800">
                             <label for="observacoes" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Registros Auxiliares</label>
                            <textarea id="observacoes" name="observacoes" rows="4"
                                class="w-full px-5 py-4 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-3xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white leading-relaxed">{{ old('observacoes', $poco->observacoes) }}</textarea>
                        </div>
                    </div>

                    <div class="px-8 py-6 bg-gray-50/50 dark:bg-slate-900/50 border-t border-gray-100 dark:border-slate-800 flex justify-end gap-4">
                        <x-pocos::button href="{{ route('pocos.show', $poco) }}" variant="outline" class="!px-8 !py-3.5 !text-[10px] !font-black !uppercase !tracking-widest !rounded-2xl">
                            Desistir
                        </x-pocos::button>
                        <x-pocos::button type="submit" variant="primary" class="!px-8 !py-3.5 !text-[10px] !font-black !uppercase !tracking-widest !rounded-2xl !bg-blue-600 !shadow-lg !shadow-blue-500/20">
                            <x-icon name="floppy-disk" style="duotone" class="w-4 h-4 mr-2" />
                            Salvar Alterações
                        </x-pocos::button>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1 space-y-8">
                 <!-- Status Operacional -->
                <div class="premium-card p-8 space-y-8">
                    <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                        <x-icon name="shield-halved" style="duotone" class="w-5 text-emerald-500" />
                        Gestão de Status
                    </h2>

                    <div>
                        <label for="status" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Situação Atual <span class="text-red-500">*</span></label>
                        <select form="poco-form" id="status" name="status" required
                            class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                            <option value="ativo" {{ old('status', $poco->status) === 'ativo' ? 'selected' : '' }}>Operacional</option>
                            <option value="inativo" {{ old('status', $poco->status) === 'inativo' ? 'selected' : '' }}>Fora de Serviço</option>
                            <option value="manutencao" {{ old('status', $poco->status) === 'manutencao' ? 'selected' : '' }}>Manutenção</option>
                            <option value="bomba_queimada" {{ old('status', $poco->status) === 'bomba_queimada' ? 'selected' : '' }}>Bomba Falha</option>
                        </select>
                    </div>

                    <div>
                        <label for="equipe_responsavel_id" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Equipe de Suporte</label>
                        <select form="poco-form" id="equipe_responsavel_id" name="equipe_responsavel_id"
                            class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                            <option value="">Sem Equipe Fixa</option>
                            @foreach($equipes as $equipe)
                                <option value="{{ $equipe->id }}" {{ old('equipe_responsavel_id', $poco->equipe_responsavel_id) == $equipe->id ? 'selected' : '' }}>
                                    {{ $equipe->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Manutenção -->
                <div class="premium-card p-8 space-y-8">
                    <h2 class="text-xs font-black text-gray-400 uppercase tracking-[0.2em] flex items-center gap-2">
                        <x-icon name="calendar-clock" style="duotone" class="w-5 text-amber-500" />
                        Calendário Manutenção
                    </h2>

                    <div class="space-y-6">
                        <div>
                            <label for="ultima_manutencao" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Última Revisão</label>
                            <input form="poco-form" type="date" id="ultima_manutencao" name="ultima_manutencao" value="{{ old('ultima_manutencao', $poco->ultima_manutencao ? $poco->ultima_manutencao->format('Y-m-d') : '') }}"
                                class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                        </div>
                        <div>
                            <label for="proxima_manutencao" class="block mb-2 text-[10px] font-black text-gray-400 uppercase tracking-widest px-1">Próxima Revisão</label>
                            <input form="poco-form" type="date" id="proxima_manutencao" name="proxima_manutencao" value="{{ old('proxima_manutencao', $poco->proxima_manutencao ? $poco->proxima_manutencao->format('Y-m-d') : '') }}"
                                class="w-full px-5 py-3.5 bg-gray-50/50 dark:bg-slate-900/50 border border-gray-200 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const locSelect = document.getElementById('localidade_id');
    const latInp = document.getElementById('latitude');
    const lngInp = document.getElementById('longitude');
    const endInp = document.getElementById('endereco');

    if (locSelect) {
        locSelect.addEventListener('change', function() {
            if (this.value && confirm('Deseja atualizar dados geográficos pela nova localidade?')) {
                fetch(`{{ url("/localidades") }}/${this.value}/dados`)
                    .then(r => r.json())
                    .then(d => {
                        if (d.latitude) latInp.value = d.latitude;
                        if (d.longitude) lngInp.value = d.longitude;
                        let e = d.endereco || '';
                        if (d.numero) e += `, ${d.numero}`;
                        if (d.bairro) e += ` - ${d.bairro}`;
                        endInp.value = e || d.nome || '';
                    });
            }
        });
    }
});
</script>
@endpush
@endsection
