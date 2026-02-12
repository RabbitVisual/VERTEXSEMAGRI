@extends('Co-Admin.layouts.app')

@section('title', 'Editar Demanda')

@section('content')
<div class="space-y-8">
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
                            <x-icon module="demandas" class="w-10 h-10 text-white" />
                        </div>
                    </div>
                    <div>
                        <div class="flex items-center gap-3 mb-2">
                            <span class="px-3 py-1 text-[10px] font-black uppercase tracking-[0.2em] bg-amber-500/10 text-amber-400 border border-amber-500/20 rounded-full">Edição</span>
                            <span class="w-1 h-1 rounded-full bg-slate-700"></span>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-widest">Protocolo: {{ $demanda->codigo ?? '#' . $demanda->id }}</span>
                        </div>
                        <h1 class="text-3xl md:text-4xl font-black text-white tracking-tight">
                            Editar <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-blue-400">Demanda</span>
                        </h1>
                    </div>
                </div>

                <div class="flex flex-wrap gap-3">
                    <x-demandas::button href="{{ route('demandas.show', $demanda) }}" variant="secondary" size="lg" class="shadow-xl">
                        <x-icon name="arrow-left" class="w-5 h-5 mr-2" />
                        Visualizar Detalhes
                    </x-demandas::button>
                </div>
            </div>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-demandas::alert type="success" dismissible>
            <div class="flex items-center gap-2">
                <x-icon name="circle-check" class="w-5 h-5" />
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </x-demandas::alert>
    @endif

    @if($errors->any())
        <x-demandas::alert type="danger" dismissible>
            <div class="flex items-start gap-2">
                <x-icon name="triangle-exclamation" class="w-5 h-5 flex-shrink-0 mt-0.5" />
                <div>
                    <p class="font-medium mb-2">Por favor, corrija os seguintes erros:</p>
                    <ul class="list-disc list-inside space-y-1 text-sm">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </x-demandas::alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2 space-y-6">
            <x-demandas::card class="mb-6 overflow-hidden">
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-indigo-500/10 rounded-xl">
                            <x-icon name="circle-info" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider">
                            Informações da Demanda
                        </h3>
                    </div>
                </x-slot>

                <form action="{{ route('demandas.update', $demanda) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Informações do Solicitante -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 pb-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="p-1.5 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                                <x-icon name="circle-user" class="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Informações do Solicitante
                            </h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-demandas::form.input
                                    label="Nome do Solicitante"
                                    name="solicitante_nome"
                                    type="text"
                                    required
                                    value="{{ old('solicitante_nome', $demanda->solicitante_nome) }}"
                                />
                                @error('solicitante_nome')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-demandas::form.input
                                    label="Apelido/Nome Social"
                                    name="solicitante_apelido"
                                    type="text"
                                    value="{{ old('solicitante_apelido', $demanda->solicitante_apelido) }}"
                                    maxlength="100"
                                    placeholder="Ex: Zé, Maria, João da Silva"
                                />
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <x-icon name="circle-info" class="w-4 h-4 inline mr-1" />
                                    Informe o apelido ou nome social do solicitante. Este campo facilita a identificação e localização da pessoa na comunidade.
                                </p>
                                @error('solicitante_apelido')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="solicitante_telefone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Telefone/WhatsApp <span class="text-red-500">*</span>
                                </label>
                                <input type="text"
                                       id="solicitante_telefone"
                                       name="solicitante_telefone"
                                       value="{{ old('solicitante_telefone', $demanda->solicitante_telefone) }}"
                                       required
                                       placeholder="(00) 00000-0000"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm @error('solicitante_telefone') border-red-500 @enderror">
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                    <x-icon name="circle-info" class="w-4 h-4 inline mr-1" />
                                    Informe o telefone ou WhatsApp para contato. O formato será aplicado automaticamente.
                                </p>
                                @error('solicitante_telefone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <x-demandas::form.input
                                    label="Email"
                                    name="solicitante_email"
                                    type="email"
                                    value="{{ old('solicitante_email', $demanda->solicitante_email) }}"
                                />
                                @error('solicitante_email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Informações da Demanda -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 pb-3">
                            <div class="p-1.5 bg-purple-100 dark:bg-purple-900/30 rounded-lg">
                                <x-icon name="file-lines" class="w-4 h-4 text-purple-600 dark:text-purple-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Informações da Demanda
                            </h4>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="localidade_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Localidade <span class="text-red-500">*</span>
                                </label>
                                <select id="localidade_id"
                                        name="localidade_id"
                                        required
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm @error('localidade_id') border-red-500 @enderror">
                                    <option value="">Selecione uma localidade</option>
                                    @foreach($localidades as $localidade)
                                        <option value="{{ $localidade->id }}" {{ old('localidade_id', $demanda->localidade_id) == $localidade->id ? 'selected' : '' }}>
                                            {{ $localidade->nome }}@if(isset($localidade->codigo)) ({{ $localidade->codigo }})@endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('localidade_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="tipo" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Tipo <span class="text-red-500">*</span>
                                </label>
                                <select id="tipo"
                                        name="tipo"
                                        required
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm @error('tipo') border-red-500 @enderror">
                                    <option value="agua" {{ old('tipo', $demanda->tipo) == 'agua' ? 'selected' : '' }}>Água</option>
                                    <option value="luz" {{ old('tipo', $demanda->tipo) == 'luz' ? 'selected' : '' }}>Luz</option>
                                    <option value="estrada" {{ old('tipo', $demanda->tipo) == 'estrada' ? 'selected' : '' }}>Estrada</option>
                                    <option value="poco" {{ old('tipo', $demanda->tipo) == 'poco' ? 'selected' : '' }}>Poço</option>
                                </select>
                                @error('tipo')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="prioridade" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Prioridade <span class="text-red-500">*</span>
                                </label>
                                <select id="prioridade"
                                        name="prioridade"
                                        required
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm @error('prioridade') border-red-500 @enderror">
                                    <option value="baixa" {{ old('prioridade', $demanda->prioridade) == 'baixa' ? 'selected' : '' }}>Baixa</option>
                                    <option value="media" {{ old('prioridade', $demanda->prioridade) == 'media' ? 'selected' : '' }}>Média</option>
                                    <option value="alta" {{ old('prioridade', $demanda->prioridade) == 'alta' ? 'selected' : '' }}>Alta</option>
                                    <option value="urgente" {{ old('prioridade', $demanda->prioridade) == 'urgente' ? 'selected' : '' }}>Urgente</option>
                                </select>
                                @error('prioridade')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select id="status"
                                        name="status"
                                        required
                                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white sm:text-sm @error('status') border-red-500 @enderror">
                                    <option value="aberta" {{ old('status', $demanda->status) == 'aberta' ? 'selected' : '' }}>Aberta</option>
                                    <option value="em_andamento" {{ old('status', $demanda->status) == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                                    <option value="concluida" {{ old('status', $demanda->status) == 'concluida' ? 'selected' : '' }}>Concluída</option>
                                    <option value="cancelada" {{ old('status', $demanda->status) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                                </select>
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    <x-icon name="circle-info" class="w-4 h-4 inline mr-1" />
                                    Ao finalizar a demanda, você poderá criar uma OS automaticamente.
                                </p>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <x-demandas::form.input
                                label="Motivo"
                                name="motivo"
                                type="text"
                                required
                                value="{{ old('motivo', $demanda->motivo) }}"
                                placeholder="Motivo da demanda"
                            />
                            @error('motivo')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Descrição -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 pb-3">
                            <div class="p-1.5 bg-amber-100 dark:bg-amber-900/30 rounded-lg">
                                <x-icon name="file-lines" class="w-4 h-4 text-amber-600 dark:text-amber-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Descrição Detalhada
                            </h4>
                        </div>

                        <div>
                            <x-demandas::form.textarea
                                label="Descrição"
                                name="descricao"
                                rows="6"
                                required
                                minlength="20"
                                value="{{ old('descricao', $demanda->descricao) }}"
                                placeholder="Descreva detalhadamente a demanda, incluindo localização precisa, características do problema, e qualquer informação relevante para facilitar a identificação e resolução..."
                            />

                            <!-- Dicas de Preenchimento -->
                            <div class="mt-3 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                                <div class="flex items-start gap-3">
                                    <x-icon name="circle-info" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                                    <div class="flex-1">
                                        <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-2">Como preencher a descrição de forma precisa:</h4>
                                        <ul class="text-xs text-blue-800 dark:text-blue-300 space-y-1 list-disc list-inside">
                                            <li><strong>Localização:</strong> Informe o endereço completo, pontos de referência, número da casa (se houver), rua, bairro, ou coordenadas aproximadas.</li>
                                            <li><strong>Características do problema:</strong> Descreva detalhadamente o que está acontecendo, quando começou, frequência, intensidade, e qualquer sintoma visível.</li>
                                            <li><strong>Contexto:</strong> Mencione se há outros problemas relacionados, condições climáticas que podem ter influenciado, ou situações especiais.</li>
                                            <li><strong>Impacto:</strong> Explique como o problema afeta a comunidade ou o solicitante, e a urgência da situação.</li>
                                            <li><strong>Informações adicionais:</strong> Inclua horários de funcionamento, restrições de acesso, ou qualquer informação que possa ajudar na resolução.</li>
                                        </ul>
                                        <p class="mt-2 text-xs text-blue-700 dark:text-blue-400 font-medium">
                                            <strong>Mínimo de 20 caracteres.</strong> Quanto mais detalhada a descrição, mais fácil será localizar e resolver o problema.
                                        </p>
                                    </div>
                                </div>
                            </div>

                            @error('descricao')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Observações -->
                    <div class="space-y-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <div class="flex items-center gap-2 pb-3">
                            <div class="p-1.5 bg-gray-100 dark:bg-gray-700 rounded-lg">
                                <x-icon name="file-lines" class="w-4 h-4 text-gray-600 dark:text-gray-400" />
                            </div>
                            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                                Informações Adicionais
                            </h4>
                        </div>

                        <div>
                            <x-demandas::form.textarea
                                label="Observações"
                                name="observacoes"
                                rows="3"
                                value="{{ old('observacoes', $demanda->observacoes) }}"
                                placeholder="Informe observações adicionais, notas internas, ou qualquer informação relevante..."
                            />
                            @error('observacoes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex items-center justify-end gap-3 pt-6 border-t border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 -mx-6 -mb-6 px-6 py-5">
                        <x-demandas::button href="{{ route('demandas.show', $demanda) }}" variant="secondary" size="lg">
                            <x-icon name="xmark" class="w-4 h-4 mr-2" />
                            Cancelar
                        </x-demandas::button>
                        <x-demandas::button type="submit" variant="primary" size="lg" class="shadow-xl border-b-4 border-indigo-700 active:border-b-0 active:translate-y-1 transition-all">
                            <x-icon name="circle-check" class="w-4 h-4 mr-2" />
                            Salvar Alterações
                        </x-demandas::button>
                    </div>
                </form>
            </x-demandas::card>
        </div>

        <!-- Sidebar com Informações -->
        <div class="lg:col-span-1 space-y-6">
            <x-demandas::card class="overflow-hidden">
                <x-slot name="header">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-500/10 rounded-xl">
                            <x-icon name="circle-info" class="w-5 h-5 text-blue-600 dark:text-blue-400" />
                        </div>
                        <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider">
                            Metadados
                        </h3>
                    </div>
                </x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Código</label>
                        <div class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">{{ $demanda->codigo ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $demanda->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @if($demanda->updated_at)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Última atualização</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $demanda->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @endif
                    @if($demanda->ordemServico)
                    <div class="rounded-lg border border-blue-200 bg-blue-50 dark:bg-blue-900/20 dark:border-blue-800 p-3">
                        <div class="flex items-center gap-2 text-blue-800 dark:text-blue-200">
                            <x-icon name="circle-info" class="h-5 w-5 text-blue-400" />
                            <div>
                                <strong>OS Vinculada:</strong>
                                <a href="{{ route('ordens.show', $demanda->ordemServico->id) }}" class="underline font-medium ml-1">
                                    {{ $demanda->ordemServico->numero }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </x-demandas::card>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara de telefone
    const telefoneInput = document.getElementById('solicitante_telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                if (value.length <= 10) {
                    value = value.replace(/^(\d{2})(\d{4})(\d{0,4}).*/, '($1) $2-$3');
                } else {
                    value = value.replace(/^(\d{2})(\d{5})(\d{0,4}).*/, '($1) $2-$3');
                }
                e.target.value = value;
            }
        });
    }

    const statusSelect = document.getElementById('status');
    const form = document.querySelector('form');

    if (statusSelect && form) {
        form.addEventListener('submit', function(e) {
            const currentStatus = '{{ $demanda->status }}';
            const newStatus = statusSelect.value;

            // Se está finalizando a demanda e não tem OS, perguntar se quer criar
            if (newStatus === 'concluida' && currentStatus !== 'concluida' && !{{ $demanda->ordemServico ? 'true' : 'false' }}) {
                e.preventDefault();
                const criarOS = confirm('Deseja criar uma Ordem de Serviço automaticamente para esta demanda?');
                if (criarOS) {
                    // Adicionar campo hidden para indicar que deve criar OS
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'criar_os';
                    input.value = '1';
                    form.appendChild(input);
                }
                form.submit();
            }
        });
    }
});
</script>
@endpush
@endsection
