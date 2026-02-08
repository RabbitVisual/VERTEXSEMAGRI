@extends('admin.layouts.admin')

@section('title', 'OS #' . $ordem->numero . ' - Admin')

@section('content')
<div class="space-y-6 md:space-y-8">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-module-icon module="Ordens" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>OS #{{ $ordem->numero }}</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <a href="{{ route('admin.ordens.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Ordens</a>
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
                <span class="text-gray-900 dark:text-white font-medium">#{{ $ordem->numero }}</span>
            </nav>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.ordens.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18" />
                </svg>
                Voltar
            </a>
            <a href="{{ route('ordens.show', $ordem->id) }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Ver no Painel Padrão
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
        <div class="flex items-center">
            <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    </div>
    @endif

    <!-- Informações da OS -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            <!-- Dados Principais -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informações da Ordem de Serviço</h3>
                </div>
                <div class="p-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Código</dt>
                            <dd class="text-sm text-gray-900 dark:text-white font-medium">{{ $ordem->numero }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Status</dt>
                            <dd class="text-sm">
                                @php
                                    $statusColors = [
                                        'aberta' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                        'em_andamento' => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-300',
                                        'concluida' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300',
                                        'cancelada' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                    ];
                                    $statusClass = $statusColors[$ordem->status] ?? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300';
                                @endphp
                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $statusClass }}">{{ ucfirst(str_replace('_', ' ', $ordem->status)) }}</span>
                            </dd>
                        </div>
                        @if($ordem->demanda)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Demanda Relacionada</dt>
                            <dd class="text-sm">
                                <a href="{{ route('admin.demandas.show', $ordem->demanda->id) }}" class="text-emerald-600 hover:text-emerald-700 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors">
                                    {{ $ordem->demanda->codigo }}
                                </a>
                            </dd>
                        </div>
                        @endif
                        @if($ordem->equipe)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Equipe</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $ordem->equipe->nome }}</dd>
                        </div>
                        @endif
                        @if($ordem->data_inicio)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Início</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $ordem->data_inicio->format('d/m/Y H:i') }}</dd>
                        </div>
                        @endif
                        @if($ordem->data_conclusao)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Conclusão</dt>
                            <dd class="text-sm text-gray-900 dark:text-white">{{ $ordem->data_conclusao->format('d/m/Y H:i') }}</dd>
                        </div>
                        @endif
                        @if($ordem->descricao)
                        <div class="md:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Descrição</dt>
                            <dd class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $ordem->descricao }}</dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Materiais Utilizados -->
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Materiais Utilizados</h3>
                </div>
                <div class="p-6">
                    @if($ordem->materiais && $ordem->materiais->count() > 0)
                        <div class="mb-4">
                            @php
                                $totalMateriais = $ordem->materiais->count();
                                $statusOS = strtolower(trim($ordem->status ?? ''));

                                if ($statusOS === 'concluida') {
                                    $textoStatus = $totalMateriais . ' material(is) utilizado(s) nesta OS';
                                } else {
                                    $materiaisUsados = $ordem->materiais->whereIn('status_reserva', ['confirmado', 'usado'])->count();
                                    $materiaisReservados = $totalMateriais - $materiaisUsados;

                                    if ($materiaisUsados > 0) {
                                        $textoStatus = $totalMateriais . ' material(is) (' . $materiaisReservados . ' reservado(s), ' . $materiaisUsados . ' usado(s))';
                                    } else {
                                        $textoStatus = $totalMateriais . ' material(is) reservado(s) para esta OS';
                                    }
                                }
                            @endphp
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                                {{ $textoStatus }}
                            </p>
                            <div class="space-y-3">
                                @foreach($ordem->materiais as $ordemMaterial)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-slate-700/50 rounded-lg border border-gray-200 dark:border-slate-600">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-1">
                                                <p class="font-medium text-gray-900 dark:text-white">{{ $ordemMaterial->material->nome ?? 'N/A' }}</p>
                                                @php
                                                    // Se a OS está concluída, considerar como "Usado" independentemente do status_reserva
                                                    $statusOS = strtolower(trim($ordem->status ?? ''));
                                                    if ($statusOS === 'concluida') {
                                                        $statusReserva = 'confirmado';
                                                    } else {
                                                        $statusReserva = strtolower(trim($ordemMaterial->status_reserva ?? 'reservado'));
                                                    }

                                                    $statusBadges = [
                                                        'reservado' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300',
                                                        'confirmado' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                                                        'usado' => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-300',
                                                        'cancelado' => 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300'
                                                    ];
                                                    $statusLabels = [
                                                        'reservado' => 'Reservado',
                                                        'confirmado' => 'Usado',
                                                        'usado' => 'Usado',
                                                        'cancelado' => 'Cancelado'
                                                    ];
                                                    $badgeClass = $statusBadges[$statusReserva] ?? $statusBadges['reservado'];
                                                    $badgeLabel = $statusLabels[$statusReserva] ?? 'Reservado';
                                                @endphp
                                                <span class="px-2.5 py-0.5 text-xs font-medium rounded-full {{ $badgeClass }}">
                                                    {{ $badgeLabel }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Quantidade: {{ formatar_quantidade($ordemMaterial->quantidade, $ordemMaterial->material->unidade_medida ?? null) }} {{ $ordemMaterial->material->unidade_medida ?? '' }}
                                                @if($ordemMaterial->valor_unitario)
                                                    • Valor: R$ {{ number_format($ordemMaterial->valor_unitario * $ordemMaterial->quantidade, 2, ',', '.') }}
                                                @endif
                                            </p>
                                        </div>
                                        @if(in_array($ordem->status, ['pendente', 'em_execucao']))
                                            <button
                                                onclick="removerMaterialAdmin({{ $ordemMaterial->material_id }})"
                                                class="ml-3 p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors"
                                                title="Remover material e cancelar reserva"
                                            >
                                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                </svg>
                                            </button>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Nenhum material registrado.</p>
                    @endif

                    @if(in_array($ordem->status, ['pendente', 'em_execucao']))
                        <div class="border-t border-gray-200 dark:border-slate-700 pt-4">
                            <h3 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">Adicionar Material</h3>
                            <form id="formAdicionarMaterialAdmin" class="space-y-3">
                                @csrf
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                    <div class="md:col-span-2">
                                        <label for="material_id_admin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Material</label>
                                        <select
                                            id="material_id_admin"
                                            name="material_id"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500"
                                        >
                                            <option value="">Selecione um material</option>
                                            @foreach($materiaisDisponiveis as $material)
                                                @php
                                                    $temEstoque = $material->quantidade_estoque > 0;
                                                    $estoqueTexto = $temEstoque
                                                        ? 'Estoque: ' . formatar_quantidade($material->quantidade_estoque, $material->unidade_medida) . ' ' . $material->unidade_medida
                                                        : 'Sem Estoque';
                                                @endphp
                                                <option
                                                    value="{{ $material->id }}"
                                                    data-estoque="{{ $material->quantidade_estoque }}"
                                                    data-unidade="{{ $material->unidade_medida }}"
                                                    {{ !$temEstoque ? 'disabled' : '' }}
                                                >
                                                    {{ $material->nome }} ({{ $estoqueTexto }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div>
                                        <label for="quantidade_material_admin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Quantidade</label>
                                        <input
                                            type="number"
                                            id="quantidade_material_admin"
                                            name="quantidade"
                                            step="0.01"
                                            min="0.01"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500"
                                            placeholder="0.00"
                                        >
                                    </div>
                                </div>
                                <button
                                    type="button"
                                    onclick="adicionarMaterialAdmin()"
                                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors"
                                >
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                    </svg>
                                    Adicionar Material
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Finalizar OS (Admin) -->
            @if(in_array($ordem->status, ['pendente', 'em_execucao']))
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Finalizar Ordem de Serviço (Admin)</h3>
                    </div>
                    <div class="p-6">
                        <div class="mb-4 p-4 text-sm text-amber-800 rounded-lg bg-amber-50 dark:bg-amber-900/20 dark:text-amber-300 border border-amber-200 dark:border-amber-800" role="alert">
                            <div class="flex items-start">
                                <svg class="flex-shrink-0 inline w-5 h-5 me-3 mt-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                                </svg>
                                <div class="flex-1">
                                    <p class="font-medium mb-1">Finalização por Admin</p>
                                    <p class="text-xs">
                                        Você está finalizando esta OS em nome do funcionário. Ao finalizar, os materiais reservados serão confirmados e a OS será marcada como concluída.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="{{ route('admin.ordens.finalizar', $ordem->id) }}" enctype="multipart/form-data" id="formFinalizarAdmin">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label for="fotos_depois_admin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Fotos Após Execução (Opcional)
                                    </label>
                                    <input
                                        type="file"
                                        id="fotos_depois_admin"
                                        name="fotos_depois[]"
                                        multiple
                                        accept="image/*"
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400"
                                    >
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Você pode selecionar múltiplas fotos</p>
                                </div>

                                <div>
                                    <label for="relatorio_execucao_admin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Relatório de Execução <span class="text-red-500">*</span>
                                    </label>
                                    <textarea
                                        id="relatorio_execucao_admin"
                                        name="relatorio_execucao"
                                        rows="5"
                                        required
                                        minlength="10"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500"
                                        placeholder="Descreva o que foi realizado:&#10;- Problema encontrado&#10;- Solução aplicada&#10;- Observações importantes"
                                    >{{ $ordem->relatorio_execucao ?? '' }}</textarea>
                                </div>

                                <div>
                                    <label for="observacoes_admin" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                        Observações Adicionais (Opcional)
                                    </label>
                                    <textarea
                                        id="observacoes_admin"
                                        name="observacoes"
                                        rows="2"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500"
                                        placeholder="Ex: Necessita retorno, verificar novamente em 30 dias..."
                                    >{{ $ordem->observacoes ?? '' }}</textarea>
                                </div>

                                <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                                    <button
                                        type="submit"
                                        class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors"
                                    >
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Finalizar OS (Admin)
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            @if($ordem->status === 'concluida')
                <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Relatório de Execução</h3>
                    </div>
                    <div class="p-6">
                        @if($ordem->relatorio_execucao)
                            <p class="text-sm text-gray-900 dark:text-white whitespace-pre-wrap">{{ $ordem->relatorio_execucao }}</p>
                        @else
                            <p class="text-sm text-gray-500 dark:text-gray-400">Nenhum relatório registrado.</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            @if($ordem->usuarioAbertura)
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Usuário de Abertura</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $ordem->usuarioAbertura->name }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $ordem->usuarioAbertura->email }}</p>
                    </div>
                </div>
            </div>
            @endif

            @if($ordem->usuarioExecucao)
            <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700 bg-gray-50 dark:bg-slate-900/50">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Usuário de Execução</h3>
                </div>
                <div class="p-6">
                    <div class="space-y-2">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $ordem->usuarioExecucao->name }}</p>
                        <p class="text-xs text-gray-600 dark:text-gray-400">{{ $ordem->usuarioExecucao->email }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    function adicionarMaterialAdmin() {
        const materialId = document.getElementById('material_id_admin').value;
        const quantidade = document.getElementById('quantidade_material_admin').value;

        if (!materialId || !quantidade || parseFloat(quantidade) <= 0) {
            alert('Selecione um material e informe a quantidade.');
            return;
        }

        const materialSelect = document.getElementById('material_id_admin');
        const materialOption = materialSelect.options[materialSelect.selectedIndex];
        const estoque = parseFloat(materialOption.getAttribute('data-estoque'));

        if (parseFloat(quantidade) > estoque) {
            alert(`Quantidade excede o estoque disponível (${estoque}).`);
            return;
        }

        fetch('{{ route("admin.ordens.materiais.adicionar", $ordem->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                material_id: materialId,
                quantidade: quantidade
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao adicionar material: ' + (data.error || 'Erro desconhecido'));
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao adicionar material.');
        });
    }

    function removerMaterialAdmin(materialId) {
        if (!confirm('Deseja remover este material? A reserva será cancelada e o estoque será restaurado.')) return;

        fetch('{{ route("admin.ordens.materiais.remover", [$ordem->id, ":materialId"]) }}'.replace(':materialId', materialId), {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao remover material.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao remover material.');
        });
    }
</script>
@endpush
@endsection
