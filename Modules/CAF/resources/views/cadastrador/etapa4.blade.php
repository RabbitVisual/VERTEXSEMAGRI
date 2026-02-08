@extends('admin.layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Etapa 4: Dados do Imóvel</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Informações da propriedade rural</p>
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
                <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center font-semibold">✓</div>
                <span class="font-medium text-green-600 dark:text-green-400">Familiares</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-yellow-600 text-white flex items-center justify-center font-semibold">4</div>
                <span class="font-medium text-yellow-600 dark:text-yellow-400">Imóvel</span>
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
    <form method="POST" action="{{ route('caf.cadastrador.store-etapa4', $cadastro->id) }}" class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6 space-y-6">
        @csrf

        <div class="bg-gradient-to-r from-yellow-600 via-amber-600 to-orange-600 px-6 py-4 rounded-t-lg -mt-6 -mx-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                    <x-icon name="home" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Situação do Imóvel</h3>
                    <p class="text-yellow-100 text-sm mt-1">Informe os dados da propriedade rural</p>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipo de Posse <span class="text-red-500">*</span></label>
                <select name="tipo_posse" required class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    <option value="">Selecione...</option>
                    <option value="proprio" {{ old('tipo_posse', $cadastro->imovel->tipo_posse ?? '') == 'proprio' ? 'selected' : '' }}>Próprio</option>
                    <option value="arrendado" {{ old('tipo_posse', $cadastro->imovel->tipo_posse ?? '') == 'arrendado' ? 'selected' : '' }}>Arrendado</option>
                    <option value="cedido" {{ old('tipo_posse', $cadastro->imovel->tipo_posse ?? '') == 'cedido' ? 'selected' : '' }}>Cedido</option>
                    <option value="ocupacao" {{ old('tipo_posse', $cadastro->imovel->tipo_posse ?? '') == 'ocupacao' ? 'selected' : '' }}>Ocupação</option>
                    <option value="outro" {{ old('tipo_posse', $cadastro->imovel->tipo_posse ?? '') == 'outro' ? 'selected' : '' }}>Outro</option>
                </select>
                @error('tipo_posse')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div id="tipo_posse_outro_div" class="{{ old('tipo_posse', $cadastro->imovel->tipo_posse ?? '') == 'outro' ? '' : 'hidden' }}">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Especifique o Tipo de Posse</label>
                <input type="text" name="tipo_posse_outro" value="{{ old('tipo_posse_outro', $cadastro->imovel->tipo_posse_outro ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Localidade</label>
                <select name="localidade_id" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
                    <option value="">Selecione...</option>
                    @foreach($localidades as $localidade)
                        <option value="{{ $localidade->id }}" {{ old('localidade_id', $cadastro->imovel->localidade_id ?? '') == $localidade->id ? 'selected' : '' }}>{{ $localidade->nome }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CEP</label>
                <input type="text" name="cep" value="{{ old('cep', $cadastro->imovel->cep ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Logradouro</label>
                <input type="text" name="logradouro" value="{{ old('logradouro', $cadastro->imovel->logradouro ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Número</label>
                <input type="text" name="numero" value="{{ old('numero', $cadastro->imovel->numero ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Complemento</label>
                <input type="text" name="complemento" value="{{ old('complemento', $cadastro->imovel->complemento ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Bairro</label>
                <input type="text" name="bairro" value="{{ old('bairro', $cadastro->imovel->bairro ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Cidade</label>
                <input type="text" name="cidade" value="{{ old('cidade', $cadastro->imovel->cidade ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">UF</label>
                <input type="text" name="uf" value="{{ old('uf', $cadastro->imovel->uf ?? '') }}" maxlength="2" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Área Total (Hectares)</label>
                <input type="number" name="area_total_hectares" step="0.01" min="0" value="{{ old('area_total_hectares', $cadastro->imovel->area_total_hectares ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Área Agricultável (Hectares)</label>
                <input type="number" name="area_agricultavel_hectares" step="0.01" min="0" value="{{ old('area_agricultavel_hectares', $cadastro->imovel->area_agricultavel_hectares ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Área de Pastagem (Hectares)</label>
                <input type="number" name="area_pastagem_hectares" step="0.01" min="0" value="{{ old('area_pastagem_hectares', $cadastro->imovel->area_pastagem_hectares ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Área de Reserva Legal (Hectares)</label>
                <input type="number" name="area_reserva_legal_hectares" step="0.01" min="0" value="{{ old('area_reserva_legal_hectares', $cadastro->imovel->area_reserva_legal_hectares ?? '') }}" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Atividades Desenvolvidas</label>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="producao_vegetal" value="1" {{ old('producao_vegetal', $cadastro->imovel->producao_vegetal ?? false) ? 'checked' : '' }} class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Produção Vegetal</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="producao_animal" value="1" {{ old('producao_animal', $cadastro->imovel->producao_animal ?? false) ? 'checked' : '' }} class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Produção Animal</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="extrativismo" value="1" {{ old('extrativismo', $cadastro->imovel->extrativismo ?? false) ? 'checked' : '' }} class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Extrativismo</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="aquicultura" value="1" {{ old('aquicultura', $cadastro->imovel->aquicultura ?? false) ? 'checked' : '' }} class="w-4 h-4 text-yellow-600 border-gray-300 rounded focus:ring-yellow-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">Aquicultura</span>
                    </label>
                </div>
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Descrição das Atividades</label>
                <textarea name="atividades_descricao" rows="3" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-yellow-500 focus:border-transparent">{{ old('atividades_descricao', $cadastro->imovel->atividades_descricao ?? '') }}</textarea>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
            <a href="{{ route('caf.cadastrador.etapa3', $cadastro->id) }}" class="px-6 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">
                Voltar
            </a>
            <button type="submit" class="px-6 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                Próxima Etapa →
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Mostrar campo "tipo_posse_outro" quando "outro" for selecionado
    document.querySelector('select[name="tipo_posse"]')?.addEventListener('change', function(e) {
        const outroDiv = document.getElementById('tipo_posse_outro_div');
        if (e.target.value === 'outro') {
            outroDiv.classList.remove('hidden');
        } else {
            outroDiv.classList.add('hidden');
        }
    });
</script>
@endpush
@endsection
