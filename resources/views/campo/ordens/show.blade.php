@extends('campo.layouts.app')

@section('title', 'Detalhes da Ordem')

@section('content')
<div class="space-y-6">
    <!-- Page Header - HyperUI Style -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-indigo-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="arrow-left" class="w-5 h-5" />
            Voltar
        </a>
    </div>

    <!-- Status Badges - HyperUI Badge Style -->
    <div class="flex flex-wrap items-center gap-3">
        <span class="inline-flex items-center px-3 md:px-4 py-1.5 md:py-2 text-sm font-semibold rounded-full border bg-{{ $ordem->status_cor }}-100 text-{{ $ordem->status_cor }}-800 dark:bg-{{ $ordem->status_cor }}-900/20 dark:text-{{ $ordem->status_cor }}-400 border-{{ $ordem->status_cor }}-200 dark:border-{{ $ordem->status_cor }}-800">
            {{ $ordem->status_texto }}
        </span>
        <span class="inline-flex items-center px-3 md:px-4 py-1.5 md:py-2 text-sm font-semibold rounded-full border bg-{{ $ordem->prioridade_cor }}-100 text-{{ $ordem->prioridade_cor }}-800 dark:bg-{{ $ordem->prioridade_cor }}-900/20 dark:text-{{ $ordem->prioridade_cor }}-400 border-{{ $ordem->prioridade_cor }}-200 dark:border-{{ $ordem->prioridade_cor }}-800">
            Prioridade: {{ ucfirst($ordem->prioridade) }}
        </span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Conteúdo Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Informações da Demanda - HyperUI Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 md:p-6">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white mb-4 md:mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                        <x-icon name="file-pdf" class="w-5 h-5" />
                    </div>
                    Descrição do Serviço
                </h2>
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-wrap">{{ $ordem->descricao }}</p>
            </div>

            <!-- Fotos Antes - HyperUI Card -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5 md:p-6">
                <h2 class="text-lg md:text-xl font-semibold text-gray-900 dark:text-white mb-4 md:mb-6 flex items-center gap-2">
                    <div class="w-8 h-8 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg flex items-center justify-center">
                        <x-icon name="file-pdf" class="w-5 h-5" />
                    </div>
                    Relatório de Execução
                </h2>
                @if($ordem->status === 'em_execucao')
                    <div class="flex items-center gap-3 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                        <x-icon name="file-pdf" class="w-5 h-5" />
                        Relatório de Conclusão <span class="text-red-500">*</span>
                    </span>
                </label>
                <textarea
                    id="relatorio_final"
                    name="relatorio_execucao"
                    rows="5"
                    required
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Descreva o que foi realizado:&#10;- Problema encontrado&#10;- Solução aplicada&#10;- Observações importantes"
                >{{ $ordem->relatorio_execucao ?? '' }}</textarea>
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    Descreva detalhadamente o serviço executado, problemas encontrados e soluções aplicadas.
                </p>
            </div>

            <div class="mb-6">
                <label for="observacoes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Observações Adicionais (Opcional)
                </label>
                <textarea
                    id="observacoes"
                    name="observacoes"
                    rows="2"
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    placeholder="Ex: Necessita retorno, verificar novamente em 30 dias..."
                >{{ $ordem->observacoes ?? '' }}</textarea>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
                <button
                    type="button"
                    onclick="fecharModalConcluir()"
                    class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors"
                >
                    Cancelar
                </button>
                <button
                    type="submit"
                    class="px-6 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors flex items-center gap-2"
                >
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Concluir Ordem
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal de Solicitação de Material -->
<div id="modalSolicitarMaterial" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl max-w-md w-full max-h-[90vh] overflow-y-auto">
        <div class="p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Solicitar Material</h3>
                <button
                    onclick="fecharModalSolicitarMaterial()"
                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                >
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <form id="formSolicitarMaterial" onsubmit="event.preventDefault(); enviarSolicitacaoMaterial();">
                @csrf
                <input type="hidden" id="solicitar_material_id" name="material_id">
                <input type="hidden" id="solicitar_ordem_servico_id" name="ordem_servico_id" value="{{ $ordem->id }}">

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Nome do Material <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="solicitar_material_nome"
                            name="material_nome"
                            required
                            readonly
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                        >
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Código do Material
                        </label>
                        <input
                            type="text"
                            id="solicitar_material_codigo"
                            name="material_codigo"
                            readonly
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-white"
                        >
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Quantidade <span class="text-red-500">*</span>
                            </label>
                            <input
                                type="number"
                                name="quantidade"
                                step="0.01"
                                min="0.01"
                                required
                                placeholder="0.00"
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            >
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Unidade <span class="text-red-500">*</span>
                            </label>
                            <select
                                id="solicitar_unidade_medida"
                                name="unidade_medida"
                                required
                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500"
                            >
                                <option value="unidade">Unidade</option>
                                <option value="metro">Metro</option>
                                <option value="litro">Litro</option>
                                <option value="kg">KG</option>
                                <option value="caixa">Caixa</option>
                                <option value="pacote">Pacote</option>
                                <option value="rolo">Rolo</option>
                                <option value="conjunto">Conjunto</option>
                                <option value="peca">Peça</option>
                                <option value="galoes">Galões</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Justificativa <span class="text-red-500">*</span>
                        </label>
                        <textarea
                            name="justificativa"
                            rows="3"
                            required
                            placeholder="Ex: Necessário para reparo urgente na OS #{{ $ordem->numero }}"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500"
                        ></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Observações (Opcional)
                        </label>
                        <textarea
                            name="observacoes"
                            rows="2"
                            placeholder="Informações adicionais sobre a solicitação"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500"
                        ></textarea>
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                    <button
                        type="button"
                        onclick="fecharModalSolicitarMaterial()"
                        class="px-4 py-2 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 rounded-lg transition-colors"
                    >
                        Cancelar
                    </button>
                    <button
                        type="submit"
                        class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors"
                    >
                        Enviar Solicitação
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Toggle formulário de material quando marcar "Não precisou de material"
    function toggleMaterialForm() {
        const checkbox = document.getElementById('sem_material');
        const formMaterial = document.getElementById('formAdicionarMaterial');

        if (checkbox && formMaterial) {
            if (checkbox.checked) {
                formMaterial.classList.add('hidden');
                // Salvar preferência no servidor
                salvarSemMaterial(true);
            } else {
                formMaterial.classList.remove('hidden');
                salvarSemMaterial(false);
            }
        }
    }

    // Salvar no servidor a opção "sem material"
    function salvarSemMaterial(semMaterial) {
        fetch('{{ route("campo.ordens.sem-material", $ordem->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ sem_material: semMaterial })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Atualizado silenciosamente
                console.log('Preferência de material atualizada');
            }
        })
        .catch(error => {
            console.error('Erro ao salvar preferência:', error);
        });
    }

    function removerFoto(path, tipo) {
        if (!confirm('Deseja remover esta foto?')) return;

        fetch('{{ route("campo.ordens.fotos.remover", $ordem->id) }}', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ path, tipo })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Erro ao remover foto.');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao remover foto.');
        });
    }

    // Adicionar material à lista dinamicamente
    function adicionarMaterialNaLista(materialData) {
        const container = document.getElementById('materiais-container');

        // Se não existir, criar o container
        if (!container) {
            const materiaisSection = document.querySelector('.bg-white.dark\\:bg-gray-800.rounded-xl');
            if (materiaisSection) {
                const newContainer = document.createElement('div');
                newContainer.id = 'materiais-container';
                newContainer.className = 'space-y-3 mb-4';
                materiaisSection.appendChild(newContainer);
            }
            return;
        }

        // Remover mensagem "Nenhum material registrado" se existir
        const emptyMessage = container.querySelector('p.text-gray-500');
        if (emptyMessage) {
            emptyMessage.remove();
        }

        // Criar elemento do material
        const materialDiv = document.createElement('div');
        materialDiv.className = 'flex items-center justify-between p-4 bg-gradient-to-r from-gray-50 to-white dark:from-gray-700/50 dark:to-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg hover:shadow-md transition-all duration-200';
        materialDiv.setAttribute('data-material-id', materialData.id);

        const quantidadeFormatada = parseFloat(materialData.quantidade).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        const valorTotalFormatado = materialData.valor_total ? parseFloat(materialData.valor_total).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }) : '0,00';

        materialDiv.innerHTML = `
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1 flex-wrap">
                    <p class="font-semibold text-gray-900 dark:text-white">${materialData.nome || 'N/A'}</p>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300 border border-blue-200 dark:border-blue-800 shadow-sm">
                        <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Reservado
                    </span>
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    <span class="font-medium">Quantidade:</span> ${quantidadeFormatada} ${materialData.unidade_medida || ''}
                    ${materialData.valor_unitario ? `<span class="mx-2">•</span><span class="font-medium">Valor:</span> R$ ${valorTotalFormatado}` : ''}
                </p>
                <p class="text-xs text-blue-600 dark:text-blue-400 mt-1 flex items-center gap-1">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                    </svg>
                    Será confirmado ao concluir a OS
                </p>
            </div>
            <button
                onclick="removerMaterial(${materialData.id})"
                class="ml-3 p-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-all duration-200 hover:scale-110 active:scale-95"
                title="Remover material (a reserva será cancelada e o estoque restaurado)"
            >
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m-4.788-5l.324-1.41A2 2 0 0111.982 3h2.036a2 2 0 011.732 1.59L15.74 5l1.259 4m-4.788 0L9.26 9m-4.788-5l.324-1.41A2 2 0 015.982 3h2.036a2 2 0 011.732 1.59L9.74 5l1.259 4M9.26 9l.346 9m4.788 0l.346-9M9.26 9h5.48" />
                </svg>
            </button>
        `;

        // Adicionar ao container
        container.appendChild(materialDiv);

        // Mostrar contador se estiver oculto
        const contadorDiv = document.querySelector('#materiais-reservados-count')?.closest('.inline-flex');
        if (contadorDiv) {
            contadorDiv.classList.remove('hidden');
        }
    }

    // Atualizar contador de materiais
    function atualizarContadorMateriais() {
        const container = document.getElementById('materiais-container');
        if (!container) return;

        const materiais = container.querySelectorAll('[data-material-id]');
        const count = materiais.length;
        const countElement = document.getElementById('materiais-reservados-count');
        const textElement = document.getElementById('materiais-reservados-text');
        const contadorDiv = document.getElementById('contador-materiais');

        if (countElement) {
            countElement.textContent = count;
        }

        if (textElement) {
            textElement.textContent = count === 1 ? 'material reservado' : 'materiais reservados';
        }

        // Mostrar ou ocultar contador
        if (contadorDiv) {
            if (count === 0) {
                contadorDiv.classList.add('hidden');
            } else {
                contadorDiv.classList.remove('hidden');
            }
        }
    }

    // Mostrar mensagem de sucesso
    function mostrarMensagemSucesso(message) {
        // Criar ou atualizar mensagem de sucesso
        let alertDiv = document.getElementById('material-success-alert');

        if (!alertDiv) {
            alertDiv = document.createElement('div');
            alertDiv.id = 'material-success-alert';
            alertDiv.className = 'mb-4 p-4 bg-emerald-50 dark:bg-emerald-900/20 border border-emerald-200 dark:border-emerald-800 rounded-lg';

            const formMaterial = document.getElementById('formAdicionarMaterial');
            if (formMaterial) {
                formMaterial.parentElement.insertBefore(alertDiv, formMaterial);
            }
        }

        alertDiv.innerHTML = `
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <p class="text-sm font-medium text-emerald-800 dark:text-emerald-200">${message}</p>
            </div>
        `;

        // Remover após 5 segundos
        setTimeout(() => {
            if (alertDiv) {
                alertDiv.remove();
            }
        }, 5000);
    }

    function adicionarMaterial() {
        const materialId = document.getElementById('material_id').value;
        const quantidade = document.getElementById('quantidade_material').value;

        if (!materialId || !quantidade || parseFloat(quantidade) <= 0) {
            alert('Selecione um material e informe a quantidade.');
            return;
        }

        const materialSelect = document.getElementById('material_id');
        const materialOption = materialSelect.options[materialSelect.selectedIndex];
        const estoque = parseFloat(materialOption.getAttribute('data-estoque'));

        if (parseFloat(quantidade) > estoque) {
            alert(`Quantidade excede o estoque disponível (${estoque}).`);
            return;
        }

        fetch('{{ route("campo.ordens.materiais", $ordem->id) }}', {
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
                // Adicionar material à lista dinamicamente
                adicionarMaterialNaLista(data.material);

                // Limpar formulário
                document.getElementById('material_id').value = '';
                document.getElementById('quantidade_material').value = '';
                document.getElementById('material-sem-estoque-alerta').classList.add('hidden');

                // Atualizar contador
                atualizarContadorMateriais();

                // Mostrar mensagem de sucesso
                mostrarMensagemSucesso(data.message || 'Material adicionado com sucesso!');
            } else {
                alert('Erro ao adicionar material: ' + (data.error || 'Erro desconhecido'));
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao adicionar material.');
        });
    }

    function removerMaterial(materialId) {
        if (!confirm('Deseja remover este material? A reserva será cancelada e o estoque será restaurado.')) return;

        fetch('{{ route("campo.ordens.materiais.remover", [$ordem->id, ":materialId"]) }}'.replace(':materialId', materialId), {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            // Verificar se a resposta é JSON antes de fazer parse
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                // Se não for JSON, provavelmente é uma página de erro HTML
                return response.text().then(text => {
                    console.error('Resposta não é JSON:', text.substring(0, 200));
                    throw new Error('Resposta do servidor não é JSON. Verifique se a rota está correta.');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                // Remover elemento do DOM - usar seletor mais específico
                const container = document.getElementById('materiais-container');
                if (container) {
                    const materialElement = container.querySelector(`[data-material-id="${materialId}"]`);
                    if (materialElement) {
                        materialElement.remove();
                    }
                }

                // Atualizar contador
                atualizarContadorMateriais();

                // Se não houver mais materiais, mostrar mensagem
                if (container && container.querySelectorAll('[data-material-id]').length === 0) {
                    container.innerHTML = '<p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Nenhum material registrado.</p>';
                }

                mostrarMensagemSucesso(data.message || 'Material removido com sucesso!');
            } else {
                alert('Erro ao remover material: ' + (data.error || 'Erro desconhecido'));
            }
        })
        .catch(error => {
            console.error('Erro ao remover material:', error);
            alert('Erro ao remover material. ' + (error.message || 'Tente recarregar a página.'));
        });
    }

    // Verificar estoque do material selecionado
    function verificarEstoqueMaterial(select) {
        const alerta = document.getElementById('material-sem-estoque-alerta');
        const option = select.options[select.selectedIndex];
        const temEstoque = option.getAttribute('data-tem-estoque') === '1';

        if (!temEstoque && option.value) {
            alerta.classList.remove('hidden');
            // Armazenar dados do material para o modal
            window.materialSelecionado = {
                id: option.value,
                nome: option.getAttribute('data-material-nome'),
                codigo: option.getAttribute('data-material-codigo'),
                unidade: option.getAttribute('data-unidade')
            };
        } else {
            alerta.classList.add('hidden');
            window.materialSelecionado = null;
        }
    }

    // Abrir modal de solicitação de material
    function abrirModalSolicitarMaterial() {
        const material = window.materialSelecionado || {
            id: null,
            nome: document.getElementById('material_id').options[document.getElementById('material_id').selectedIndex]?.getAttribute('data-material-nome') || '',
            codigo: document.getElementById('material_id').options[document.getElementById('material_id').selectedIndex]?.getAttribute('data-material-codigo') || '',
            unidade: document.getElementById('material_id').options[document.getElementById('material_id').selectedIndex]?.getAttribute('data-unidade') || 'unidade'
        };

        // Preencher formulário do modal
        document.getElementById('solicitar_material_nome').value = material.nome;
        document.getElementById('solicitar_material_codigo').value = material.codigo || '';
        document.getElementById('solicitar_material_id').value = material.id || '';
        document.getElementById('solicitar_unidade_medida').value = material.unidade;
        document.getElementById('solicitar_ordem_servico_id').value = {{ $ordem->id }};

        // Mostrar modal
        document.getElementById('modalSolicitarMaterial').classList.remove('hidden');
    }

    // Fechar modal de solicitação
    function fecharModalSolicitarMaterial() {
        document.getElementById('modalSolicitarMaterial').classList.add('hidden');
        document.getElementById('formSolicitarMaterial').reset();
    }

    // Enviar solicitação de material
    function enviarSolicitacaoMaterial() {
        const form = document.getElementById('formSolicitarMaterial');
        const formData = new FormData(form);

        fetch('{{ route("campo.materiais.solicitar.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Solicitação enviada com sucesso! O administrador será notificado.');
                fecharModalSolicitarMaterial();
                // Limpar seleção de material
                document.getElementById('material_id').value = '';
                document.getElementById('material-sem-estoque-alerta').classList.add('hidden');
            } else {
                alert('Erro ao enviar solicitação: ' + (data.message || 'Erro desconhecido'));
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao enviar solicitação.');
        });
    }

    function concluirOrdem() {
        document.getElementById('modalConcluir').classList.remove('hidden');
    }

    function fecharModalConcluir() {
        document.getElementById('modalConcluir').classList.add('hidden');
    }

    // Preview das fotos selecionadas no modal de conclusão
    function previewFotosModal(input) {
        const previewContainer = document.getElementById('preview-fotos-modal');
        const files = Array.from(input.files);

        if (files.length === 0) {
            previewContainer.classList.add('hidden');
            previewContainer.innerHTML = '';
            return;
        }

        previewContainer.classList.remove('hidden');
        previewContainer.innerHTML = '';

        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-20 object-cover rounded-lg border border-emerald-300 dark:border-emerald-600">
                    <div class="absolute bottom-1 left-1 px-1.5 py-0.5 bg-emerald-500 text-white text-xs font-medium rounded">
                        Nova
                    </div>
                `;
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(file);
        });

        // Atualizar contador no resumo
        const resumoFotosDepois = document.getElementById('resumo-fotos-depois');
        if (resumoFotosDepois) {
            const existentes = {{ is_array($ordem->fotos_depois) ? count($ordem->fotos_depois) : 0 }};
            resumoFotosDepois.textContent = (existentes + files.length) + ' (+ ' + files.length + ' nova(s))';
        }
    }
</script>
@endpush
@endsection


