@extends('Co-Admin.layouts.app')

@section('title', 'Editar OS')

@section('content')
<div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon module="ordens" class="w-6 h-6" />
                Editar OS {{ $ordem->numero }}
            </h1>
            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Atualizar informações da ordem de serviço</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <x-ordens::button href="{{ route('ordens.show', $ordem) }}" variant="outline">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </x-ordens::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-ordens::alert type="success" dismissible>
            {{ session('success') }}
        </x-ordens::alert>
    @endif

    @if($errors->any())
        <x-ordens::alert type="danger" dismissible>
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </x-ordens::alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Formulário Principal -->
        <div class="lg:col-span-2">
            <x-ordens::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        Informações da OS
                    </h3>
                </x-slot>

                <form action="{{ route('ordens.update', $ordem) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-ordens::form.select
                            label="Demanda (Opcional)"
                            name="demanda_id"
                        >
                            <option value="">Nenhuma</option>
                            @foreach($demandas as $demanda)
                                <option value="{{ $demanda->id }}" {{ old('demanda_id', $ordem->demanda_id) == $demanda->id ? 'selected' : '' }}>
                                    {{ $demanda->codigo ?? '#' . $demanda->id }} - {{ $demanda->solicitante_nome }} ({{ $demanda->tipo_texto ?? ucfirst($demanda->tipo) }})
                                </option>
                            @endforeach
                        </x-ordens::form.select>
                        <x-ordens::form.select
                            label="Equipe"
                            name="equipe_id"
                            required
                        >
                            <option value="">Selecione uma equipe</option>
                            @foreach($equipes as $equipe)
                                <option value="{{ $equipe->id }}" {{ old('equipe_id', $ordem->equipe_id) == $equipe->id ? 'selected' : '' }}>
                                    {{ $equipe->nome }}@if(isset($equipe->codigo)) ({{ $equipe->codigo }})@endif
                                </option>
                            @endforeach
                        </x-ordens::form.select>
                    </div>

                    <x-ordens::form.input
                        label="Tipo de Serviço"
                        name="tipo_servico"
                        type="text"
                        required
                        value="{{ old('tipo_servico', $ordem->tipo_servico) }}"
                    />

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <x-ordens::form.select
                            label="Prioridade"
                            name="prioridade"
                            required
                        >
                            <option value="baixa" {{ old('prioridade', $ordem->prioridade) == 'baixa' ? 'selected' : '' }}>Baixa</option>
                            <option value="media" {{ old('prioridade', $ordem->prioridade) == 'media' ? 'selected' : '' }}>Média</option>
                            <option value="alta" {{ old('prioridade', $ordem->prioridade) == 'alta' ? 'selected' : '' }}>Alta</option>
                            <option value="urgente" {{ old('prioridade', $ordem->prioridade) == 'urgente' ? 'selected' : '' }}>Urgente</option>
                        </x-ordens::form.select>
                        <x-ordens::form.select
                            label="Status"
                            name="status"
                            required
                        >
                            <option value="pendente" {{ old('status', $ordem->status) == 'pendente' ? 'selected' : '' }}>Pendente</option>
                            <option value="em_execucao" {{ old('status', $ordem->status) == 'em_execucao' ? 'selected' : '' }}>Em Execução</option>
                            <option value="concluida" {{ old('status', $ordem->status) == 'concluida' ? 'selected' : '' }}>Concluída</option>
                            <option value="cancelada" {{ old('status', $ordem->status) == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                        </x-ordens::form.select>
                    </div>

                    <div class="relative">
                        <x-ordens::form.textarea
                            label="Descrição"
                            name="descricao"
                            id="descricao"
                            rows="5"
                            required
                            maxlength="500"
                            value="{{ old('descricao', $ordem->descricao) }}"
                        />
                        <div class="absolute top-0 right-0 pt-1 pr-1">
                            <span id="char-count-descricao" class="text-[9px] font-medium text-gray-400 bg-gray-50 dark:bg-gray-800 px-1 rounded">0/500</span>
                        </div>
                    </div>

                    @if($ordem->status === 'em_execucao' || $ordem->status === 'concluida')
                    <div class="relative">
                        <x-ordens::form.textarea
                            label="Relatório de Execução"
                            name="relatorio_execucao"
                            id="relatorio_execucao"
                            rows="4"
                            maxlength="600"
                            value="{{ old('relatorio_execucao', $ordem->relatorio_execucao) }}"
                            help="Descreva detalhadamente o trabalho realizado"
                        />
                        <div class="absolute top-0 right-0 pt-1 pr-1">
                            <span id="char-count-relatorio" class="text-[9px] font-medium text-gray-400 bg-gray-50 dark:bg-gray-800 px-1 rounded">0/600</span>
                        </div>
                    </div>
                    @endif

                    <div class="relative">
                        <x-ordens::form.textarea
                            label="Observações"
                            name="observacoes"
                            id="observacoes"
                            rows="3"
                            maxlength="400"
                            value="{{ old('observacoes', $ordem->observacoes) }}"
                        />
                        <div class="absolute top-0 right-0 pt-1 pr-1">
                            <span id="char-count-observacoes" class="text-[9px] font-medium text-gray-400 bg-gray-50 dark:bg-gray-800 px-1 rounded">0/400</span>
                        </div>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                        <x-ordens::button href="{{ route('ordens.show', $ordem) }}" variant="outline">
                            Cancelar
                        </x-ordens::button>
                        <x-ordens::button type="submit" variant="primary">
                            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Atualizar OS
                        </x-ordens::button>
                    </div>
                </form>
            </x-ordens::card>
        </div>

        <!-- Sidebar -->
        <div class="lg:col-span-1">
            <x-ordens::card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                        </svg>
                        Informações
                    </h3>
                </x-slot>

                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Número</label>
                        <div class="text-lg font-semibold text-indigo-600 dark:text-indigo-400">{{ $ordem->numero }}</div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Status Atual</label>
                        <div>
                            @php
                                $statusVariants = [
                                    'pendente' => 'warning',
                                    'em_execucao' => 'info',
                                    'concluida' => 'success',
                                    'cancelada' => 'danger'
                                ];
                                $statusVariant = $statusVariants[$ordem->status] ?? 'default';
                            @endphp
                            <x-ordens::badge :variant="$statusVariant">
                                {{ $ordem->status_texto }}
                            </x-ordens::badge>
                        </div>
                    </div>
                    @if($ordem->demanda)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Demanda Vinculada</label>
                        <div>
                            <a href="{{ route('demandas.show', $ordem->demanda->id) }}" class="text-indigo-600 dark:text-indigo-400 hover:underline font-medium">
                                {{ $ordem->demanda->codigo ?? '#' . $ordem->demanda->id }}
                            </a>
                        </div>
                    </div>
                    @endif
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Criado em</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $ordem->created_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @if($ordem->updated_at)
                    <div>
                        <label class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1">Última atualização</label>
                        <div class="text-sm text-gray-900 dark:text-white">{{ $ordem->updated_at->format('d/m/Y H:i') }}</div>
                    </div>
                    @endif
                    @if($ordem->tempo_execucao_formatado)
                    <x-ordens::alert type="info">
                        <svg class="w-4 h-4 inline mr-2" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <strong>Tempo de Execução:</strong> {{ $ordem->tempo_execucao_formatado }}
                    </x-ordens::alert>
                    @endif
                </div>
            </x-ordens::card>
        </div>
    </div>
</div>
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Função genérica para contador
    function setupCounter(fieldId, countId, limit) {
        const field = document.getElementById(fieldId);
        const count = document.getElementById(countId);

        if (field && count) {
            const updateCount = () => {
                const length = field.value.length;
                count.textContent = `${length}/${limit}`;
                if (length >= (limit * 0.9)) count.classList.replace('text-gray-400', 'text-amber-500');
                else count.classList.replace('text-amber-500', 'text-gray-400');
                if (length >= limit) count.classList.replace('text-amber-500', 'text-red-500');
                else count.classList.remove('text-red-500');
            };
            field.addEventListener('input', updateCount);
            updateCount();
        }
    }

    setupCounter('descricao', 'char-count-descricao', 500);
    setupCounter('relatorio_execucao', 'char-count-relatorio', 600);
    setupCounter('observacoes', 'char-count-observacoes', 400);
});
</script>
@endpush
@endsection
