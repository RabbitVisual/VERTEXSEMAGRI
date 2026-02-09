@extends('Co-Admin.layouts.app')

@section('title', 'Novo Ponto de Luz')

@section('content')
<div class="space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 p-8 shadow-sm">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-64 h-64 bg-emerald-500/5 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 dark:bg-emerald-900/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 shadow-inner border border-emerald-100 dark:border-emerald-800/50">
                    <x-icon name="plus" class="w-7 h-7" />
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Novo <span class="text-indigo-600 dark:text-indigo-400">Ponto de Luz</span>
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Cadastro técnico de ativo de iluminação pública</p>
                </div>
            </div>

            <x-iluminacao::button href="{{ route('iluminacao.index') }}" variant="outline" icon="arrow-left">
                Voltar
            </x-iluminacao::button>
        </div>
    </div>

    <!-- Multi-column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Form Column -->
        <div class="lg:col-span-8">
            @if($errors->any())
                <div class="mb-6">
                    <x-iluminacao::alert type="danger" dismissible>
                        <div class="flex items-center gap-2 mb-2">
                            <x-icon name="triangle-exclamation" class="w-5 h-5" />
                            <span class="font-bold">Erros de validação detectados:</span>
                        </div>
                        <ul class="list-disc list-inside space-y-1 ml-7 text-sm opacity-90">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-iluminacao::alert>
                </div>
            @endif

            @if(!$hasLocalidades)
                <div class="mb-6">
                    <x-iluminacao::alert type="warning">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <x-icon name="circle-info" class="w-6 h-6" />
                                <div>
                                    <p class="font-bold">Configuração Pendente</p>
                                    <p class="text-sm opacity-80">É necessário cadastrar pelo menos uma localidade antes de criar pontos.</p>
                                </div>
                            </div>
                            <x-iluminacao::button href="{{ route('localidades.create') }}" variant="secondary" size="sm">
                                Cadastrar Localidade
                            </x-iluminacao::button>
                        </div>
                    </x-iluminacao::alert>
                </div>
            @endif

            <form action="{{ route('iluminacao.store') }}" method="POST" class="space-y-8">
                @csrf

                <!-- Section: Informações Base -->
                <x-iluminacao::card>
                    <div class="flex items-center gap-3 mb-8 pb-4 border-b border-slate-100 dark:border-slate-700/50">
                        <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
                            <x-icon name="info" class="w-5 h-5" />
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Informações Básicas</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-1">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Código do Ativo</label>
                            <div class="relative group">
                                <input type="text" disabled placeholder="Gerado pelo sistema..."
                                    class="w-full px-5 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-400 cursor-not-allowed font-mono italic">
                                <div class="absolute right-4 top-1/2 -translate-y-1/2">
                                    <x-icon name="lock" class="w-4 h-4 opacity-30" />
                                </div>
                            </div>
                        </div>

                        <div class="md:col-span-1">
                            <x-iluminacao::form.select label="Localidade / Distrito" name="localidade_id" required icon="map-location-dot">
                                <option value="" disabled selected>Escolha a localidade...</option>
                                @foreach($localidades as $loc)
                                    <option value="{{ $loc->id }}" {{ old('localidade_id') == $loc->id ? 'selected' : '' }}>
                                        {{ $loc->nome }} {{ $loc->codigo ? "({$loc->codigo})" : "" }}
                                    </option>
                                @endforeach
                            </x-iluminacao::form.select>
                        </div>

                        <div class="md:col-span-2">
                            <x-iluminacao::form.input label="Endereço Completo" name="endereco" type="text"
                                value="{{ old('endereco') }}" placeholder="Ex: Rua das Flores, 123, Bairro Centro" icon="map-pin" required />
                        </div>
                    </div>
                </x-iluminacao::card>

                <!-- Section: Ficha Técnica -->
                <x-iluminacao::card>
                    <div class="flex items-center gap-3 mb-8 pb-4 border-b border-slate-100 dark:border-slate-700/50">
                        <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center text-amber-600 dark:text-amber-400">
                            <x-icon name="microchip" class="w-5 h-5" />
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-white">Especificações & Carga</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <x-iluminacao::form.select label="Status Inicial" name="status" required icon="toggle-on">
                            <option value="funcionando" {{ old('status', 'funcionando') == 'funcionando' ? 'selected' : '' }}>Em Operação (OK)</option>
                            <option value="com_defeito" {{ old('status') == 'com_defeito' ? 'selected' : '' }}>Com Defeito</option>
                            <option value="desligado" {{ old('status') == 'desligado' ? 'selected' : '' }}>Desativado / Desligado</option>
                        </x-iluminacao::form.select>

                        <x-iluminacao::form.input label="Tipo de Lâmpada" name="tipo_lampada" type="text"
                            value="{{ old('tipo_lampada') }}" placeholder="Ex: LED, HPS, Vapor Sódio" icon="lightbulb" />

                        <x-iluminacao::form.input label="Potência (Watts)" name="potencia" type="number"
                            value="{{ old('potencia') }}" placeholder="Ex: 50, 100, 150" icon="bolt" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="grid grid-cols-2 gap-4">
                            <x-iluminacao::form.input label="Qtd. Pontos" name="quantidade" type="number" min="1" value="{{ old('quantidade', 1) }}" icon="list-ol" />
                            <x-iluminacao::form.input label="Horas/Dia" name="horas_diarias" type="number" step="0.1" value="{{ old('horas_diarias') }}" placeholder="12.0" icon="clock" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <x-iluminacao::form.input label="Barramento" name="barramento" value="{{ old('barramento') }}" placeholder="ID Circuito" icon="diagram-project" />
                            <x-iluminacao::form.input label="Transformador" name="trafo" value="{{ old('trafo') }}" placeholder="ID Trafo" icon="bolt-lightning" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <x-iluminacao::form.input label="Estrutura (Poste)" name="tipo_poste" value="{{ old('tipo_poste') }}" placeholder="Ex: Concreto Curvo, Metálico" icon="tower-broadcast" />
                        <x-iluminacao::form.input label="Altura (m)" name="altura_poste" type="number" step="0.1" value="{{ old('altura_poste') }}" placeholder="Ex: 8.5" icon="ruler-vertical" />
                    </div>
                </x-iluminacao::card>

                <!-- Section: Geolocalização -->
                <x-iluminacao::card>
                    <div x-data="{
                        lat: '{{ old('latitude') }}',
                        lng: '{{ old('longitude') }}',
                        convertDMS(type) {
                            let input = type === 'lat' ? this.lat : this.lng;
                            let regex = /(\d+)[°\s]+(\d+)[\'\s]+(\d+(?:\.\d+)?)[\"\s]*([NSEWnsew])?/;
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
                        <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-100 dark:border-slate-700/50">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center text-purple-600 dark:text-purple-400">
                                    <x-icon name="location-dot" class="w-5 h-5" />
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 dark:text-white">Georreferenciamento</h3>
                            </div>
                            <div class="px-3 py-1 bg-slate-100 dark:bg-slate-900 rounded-lg text-[10px] font-bold text-slate-400 uppercase tracking-widest border border-slate-200 dark:border-slate-700">
                                Formatos: Decimal ou DMS
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Latitude</label>
                                <div class="relative">
                                    <input type="text" name="latitude" x-model="lat" @blur="convertDMS('lat')"
                                        placeholder="-12.2336 ou 12° 14' 01\" S"
                                        class="w-full px-5 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-mono text-sm">
                                    <div class="absolute left-0 top-0 h-full flex items-center pl-4 pointer-events-none opacity-20">
                                        <x-icon name="arrows-up-down" class="w-4 h-4" />
                                    </div>
                                </div>
                            </div>
                            <div class="space-y-1">
                                <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Longitude</label>
                                <div class="relative">
                                    <input type="text" name="longitude" x-model="lng" @blur="convertDMS('lng')"
                                        placeholder="-38.7454 ou 38° 44' 43\" W"
                                        class="w-full px-5 py-3 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all font-mono text-sm">
                                    <div class="absolute left-0 top-0 h-full flex items-center pl-4 pointer-events-none opacity-20">
                                        <x-icon name="arrows-left-right" class="w-4 h-4" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-inner">
                            <x-map
                                latitude-field="latitude"
                                longitude-field="longitude"
                                nome-mapa-field="nome_mapa"
                                :latitude="old('latitude')"
                                :longitude="old('longitude')"
                                icon-type="ponto_luz"
                                height="450px"
                                center-lat="-12.2336"
                                center-lng="-38.7454"
                                zoom="14"
                            />
                        </div>
                    </div>
                </x-iluminacao::card>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-4 p-8 bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 shadow-sm">
                    <x-iluminacao::button href="{{ route('iluminacao.index') }}" variant="outline" size="lg">
                        Descartar Alterações
                    </x-iluminacao::button>
                    <x-iluminacao::button type="submit" variant="primary" size="lg" icon="cloud-arrow-up">
                        Finalizar e Salvar Ponto
                    </x-iluminacao::button>
                </div>
            </form>
        </div>

        <!-- Sidebar / Tips -->
        <div class="lg:col-span-4 space-y-6">
            <x-iluminacao::card header="Informações Adicionais">
                <x-iluminacao::form.input label="Data de Instalação" name="data_instalacao" type="date" value="{{ old('data_instalacao') }}" icon="calendar-plus" />
                <div class="mt-4">
                    <x-iluminacao::form.textarea label="Observações Técnicas" name="observacoes" rows="5" value="{{ old('observacoes') }}"
                        placeholder="Descreva detalhes específicos da instalação ou defeitos prévios..." icon="align-left" />
                </div>
            </x-iluminacao::card>

            <x-iluminacao::card class="bg-indigo-600 border-none text-white overflow-hidden relative group">
                <div class="absolute -right-4 -top-4 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10">
                    <h4 class="text-lg font-bold mb-3 flex items-center gap-2">
                        <x-icon name="lightbulb" class="w-5 h-5 text-indigo-200" />
                        Dica do Especialista
                    </h4>
                    <p class="text-sm text-indigo-100 leading-relaxed opacity-90">
                        O código do ponto (ex: PL-2026-001) é gerado automaticamente para garantir a integridade do inventário. Certifique-se de marcar a localização exata no mapa para otimizar as futuras rotas de manutenção.
                    </p>
                </div>
            </x-iluminacao::card>

            <x-iluminacao::card header="Atalhos Rápidos">
                <div class="space-y-3">
                    <a href="{{ route('localidades.index') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-900 transition-colors group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 group-hover:text-indigo-500">
                                <x-icon name="map" class="w-4 h-4" />
                            </div>
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-tighter">Gerenciar Localidades</span>
                        </div>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-300" />
                    </a>
                    <a href="{{ route('iluminacao.index') }}" class="flex items-center justify-between p-3 rounded-xl hover:bg-slate-50 dark:hover:bg-slate-900 transition-colors group">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-500 group-hover:text-amber-500">
                                <x-icon name="circle-question" class="w-4 h-4" />
                            </div>
                            <span class="text-xs font-bold text-slate-600 dark:text-slate-400 uppercase tracking-tighter">Sincronização Neoenergia</span>
                        </div>
                        <x-icon name="chevron-right" class="w-3 h-3 text-slate-300" />
                    </a>
                </div>
            </x-iluminacao::card>
        </div>
    </div>
</div>
@endsection
