@extends('admin.layouts.admin')

@section('title', 'Solicitar Materiais - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 max-w-full overflow-x-hidden">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 pb-4 md:pb-6 border-b border-gray-200 dark:border-slate-700">
        <div>
            <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 dark:text-white flex items-center gap-3 mb-2">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                    <x-icon name="eye" class="w-5 h-5" />
                Visualizar PDF
            </button>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-6 py-3 text-sm font-medium text-white bg-emerald-600 rounded-lg hover:bg-emerald-700 focus:ring-4 focus:ring-emerald-300 dark:bg-emerald-600 dark:hover:bg-emerald-700 dark:focus:ring-emerald-800 transition-colors shadow-lg hover:shadow-xl">
                <x-icon name="file-pdf" class="w-5 h-5" />
                    Material Não Cadastrado
                </h4>
                <button type="button" class="btn-remover-customizado text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300" title="Remover">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Nome do Material <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="materiais_customizados[${index}][nome]"
                           required
                           placeholder="Ex: Parafuso 6mm"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-900 dark:text-white mb-1">
                        Especificação Técnica
                    </label>
                    <input type="text"
                           name="materiais_customizados[${index}][especificacao]"
                           placeholder="Ex: Aço inox, 6mm x 20mm"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-900 dark:text-white mb-1">
                        Quantidade <span class="text-red-500">*</span>
                    </label>
                    <input type="number"
                           name="materiais_customizados[${index}][quantidade]"
                           step="0.01"
                           min="0.01"
                           required
                           placeholder="0.00"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-900 dark:text-white mb-1">
                        Unidade de Medida <span class="text-red-500">*</span>
                    </label>
                    <select name="materiais_customizados[${index}][unidade_medida]"
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                        <option value="unidade">Unidade</option>
                        <option value="metro">Metro</option>
                        <option value="litro">Litro</option>
                        <option value="kg">Quilograma</option>
                        <option value="caixa">Caixa</option>
                        <option value="pacote">Pacote</option>
                    </select>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-medium text-gray-900 dark:text-white mb-1">
                        Justificativa <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           name="materiais_customizados[${index}][justificativa]"
                           required
                           placeholder="Ex: Material necessário para manutenção de equipamentos"
                           class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block w-full p-2.5 dark:bg-slate-700 dark:border-slate-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-emerald-500 dark:focus:border-emerald-500">
                </div>
            </div>
        `;

        materiaisCustomizados.appendChild(materialCustomizado);

        // Adicionar evento de remoção
        materialCustomizado.querySelector('.btn-remover-customizado').addEventListener('click', function() {
            materialCustomizado.remove();
        });
    });

    // Função para preparar dados do formulário antes da validação
    function prepararDadosFormulario() {
        // Garantir que apenas campos selecionados tenham required
        checkboxes.forEach(checkbox => {
            const form = checkbox.closest('.material-item')?.querySelector('.material-form');
            if (form) {
                const inputs = form.querySelectorAll('input:not([type="checkbox"])');
                if (checkbox.checked) {
                    // Se está marcado, garantir que está habilitado e required
                    inputs.forEach(input => {
                        input.removeAttribute('disabled');
                        if (input.hasAttribute('data-required')) {
                            input.setAttribute('required', 'required');
                        }
                    });
                } else {
                    // Se não está marcado, remover required e desabilitar
                    inputs.forEach(input => {
                        input.removeAttribute('required');
                        input.setAttribute('disabled', 'disabled');
                    });
                }
            }
        });

        // Materiais customizados sempre devem estar habilitados e com required
        document.querySelectorAll('.material-customizado input[required], .material-customizado select[required]').forEach(input => {
            input.removeAttribute('disabled');
        });
    }

    // Visualizar PDF
    btnVisualizar.addEventListener('click', function(e) {
        e.preventDefault();

        // Preparar dados antes de validar
        prepararDadosFormulario();

        // Validar formulário
        if (!formSolicitacao.checkValidity()) {
            formSolicitacao.reportValidity();
            return;
        }

        // Criar formulário temporário para visualização
        const formData = new FormData(formSolicitacao);
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route('admin.materiais.solicitar.visualizar-pdf') }}';
        form.target = '_blank';

        // Adicionar token CSRF
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        // Adicionar apenas campos válidos (não desabilitados)
        formData.forEach((value, key) => {
            // Ignorar campos desabilitados
            const input = formSolicitacao.querySelector(`[name="${key}"]`);
            if (input && !input.disabled) {
                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = key;
                hiddenInput.value = value;
                form.appendChild(hiddenInput);
            }
        });

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    });

    // Reindexar materiais ao remover
    formSolicitacao.addEventListener('submit', function(e) {
        // Preparar dados antes de validar - remover required de campos não selecionados
        checkboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                const form = checkbox.closest('.material-item')?.querySelector('.material-form');
                if (form) {
                    form.querySelectorAll('input[required]').forEach(input => {
                        input.removeAttribute('required');
                        input.setAttribute('disabled', 'disabled');
                    });
                }
            }
        });

        // Validar antes de reindexar
        if (!formSolicitacao.checkValidity()) {
            e.preventDefault();
            formSolicitacao.reportValidity();
            return false;
        }

        // Reindexar apenas materiais selecionados
        let index = 0;
        const selectedCheckboxes = Array.from(checkboxes).filter(cb => cb.checked);

        selectedCheckboxes.forEach(checkbox => {
            const item = checkbox.closest('.material-item');
            const form = item.querySelector('.material-form');

            // Atualizar índices
            checkbox.name = `materiais[${index}][material_id]`;
            form.querySelectorAll('input').forEach(input => {
                if (input.name.includes('[quantidade]')) {
                    input.name = `materiais[${index}][quantidade]`;
                } else if (input.name.includes('[justificativa]')) {
                    input.name = `materiais[${index}][justificativa]`;
                }
            });

            index++;
        });

        // Reindexar materiais customizados
        let customIndex = 0;
        document.querySelectorAll('.material-customizado').forEach(item => {
            const inputs = item.querySelectorAll('input, select');
            inputs.forEach(input => {
                const name = input.name;
                if (name.includes('materiais_customizados[')) {
                    input.name = name.replace(/materiais_customizados\[\d+\]/, `materiais_customizados[${customIndex}]`);
                }
            });
            customIndex++;
        });

        // Remover campos não selecionados do formulário antes de enviar
        checkboxes.forEach(checkbox => {
            if (!checkbox.checked) {
                const form = checkbox.closest('.material-item')?.querySelector('.material-form');
                if (form) {
                    form.querySelectorAll('input').forEach(input => {
                        input.remove();
                    });
                }
            }
        });
        });
    });

    @if(isset($solicitacaoCampo) && $solicitacaoCampo)
    // Pré-preencher material customizado quando vier de solicitação do campo
    document.addEventListener('DOMContentLoaded', function() {
        const btnAdicionar = document.getElementById('btnAdicionarCustomizado');
        if (btnAdicionar) {
            btnAdicionar.click();

            setTimeout(function() {
                const container = document.getElementById('materiais_customizados');
                const ultimoItem = container.querySelector('.material-customizado:last-child');

                if (ultimoItem) {
                    const nomeInput = ultimoItem.querySelector('input[name*="[nome]"]');
                    const especificacaoInput = ultimoItem.querySelector('input[name*="[especificacao]"]');
                    const quantidadeInput = ultimoItem.querySelector('input[name*="[quantidade]"]');
                    const unidadeSelect = ultimoItem.querySelector('select[name*="[unidade_medida]"]');
                    const justificativaInput = ultimoItem.querySelector('input[name*="[justificativa]"]');

                    if (nomeInput) nomeInput.value = '{{ $solicitacaoCampo->material_nome }}';
                    if (especificacaoInput && '{{ $solicitacaoCampo->material_codigo }}') {
                        especificacaoInput.value = 'Código: {{ $solicitacaoCampo->material_codigo }}';
                    }
                    if (quantidadeInput) quantidadeInput.value = '{{ $solicitacaoCampo->quantidade }}';
                    if (unidadeSelect) unidadeSelect.value = '{{ $solicitacaoCampo->unidade_medida }}';
                    if (justificativaInput) justificativaInput.value = '{{ $solicitacaoCampo->justificativa }}';
                }
            }, 100);
        }
    });
    @endif
</script>
@endpush
@endsection

