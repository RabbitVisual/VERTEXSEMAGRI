@extends('admin.layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Etapa 2: Dados do Cônjuge</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Informações do cônjuge ou companheiro(a)</p>
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
                <div class="w-8 h-8 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold">2</div>
                <span class="font-medium text-blue-600 dark:text-blue-400">Cônjuge</span>
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

    @if($cadastro->estado_civil === 'solteiro')
        <!-- Mensagem para agricultor solteiro -->
        <div class="bg-gradient-to-r from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20 rounded-lg p-12 text-center border border-blue-200 dark:border-blue-800">
            <div class="mx-auto flex items-center justify-center h-20 w-20 rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 mb-6 shadow-lg">
                <x-icon name="information-circle" class="w-10 h-10 text-white" />
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-3">Agricultor Solteiro</h3>
            <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">Como o agricultor é solteiro, esta etapa não é necessária. Você pode continuar para a próxima etapa.</p>
            <a href="{{ route('caf.cadastrador.etapa3', $cadastro->id) }}" class="inline-flex items-center gap-2 px-8 py-3 bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-600 text-white rounded-lg hover:from-blue-700 hover:via-cyan-700 hover:to-teal-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                Continuar para Próxima Etapa
                <x-icon name="arrow-right" class="w-5 h-5" />
            </a>
        </div>
    @else
        <!-- Formulário -->
        <form method="POST" action="{{ route('caf.cadastrador.store-etapa2', $cadastro->id) }}" class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6 space-y-6">
            @csrf

            <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 px-6 py-4 rounded-t-lg -mt-6 -mx-6 mb-6">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                        <x-icon name="user-group" class="w-6 h-6 text-white" />
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-white">Dados do Cônjuge/Companheiro(a)</h3>
                        <p class="text-green-100 text-sm mt-1">Preencha as informações do cônjuge ou companheiro(a)</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nome Completo <span class="text-red-500">*</span></label>
                    <input type="text" name="nome_completo" value="{{ old('nome_completo', $cadastro->conjuge->nome_completo ?? '') }}" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @error('nome_completo')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CPF</label>
                    <input type="text" name="cpf" id="cpf" value="{{ old('cpf', $cadastro->conjuge->cpf ?? '') }}" maxlength="14" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                    @error('cpf')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">RG</label>
                    <input type="text" name="rg" value="{{ old('rg', $cadastro->conjuge->rg ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Data de Nascimento</label>
                    <input type="date" name="data_nascimento" value="{{ old('data_nascimento', $cadastro->conjuge->data_nascimento?->format('Y-m-d') ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sexo</label>
                    <select name="sexo" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <option value="">Selecione...</option>
                        <option value="M" {{ old('sexo', $cadastro->conjuge->sexo ?? '') == 'M' ? 'selected' : '' }}>Masculino</option>
                        <option value="F" {{ old('sexo', $cadastro->conjuge->sexo ?? '') == 'F' ? 'selected' : '' }}>Feminino</option>
                        <option value="Outro" {{ old('sexo', $cadastro->conjuge->sexo ?? '') == 'Outro' ? 'selected' : '' }}>Outro</option>
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Telefone</label>
                    <input type="text" name="telefone" value="{{ old('telefone', $cadastro->conjuge->telefone ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Celular</label>
                    <input type="text" name="celular" value="{{ old('celular', $cadastro->conjuge->celular ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">E-mail</label>
                    <input type="email" name="email" value="{{ old('email', $cadastro->conjuge->email ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Profissão</label>
                    <input type="text" name="profissao" value="{{ old('profissao', $cadastro->conjuge->profissao ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Renda Mensal (R$)</label>
                    <input type="number" name="renda_mensal" step="0.01" min="0" value="{{ old('renda_mensal', $cadastro->conjuge->renda_mensal ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-green-500 focus:border-transparent">
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
                <a href="{{ route('caf.cadastrador.index') }}" class="px-6 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">
                    Voltar
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    Próxima Etapa →
                </button>
            </div>
        </form>
    @endif
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

    // Auto-completar dados do cônjuge se houver família cadastrada
    @if(isset($familia) && $familia->count() > 0)
        // Buscar cônjuge na família (geralmente é o outro adulto)
        const familia = @json($familia->map(function($p) {
            return [
                'id' => $p->id,
                'nome' => $p->nom_pessoa,
                'cpf' => $p->num_cpf_pessoa,
                'cpf_formatado' => $p->cpf_formatado ?? $p->num_cpf_pessoa,
                'data_nascimento' => $p->data_nascimento ? $p->data_nascimento->format('Y-m-d') : null,
                'sexo' => $p->cod_sexo_pessoa == 1 ? 'M' : ($p->cod_sexo_pessoa == 2 ? 'F' : null),
            ];
        }));
        
        // Se houver apenas um adulto na família além do titular, pode ser o cônjuge
        const adultos = familia.filter(p => p.idade >= 18 || !p.data_nascimento);
        if (adultos.length > 0 && !document.querySelector('input[name="nome_completo"]').value) {
            const conjuge = adultos[0];
            
            const nomeInput = document.querySelector('input[name="nome_completo"]');
            if (nomeInput && !nomeInput.value) nomeInput.value = conjuge.nome;
            
            const cpfInput = document.querySelector('input[name="cpf"]');
            if (cpfInput && conjuge.cpf && !cpfInput.value) {
                const cpfFormatado = conjuge.cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4');
                cpfInput.value = cpfFormatado;
            }
            
            const dataNascInput = document.querySelector('input[name="data_nascimento"]');
            if (dataNascInput && conjuge.data_nascimento && !dataNascInput.value) {
                dataNascInput.value = conjuge.data_nascimento;
            }
            
            // Mostrar aviso
            if (!document.getElementById('familia-auto-complete')) {
                const alertDiv = document.createElement('div');
                alertDiv.id = 'familia-auto-complete';
                alertDiv.className = 'bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4 mb-4';
                alertDiv.innerHTML = `
                    <div class="flex items-start gap-3">
                        <x-icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                        <div>
                            <h3 class="font-medium text-blue-900 dark:text-blue-300">Dados da Família Cadastrada</h3>
                            <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">Os campos foram preenchidos automaticamente com dados da família cadastrada no CadÚnico. Verifique e ajuste se necessário.</p>
                        </div>
                    </div>
                `;
                document.querySelector('form').insertBefore(alertDiv, document.querySelector('form').firstChild);
            }
        }
    @endif
});
</script>
@endpush
@endsection
