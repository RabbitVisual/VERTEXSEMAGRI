@extends('admin.layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Etapa 1: Dados Pessoais</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Informações básicas do agricultor familiar</p>
        </div>
        <a href="{{ route('caf.cadastrador.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <x-icon name="x-mark" class="w-6 h-6" />
        </a>
    </div>

    <!-- Progresso -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-4">
        <div class="flex items-center justify-between text-sm">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold">1</div>
                <span class="font-medium text-blue-600 dark:text-blue-400">Dados Pessoais</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-600 dark:text-gray-400 flex items-center justify-center font-semibold">2</div>
                <span class="text-gray-500 dark:text-gray-400">Cônjuge</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-600 dark:text-gray-400 flex items-center justify-center font-semibold">3</div>
                <span class="text-gray-500 dark:text-gray-400">Familiares</span>
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

    <!-- Busca de Pessoa no CadÚnico -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6 mb-6">
        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
            <x-icon name="user" class="w-4 h-4 inline mr-1" />
            Buscar Pessoa no CadÚnico
            <span class="text-gray-500 dark:text-gray-400 text-xs font-normal">(Opcional - Busque por nome, NIS ou CPF)</span>
        </label>
        <div class="flex gap-2">
            <div class="flex-1 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-icon name="magnifying-glass" class="h-5 w-5 text-gray-400" />
                </div>
                <input type="text"
                       id="buscar_pessoa"
                       placeholder="Digite o nome, NIS ou CPF para buscar..."
                       autocomplete="off"
                       class="block w-full pl-10 pr-3 py-2 border border-gray-300 dark:border-slate-600 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-slate-700 dark:text-white dark:placeholder-gray-400 sm:text-sm">
            </div>
            <button type="button" id="limpar_busca" class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-600">
                <x-icon name="x-mark" class="w-5 h-5" />
            </button>
        </div>
        <div id="resultados_busca" class="mt-2 hidden"></div>
        <div id="pessoa_selecionada" class="mt-3 hidden">
            <div class="rounded-lg border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-900/20 p-4">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <x-icon name="check-circle" class="h-5 w-5 text-emerald-400" />
                            <strong id="pessoa_nome_selecionada" class="text-emerald-800 dark:text-emerald-200"></strong>
                        </div>
                        <small id="pessoa_info_selecionada" class="text-emerald-700 dark:text-emerald-300 text-sm"></small>
                    </div>
                    <button type="button" id="remover_pessoa" class="ml-4 p-1 text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300">
                        <x-icon name="x-mark" class="w-5 h-5" />
                    </button>
                </div>
            </div>
        </div>
    </div>

    @if($pessoa)
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-6">
            <div class="flex items-start gap-3">
                <x-icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                <div>
                    <h3 class="font-medium text-blue-900 dark:text-blue-300">Dados da Base Municipal</h3>
                    <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">Os dados abaixo foram preenchidos automaticamente da base municipal. Você pode editar se necessário.</p>
                </div>
            </div>
        </div>
    @endif

    <!-- Formulário -->
    <form method="POST" action="{{ route('caf.cadastrador.store-etapa1') }}" id="formEtapa1" class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6 space-y-6">
        @csrf
        
        <input type="hidden" id="pessoa_id" name="pessoa_id" value="{{ old('pessoa_id', isset($pessoa) ? $pessoa->id : '') }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nome Completo <span class="text-red-500">*</span></label>
                <input type="text" name="nome_completo" value="{{ old('nome_completo', isset($pessoa) && $pessoa->nom_pessoa ? $pessoa->nom_pessoa : '') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('nome_completo')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CPF <span class="text-red-500">*</span></label>
                <input type="text" name="cpf" id="cpf" value="{{ old('cpf', isset($pessoa) && $pessoa->num_cpf_pessoa ? $pessoa->num_cpf_pessoa : '') }}" required maxlength="14" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                @error('cpf')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">RG</label>
                <input type="text" name="rg" value="{{ old('rg') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data de Nascimento</label>
                <input type="date" name="data_nascimento" value="{{ old('data_nascimento', isset($pessoa) && $pessoa->data_nascimento ? $pessoa->data_nascimento->format('Y-m-d') : '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sexo</label>
                <select name="sexo" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Selecione...</option>
                    <option value="M" {{ old('sexo') == 'M' ? 'selected' : '' }}>Masculino</option>
                    <option value="F" {{ old('sexo') == 'F' ? 'selected' : '' }}>Feminino</option>
                    <option value="Outro" {{ old('sexo') == 'Outro' ? 'selected' : '' }}>Outro</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Estado Civil</label>
                <select name="estado_civil" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Selecione...</option>
                    <option value="solteiro" {{ old('estado_civil') == 'solteiro' ? 'selected' : '' }}>Solteiro(a)</option>
                    <option value="casado" {{ old('estado_civil') == 'casado' ? 'selected' : '' }}>Casado(a)</option>
                    <option value="divorciado" {{ old('estado_civil') == 'divorciado' ? 'selected' : '' }}>Divorciado(a)</option>
                    <option value="viuvo" {{ old('estado_civil') == 'viuvo' ? 'selected' : '' }}>Viúvo(a)</option>
                    <option value="uniao_estavel" {{ old('estado_civil') == 'uniao_estavel' ? 'selected' : '' }}>União Estável</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Telefone</label>
                <input type="text" name="telefone" id="telefone" value="{{ old('telefone') }}" maxlength="14" placeholder="(00) 0000-0000" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Celular</label>
                <input type="text" name="celular" id="celular" value="{{ old('celular') }}" maxlength="15" placeholder="(00) 00000-0000" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">E-mail</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Localidade</label>
                <select name="localidade_id" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">Selecione...</option>
                    @foreach($localidades as $localidade)
                        <option value="{{ $localidade->id }}" {{ old('localidade_id', isset($pessoa) && $pessoa->localidade_id ? $pessoa->localidade_id : '') == $localidade->id ? 'selected' : '' }}>{{ $localidade->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CEP</label>
                <input type="text" name="cep" id="cep" value="{{ old('cep') }}" maxlength="9" placeholder="00000-000" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Logradouro</label>
                <input type="text" name="logradouro" value="{{ old('logradouro') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Número</label>
                <input type="text" name="numero" value="{{ old('numero') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Complemento</label>
                <input type="text" name="complemento" value="{{ old('complemento') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bairro</label>
                <input type="text" name="bairro" value="{{ old('bairro') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cidade</label>
                <input type="text" name="cidade" value="{{ old('cidade') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">UF</label>
                <input type="text" name="uf" value="{{ old('uf') }}" maxlength="2" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
            <a href="{{ route('caf.cadastrador.index') }}" class="px-6 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">
                Cancelar
            </a>
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Próxima Etapa →
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Máscara de CPF
    const cpfInput = document.getElementById('cpf');
    if (cpfInput) {
        cpfInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d)/, '$1.$2');
                value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
                e.target.value = value;
            }
        });
    }

    // Máscara de Telefone
    const telefoneInput = document.getElementById('telefone');
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 10) {
                value = value.replace(/^(\d{2})(\d)/, '($1) $2');
                value = value.replace(/(\d{4})(\d)/, '$1-$2');
                e.target.value = value;
            }
        });
    }

    // Máscara de Celular
    const celularInput = document.getElementById('celular');
    if (celularInput) {
        celularInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                if (value.length <= 10) {
                    value = value.replace(/^(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{4})(\d)/, '$1-$2');
                } else {
                    value = value.replace(/^(\d{2})(\d)/, '($1) $2');
                    value = value.replace(/(\d{5})(\d)/, '$1-$2');
                }
                e.target.value = value;
            }
        });
    }

    // Máscara de CEP
    const cepInput = document.getElementById('cep');
    if (cepInput) {
        cepInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 8) {
                value = value.replace(/^(\d{5})(\d)/, '$1-$2');
                e.target.value = value;
            }
        });
    }

    // Busca de pessoas
    let buscaTimeout;
    const buscarPessoaInput = document.getElementById('buscar_pessoa');
    const resultadosBusca = document.getElementById('resultados_busca');
    const pessoaSelecionada = document.getElementById('pessoa_selecionada');
    const pessoaIdInput = document.getElementById('pessoa_id');
    const formEtapa1 = document.getElementById('formEtapa1');

    if (buscarPessoaInput) {
        buscarPessoaInput.addEventListener('input', function() {
            const query = this.value.trim();
            clearTimeout(buscaTimeout);

            if (query.length < 2) {
                resultadosBusca.classList.add('hidden');
                return;
            }

            buscaTimeout = setTimeout(() => {
                fetch(`{{ route('caf.cadastrador.buscar-pessoa') }}?q=${encodeURIComponent(query)}`, {
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    }
                })
                    .then(response => {
                        if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                        return response.json();
                    })
                    .then(data => {
                        if (data.length === 0) {
                            resultadosBusca.innerHTML = `
                                <div class="rounded-lg border border-blue-200 dark:border-blue-800 bg-blue-50 dark:bg-blue-900/20 p-3">
                                    <div class="flex items-center gap-2 text-blue-800 dark:text-blue-200">
                                        <x-icon name="information-circle" class="h-5 w-5 text-blue-400" />
                                        Nenhuma pessoa encontrada. Você pode preencher os dados manualmente.
                                    </div>
                                </div>
                            `;
                            resultadosBusca.classList.remove('hidden');
                            return;
                        }

                        let html = '<div class="space-y-2">';
                        data.forEach(pessoa => {
                            let info = [];
                            if (pessoa.nis_formatado) info.push(`NIS: ${pessoa.nis_formatado}`);
                            if (pessoa.cpf_formatado) info.push(`CPF: ${pessoa.cpf_formatado}`);
                            if (pessoa.localidade_nome) info.push(`Localidade: ${pessoa.localidade_nome}`);
                            if (pessoa.idade) info.push(`Idade: ${pessoa.idade} anos`);

                            html += `
                                <a href="#" class="block p-3 border border-gray-200 dark:border-slate-700 rounded-lg hover:bg-gray-50 dark:hover:bg-slate-700 pessoa-item transition-colors"
                                   data-pessoa-id="${pessoa.id}"
                                   data-pessoa-nome="${pessoa.nome}"
                                   data-pessoa-localidade-id="${pessoa.localidade_id || ''}"
                                   data-pessoa-localidade-nome="${pessoa.localidade_nome || ''}">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <div class="font-medium text-gray-900 dark:text-white">${pessoa.nome}${pessoa.apelido ? ` (${pessoa.apelido})` : ''}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">${info.join(' • ')}</div>
                                        </div>
                                        ${pessoa.recebe_pbf ? '<span class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 dark:bg-emerald-900 text-emerald-800 dark:text-emerald-200">PBF</span>' : ''}
                                    </div>
                                </a>
                            `;
                        });
                        html += '</div>';
                        resultadosBusca.innerHTML = html;
                        resultadosBusca.classList.remove('hidden');

                        document.querySelectorAll('.pessoa-item').forEach(item => {
                            item.addEventListener('click', function(e) {
                                e.preventDefault();
                                selecionarPessoa(this);
                            });
                        });
                    })
                    .catch(error => {
                        console.error('Erro ao buscar pessoa:', error);
                        resultadosBusca.innerHTML = '<div class="rounded-lg border border-red-200 dark:border-red-800 bg-red-50 dark:bg-red-900/20 p-3 text-red-800 dark:text-red-200">Erro ao buscar pessoa. Tente novamente.</div>';
                        resultadosBusca.classList.remove('hidden');
                    });
            }, 300);
        });
    }

    function selecionarPessoa(element) {
        const pessoaId = element.getAttribute('data-pessoa-id');
        const urlBase = '{{ url("/cadastrador/caf/pessoa") }}';
        
        fetch(`${urlBase}/${pessoaId}`)
            .then(response => response.json())
            .then(pessoa => {
                // Preencher campos da etapa 1
                pessoaIdInput.value = pessoa.id;
                
                const nomeInput = document.querySelector('input[name="nome_completo"]');
                if (nomeInput) nomeInput.value = pessoa.nome;
                
                const cpfInput = document.querySelector('input[name="cpf"]');
                if (cpfInput && pessoa.cpf) {
                    const cpfFormatado = pessoa.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                    cpfInput.value = cpfFormatado;
                }
                
                const dataNascInput = document.querySelector('input[name="data_nascimento"]');
                if (dataNascInput && pessoa.data_nascimento) {
                    dataNascInput.value = pessoa.data_nascimento;
                }
                
                const sexoSelect = document.querySelector('select[name="sexo"]');
                if (sexoSelect && pessoa.sexo) {
                    sexoSelect.value = pessoa.sexo;
                }
                
                const localidadeSelect = document.querySelector('select[name="localidade_id"]');
                if (localidadeSelect && pessoa.localidade_id) {
                    localidadeSelect.value = pessoa.localidade_id;
                }

                // Exibir pessoa selecionada
                document.getElementById('pessoa_nome_selecionada').textContent = pessoa.nome;
                let info = [];
                if (pessoa.nis_formatado) info.push(`NIS: ${pessoa.nis_formatado}`);
                if (pessoa.cpf_formatado) info.push(`CPF: ${pessoa.cpf_formatado}`);
                if (pessoa.localidade_nome) {
                    info.push(`Localidade: ${pessoa.localidade_nome}`);
                }
                if (pessoa.idade) info.push(`Idade: ${pessoa.idade} anos`);
                if (pessoa.recebe_pbf) info.push(`Beneficiária PBF`);
                document.getElementById('pessoa_info_selecionada').innerHTML = info.join(' • ');

                pessoaSelecionada.classList.remove('hidden');
                resultadosBusca.classList.add('hidden');
                buscarPessoaInput.value = '';

                // Armazenar dados da pessoa e família para uso nas próximas etapas
                sessionStorage.setItem('caf_pessoa_selecionada', JSON.stringify(pessoa));
            })
            .catch(error => {
                console.error('Erro ao obter dados da pessoa:', error);
            });
    }

    // Remover pessoa selecionada
    const removerPessoaBtn = document.getElementById('remover_pessoa');
    if (removerPessoaBtn) {
        removerPessoaBtn.addEventListener('click', function() {
            pessoaIdInput.value = '';
            pessoaSelecionada.classList.add('hidden');
            sessionStorage.removeItem('caf_pessoa_selecionada');
        });
    }

    // Limpar busca
    const limparBuscaBtn = document.getElementById('limpar_busca');
    if (limparBuscaBtn) {
        limparBuscaBtn.addEventListener('click', function() {
            buscarPessoaInput.value = '';
            resultadosBusca.classList.add('hidden');
        });
    }
});
</script>
@endpush
@endsection

