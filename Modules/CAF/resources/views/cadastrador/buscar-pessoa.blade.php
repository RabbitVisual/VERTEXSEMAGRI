@extends('admin.layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Buscar na Base Municipal</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Busque pessoas cadastradas no CadÚnico para pré-cadastro CAF</p>
        </div>
        <a href="{{ route('caf.cadastrador.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">
            <x-icon name="arrow-left" class="w-5 h-5" />
            Voltar
        </a>
    </div>

    <!-- Formulário de Busca -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
        <form method="GET" action="{{ route('caf.cadastrador.buscar-pessoa') }}" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">CPF</label>
                <input type="text" name="cpf" value="{{ request('cpf') }}" placeholder="000.000.000-00" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white" id="cpf-input">
            </div>
            <button type="submit" class="w-full sm:w-auto px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <x-icon name="magnifying-glass" class="w-5 h-5 inline mr-2" />
                Buscar
            </button>
        </form>
    </div>

    <!-- Resultados -->
    @if($pessoas->count() > 0)
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-slate-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Resultados da Busca</h2>
            </div>
            <div class="divide-y divide-gray-200 dark:divide-slate-700">
                @foreach($pessoas as $pessoa)
                    <div class="p-6 hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $pessoa->nom_pessoa }}</h3>
                                <div class="mt-2 space-y-1 text-sm text-gray-600 dark:text-gray-400">
                                    <p><span class="font-medium">CPF:</span> {{ $pessoa->num_cpf_pessoa }}</p>
                                    <p><span class="font-medium">NIS:</span> {{ $pessoa->num_nis_pessoa_atual ?? 'N/A' }}</p>
                                    @if($pessoa->data_nascimento)
                                        <p><span class="font-medium">Data de Nascimento:</span> {{ $pessoa->data_nascimento->format('d/m/Y') }}</p>
                                    @endif
                                    @if($pessoa->localidade)
                                        <p><span class="font-medium">Localidade:</span> {{ $pessoa->localidade->nome }}</p>
                                    @endif
                                </div>
                            </div>
                            <a href="{{ route('caf.cadastrador.create', ['pessoa_id' => $pessoa->id]) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                                <x-icon name="plus-circle" class="w-5 h-5" />
                                Usar este Cadastro
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @elseif(request('cpf'))
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-12 text-center">
            <x-icon name="magnifying-glass" class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" />
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Nenhuma pessoa encontrada</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Não foi encontrada nenhuma pessoa com este CPF na base municipal.</p>
            <a href="{{ route('caf.cadastrador.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                <x-icon name="plus-circle" class="w-5 h-5" />
                Criar Cadastro Manual
            </a>
        </div>
    @endif
</div>

@push('scripts')
<script>
    // Máscara de CPF
    document.getElementById('cpf-input')?.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length <= 11) {
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d)/, '$1.$2');
            value = value.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
            e.target.value = value;
        }
    });
</script>
@endpush
@endsection

