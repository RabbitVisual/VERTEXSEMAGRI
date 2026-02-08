@extends('admin.layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Etapa 6: Revisão e Finalização</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Revise todas as informações antes de finalizar</p>
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
                <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center font-semibold">✓</div>
                <span class="font-medium text-green-600 dark:text-green-400">Renda</span>
            </div>
            <div class="flex-1 h-1 bg-gray-200 dark:bg-slate-700 mx-4"></div>
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-semibold">6</div>
                <span class="font-medium text-emerald-600 dark:text-emerald-400">Revisão</span>
            </div>
        </div>
    </div>

    <!-- Resumo do Cadastro -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6 space-y-6">
        <div class="bg-gradient-to-r from-emerald-600 via-teal-600 to-cyan-600 px-6 py-4 rounded-t-lg -mt-6 -mx-6 mb-6">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-lg flex items-center justify-center">
                    <x-icon name="check-circle" class="w-6 h-6 text-white" />
                </div>
                <div>
                    <h3 class="text-xl font-bold text-white">Resumo do Cadastro CAF</h3>
                    <p class="text-emerald-100 text-sm mt-1">Revise todas as informações antes de finalizar</p>
                </div>
            </div>
        </div>

        <!-- Dados do Agricultor -->
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6 border border-blue-200 dark:border-blue-800">
            <h4 class="text-lg font-bold text-blue-900 dark:text-blue-300 mb-4 flex items-center gap-2">
                <x-icon name="user" class="w-5 h-5" />
                Dados do Agricultor
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><span class="font-semibold">Nome:</span> {{ $cadastro->nome_completo }}</div>
                <div><span class="font-semibold">CPF:</span> {{ $cadastro->cpf }}</div>
                <div><span class="font-semibold">Data Nascimento:</span> {{ $cadastro->data_nascimento?->format('d/m/Y') ?? 'N/A' }}</div>
                <div><span class="font-semibold">Estado Civil:</span> {{ $cadastro->estado_civil_texto }}</div>
                <div><span class="font-semibold">Telefone:</span> {{ $cadastro->telefone ?? 'N/A' }}</div>
                <div><span class="font-semibold">Celular:</span> {{ $cadastro->celular ?? 'N/A' }}</div>
                <div><span class="font-semibold">Localidade:</span> {{ $cadastro->localidade?->nome ?? 'N/A' }}</div>
            </div>
        </div>

        @if($cadastro->conjuge)
        <!-- Dados do Cônjuge -->
        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-6 border border-green-200 dark:border-green-800">
            <h4 class="text-lg font-bold text-green-900 dark:text-green-300 mb-4 flex items-center gap-2">
                <x-icon name="user-group" class="w-5 h-5" />
                Dados do Cônjuge
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><span class="font-semibold">Nome:</span> {{ $cadastro->conjuge->nome_completo }}</div>
                <div><span class="font-semibold">CPF:</span> {{ $cadastro->conjuge->cpf ?? 'N/A' }}</div>
                <div><span class="font-semibold">Data Nascimento:</span> {{ $cadastro->conjuge->data_nascimento?->format('d/m/Y') ?? 'N/A' }}</div>
                <div><span class="font-semibold">Profissão:</span> {{ $cadastro->conjuge->profissao ?? 'N/A' }}</div>
            </div>
        </div>
        @endif

        @if($cadastro->familiares && $cadastro->familiares->count() > 0)
        <!-- Familiares -->
        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-6 border border-purple-200 dark:border-purple-800">
            <h4 class="text-lg font-bold text-purple-900 dark:text-purple-300 mb-4 flex items-center gap-2">
                <x-icon name="users" class="w-5 h-5" />
                Familiares ({{ $cadastro->familiares->count() }})
            </h4>
            <div class="space-y-2">
                @foreach($cadastro->familiares as $familiar)
                    <div class="flex justify-between items-center bg-white dark:bg-slate-800 rounded-lg p-3 border border-gray-200 dark:border-slate-700">
                        <div>
                            <span class="font-semibold">{{ $familiar->nome_completo }}</span>
                            <span class="text-gray-600 dark:text-gray-400 ml-2">- {{ $familiar->parentesco_texto }}</span>
                        </div>
                        <span class="text-gray-500 dark:text-gray-400 text-sm">{{ $familiar->cpf ?? 'N/A' }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

        @if($cadastro->imovel)
        <!-- Dados do Imóvel -->
        <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-lg p-6 border border-yellow-200 dark:border-yellow-800">
            <h4 class="text-lg font-bold text-yellow-900 dark:text-yellow-300 mb-4 flex items-center gap-2">
                <x-icon name="home" class="w-5 h-5" />
                Dados do Imóvel
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div><span class="font-semibold">Tipo de Posse:</span> {{ $cadastro->imovel->tipo_posse_texto }}</div>
                <div><span class="font-semibold">Área Total:</span> {{ number_format($cadastro->imovel->area_total_hectares ?? 0, 2, ',', '.') }} ha</div>
                <div><span class="font-semibold">Área Agricultável:</span> {{ number_format($cadastro->imovel->area_agricultavel_hectares ?? 0, 2, ',', '.') }} ha</div>
                <div><span class="font-semibold">Localidade:</span> {{ $cadastro->imovel->localidade?->nome ?? 'N/A' }}</div>
            </div>
        </div>
        @endif

        @if($cadastro->rendaFamiliar)
        <!-- Renda Familiar -->
        <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-6 border border-indigo-200 dark:border-indigo-800">
            <h4 class="text-lg font-bold text-indigo-900 dark:text-indigo-300 mb-4 flex items-center gap-2">
                <x-icon name="currency-dollar" class="w-5 h-5" />
                Renda Familiar
            </h4>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white dark:bg-slate-800 rounded-lg p-4 border border-indigo-200 dark:border-indigo-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Renda Total Mensal</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">R$ {{ number_format($cadastro->rendaFamiliar->renda_total_mensal ?? 0, 2, ',', '.') }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-lg p-4 border border-indigo-200 dark:border-indigo-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Renda Per Capita</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">R$ {{ number_format($cadastro->rendaFamiliar->renda_per_capita ?? 0, 2, ',', '.') }}</p>
                </div>
                <div class="bg-white dark:bg-slate-800 rounded-lg p-4 border border-indigo-200 dark:border-indigo-700">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Número de Membros</p>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">{{ $cadastro->rendaFamiliar->numero_membros ?? 0 }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Ações -->
        <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-200 dark:border-slate-700">
            <a href="{{ route('caf.cadastrador.etapa5', $cadastro->id) }}" class="flex-1 px-6 py-3 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors text-center">
                Voltar para Editar
            </a>
            <a href="{{ route('caf.cadastrador.pdf', $cadastro->id) }}" target="_blank" class="flex-1 px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-center inline-flex items-center justify-center gap-2">
                <x-icon name="document-arrow-down" class="w-5 h-5" />
                Gerar PDF
            </a>
            <a href="{{ route('caf.cadastrador.index') }}" class="flex-1 px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors text-center">
                Finalizar e Salvar
            </a>
        </div>
    </div>
</div>
@endsection
