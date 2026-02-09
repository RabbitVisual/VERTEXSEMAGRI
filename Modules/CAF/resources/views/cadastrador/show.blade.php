@extends('admin.layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-icon module="caf" class="w-8 h-8" />
                Cadastro CAF - {{ $cadastro->protocolo ?? $cadastro->codigo }}
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Visualização completa do cadastro</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('caf.cadastrador.pdf', $cadastro->id) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                <x-icon name="document-arrow-down" class="w-5 h-5" />
                Gerar PDF
            </a>
            <a href="{{ route('caf.cadastrador.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">
                <x-icon name="arrow-left" class="w-5 h-5" />
                Voltar
            </a>
        </div>
    </div>

    <!-- Status Badge -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($cadastro->status == 'aprovado') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                    @elseif($cadastro->status == 'completo') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                    @elseif($cadastro->status == 'enviado_caf') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400
                    @elseif($cadastro->status == 'rejeitado') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                    @elseif($cadastro->status == 'em_andamento') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                    @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400
                    @endif">
                    {{ $cadastro->status_texto }}
                </span>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <span class="font-medium">Protocolo:</span> {{ $cadastro->protocolo ?? 'N/A' }}
                </div>
                <div class="text-sm text-gray-600 dark:text-gray-400">
                    <span class="font-medium">Código:</span> {{ $cadastro->codigo }}
                </div>
            </div>
            <div class="text-sm text-gray-600 dark:text-gray-400">
                Criado em: {{ $cadastro->created_at->format('d/m/Y H:i') }}
            </div>
        </div>
    </div>

    <!-- Dados do Agricultor -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 via-cyan-600 to-teal-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <x-icon name="user" class="w-6 h-6" />
                Dados do Agricultor
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nome Completo</label>
                    <p class="text-gray-900 dark:text-white font-semibold">{{ $cadastro->nome_completo }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">CPF</label>
                    <p class="text-gray-900 dark:text-white">{{ $cadastro->cpf }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">RG</label>
                    <p class="text-gray-900 dark:text-white">{{ $cadastro->rg ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Nascimento</label>
                    <p class="text-gray-900 dark:text-white">{{ $cadastro->data_nascimento?->format('d/m/Y') ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Sexo</label>
                    <p class="text-gray-900 dark:text-white">{{ $cadastro->sexo ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Estado Civil</label>
                    <p class="text-gray-900 dark:text-white">{{ $cadastro->estado_civil_texto }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Telefone</label>
                    <p class="text-gray-900 dark:text-white">{{ $cadastro->telefone ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Celular</label>
                    <p class="text-gray-900 dark:text-white">{{ $cadastro->celular ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">E-mail</label>
                    <p class="text-gray-900 dark:text-white">{{ $cadastro->email ?? 'N/A' }}</p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Endereço</label>
                    <p class="text-gray-900 dark:text-white">
                        {{ $cadastro->logradouro ?? '' }} {{ $cadastro->numero ?? '' }}, {{ $cadastro->bairro ?? '' }} - {{ $cadastro->cidade ?? '' }}/{{ $cadastro->uf ?? '' }}
                    </p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Localidade</label>
                    <p class="text-gray-900 dark:text-white">{{ $cadastro->localidade?->nome ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($cadastro->conjuge)
    <!-- Dados do Cônjuge -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <x-icon name="user-group" class="w-6 h-6" />
                Dados do Cônjuge
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Nome Completo</label>
                    <p class="text-gray-900 dark:text-white font-semibold">{{ $cadastro->conjuge->nome_completo }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">CPF</label>
                    <p class="text-gray-900 dark:text-white">{{ $cadastro->conjuge->cpf ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Data de Nascimento</label>
                    <p class="text-gray-900 dark:text-white">{{ $cadastro->conjuge->data_nascimento?->format('d/m/Y') ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Profissão</label>
                    <p class="text-gray-900 dark:text-white">{{ $cadastro->conjuge->profissao ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Renda Mensal</label>
                    <p class="text-gray-900 dark:text-white">R$ {{ number_format($cadastro->conjuge->renda_mensal ?? 0, 2, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($cadastro->familiares && $cadastro->familiares->count() > 0)
    <!-- Familiares -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="bg-gradient-to-r from-purple-600 via-violet-600 to-fuchsia-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <x-icon name="users" class="w-6 h-6" />
                Familiares ({{ $cadastro->familiares->count() }})
            </h2>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-slate-900">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Nome</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">CPF</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Data Nascimento</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Parentesco</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase">Escolaridade</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-slate-700">
                        @foreach($cadastro->familiares as $familiar)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900 dark:text-white">{{ $familiar->nome_completo }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $familiar->cpf ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $familiar->data_nascimento?->format('d/m/Y') ?? 'N/A' }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $familiar->parentesco_texto }}</td>
                                <td class="px-4 py-3 text-sm text-gray-600 dark:text-gray-400">{{ $familiar->escolaridade ?? 'N/A' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    @if($cadastro->imovel)
    <!-- Dados do Imóvel -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="bg-gradient-to-r from-yellow-600 via-amber-600 to-orange-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <x-icon name="home" class="w-6 h-6" />
                Dados do Imóvel
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Tipo de Posse</label>
                    <p class="text-gray-900 dark:text-white">{{ $cadastro->imovel->tipo_posse_texto }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Localidade</label>
                    <p class="text-gray-900 dark:text-white">{{ $cadastro->imovel->localidade?->nome ?? 'N/A' }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Área Total</label>
                    <p class="text-gray-900 dark:text-white">{{ number_format($cadastro->imovel->area_total_hectares ?? 0, 2, ',', '.') }} ha</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Área Agricultável</label>
                    <p class="text-gray-900 dark:text-white">{{ number_format($cadastro->imovel->area_agricultavel_hectares ?? 0, 2, ',', '.') }} ha</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Área de Pastagem</label>
                    <p class="text-gray-900 dark:text-white">{{ number_format($cadastro->imovel->area_pastagem_hectares ?? 0, 2, ',', '.') }} ha</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Área Reserva Legal</label>
                    <p class="text-gray-900 dark:text-white">{{ number_format($cadastro->imovel->area_reserva_legal_hectares ?? 0, 2, ',', '.') }} ha</p>
                </div>
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Atividades Desenvolvidas</label>
                    <div class="flex flex-wrap gap-2 mt-2">
                        @if($cadastro->imovel->producao_vegetal)
                            <span class="px-3 py-1 bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 rounded-full text-sm">Produção Vegetal</span>
                        @endif
                        @if($cadastro->imovel->producao_animal)
                            <span class="px-3 py-1 bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400 rounded-full text-sm">Produção Animal</span>
                        @endif
                        @if($cadastro->imovel->extrativismo)
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400 rounded-full text-sm">Extrativismo</span>
                        @endif
                        @if($cadastro->imovel->aquicultura)
                            <span class="px-3 py-1 bg-cyan-100 text-cyan-800 dark:bg-cyan-900/30 dark:text-cyan-400 rounded-full text-sm">Aquicultura</span>
                        @endif
                    </div>
                </div>
                @if($cadastro->imovel->atividades_descricao)
                <div class="md:col-span-3">
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Descrição das Atividades</label>
                    <p class="text-gray-900 dark:text-white">{{ $cadastro->imovel->atividades_descricao }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    @if($cadastro->rendaFamiliar)
    <!-- Renda Familiar -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="bg-gradient-to-r from-indigo-600 via-blue-600 to-cyan-600 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <x-icon name="currency-dollar" class="w-6 h-6" />
                Renda Familiar
            </h2>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-4 border border-indigo-200 dark:border-indigo-800">
                    <label class="block text-sm font-medium text-indigo-600 dark:text-indigo-400 mb-1">Renda Total Mensal</label>
                    <p class="text-2xl font-bold text-indigo-900 dark:text-indigo-300">R$ {{ number_format($cadastro->rendaFamiliar->renda_total_mensal ?? 0, 2, ',', '.') }}</p>
                </div>
                <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-4 border border-indigo-200 dark:border-indigo-800">
                    <label class="block text-sm font-medium text-indigo-600 dark:text-indigo-400 mb-1">Renda Per Capita</label>
                    <p class="text-2xl font-bold text-indigo-900 dark:text-indigo-300">R$ {{ number_format($cadastro->rendaFamiliar->renda_per_capita ?? 0, 2, ',', '.') }}</p>
                </div>
                <div class="bg-indigo-50 dark:bg-indigo-900/20 rounded-lg p-4 border border-indigo-200 dark:border-indigo-800">
                    <label class="block text-sm font-medium text-indigo-600 dark:text-indigo-400 mb-1">Número de Membros</label>
                    <p class="text-2xl font-bold text-indigo-900 dark:text-indigo-300">{{ $cadastro->rendaFamiliar->numero_membros ?? 0 }}</p>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Renda da Agricultura</label>
                    <p class="text-gray-900 dark:text-white">R$ {{ number_format($cadastro->rendaFamiliar->renda_agricultura ?? 0, 2, ',', '.') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Renda da Pecuária</label>
                    <p class="text-gray-900 dark:text-white">R$ {{ number_format($cadastro->rendaFamiliar->renda_pecuaria ?? 0, 2, ',', '.') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Renda do Extrativismo</label>
                    <p class="text-gray-900 dark:text-white">R$ {{ number_format($cadastro->rendaFamiliar->renda_extrativismo ?? 0, 2, ',', '.') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Renda de Aposentadoria</label>
                    <p class="text-gray-900 dark:text-white">R$ {{ number_format($cadastro->rendaFamiliar->renda_aposentadoria ?? 0, 2, ',', '.') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Renda do Bolsa Família</label>
                    <p class="text-gray-900 dark:text-white">R$ {{ number_format($cadastro->rendaFamiliar->renda_bolsa_familia ?? 0, 2, ',', '.') }}</p>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Outras Rendas</label>
                    <p class="text-gray-900 dark:text-white">R$ {{ number_format($cadastro->rendaFamiliar->renda_outros ?? 0, 2, ',', '.') }}</p>
                </div>
            </div>
            @if($cadastro->rendaFamiliar->beneficios_descricao)
            <div class="mt-6">
                <label class="block text-sm font-medium text-gray-500 dark:text-gray-400 mb-1">Benefícios Recebidos</label>
                <p class="text-gray-900 dark:text-white">{{ $cadastro->rendaFamiliar->beneficios_descricao }}</p>
            </div>
            @endif
        </div>
    </div>
    @endif

    @if($cadastro->observacoes)
    <!-- Observações -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-600 to-gray-700 px-6 py-4">
            <h2 class="text-xl font-bold text-white flex items-center gap-2">
                <x-icon name="document-text" class="w-6 h-6" />
                Observações
            </h2>
        </div>
        <div class="p-6">
            <p class="text-gray-900 dark:text-white whitespace-pre-wrap">{{ $cadastro->observacoes }}</p>
        </div>
    </div>
    @endif
</div>
@endsection

