@extends('Co-Admin.layouts.app')

@section('title', 'Novo Poço Artesiano')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in pb-12">
    <!-- Premium Header Section -->
    <div class="relative overflow-hidden bg-slate-900 rounded-3xl border border-slate-800 shadow-2xl mb-8">
        <!-- Background Decorations -->
        <div class="absolute top-0 right-0 -mt-12 -mr-12 w-64 h-64 bg-blue-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 left-0 -mb-12 -ml-12 w-64 h-64 bg-indigo-500/10 rounded-full blur-3xl"></div>

        <div class="relative px-8 py-10 md:px-12 md:py-16">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-8">
                <div class="space-y-4">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-500/20 text-blue-400 text-[10px] font-black uppercase tracking-widest">
                        <x-icon name="plus" class="w-3 h-3" />
                        Cadastro Técnico
                    </div>

                    <div class="space-y-2">
                        <h1 class="text-4xl md:text-5xl font-black text-white uppercase tracking-tight">
                            Novo <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-indigo-400 font-light">Poço</span>
                        </h1>
                        <nav class="flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-500">
                            <a href="{{ route('pocos.index') }}" class="hover:text-blue-400 transition-colors">Poços Artesianos</a>
                            <x-icon name="chevron-right" class="w-2 h-2" />
                            <span class="text-blue-400">Novo Registro</span>
                        </nav>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('pocos.index') }}" class="group inline-flex items-center justify-center gap-2 px-6 py-3 text-[10px] font-black text-white bg-slate-800 rounded-xl hover:bg-slate-700 transition-all uppercase tracking-widest border border-slate-700">
                        <x-icon name="arrow-left" class="w-4 h-4 mr-1 group-hover:-translate-x-1 transition-transform" />
                        Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('warning'))
        <div class="p-6 bg-amber-50 dark:bg-amber-900/10 border border-amber-100 dark:border-amber-900/20 rounded-3xl animate-shake">
            <div class="flex items-center gap-4 text-amber-800 dark:text-amber-400">
                <x-icon name="triangle-exclamation" style="duotone" class="w-6 h-6" />
                <p class="text-xs font-black uppercase tracking-widest">{!! session('warning') !!}</p>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2 space-y-8">
            <div class="premium-card overflow-hidden">
                <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-800 bg-gray-50/50 dark:bg-slate-900/50">
                    <h2 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-2">
                        <x-icon name="circle-info" class="w-5 text-blue-500" />
                        Especificações Técnicas
                    </h2>
                </div>

                <form action="{{ route('pocos.store') }}" method="POST" class="p-8 space-y-10">
                    @csrf

                    <!-- Informações Básicas -->
                    <div class="space-y-6">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
                                <x-icon name="location-crosshairs" class="w-4 h-4" />
                            </div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-500">Localização e Identificação</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="localidade_id" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Localidade <span class="text-red-500">*</span></label>
                                <select id="localidade_id" name="localidade_id" required
                                    class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                    <option value="">Selecione...</option>
                                    @foreach($localidades as $loc)
                                        <option value="{{ $loc->id }}" {{ old('localidade_id') == $loc->id ? 'selected' : '' }}>
                                            {{ $loc->nome }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="endereco" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Endereço Completo <span class="text-red-500">*</span></label>
                                <input type="text" id="endereco" name="endereco" value="{{ old('endereco') }}" required
                                    placeholder="Logradouro, número, ponto de referência"
                                    class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                            </div>
                        </div>

                        <div x-data="{
                            lat: '{{ old('latitude') }}',
                            lng: '{{ old('longitude') }}',
                            convertDMS(type) {
                                let input = type === 'lat' ? this.lat : this.lng;
                                let regex = /(\d+)[°\s]+(\d+)[\x27\s]+(\d+(?:\.\d+)?)[\x22\s]*([NSEWnsew])?/;
                                let match = input.match(regex);
                                if (match) {
                                    let deg = parseFloat(match[1]);
                                    let min = parseFloat(match[2]);
                                    let sec = parseFloat(match[3]);
                                    let dir = match[4] ? match[4].toUpperCase() : null;
                                    let dec = deg + min/60 + sec/3600;
                                    if (dir === 'S' || dir === 'W') dec = -dec;
                                    if (type === 'lat') this.lat = dec.toFixed(6);
                                    else this.lng = dec.toFixed(6);
                                }
                            }
                        }">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label for="latitude" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Latitude</label>
                                    <input type="text" id="latitude" name="latitude" x-model="lat" @blur="convertDMS('lat')"
                                        placeholder="-12.345678 ou 12° 14' 01\" S"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                </div>
                                <div>
                                    <label for="longitude" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Longitude</label>
                                    <input type="text" id="longitude" name="longitude" x-model="lng" @blur="convertDMS('lng')"
                                        placeholder="-38.123456 ou 38° 44' 43\" W"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                                </div>
                            </div>

                        <!-- Mapa Interativo -->
                        <div class="mt-4 rounded-3xl overflow-hidden border border-slate-100 dark:border-slate-800 shadow-inner">
                            <x-map
                                latitude-field="latitude"
                                longitude-field="longitude"
                                nome-mapa-field="nome_mapa"
                                :latitude="old('latitude')"
                                :longitude="old('longitude')"
                                :nome-mapa="old('nome_mapa')"
                                icon-type="poco"
                                height="400px"
                                center-lat="-12.2336"
                                center-lng="-38.7454"
                                zoom="13"
                            />
                        </div>
                    </div>

                    <!-- Características Técnicas -->
                    <div class="space-y-6 pt-10 border-t border-gray-100 dark:border-slate-800">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600">
                                <x-icon name="droplet" class="w-4 h-4" />
                            </div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-500">Dados da Perfuração</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="profundidade_metros" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Profundidade (Metros) <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <input type="number" step="0.01" id="profundidade_metros" name="profundidade_metros" value="{{ old('profundidade_metros') }}" required
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white leading-relaxed">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-lg">MT</span>
                                </div>
                            </div>
                            <div>
                                <label for="vazao_litros_hora" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Vazão (Litros/Hora)</label>
                                <div class="relative">
                                    <input type="number" step="0.01" id="vazao_litros_hora" name="vazao_litros_hora" value="{{ old('vazao_litros_hora') }}"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white leading-relaxed">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-lg">L/H</span>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="diametro" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Diâmetro Nominal</label>
                                <input type="text" id="diametro" name="diametro" value="{{ old('diametro') }}"
                                    placeholder="Ex: 4 polegadas, 100mm"
                                    class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white leading-relaxed">
                            </div>
                            <div>
                                <label for="data_perfuracao" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Data da Obra</label>
                                <input type="date" id="data_perfuracao" name="data_perfuracao" value="{{ old('data_perfuracao') }}"
                                    class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white leading-relaxed">
                            </div>
                        </div>
                    </div>

                    <!-- Manutenção e Bombas -->
                    <div class="space-y-6 pt-10 border-t border-gray-100 dark:border-slate-800">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center text-amber-600">
                                <x-icon name="microchip" class="w-4 h-4" />
                            </div>
                            <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-500">Sistema Elevatório</h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div>
                                <label for="tipo_bomba" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Modelo de Bomba</label>
                                <input type="text" id="tipo_bomba" name="tipo_bomba" value="{{ old('tipo_bomba') }}"
                                    placeholder="Ex: Submersa Multi-estágio"
                                    class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white leading-relaxed">
                            </div>
                            <div>
                                <label for="potencia_bomba" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Potência Nominal</label>
                                <div class="relative">
                                    <input type="number" id="potencia_bomba" name="potencia_bomba" value="{{ old('potencia_bomba') }}"
                                        placeholder="7.5"
                                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white leading-relaxed">
                                    <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[10px] font-black text-slate-400 uppercase tracking-widest bg-slate-100 dark:bg-slate-800 px-2 py-1 rounded-lg">CV/HP</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t border-gray-100 dark:border-slate-800 pt-10">
                        <label for="observacoes" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Informações Adicionais</label>
                        <textarea id="observacoes" name="observacoes" rows="4"
                            placeholder="Notas técnicas, histórico ou alertas específicos para este poço..."
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white leading-relaxed">{{ old('observacoes') }}</textarea>
                    </div>

                    <div class="flex items-center justify-end gap-4 pt-6 border-t border-gray-100 dark:border-slate-800">
                        <x-pocos::button href="{{ route('pocos.index') }}" variant="secondary" class="!rounded-2xl !px-8 border-slate-200">
                            Cancelar
                        </x-pocos::button>
                        <x-pocos::button type="submit" variant="primary" class="!rounded-2xl !px-10 !bg-blue-600 shadow-lg shadow-blue-500/20">
                            <x-icon name="floppy-disk" class="w-4 h-4 mr-2" />
                            Finalizar Cadastro
                        </x-pocos::button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1 space-y-8">
            <!-- Card de Status Rápido -->
            <div class="premium-card p-8 space-y-6">
                <h2 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-2">
                    <x-icon name="shield-check" class="w-5 text-emerald-500" />
                    Status Operacional
                </h2>

                <div>
                    <label for="status" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Situação Inicial <span class="text-red-500">*</span></label>
                    <select form="poco-form" id="status" name="status" required
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                        <option value="ativo">100% Operacional</option>
                        <option value="inativo">Fora de Serviço</option>
                        <option value="manutencao">Manutenção Preventiva</option>
                        <option value="bomba_queimada">Falha Crítica (Bomba)</option>
                    </select>
                </div>

                <div>
                    <label for="equipe_responsavel_id" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Equipe de Suporte</label>
                    <select form="poco-form" id="equipe_responsavel_id" name="equipe_responsavel_id"
                        class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                        <option value="">Sem Equipe Fixa</option>
                        @foreach($equipes as $equipe)
                            <option value="{{ $equipe->id }}">
                                {{ $equipe->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Manutenção -->
            <div class="premium-card p-8 space-y-6">
                <h2 class="text-xs font-black text-slate-400 uppercase tracking-[0.2em] flex items-center gap-2">
                    <x-icon name="calendar-clock" class="w-5 text-amber-500" />
                    Cronograma
                </h2>

                <div class="space-y-6">
                    <div>
                        <label for="ultima_manutencao" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Último Check-up</label>
                        <input form="poco-form" type="date" id="ultima_manutencao" name="ultima_manutencao" value="{{ old('ultima_manutencao') }}"
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                    </div>
                    <div>
                        <label for="proxima_manutencao" class="block mb-2 text-[10px] font-black text-slate-400 uppercase tracking-widest px-1">Próxima Revisão</label>
                        <input form="poco-form" type="date" id="proxima_manutencao" name="proxima_manutencao" value="{{ old('proxima_manutencao') }}"
                            class="w-full px-5 py-3.5 bg-slate-50 border border-slate-200 dark:bg-slate-900/50 dark:border-slate-700 rounded-2xl text-sm font-bold focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 transition-all dark:text-white">
                    </div>
                </div>
            </div>

            <!-- Guia Rapido -->
            <div class="bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-900/20 rounded-3xl p-6">
                <div class="flex items-start gap-4">
                    <div class="p-3 bg-white dark:bg-slate-800 rounded-xl shadow-sm text-indigo-500">
                        <x-icon name="lightbulb" class="w-6 h-6" />
                    </div>
                    <div>
                        <h4 class="text-xs font-black text-indigo-900 dark:text-indigo-300 uppercase tracking-widest mb-1">Informação</h4>
                        <p class="text-[11px] text-indigo-700 dark:text-indigo-400/80 leading-relaxed font-bold uppercase tracking-tight">O código identificador do poço será gerado automaticamente após a criação (POC-ESTADO-ANO-001).</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const localidadeSelect = document.getElementById('localidade_id');
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');
    const enderecoInput = document.getElementById('endereco');

    if (localidadeSelect) {
        localidadeSelect.addEventListener('change', function() {
            if (this.value) {
                fetch(`{{ url("/localidades") }}/${this.value}/dados`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.latitude && !latitudeInput.value) latitudeInput.value = data.latitude;
                        if (data.longitude && !longitudeInput.value) longitudeInput.value = data.longitude;

                        if (!enderecoInput.value) {
                            let end = data.endereco || '';
                            if (data.numero) end += `, ${data.numero}`;
                            if (data.bairro) end += ` - ${data.bairro}`;
                            enderecoInput.value = end || data.nome || '';
                        }
                    });
            }
        });
    }
});
</script>
@endpush
@endsection
