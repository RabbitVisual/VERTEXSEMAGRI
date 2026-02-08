@extends('admin.layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Etapa 3: Familiares</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Adicione informações dos familiares</p>
        </div>
        <a href="{{ route('caf.cadastrador.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <x-icon name="x-mark" class="w-6 h-6" />
        </a>
    </div>

    <!-- Progresso -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-4">
        <div class="flex items-center justify-between text-sm">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center font-semibold">✓</div>
                <span class="font-medium text-green-600 dark:text-green-400">Dados Pessoais</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center font-semibold">✓</div>
                <span class="font-medium text-green-600 dark:text-green-400">Cônjuge</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-purple-600 text-white flex items-center justify-center font-semibold">3</div>
                <span class="font-medium text-purple-600 dark:text-purple-400">Familiares</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-600 dark:text-gray-400 flex items-center justify-center font-semibold">4</div>
                <span class="text-gray-500 dark:text-gray-400">Imóvel</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-600 dark:text-gray-400 flex items-center justify-center font-semibold">5</div>
                <span class="text-gray-500 dark:text-gray-400">Renda</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-600 dark:text-gray-400 flex items-center justify-center font-semibold">6</div>
                <span class="text-gray-500 dark:text-gray-400">Revisão</span>
            </div>
        </div>
    </div>

    <!-- Formulário -->
    <form method="POST" action="{{ route('caf.cadastrador.store-etapa3', $cadastro->id) }}" class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6 space-y-6">
        @csrf

        <div class="bg-gradient-to-r from-purple-600 via-violet-600 to-fuchsia-600 px-6 py-4 rounded-t-lg -mt-6 -mx-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                    <x-icon name="users" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Familiares</h3>
                    <p class="text-purple-100 text-sm mt-1">Adicione informações dos filhos e outros familiares</p>
                </div>
            </div>
        </div>

        <div id="familiares-container" class="space-y-4">
            @if($cadastro->familiares && $cadastro->familiares->count() > 0)
                @foreach($cadastro->familiares as $index => $familiar)
                    <div class="familiar-item bg-gray-50 dark:bg-slate-700 rounded-lg p-6 border border-gray-200 dark:border-slate-600">
                        <div class="flex items-center justify-between mb-4">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                                <x-icon name="user" class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                                Familiar {{ $index + 1 }}
                            </h4>
                            <button type="button" onclick="removeFamiliar(this)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                                <x-icon name="trash" class="w-5 h-5" />
                            </button>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nome Completo <span class="text-red-500">*</span></label>
                                <input type="text" name="familiares[{{ $index }}][nome_completo]" value="{{ old("familiares.$index.nome_completo", $familiar->nome_completo) }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CPF</label>
                                <input type="text" name="familiares[{{ $index }}][cpf]" value="{{ old("familiares.$index.cpf", $familiar->cpf) }}" maxlength="14" class="cpf-input w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">RG</label>
                                <input type="text" name="familiares[{{ $index }}][rg]" value="{{ old("familiares.$index.rg", $familiar->rg) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data de Nascimento</label>
                                <input type="date" name="familiares[{{ $index }}][data_nascimento]" value="{{ old("familiares.$index.data_nascimento", $familiar->data_nascimento?->format('Y-m-d')) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sexo</label>
                                <select name="familiares[{{ $index }}][sexo]" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="">Selecione...</option>
                                    <option value="M" {{ old("familiares.$index.sexo", $familiar->sexo) == 'M' ? 'selected' : '' }}>Masculino</option>
                                    <option value="F" {{ old("familiares.$index.sexo", $familiar->sexo) == 'F' ? 'selected' : '' }}>Feminino</option>
                                    <option value="Outro" {{ old("familiares.$index.sexo", $familiar->sexo) == 'Outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Parentesco <span class="text-red-500">*</span></label>
                                <select name="familiares[{{ $index }}][parentesco]" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="">Selecione...</option>
                                    <option value="filho" {{ old("familiares.$index.parentesco", $familiar->parentesco) == 'filho' ? 'selected' : '' }}>Filho(a)</option>
                                    <option value="pai" {{ old("familiares.$index.parentesco", $familiar->parentesco) == 'pai' ? 'selected' : '' }}>Pai</option>
                                    <option value="mae" {{ old("familiares.$index.parentesco", $familiar->parentesco) == 'mae' ? 'selected' : '' }}>Mãe</option>
                                    <option value="irmao" {{ old("familiares.$index.parentesco", $familiar->parentesco) == 'irmao' ? 'selected' : '' }}>Irmão(ã)</option>
                                    <option value="neto" {{ old("familiares.$index.parentesco", $familiar->parentesco) == 'neto' ? 'selected' : '' }}>Neto(a)</option>
                                    <option value="avo" {{ old("familiares.$index.parentesco", $familiar->parentesco) == 'avo' ? 'selected' : '' }}>Avô(ó)</option>
                                    <option value="outro" {{ old("familiares.$index.parentesco", $familiar->parentesco) == 'outro' ? 'selected' : '' }}>Outro</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Escolaridade</label>
                                <select name="familiares[{{ $index }}][escolaridade]" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="">Selecione...</option>
                                    <option value="analfabeto" {{ old("familiares.$index.escolaridade", $familiar->escolaridade) == 'analfabeto' ? 'selected' : '' }}>Analfabeto</option>
                                    <option value="fundamental_incompleto" {{ old("familiares.$index.escolaridade", $familiar->escolaridade) == 'fundamental_incompleto' ? 'selected' : '' }}>Fundamental Incompleto</option>
                                    <option value="fundamental_completo" {{ old("familiares.$index.escolaridade", $familiar->escolaridade) == 'fundamental_completo' ? 'selected' : '' }}>Fundamental Completo</option>
                                    <option value="medio_incompleto" {{ old("familiares.$index.escolaridade", $familiar->escolaridade) == 'medio_incompleto' ? 'selected' : '' }}>Médio Incompleto</option>
                                    <option value="medio_completo" {{ old("familiares.$index.escolaridade", $familiar->escolaridade) == 'medio_completo' ? 'selected' : '' }}>Médio Completo</option>
                                    <option value="superior_incompleto" {{ old("familiares.$index.escolaridade", $familiar->escolaridade) == 'superior_incompleto' ? 'selected' : '' }}>Superior Incompleto</option>
                                    <option value="superior_completo" {{ old("familiares.$index.escolaridade", $familiar->escolaridade) == 'superior_completo' ? 'selected' : '' }}>Superior Completo</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Trabalha?</label>
                                <select name="familiares[{{ $index }}][trabalha]" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                                    <option value="0" {{ old("familiares.$index.trabalha", $familiar->trabalha) == 0 ? 'selected' : '' }}>Não</option>
                                    <option value="1" {{ old("familiares.$index.trabalha", $familiar->trabalha) == 1 ? 'selected' : '' }}>Sim</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Renda Mensal (R$)</label>
                                <input type="number" name="familiares[{{ $index }}][renda_mensal]" step="0.01" min="0" value="{{ old("familiares.$index.renda_mensal", $familiar->renda_mensal) }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <div class="flex justify-center">
            <button type="button" onclick="addFamiliar()" class="inline-flex items-center gap-2 px-6 py-3 border-2 border-purple-300 dark:border-purple-600 text-purple-700 dark:text-purple-300 bg-purple-50 dark:bg-purple-900/20 rounded-lg hover:bg-purple-100 dark:hover:bg-purple-900/30 transition-colors">
                <x-icon name="plus-circle" class="w-5 h-5" />
                Adicionar Familiar
            </button>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
            <a href="{{ route('caf.cadastrador.etapa2', $cadastro->id) }}" class="px-6 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">
                Voltar
            </a>
            <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                Próxima Etapa →
            </button>
        </div>
    </form>
</div>

<template id="familiar-template">
    <div class="familiar-item bg-gray-50 dark:bg-slate-700 rounded-lg p-6 border border-gray-200 dark:border-slate-600">
        <div class="flex items-center justify-between mb-4">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon name="user" class="w-5 h-5 text-purple-600 dark:text-purple-400" />
                Familiar <span class="familiar-number"></span>
            </h4>
            <button type="button" onclick="removeFamiliar(this)" class="text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 transition-colors p-2 rounded-lg hover:bg-red-50 dark:hover:bg-red-900/20">
                <x-icon name="trash" class="w-5 h-5" />
            </button>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nome Completo <span class="text-red-500">*</span></label>
                <input type="text" name="familiares[IDX][nome_completo]" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CPF</label>
                <input type="text" name="familiares[IDX][cpf]" maxlength="14" class="cpf-input w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">RG</label>
                <input type="text" name="familiares[IDX][rg]" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data de Nascimento</label>
                <input type="date" name="familiares[IDX][data_nascimento]" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sexo</label>
                <select name="familiares[IDX][sexo]" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">Selecione...</option>
                    <option value="M">Masculino</option>
                    <option value="F">Feminino</option>
                    <option value="Outro">Outro</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Parentesco <span class="text-red-500">*</span></label>
                <select name="familiares[IDX][parentesco]" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">Selecione...</option>
                    <option value="filho">Filho(a)</option>
                    <option value="pai">Pai</option>
                    <option value="mae">Mãe</option>
                    <option value="irmao">Irmão(ã)</option>
                    <option value="neto">Neto(a)</option>
                    <option value="avo">Avô(ó)</option>
                    <option value="outro">Outro</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Escolaridade</label>
                <select name="familiares[IDX][escolaridade]" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="">Selecione...</option>
                    <option value="analfabeto">Analfabeto</option>
                    <option value="fundamental_incompleto">Fundamental Incompleto</option>
                    <option value="fundamental_completo">Fundamental Completo</option>
                    <option value="medio_incompleto">Médio Incompleto</option>
                    <option value="medio_completo">Médio Completo</option>
                    <option value="superior_incompleto">Superior Incompleto</option>
                    <option value="superior_completo">Superior Completo</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Trabalha?</label>
                <select name="familiares[IDX][trabalha]" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
                    <option value="0">Não</option>
                    <option value="1">Sim</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Renda Mensal (R$)</label>
                <input type="number" name="familiares[IDX][renda_mensal]" step="0.01" min="0" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-gray-900 dark:text-white focus:ring-2 focus:ring-purple-500 focus:border-transparent">
            </div>
        </div>
    </div>
</template>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    let familiarIndex = {{ $cadastro->familiares ? $cadastro->familiares->count() : 0 }};
    
    // Auto-completar familiares se houver família cadastrada
    @if(isset($familia) && $familia->count() > 0)
        const familia = @json($familia->map(function($p) {
            return [
                'id' => $p->id,
                'nome' => $p->nom_pessoa,
                'cpf' => $p->num_cpf_pessoa,
                'cpf_formatado' => $p->cpf_formatado ?? $p->num_cpf_pessoa,
                'data_nascimento' => $p->data_nascimento ? $p->data_nascimento->format('Y-m-d') : null,
                'sexo' => $p->cod_sexo_pessoa == 1 ? 'M' : ($p->cod_sexo_pessoa == 2 ? 'F' : null),
                'idade' => $p->idade,
            ];
        }));
        
        // Se não houver familiares cadastrados ainda, adicionar automaticamente
        const container = document.getElementById('familiares-container');
        if (container && familiarIndex === 0 && familia.length > 0) {
            // Mostrar aviso
            if (!document.getElementById('familia-auto-complete')) {
                const alertDiv = document.createElement('div');
                alertDiv.id = 'familia-auto-complete';
                alertDiv.className = 'bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4';
                alertDiv.innerHTML = `
                    <div class="flex items-start gap-3">
                        <x-icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                        <div>
                            <h3 class="font-medium text-blue-900 dark:text-blue-300">Família Cadastrada no CadÚnico</h3>
                            <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">Encontramos ${familia.length} familiar(es) cadastrado(s) na base. Clique no botão abaixo para adicionar automaticamente ou adicione manualmente.</p>
                            <button type="button" onclick="adicionarFamiliaCompleta()" class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm">
                                Adicionar Todos os Familiares
                            </button>
                        </div>
                    </div>
                `;
                container.insertBefore(alertDiv, container.firstChild);
            }
            
            // Função para adicionar família completa
            window.adicionarFamiliaCompleta = function() {
                familia.forEach((familiar, index) => {
                    addFamiliar();
                    const lastItem = container.querySelector('.familiar-item:last-child');
                    if (lastItem) {
                        const nomeInput = lastItem.querySelector('input[name*="[nome_completo]"]');
                        if (nomeInput) nomeInput.value = familiar.nome;
                        
                        const cpfInput = lastItem.querySelector('input[name*="[cpf]"]');
                        if (cpfInput && familiar.cpf) {
                            const cpfFormatado = familiar.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                            cpfInput.value = cpfFormatado;
                        }
                        
                        const dataNascInput = lastItem.querySelector('input[name*="[data_nascimento]"]');
                        if (dataNascInput && familiar.data_nascimento) {
                            dataNascInput.value = familiar.data_nascimento;
                        }
                        
                        const sexoSelect = lastItem.querySelector('select[name*="[sexo]"]');
                        if (sexoSelect && familiar.sexo) {
                            sexoSelect.value = familiar.sexo;
                        }
                        
                        // Determinar parentesco baseado na idade
                        const parentescoSelect = lastItem.querySelector('select[name*="[parentesco]"]');
                        if (parentescoSelect) {
                            if (familiar.idade && familiar.idade < 18) {
                                parentescoSelect.value = 'filho';
                            } else if (familiar.idade && familiar.idade >= 60) {
                                parentescoSelect.value = 'avo';
                            } else {
                                parentescoSelect.value = 'outro';
                            }
                        }
                    }
                });
                
                // Remover aviso após adicionar
                const alertDiv = document.getElementById('familia-auto-complete');
                if (alertDiv) alertDiv.remove();
            };
        }
    @endif
});

    function addFamiliar() {
        const template = document.getElementById('familiar-template').innerHTML;
        const container = document.getElementById('familiares-container');
        const newFamiliar = template.replace(/IDX/g, familiarIndex++);
        container.insertAdjacentHTML('beforeend', newFamiliar);
        updateFamiliarNumbers();
    }

    function removeFamiliar(button) {
        button.closest('.familiar-item').remove();
        updateFamiliarNumbers();
    }

    function updateFamiliarNumbers() {
        const items = document.querySelectorAll('.familiar-item');
        items.forEach((item, index) => {
            const numberSpan = item.querySelector('.familiar-number');
            if (numberSpan) {
                numberSpan.textContent = index + 1;
            }
        });
    }

    // Máscara de CPF
    document.addEventListener('input', function(e) {
        if (e.target.classList.contains('cpf-input')) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                e.target.value = value;
            }
        }
    });
</script>
@endpush
@endsection
