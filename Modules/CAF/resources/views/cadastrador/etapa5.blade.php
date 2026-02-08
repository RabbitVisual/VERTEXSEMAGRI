@extends('admin.layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Etapa 5: Renda Familiar</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Informações sobre a renda da família</p>
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
                <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center font-semibold">✓</div>
                <span class="font-medium text-green-600 dark:text-green-400">Imóvel</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-indigo-600 text-white flex items-center justify-center font-semibold">5</div>
                <span class="font-medium text-indigo-600 dark:text-indigo-400">Renda</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-slate-700 text-gray-600 dark:text-gray-400 flex items-center justify-center font-semibold">6</div>
                <span class="text-gray-500 dark:text-gray-400">Revisão</span>
            </div>
        </div>
    </div>

    <!-- Formulário -->
    <form method="POST" action="{{ route('caf.cadastrador.store-etapa5', $cadastro->id) }}" class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6 space-y-6">
        @csrf

        <div class="bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-600 px-6 py-4 rounded-t-lg -mt-6 -mx-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                    <x-icon name="currency-dollar" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Renda Familiar</h3>
                    <p class="text-indigo-100 text-sm mt-1">Informe a renda mensal da família</p>
                </div>
            </div>
        </div>

        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
            <div class="flex items-start gap-3">
                <x-icon name="information-circle" class="w-5 h-5 text-blue-600 dark:text-blue-400 flex-shrink-0 mt-0.5" />
                <div>
                    <h4 class="font-semibold text-blue-900 dark:text-blue-300">Número de Membros da Família</h4>
                    <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">Total: <strong>{{ $numeroMembros }}</strong> membros (incluindo o agricultor{{ $cadastro->conjuge ? ', cônjuge' : '' }} e familiares)</p>
                </div>
            </div>
        </div>

        <input type="hidden" name="numero_membros" value="{{ $numeroMembros }}">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Renda da Agricultura (R$)</label>
                <input type="number" name="renda_agricultura" step="0.01" min="0" value="{{ old('renda_agricultura', $cadastro->rendaFamiliar->renda_agricultura ?? 0) }}" class="renda-input w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Renda da Pecuária (R$)</label>
                <input type="number" name="renda_pecuaria" step="0.01" min="0" value="{{ old('renda_pecuaria', $cadastro->rendaFamiliar->renda_pecuaria ?? 0) }}" class="renda-input w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Renda do Extrativismo (R$)</label>
                <input type="number" name="renda_extrativismo" step="0.01" min="0" value="{{ old('renda_extrativismo', $cadastro->rendaFamiliar->renda_extrativismo ?? 0) }}" class="renda-input w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Renda de Aposentadoria (R$)</label>
                <input type="number" name="renda_aposentadoria" step="0.01" min="0" value="{{ old('renda_aposentadoria', $cadastro->rendaFamiliar->renda_aposentadoria ?? 0) }}" class="renda-input w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Renda do Bolsa Família (R$)</label>
                <input type="number" name="renda_bolsa_familia" step="0.01" min="0" value="{{ old('renda_bolsa_familia', $cadastro->rendaFamiliar->renda_bolsa_familia ?? 0) }}" class="renda-input w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Outras Rendas (R$)</label>
                <input type="number" name="renda_outros" step="0.01" min="0" value="{{ old('renda_outros', $cadastro->rendaFamiliar->renda_outros ?? 0) }}" class="renda-input w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Descrição de Outras Rendas</label>
                <textarea name="renda_outros_descricao" rows="2" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('renda_outros_descricao', $cadastro->rendaFamiliar->renda_outros_descricao ?? '') }}</textarea>
            </div>
        </div>

        <!-- Benefícios Sociais -->
        <div class="border-t border-gray-200 dark:border-slate-700 pt-6">
            <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Benefícios Sociais Recebidos</h4>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="recebe_bolsa_familia" value="1" {{ old('recebe_bolsa_familia', $cadastro->rendaFamiliar->recebe_bolsa_familia ?? false) ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Bolsa Família</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="recebe_aposentadoria" value="1" {{ old('recebe_aposentadoria', $cadastro->rendaFamiliar->recebe_aposentadoria ?? false) ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Aposentadoria</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="recebe_bpc" value="1" {{ old('recebe_bpc', $cadastro->rendaFamiliar->recebe_bpc ?? false) ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <span class="text-sm text-gray-700 dark:text-gray-300">BPC</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="recebe_outros" value="1" {{ old('recebe_outros', $cadastro->rendaFamiliar->recebe_outros ?? false) ? 'checked' : '' }} class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    <span class="text-sm text-gray-700 dark:text-gray-300">Outros</span>
                </label>
            </div>
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Descrição de Outros Benefícios</label>
                <textarea name="beneficios_descricao" rows="2" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">{{ old('beneficios_descricao', $cadastro->rendaFamiliar->beneficios_descricao ?? '') }}</textarea>
            </div>
        </div>

        <!-- Resumo Calculado -->
        <div class="bg-gradient-to-br from-indigo-50 to-blue-50 dark:from-indigo-900/20 dark:to-blue-900/20 rounded-lg p-6 border border-indigo-200 dark:border-indigo-800">
            <h4 class="text-lg font-semibold text-indigo-900 dark:text-indigo-300 mb-4">Resumo da Renda</h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-slate-800 rounded-lg p-4 border border-indigo-200 dark:border-indigo-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Renda Total Mensal</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400" id="renda-total">R$ 0,00</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-lg p-4 border border-indigo-200 dark:border-indigo-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Renda Per Capita</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400" id="renda-per-capita">R$ 0,00</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-lg p-4 border border-indigo-200 dark:border-indigo-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Número de Membros</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $numeroMembros }}</p>
                </div>
            </div>
        </div>

        <div class="flex justify-end gap-3 pt-4 border-t border-gray-200 dark:border-slate-700">
            <a href="{{ route('caf.cadastrador.etapa4', $cadastro->id) }}" class="px-6 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">
                Voltar
            </a>
            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                Próxima Etapa →
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    function calcularRenda() {
        const inputs = document.querySelectorAll('.renda-input');
        let total = 0;
        inputs.forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        
        const membros = {{ $numeroMembros }};
        const perCapita = membros > 0 ? total / membros : 0;
        
        document.getElementById('renda-total').textContent = 'R$ ' + total.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        document.getElementById('renda-per-capita').textContent = 'R$ ' + perCapita.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    document.querySelectorAll('.renda-input').forEach(input => {
        input.addEventListener('input', calcularRenda);
    });

    calcularRenda();
</script>
@endpush
@endsection
