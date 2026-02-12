@extends('Co-Admin.layouts.app')

@section('title', 'Editar Ponto de Luz')

@section('content')
<div class="space-y-8 animate-fade-in pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 p-8 shadow-sm">
        <div class="absolute top-0 right-0 -mt-8 -mr-8 w-64 h-64 bg-amber-500/5 rounded-full blur-3xl"></div>

        <div class="relative flex flex-col sm:flex-row sm:items-center sm:justify-between gap-6">
            <div class="flex items-center gap-5">
                <div class="w-14 h-14 rounded-2xl bg-amber-50 dark:bg-amber-900/20 flex items-center justify-center text-amber-600 dark:text-amber-400 shadow-inner border border-amber-100 dark:border-amber-800/50">
                    <x-icon name="pen-to-square" class="w-7 h-7" />
                </div>
                <div>
                    <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white tracking-tight">
                        Editar <span class="text-indigo-600 dark:text-indigo-400">Ponto #{{ $ponto->id }}</span>
                    </h1>
                    <p class="text-sm text-slate-500 dark:text-slate-400 font-medium mt-1">Identificador: <span class="font-mono text-indigo-500 dark:text-indigo-400">{{ $ponto->codigo ?? 'N/A' }}</span></p>
                </div>
            </div>

            <x-iluminacao::button href="{{ route('co-admin.iluminacao.show', $ponto) }}" variant="outline" icon="arrow-left">
                Voltar Detalhes
            </x-iluminacao::button>
        </div>
    </div>

    <!-- Multi-column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Main Form Column -->
        <div class="lg:col-span-8">
            @if(session('success'))
                <div class="mb-6">
                    <x-iluminacao::alert type="success" dismissible>
                        <div class="flex items-center gap-3">
                            <x-icon name="check-circle" class="w-5 h-5 font-bold" />
                            <span class="font-medium">{{ session('success') }}</span>
                        </div>
                    </x-iluminacao::alert>
                </div>
            @endif

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

            <form action="{{ route('co-admin.iluminacao.update', $ponto) }}" method="POST" class="space-y-8">
                @csrf
                @method('PUT')

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
                            <x-iluminacao::form.input label="Código do Ativo" name="codigo" type="text"
                                value="{{ old('codigo', $ponto->codigo) }}" readonly disabled icon="lock" />
                        </div>

                        <div class="md:col-span-1">
                            <x-iluminacao::form.select label="Localidade / Distrito" name="localidade_id" required icon="map-location-dot">
                                @foreach($localidades as $loc)
                                    <option value="{{ $loc->id }}" {{ old('localidade_id', $ponto->localidade_id) == $loc->id ? 'selected' : '' }}>
                                        {{ $loc->nome }} {{ $loc->codigo ? "({$loc->codigo})" : "" }}
                                    </option>
                                @endforeach
                            </x-iluminacao::form.select>
                        </div>

                        <div class="md:col-span-2">
                            <x-iluminacao::form.input label="Endereço Completo" name="endereco" type="text"
                                value="{{ old('endereco', $ponto->endereco) }}" placeholder="Ex: Rua das Flores, 123, Bairro Centro" icon="map-pin" required />
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
                        <x-iluminacao::form.select label="Status Técnico" name="status" required icon="toggle-on">
                            <option value="funcionando" {{ old('status', $ponto->status) == 'funcionando' ? 'selected' : '' }}>Em Operação (OK)</option>
                            <option value="com_defeito" {{ old('status', $ponto->status) == 'com_defeito' ? 'selected' : '' }}>Com Defeito</option>
                            <option value="desligado" {{ old('status', $ponto->status) == 'desligado' ? 'selected' : '' }}>Desativado / Desligado</option>
                        </x-iluminacao::form.select>

                        <x-iluminacao::form.input label="Tipo de Lâmpada" name="tipo_lampada" type="text"
                            value="{{ old('tipo_lampada', $ponto->tipo_lampada) }}" placeholder="Ex: LED, HPS, Vapor Sódio" icon="lightbulb" />

                        <x-iluminacao::form.input label="Potência (Watts)" name="potencia" type="number"
                            value="{{ old('potencia', $ponto->potencia) }}" placeholder="Ex: 50, 100, 150" icon="bolt" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="grid grid-cols-2 gap-4">
                            <x-iluminacao::form.input label="Qtd. Pontos" name="quantidade" type="number" min="1" value="{{ old('quantidade', $ponto->quantidade ?? 1) }}" icon="list-ol" />
                            <x-iluminacao::form.input label="Horas/Dia" name="horas_diarias" type="number" step="0.1" value="{{ old('horas_diarias', $ponto->horas_diarias ?? '') }}" placeholder="12.0" icon="clock" />
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <x-iluminacao::form.input label="Barramento" name="barramento" value="{{ old('barramento', $ponto->barramento ?? '') }}" placeholder="ID Circuito" icon="diagram-project" />
                            <x-iluminacao::form.input label="Transformador" name="trafo" value="{{ old('trafo', $ponto->trafo ?? '') }}" placeholder="ID Trafo" icon="bolt-lightning" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <x-iluminacao::form.input label="Estrutura (Poste)" name="tipo_poste" value="{{ old('tipo_poste', $ponto->tipo_poste) }}" placeholder="Ex: Concreto Curvo, Metálico" icon="tower-broadcast" />
                        <x-iluminacao::form.input label="Altura (m)" name="altura_poste" type="number" step="0.1" value="{{ old('altura_poste', $ponto->altura_poste) }}" placeholder="Ex: 8.5" icon="ruler-vertical" />
                    </div>
                </x-iluminacao::card>

                <!-- Section: Georreferenciamento -->
                @include('iluminacao::partials.coordinates', ['latitude' => old('latitude', $ponto->latitude), 'longitude' => old('longitude', $ponto->longitude)])

                <!-- Actions -->
                <div class="flex items-center justify-end gap-4 p-8 bg-white dark:bg-slate-800 rounded-3xl border border-slate-200 dark:border-slate-700/50 shadow-sm">
                    <x-iluminacao::button href="{{ route('co-admin.iluminacao.show', $ponto) }}" variant="outline" size="lg">
                        Descartar Alterações
                    </x-iluminacao::button>
                    <x-iluminacao::button type="submit" variant="primary" size="lg" icon="cloud-arrow-up">
                        Atualizar Registro
                    </x-iluminacao::button>
                </div>
            </form>
        </div>

        <!-- Sidebar / Tips -->
        <div class="lg:col-span-4 space-y-6">
            <x-iluminacao::card header="Ciclo de Vida">
                <x-iluminacao::form.input label="Data Instalação" name="data_instalacao" type="date"
                    value="{{ old('data_instalacao', $ponto->data_instalacao ? $ponto->data_instalacao->format('Y-m-d') : '') }}" icon="calendar-plus" />

                <div class="mt-4">
                    <x-iluminacao::form.input label="Última Manutenção" name="ultima_manutencao" type="date"
                        value="{{ old('ultima_manutencao', $ponto->ultima_manutencao ? $ponto->ultima_manutencao->format('Y-m-d') : '') }}" icon="wrench" />
                </div>

                <div class="mt-4">
                    <x-iluminacao::form.textarea label="Observações Técnicas" name="observacoes" rows="5" value="{{ old('observacoes', $ponto->observacoes) }}"
                        placeholder="Histórico de reparos ou particularidades..." icon="align-left" />
                </div>
            </x-iluminacao::card>

            <x-iluminacao::card class="bg-indigo-600 border-none text-white overflow-hidden relative group">
                <div class="absolute -right-4 -top-4 w-32 h-32 bg-white/10 rounded-full blur-2xl group-hover:scale-150 transition-transform duration-700"></div>
                <div class="relative z-10">
                    <h4 class="text-lg font-bold mb-3 flex items-center gap-2">
                        <x-icon name="history" class="w-5 h-5 text-indigo-200" />
                        Histórico de Auditoria
                    </h4>
                    <p class="text-sm text-indigo-100 leading-relaxed opacity-90">
                        Cada alteração neste formulário gera um registro no histórico do ponto. Você pode consultar quem alterou e o que foi mudado na aba <b>Histórico de Eventos</b> na visualização de detalhes.
                    </p>
                </div>
            </x-iluminacao::card>

            <x-iluminacao::card header="Metadados do Sistema">
                <div class="space-y-3">
                    <div class="flex items-center justify-between text-xs pb-3 border-b border-slate-100 dark:border-slate-700/50">
                        <span class="text-slate-400">Criado em:</span>
                        <span class="font-bold text-slate-600 dark:text-slate-300">{{ $ponto->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex items-center justify-between text-xs">
                        <span class="text-slate-400">Última atualização:</span>
                        <span class="font-bold text-slate-600 dark:text-slate-300">{{ $ponto->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </x-iluminacao::card>
        </div>
    </div>
</div>
@endsection
