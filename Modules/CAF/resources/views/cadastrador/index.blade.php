@extends('admin.layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white flex items-center gap-2">
                <x-module-icon module="CAF" class="w-8 h-8" />
                Meus Cadastros CAF
            </h1>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Gerencie seus cadastros de agricultores familiares</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('caf.cadastrador.buscar-pessoa') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <x-icon name="magnifying-glass" class="w-5 h-5" />
                Buscar na Base Municipal
            </a>
            <a href="{{ route('caf.cadastrador.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                <x-icon name="plus-circle" class="w-5 h-5" />
                Novo Cadastro
            </a>
        </div>
    </div>

    <!-- Filtros -->
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-6">
        <form method="GET" action="{{ route('caf.cadastrador.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Buscar</label>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Nome, CPF, Protocolo..." class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white">
                    <option value="">Todos</option>
                    <option value="rascunho" {{ request('status') == 'rascunho' ? 'selected' : '' }}>Rascunho</option>
                    <option value="em_andamento" {{ request('status') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                    <option value="completo" {{ request('status') == 'completo' ? 'selected' : '' }}>Completo</option>
                    <option value="aprovado" {{ request('status') == 'aprovado' ? 'selected' : '' }}>Aprovado</option>
                    <option value="rejeitado" {{ request('status') == 'rejeitado' ? 'selected' : '' }}>Rejeitado</option>
                    <option value="enviado_caf" {{ request('status') == 'enviado_caf' ? 'selected' : '' }}>Enviado ao CAF</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Localidade</label>
                <select name="localidade_id" class="w-full px-4 py-2 border border-gray-300 dark:border-slate-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-slate-700 dark:text-white">
                    <option value="">Todas</option>
                    @foreach($localidades as $localidade)
                        <option value="{{ $localidade->id }}" {{ request('localidade_id') == $localidade->id ? 'selected' : '' }}>{{ $localidade->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Filtrar
                </button>
                <a href="{{ route('caf.cadastrador.index') }}" class="px-4 py-2 bg-gray-200 dark:bg-slate-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-slate-600 transition-colors">
                    Limpar
                </a>
            </div>
        </form>
    </div>

    <!-- Lista de Cadastros -->
    @if($cadastros->count() > 0)
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-slate-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Protocolo</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Agricultor</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Localidade</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Data</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-slate-800 divide-y divide-gray-200 dark:divide-slate-700">
                        @foreach($cadastros as $cadastro)
                            <tr class="hover:bg-gray-50 dark:hover:bg-slate-700 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $cadastro->protocolo ?? 'N/A' }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $cadastro->codigo }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $cadastro->nome_completo }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $cadastro->cpf }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-white">{{ $cadastro->localidade?->nome ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($cadastro->status == 'aprovado') bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400
                                        @elseif($cadastro->status == 'completo') bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-400
                                        @elseif($cadastro->status == 'enviado_caf') bg-emerald-100 text-emerald-800 dark:bg-emerald-900/30 dark:text-emerald-400
                                        @elseif($cadastro->status == 'rejeitado') bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-400
                                        @elseif($cadastro->status == 'em_andamento') bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-400
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900/30 dark:text-gray-400
                                        @endif">
                                        {{ $cadastro->status_texto }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                    {{ $cadastro->created_at->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('caf.cadastrador.show', $cadastro->id) }}" class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300" title="Visualizar">
                                            <x-icon name="eye" class="w-5 h-5" />
                                        </a>
                                        @if($cadastro->status == 'completo' || $cadastro->status == 'aprovado')
                                            <a href="{{ route('caf.cadastrador.pdf', $cadastro->id) }}" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300" title="Gerar PDF">
                                                <x-icon name="document-arrow-down" class="w-5 h-5" />
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Paginação -->
            <div class="px-6 py-4 border-t border-gray-200 dark:border-slate-700">
                {{ $cadastros->links() }}
            </div>
        </div>
    @else
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-sm border border-gray-200 dark:border-slate-700 p-12 text-center">
            <x-icon name="document-text" class="w-16 h-16 text-gray-400 dark:text-gray-600 mx-auto mb-4" />
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Nenhum cadastro encontrado</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Comece criando um novo cadastro CAF</p>
            <a href="{{ route('caf.cadastrador.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                <x-icon name="plus-circle" class="w-5 h-5" />
                Novo Cadastro
            </a>
        </div>
    @endif
</div>
@endsection

