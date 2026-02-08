@extends('admin.layouts.admin')

@section('title', 'Nova Solicitação de Materiais - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 max-w-full overflow-x-hidden">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="plus" class="w-6 h-6 md:w-7 md:h-7 text-white" />
                </div>
                <span>Nova Solicitação</span>
            </h1>
            <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Admin</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Materiais</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <a href="{{ route('admin.materiais.solicitacoes.index') }}" class="hover:text-emerald-600 dark:hover:text-emerald-400 transition-colors">Solicitações</a>
                <x-icon name="chevron-right" class="w-4 h-4" />
                <span class="text-gray-900 dark:text-white font-medium">Nova</span>
            </nav>
        </div>
        <a href="{{ route('admin.materiais.solicitacoes.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-4 focus:ring-gray-200 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 dark:focus:ring-slate-700 transition-colors">
            <x-icon name="arrow-left" class="w-5 h-5" />
            Voltar
        </a>
    </div>

    <!-- Info Banner for Solicitação do Campo -->
    @if(isset($solicitacaoCampo) && $solicitacaoCampo)
        <div class="p-4 mb-6 text-blue-800 rounded-2xl bg-blue-50 dark:bg-blue-900/20 dark:text-blue-400 border border-blue-100 dark:border-blue-900/30 flex items-start gap-4">
            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/40 rounded-xl flex items-center justify-center flex-shrink-0">
                <x-icon name="circle-info" class="w-6 h-6 text-blue-600 dark:text-blue-400" />
            </div>
            <div>
                <h4 class="font-bold text-sm mb-1 uppercase tracking-widest">Processando Solicitação do Campo</h4>
                <p class="text-xs opacity-90 leading-relaxed">Você está processando uma solicitação feita por <strong>{{ $solicitacaoCampo->user->name }}</strong>. Os dados do material foram pré-preenchidos. Complete o formulário para gerar o ofício oficial.</p>
            </div>
        </div>
    @endif

    <!-- Formulário Principal -->
    <form id="formSolicitacao" method="POST" action="{{ route('admin.materiais.solicitar.gerar-pdf') }}" class="space-y-8">
        @csrf
        @if(isset($solicitacaoCampo) && $solicitacaoCampo)
            <input type="hidden" name="solicitacao_campo_id" value="{{ $solicitacaoCampo->id }}">
        @endif

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
            <!-- Coluna da Esquerda: Dados Administrativos -->
            <div class="xl:col-span-2 space-y-8">
                <!-- Seção: Identificação do Ofício -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3">
                            <x-icon name="file-invoice" class="w-5 h-5 text-emerald-500" />
                            Identificação do Ofício
                        </h3>
                    </div>
                    <div class="p-8">
                        <div class="p-4 mb-6 bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-900/30 rounded-2xl flex gap-3">
                            <x-icon name="sparkles" class="w-5 h-5 text-amber-500 flex-shrink-0 mt-0.5" />
                            <p class="text-xs text-amber-800 dark:text-amber-300 font-medium">
                                <strong>Numeração Automática:</strong> O número do ofício será gerado sequencialmente pelo sistema ao salvar, garantindo a integridade dos registros.
                            </p>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="cidade" class="block mb-2 text-xs font-bold text-gray-400 uppercase tracking-widest pl-1">Cidade / Localidade</label>
                                <input type="text" id="cidade" name="cidade" value="{{ old('cidade', 'Coração de Maria - BA') }}" required readonly
                                    class="bg-gray-100 border border-transparent text-gray-500 text-sm rounded-xl block w-full p-4 dark:bg-slate-900 dark:text-gray-500 cursor-not-allowed font-medium">
                            </div>
                            <div>
                                <label for="data" class="block mb-2 text-xs font-bold text-gray-400 uppercase tracking-widest pl-1">Data do Documento</label>
                                <input type="date" id="data" name="data" value="{{ old('data', date('Y-m-d')) }}" required
                                    class="bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-4 dark:bg-slate-900 dark:border-slate-700 dark:text-white transition-all font-medium">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seção: Responsáveis -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Secretário -->
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 font-bold text-sm text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                             <x-icon name="user-tie" class="w-4 h-4 text-emerald-500" />
                             Secretário(a)
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label for="secretario_nome" class="block mb-1.5 text-xs font-bold text-gray-400 uppercase tracking-widest">Nome Completo</label>
                                <input type="text" id="secretario_nome" name="secretario_nome" value="{{ old('secretario_nome') }}" required placeholder="Assinatura principal..."
                                    class="bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white font-medium">
                            </div>
                            <div>
                                <label for="secretario_cargo" class="block mb-1.5 text-xs font-bold text-gray-400 uppercase tracking-widest">Cargo / Função</label>
                                <input type="text" id="secretario_cargo" name="secretario_cargo" value="{{ old('secretario_cargo', 'Secretário(a) Municipal de Agricultura') }}" required readonly
                                    class="bg-gray-100 border border-transparent text-gray-500 text-xs rounded-xl block w-full p-3 dark:bg-slate-900 dark:text-gray-500 cursor-not-allowed font-bold">
                            </div>
                        </div>
                    </div>

                    <!-- Servidor -->
                    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 font-bold text-sm text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                             <x-icon name="user-gear" class="w-4 h-4 text-emerald-500" />
                             Servidor Responsável
                        </div>
                        <div class="p-6 space-y-4">
                            <div>
                                <label for="servidor_nome" class="block mb-1.5 text-xs font-bold text-gray-400 uppercase tracking-widest">Nome do Servidor</label>
                                <input type="text" id="servidor_nome" name="servidor_nome" value="{{ old('servidor_nome', auth()->user()->name) }}" required
                                    class="bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white font-medium">
                            </div>
                            <div>
                                <label for="servidor_cargo" class="block mb-1.5 text-xs font-bold text-gray-400 uppercase tracking-widest">Cargo do Servidor</label>
                                <input type="text" id="servidor_cargo" name="servidor_cargo" value="{{ old('servidor_cargo', 'Servidor Responsável pelo Setor de Infraestrutura') }}" required
                                    class="bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-3 dark:bg-slate-900 dark:border-slate-700 dark:text-white font-medium">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Seção: Seleção de Materiais -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div class="px-8 py-6 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white flex items-center gap-3">
                            <x-icon name="boxes-stacked" class="w-5 h-5 text-emerald-500" />
                            Materiais Solicitados
                        </h3>
                        <div class="flex flex-wrap items-center gap-4">
                            <label class="relative inline-flex items-center cursor-pointer group">
                                <input type="checkbox" id="filtro_baixo_estoque" class="sr-only peer">
                                <div class="w-9 h-5 bg-gray-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-slate-600 peer-checked:bg-red-500"></div>
                                <span class="ml-2 text-xs font-bold text-gray-500 dark:text-gray-400 group-hover:text-red-500 transition-colors uppercase tracking-widest">Estoque Crítico</span>
                            </label>
                            <button type="button" id="btnAdicionarCustomizado" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-100 dark:border-emerald-900/30 rounded-xl hover:bg-emerald-600 hover:text-white transition-all shadow-sm">
                                <x-icon name="plus" class="w-4 h-4" />
                                Material Avulso
                            </button>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="relative mb-6">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-gray-400">
                                <x-icon name="magnifying-glass" class="w-5 h-5" />
                            </div>
                            <input type="text" id="buscar_material" placeholder="Filtrar por nome, código ou categoria..."
                                class="bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-2xl focus:ring-emerald-500 focus:border-emerald-500 block w-full pl-12 p-4 dark:bg-slate-900 dark:border-slate-700 dark:text-white transition-all font-medium">
                        </div>

                        <!-- Materiais Customizados (Não Cadastrados) -->
                        <div id="materiais_customizados" class="space-y-4 mb-6"></div>

                        <div id="lista_materiais" class="space-y-3 max-h-[600px] overflow-y-auto pr-2 custom-scrollbar">
                            @forelse($materiais as $material)
                                <div class="material-item p-4 bg-white dark:bg-slate-800 border border-gray-100 dark:border-slate-700 rounded-2xl hover:border-emerald-500/50 hover:shadow-lg transition-all"
                                     data-nome="{{ strtolower($material->nome) }}"
                                     data-codigo="{{ strtolower($material->codigo ?? '') }}"
                                     data-categoria="{{ strtolower($material->categoria_formatada) }}"
                                     data-estoque-baixo="{{ $material->estaComEstoqueBaixo() ? 'true' : 'false' }}">
                                    <div class="flex items-start gap-4">
                                        <div class="pt-1">
                                            <input type="checkbox" name="materiais[{{ $loop->index }}][material_id]" value="{{ $material->id }}"
                                                   class="material-checkbox w-6 h-6 rounded-lg border-gray-200 text-emerald-600 focus:ring-emerald-500 transition-all cursor-pointer"
                                                   data-material-id="{{ $material->id }}">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex flex-wrap items-center gap-2 mb-2">
                                                <h4 class="font-bold text-gray-900 dark:text-white truncate">{{ $material->nome }}</h4>
                                                @if($material->codigo)
                                                    <span class="px-2 py-0.5 text-[10px] bg-gray-100 dark:bg-slate-700 text-gray-500 dark:text-gray-400 font-bold rounded uppercase tracking-tighter">
                                                        #{{ $material->codigo }}
                                                    </span>
                                                @endif
                                                @if($material->estaComEstoqueBaixo())
                                                    <x-icon name="triangle-exclamation" class="w-4 h-4 text-red-500" title="Estoque Crítico" />
                                                @endif
                                            </div>
                                            <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 text-[11px]">
                                                <span class="text-gray-400 font-bold uppercase tracking-widest flex items-center gap-1">
                                                    <x-icon name="tag" class="w-3 h-3" />
                                                    {{ $material->categoria_formatada }}
                                                </span>
                                                <span class="text-gray-400 font-bold uppercase tracking-widest flex items-center gap-1">
                                                    <x-icon name="warehouse" class="w-3 h-3" />
                                                    Saldo: {{ formatar_quantidade($material->quantidade_estoque, $material->unidade_medida) }} {{ $material->unidade_medida }}
                                                </span>
                                            </div>

                                            <!-- Form fields integrated into item - toggled by checkbox -->
                                            <div class="material-form mt-4 hidden grid grid-cols-1 md:grid-cols-2 gap-4 animate-fadeIn">
                                                <div>
                                                    <label class="block mb-1.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Qtd Solicitada <span class="text-red-500">*</span></label>
                                                    <input type="number" name="materiais[{{ $loop->index }}][quantidade]" step="0.01" min="0.01" data-required="true" disabled placeholder="0.00"
                                                        class="bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-900 dark:border-slate-700 dark:text-white transition-all font-bold">
                                                </div>
                                                <div>
                                                    <label class="block mb-1.5 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Justificativa <span class="text-red-500">*</span></label>
                                                    <input type="text" name="materiais[{{ $loop->index }}][justificativa]" data-required="true" disabled placeholder="Ex: Manutenção da Escola..."
                                                        class="bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-900 dark:border-slate-700 dark:text-white transition-all">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="py-12 text-center">
                                    <x-icon name="boxes-packing" class="w-12 h-12 text-gray-200 mx-auto mb-4" />
                                    <p class="text-gray-400 font-medium">Nenhum material cadastrado no acervo.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coluna da Direita: Finalização -->
            <div class="space-y-8">
                <!-- Observações -->
                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/50 dark:bg-slate-900/50 text-xs font-bold text-gray-400 uppercase tracking-widest">
                        Observações do Ofício
                    </div>
                    <div class="p-6">
                        <textarea name="observacoes" id="observacoes" rows="6" placeholder="Notas adicionais que constarão no documento final..."
                            class="bg-gray-50 border border-gray-100 text-gray-900 text-sm rounded-2xl focus:ring-emerald-500 focus:border-emerald-500 block w-full p-4 dark:bg-slate-900 dark:border-slate-700 dark:text-white transition-all italic">{{ old('observacoes') }}</textarea>
                    </div>
                </div>

                <!-- Painel de Ações -->
                <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl shadow-xl p-8 sticky top-8 border border-slate-700/50">
                    <h4 class="text-white font-bold text-lg mb-6 flex items-center gap-2">
                        <x-icon name="circle-check" class="w-5 h-5 text-emerald-400" />
                        Ações Finais
                    </h4>
                    <div class="space-y-4">
                        <button type="button" id="btnVisualizar" class="w-full inline-flex items-center justify-center gap-3 px-6 py-4 text-sm font-bold text-white bg-blue-600 rounded-2xl hover:bg-blue-700 shadow-lg shadow-blue-500/20 transition-all group">
                            <x-icon name="eye" class="w-5 h-5 group-hover:scale-110 transition-transform" />
                            Visualizar Rascunho
                        </button>
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-3 px-6 py-4 text-sm font-bold text-white bg-emerald-600 rounded-2xl hover:bg-emerald-700 shadow-lg shadow-emerald-500/30 transition-all group">
                            <x-icon name="file-pdf" class="w-5 h-5 group-hover:rotate-12 transition-transform" />
                            Gerar e Baixar Oficial
                        </button>
                        <p class="text-[10px] text-slate-400 text-center uppercase tracking-widest font-bold mt-4">
                            O documento será registrado permanentemente após a geração.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.material-checkbox');
    const buscarInput = document.getElementById('buscar_material');
    const filtroBaixoEstoque = document.getElementById('filtro_baixo_estoque');
    const btnVisualizar = document.getElementById('btnVisualizar');
    const btnAdicionarCustomizado = document.getElementById('btnAdicionarCustomizado');
    const materiaisCustomizados = document.getElementById('materiais_customizados');
    const formSolicitacao = document.getElementById('formSolicitacao');
    let customizadoIndex = 0;

    // Alternar formulário do item
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const item = this.closest('.material-item');
            const form = item.querySelector('.material-form');
            const inputs = form.querySelectorAll('input');

            if (this.checked) {
                item.classList.add('ring-2', 'ring-emerald-500', 'border-transparent', 'bg-emerald-50/30', 'dark:bg-emerald-900/10');
                form.classList.remove('hidden');
                inputs.forEach(input => {
                    input.removeAttribute('disabled');
                    if (input.hasAttribute('data-required')) input.setAttribute('required', 'required');
                });
            } else {
                item.classList.remove('ring-2', 'ring-emerald-500', 'border-transparent', 'bg-emerald-50/30', 'dark:bg-emerald-900/10');
                form.classList.add('hidden');
                inputs.forEach(input => {
                    input.removeAttribute('required');
                    input.setAttribute('disabled', 'disabled');
                });
            }
        });
    });

    // Material Avulso (Não Cadastrado)
    btnAdicionarCustomizado.addEventListener('click', function() {
        const index = customizadoIndex++;
        const card = document.createElement('div');
        card.className = 'animate-fadeIn p-6 bg-emerald-50 text-emerald-900 dark:bg-emerald-900/10 dark:text-emerald-400 rounded-3xl border border-emerald-200 dark:border-emerald-800 relative group';
        card.innerHTML = `
            <button type="button" class="btn-remover-customizado absolute -top-3 -right-3 w-8 h-8 bg-red-500 text-white rounded-full flex items-center justify-center shadow-lg hover:scale-110 transition-transform">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <h4 class="font-bold text-xs uppercase tracking-widest mb-4 flex items-center gap-2">
                <i class="fa-solid fa-file-circle-plus"></i> Material Não Cadastrado
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1 opacity-70 italic">Nome do Material *</label>
                    <input type="text" name="materiais_customizados[${index}][nome]" required placeholder="Descreva o que deseja..."
                        class="bg-white border-transparent text-gray-900 text-sm rounded-xl block w-full p-2.5 dark:bg-slate-900 dark:text-white font-bold">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1 opacity-70">Especificação (Marca/Tipo)</label>
                    <input type="text" name="materiais_customizados[${index}][especificacao]" placeholder="Opcional..."
                        class="bg-white border-transparent text-gray-900 text-sm rounded-xl block w-full p-2.5 dark:bg-slate-900 dark:text-white">
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest mb-1 opacity-70">Quantidade *</label>
                        <input type="number" name="materiais_customizados[${index}][quantidade]" step="0.01" min="0.01" required placeholder="0.00"
                            class="bg-white border-transparent text-gray-900 text-sm rounded-xl block w-full p-2.5 dark:bg-slate-900 dark:text-white font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold uppercase tracking-widest mb-1 opacity-70">Unidade *</label>
                        <select name="materiais_customizados[${index}][unidade_medida]" required
                                class="bg-white border-transparent text-gray-900 text-sm rounded-xl block w-full p-2.5 dark:bg-slate-900 dark:text-white font-bold">
                            <option value="unidade">UN</option>
                            <option value="metro">M</option>
                            <option value="litro">L</option>
                            <option value="kg">KG</option>
                        </select>
                    </div>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-[10px] font-bold uppercase tracking-widest mb-1 opacity-70">Justificativa *</label>
                    <input type="text" name="materiais_customizados[${index}][justificativa]" required placeholder="Por que solicitar este item?"
                        class="bg-white border-transparent text-gray-900 text-sm rounded-xl block w-full p-2.5 dark:bg-slate-900 dark:text-white">
                </div>
            </div>
        `;
        materiaisCustomizados.appendChild(card);
        card.querySelector('.btn-remover-customizado').onclick = () => card.remove();
    });

    // Filtros e Busca
    buscarInput.addEventListener('input', function() {
        const termo = this.value.toLowerCase();
        document.querySelectorAll('.material-item').forEach(item => {
            const matches = item.dataset.nome.includes(termo) || item.dataset.codigo.includes(termo) || item.dataset.categoria.includes(termo);
            item.style.display = matches ? '' : 'none';
        });
    });

    filtroBaixoEstoque.addEventListener('change', function() {
        document.querySelectorAll('.material-item').forEach(item => {
            if (this.checked && item.dataset.estoqueBaixo === 'false') {
                item.style.display = 'none';
            } else if (!buscarInput.value || item.dataset.nome.includes(buscarInput.value.toLowerCase())) {
                item.style.display = '';
            }
        });
    });

    // Helper: Preparar inputs antes de enviar
    function syncInputs() {
        checkboxes.forEach(cb => {
            const form = cb.closest('.material-item').querySelector('.material-form');
            form.querySelectorAll('input').forEach(input => {
                if (cb.checked) {
                    input.removeAttribute('disabled');
                    if (input.hasAttribute('data-required')) input.setAttribute('required', 'required');
                } else {
                    input.setAttribute('disabled', 'disabled');
                    input.removeAttribute('required');
                }
            });
        });
    }

    // Visualizar PDF em nova aba
    btnVisualizar.addEventListener('click', function(e) {
        syncInputs();
        if (!formSolicitacao.checkValidity()) {
            formSolicitacao.reportValidity();
            return;
        }

        const formData = new FormData(formSolicitacao);
        const tempForm = document.createElement('form');
        tempForm.method = 'POST';
        tempForm.action = '{{ route('admin.materiais.solicitar.visualizar-pdf') }}';
        tempForm.target = '_blank';

        const csrf = document.createElement('input');
        csrf.type = 'hidden';
        csrf.name = '_token';
        csrf.value = '{{ csrf_token() }}';
        tempForm.appendChild(csrf);

        for (let [key, value] of formData.entries()) {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = key;
            input.value = value;
            tempForm.appendChild(input);
        }

        document.body.appendChild(tempForm);
        tempForm.submit();
        tempForm.remove();
    });

    // Envio Final: Garantir limpeza de índices
    formSolicitacao.onsubmit = function() {
        syncInputs();
        return formSolicitacao.checkValidity();
    };
});
</script>

<style>
.custom-scrollbar::-webkit-scrollbar { width: 5px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: #10b981; border-radius: 10px; }
.animate-fadeIn { animation: fadeIn 0.3s ease-out; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endpush
@endsection
