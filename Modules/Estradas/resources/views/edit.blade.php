@extends('Co-Admin.layouts.app')

@section('title', 'Editar Trecho')

@section('content')
<div class="space-y-6">
    <!-- Premium Header Area -->
    <div class="relative overflow-hidden bg-slate-900 rounded-3xl border border-slate-800 shadow-2xl mb-8">
        <!-- Decorative Elements -->
        <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-indigo-500/10 rounded-full blur-[100px]"></div>
        <div class="absolute bottom-0 left-0 -mb-20 -ml-20 w-80 h-80 bg-blue-500/10 rounded-full blur-[100px]"></div>

        <div class="relative px-8 py-10">
            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-8">
                <div class="flex items-center gap-6">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-indigo-500 to-blue-500 rounded-2xl blur opacity-25 group-hover:opacity-50 transition duration-1000 group-hover:duration-200"></div>
                        <div class="relative p-5 bg-slate-800/50 backdrop-blur-xl rounded-2xl border border-white/10 shadow-2xl">
                            <x-icon module="estradas" class="w-10 h-10 text-white" />
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 rounded-full">Edição</span>
                            <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Infraestrutura</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">
                            Editar <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-blue-400">Trecho</span>
                        </h1>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <x-estradas::button href="{{ route('estradas.show', $trecho) }}" variant="secondary" size="lg" class="shadow-xl">
                        <x-icon name="eye" class="w-5 h-5 mr-2" />
                        Ver Detalhes
                    </x-estradas::button>
                    <x-estradas::button href="{{ route('estradas.index') }}" variant="secondary" size="lg" class="shadow-xl">
                        <x-icon name="arrow-left" class="w-5 h-5 mr-2" />
                        Voltar
                    </x-estradas::button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-estradas::alert type="success" dismissible>
            {{ session('success') }}
        </x-estradas::alert>
    @endif

    @if($errors->any())
        <x-estradas::alert type="danger" dismissible>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-estradas::alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-slate-800 rounded-3xl border border-gray-200 dark:border-slate-700 shadow-sm overflow-hidden mb-8">
                <form action="{{ route('estradas.update', $trecho) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Seção 1: Informações Básicas -->
                    <div class="p-8 border-b border-gray-100 dark:border-slate-700/50">
                        <div class="flex items-center gap-4 mb-1">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 flex items-center justify-center border border-indigo-100 dark:border-indigo-800">
                                <x-icon name="circle-info" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">Informações do Trecho</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Dados principais de identificação</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 space-y-8">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="md:col-span-2">
                                <x-estradas::form.input
                                    label="Nome"
                                    name="nome"
                                    type="text"
                                    required
                                    value="{{ old('nome', $trecho->nome) }}"
                                />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Código
                                </label>
                                @if($trecho->codigo)
                                    <div class="relative">
                                        <input
                                            type="text"
                                            value="{{ $trecho->codigo }}"
                                            disabled
                                            readonly
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-gray-100 dark:bg-slate-700 text-gray-900 dark:text-white font-mono cursor-not-allowed"
                                        />
                                        <div class="absolute inset-0 flex items-center justify-end pr-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                    </div>
                                @else
                                    <div class="relative">
                                        <input
                                            type="text"
                                            value=""
                                            placeholder="Será gerado automaticamente"
                                            disabled
                                            readonly
                                            class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-gray-400 cursor-not-allowed"
                                        />
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </div>
                                    </div>
                                @endif
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    @if($trecho->codigo)
                                        Código já atribuído. Será gerado automaticamente se estiver vazio ao salvar.
                                    @else
                                        Será gerado automaticamente ao salvar
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-estradas::form.select
                                label="Localidade"
                                name="localidade_id"
                                required
                            >
                                <option value="">Selecione</option>
                                @foreach($localidades as $loc)
                                    <option value="{{ $loc->id }}" {{ old('localidade_id', $trecho->localidade_id) == $loc->id ? 'selected' : '' }}>
                                        {{ $loc->nome }}
                                    </option>
                                @endforeach
                            </x-estradas::form.select>
                            <x-estradas::form.select
                                label="Tipo"
                                name="tipo"
                                required
                            >
                                <option value="vicinal" {{ old('tipo', $trecho->tipo) == 'vicinal' ? 'selected' : '' }}>Vicinal</option>
                                <option value="principal" {{ old('tipo', $trecho->tipo) == 'principal' ? 'selected' : '' }}>Principal</option>
                                <option value="secundaria" {{ old('tipo', $trecho->tipo) == 'secundaria' ? 'selected' : '' }}>Secundária</option>
                            </x-estradas::form.select>
                        </div>
                    </div>

                    <!-- Seção 2: Características Físicas -->
                    <div class="p-8 border-t border-b border-gray-100 dark:border-slate-700/50">
                        <div class="flex items-center gap-4 mb-1">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center border border-blue-100 dark:border-blue-800">
                                <x-icon name="ruler-combined" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">Dimensões e Pavimentação</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Especificações físicas da via</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 space-y-8">

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <x-estradas::form.input
                                label="Extensão (km)"
                                name="extensao_km"
                                type="number"
                                step="0.01"
                                value="{{ old('extensao_km', $trecho->extensao_km) }}"
                            />
                            <x-estradas::form.input
                                label="Largura (metros)"
                                name="largura_metros"
                                type="number"
                                step="0.01"
                                value="{{ old('largura_metros', $trecho->largura_metros) }}"
                            />
                            <x-estradas::form.select
                                label="Tipo de Pavimento"
                                name="tipo_pavimento"
                            >
                                <option value="">Selecione</option>
                                <option value="asfalto" {{ old('tipo_pavimento', $trecho->tipo_pavimento) == 'asfalto' ? 'selected' : '' }}>Asfalto</option>
                                <option value="cascalho" {{ old('tipo_pavimento', $trecho->tipo_pavimento) == 'cascalho' ? 'selected' : '' }}>Cascalho</option>
                                <option value="terra" {{ old('tipo_pavimento', $trecho->tipo_pavimento) == 'terra' ? 'selected' : '' }}>Terra</option>
                            </x-estradas::form.select>
                        </div>
                    </div>

                    <!-- Seção 3: Condição e Manutenção -->
                    <div class="p-8 border-t border-b border-gray-100 dark:border-slate-700/50">
                        <div class="flex items-center gap-4 mb-1">
                            <div class="w-10 h-10 rounded-xl bg-amber-50 dark:bg-amber-900/30 flex items-center justify-center border border-amber-100 dark:border-amber-800">
                                <x-icon name="screwdriver-wrench" class="w-5 h-5 text-amber-600 dark:text-amber-400" />
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">Estado de Conservação</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Situação atual e registros de manutenção</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8 space-y-8">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-estradas::form.select
                                label="Condição"
                                name="condicao"
                                required
                            >
                                <option value="boa" {{ old('condicao', $trecho->condicao) == 'boa' ? 'selected' : '' }}>Boa</option>
                                <option value="regular" {{ old('condicao', $trecho->condicao) == 'regular' ? 'selected' : '' }}>Regular</option>
                                <option value="ruim" {{ old('condicao', $trecho->condicao) == 'ruim' ? 'selected' : '' }}>Ruim</option>
                                <option value="pessima" {{ old('condicao', $trecho->condicao) == 'pessima' ? 'selected' : '' }}>Péssima</option>
                            </x-estradas::form.select>
                            <div>
                                <div class="flex items-center mb-2">
                                    <input type="checkbox"
                                           id="tem_ponte"
                                           name="tem_ponte"
                                           value="1"
                                           {{ old('tem_ponte', $trecho->tem_ponte) ? 'checked' : '' }}
                                           class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                                    <label for="tem_ponte" class="ml-2 block text-sm text-gray-900 dark:text-white">
                                        Possui ponte(s)
                                    </label>
                                </div>
                                <div id="numero_pontes_container" style="{{ old('tem_ponte', $trecho->tem_ponte) ? '' : 'display: none;' }}">
                                    <x-estradas::form.input
                                        label="Número de Pontes"
                                        name="numero_pontes"
                                        type="number"
                                        value="{{ old('numero_pontes', $trecho->numero_pontes ?? 1) }}"
                                        min="1"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-estradas::form.input
                                label="Última Manutenção"
                                name="ultima_manutencao"
                                type="date"
                                value="{{ old('ultima_manutencao', $trecho->ultima_manutencao?->format('Y-m-d')) }}"
                            />
                            <x-estradas::form.input
                                label="Próxima Manutenção"
                                name="proxima_manutencao"
                                type="date"
                                value="{{ old('proxima_manutencao', $trecho->proxima_manutencao?->format('Y-m-d')) }}"
                            />
                        </div>
                    </div>

                    <!-- Seção 4: Observações -->
                    <div class="p-8 border-t border-b border-gray-100 dark:border-slate-700/50">
                        <div class="flex items-center gap-4 mb-1">
                            <div class="w-10 h-10 rounded-xl bg-slate-50 dark:bg-slate-900/30 flex items-center justify-center border border-slate-100 dark:border-slate-800">
                                <x-icon name="file-lines" class="w-5 h-5 text-slate-600 dark:text-slate-400" />
                            </div>
                            <div>
                                <h3 class="text-lg font-black text-slate-900 dark:text-white uppercase tracking-tight">Notas Adicionais</h3>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest leading-none">Observações e detalhes complementares</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-8">

                        <x-estradas::form.textarea
                            label="Observações"
                            name="observacoes"
                            rows="3"
                            value="{{ old('observacoes', $trecho->observacoes) }}"
                        />
                    </div>

                    <!-- Footer Buttons -->
                    <div class="bg-slate-50 dark:bg-slate-900/50 px-8 py-6 border-t border-gray-200 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-end gap-4">
                        <x-estradas::button href="{{ route('estradas.index') }}" variant="secondary" size="lg" class="w-full sm:w-auto">
                            Cancelar
                        </x-estradas::button>
                        <x-estradas::button type="submit" variant="primary" size="lg" class="w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 border-b-4 border-indigo-800 active:border-b-0 active:translate-y-1 transition-all">
                            <x-icon name="check" class="w-5 h-5 mr-2" />
                            Salvar Alterações
                        </x-estradas::button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Sidebar com Informações -->
        <div class="lg:col-span-1">
            <x-estradas::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <x-estradas::icon name="information-circle" class="w-5 h-5" />
                        Informações
                    </h3>
                </x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">ID</label>
                        <div class="text-base font-semibold text-gray-900 dark:text-white">#{{ $trecho->id }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $trecho->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @if($trecho->updated_at)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Atualizado em</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $trecho->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @endif
                </div>
            </x-estradas::card>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mostrar/ocultar campo de número de pontes
    const temPonteCheckbox = document.getElementById('tem_ponte');
    const numeroPontesContainer = document.getElementById('numero_pontes_container');

    if (temPonteCheckbox && numeroPontesContainer) {
        function toggleNumeroPontes() {
            if (temPonteCheckbox.checked) {
                numeroPontesContainer.style.display = 'block';
            } else {
                numeroPontesContainer.style.display = 'none';
                document.querySelector('[name="numero_pontes"]').value = '';
            }
        }

        temPonteCheckbox.addEventListener('change', toggleNumeroPontes);
    }
});
</script>
@endpush
@endsection
