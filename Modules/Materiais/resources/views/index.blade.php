@extends('Co-Admin.layouts.app')

@section('title', 'Materiais')

@section('content')
<div class="space-y-8">
    <!-- Page Header -->
    <div class="bg-gradient-to-r from-indigo-600 via-indigo-700 to-indigo-800 dark:from-indigo-800 dark:via-indigo-900 dark:to-indigo-950 rounded-2xl shadow-2xl p-6 md:p-8 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-white/10 [mask-image:linear-gradient(0deg,white,rgba(255,255,255,0.6))]"></div>
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="p-4 bg-white/20 rounded-2xl backdrop-blur-sm shadow-lg">
                    <x-module-icon module="Materiais" class="w-10 h-10 text-white" />
                </div>
                <div>
                    <h1 class="text-3xl md:text-4xl font-bold flex items-center gap-2">
                        Gestão de Materiais
                    </h1>
                    <p class="text-indigo-100 dark:text-indigo-200 mt-2 text-sm md:text-base">
                        Controle completo do estoque de materiais e equipamentos
                    </p>
                </div>
            </div>
            <x-materiais::button href="{{ route('materiais.create') }}" variant="outline-primary" class="!bg-white !text-indigo-600 hover:!bg-indigo-50 !border-indigo-600 shadow-xl hover:shadow-2xl transition-all transform hover:scale-105">
                <x-materiais::icon name="plus-circle" class="w-5 h-5 mr-2" />
                Novo Material
            </x-materiais::button>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <x-materiais::alert type="success" dismissible>
            <div class="flex items-center gap-2">
                <x-materiais::icon name="check-circle" class="w-5 h-5" />
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        </x-materiais::alert>
    @endif

    @if(session('error'))
        <x-materiais::alert type="danger" dismissible>
            <div class="flex items-center gap-2">
                <x-materiais::icon name="exclamation-triangle" class="w-5 h-5" />
                <span class="font-medium">{{ session('error') }}</span>
            </div>
        </x-materiais::alert>
    @endif

    <!-- Estatísticas -->
    @if(isset($stats))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 items-stretch">
        <x-materiais::stat-card
            title="Total de Materiais"
            :value="$stats['total'] ?? 0"
            icon="cube"
            color="primary"
            subtitle="Todos os materiais cadastrados"
        />
        <x-materiais::stat-card
            title="Materiais Ativos"
            :value="$stats['ativos'] ?? 0"
            icon="check-circle"
            color="success"
            subtitle="Em uso no sistema"
        />
        <x-materiais::stat-card
            title="Baixo Estoque"
            :value="$stats['baixo_estoque'] ?? 0"
            icon="exclamation-triangle"
            color="warning"
            subtitle="Abaixo do mínimo"
        />
        <x-materiais::stat-card
            title="Sem Estoque"
            :value="$stats['sem_estoque'] ?? 0"
            icon="x-circle"
            color="danger"
            subtitle="Estoque zerado"
        />
        <x-materiais::stat-card
            title="Valor Total"
            :value="number_format($stats['valor_total_estoque'] ?? 0, 2, ',', '.')"
            icon="currency-dollar"
            color="info"
            subtitle="Valor em estoque"
            prefix="R$ "
        />
    </div>
    @endif

    <!-- Filtros -->
    <x-materiais::filter-bar
        action="{{ route('materiais.index') }}"
        :filters="[
            [
                'name' => 'categoria_id',
                'label' => 'Categoria',
                'type' => 'select',
                'options' => collect(['' => 'Todas as Categorias'])->merge($categorias->pluck('nome', 'id'))->toArray(),
            ],
            [
                'name' => 'subcategoria_id',
                'label' => 'Subcategoria',
                'type' => 'select',
                'options' => collect(['' => 'Todas as Subcategorias'])->merge(
                    $categorias->flatMap(function($cat) {
                        return $cat->subcategorias->pluck('nome', 'id')->mapWithKeys(function($nome, $id) use ($cat) {
                            return [$id => $cat->nome . ' - ' . $nome];
                        });
                    })
                )->toArray(),
            ],
            [
                'name' => 'ativo',
                'label' => 'Status',
                'type' => 'select',
                'options' => [
                    '' => 'Todos',
                    '1' => 'Ativo',
                    '0' => 'Inativo'
                ],
            ]
        ]"
        search-placeholder="Buscar por nome, código, categoria ou subcategoria..."
    >
        <div class="flex items-center gap-3 p-4 bg-gradient-to-r from-amber-50 to-amber-100 dark:from-amber-900/20 dark:to-amber-800/20 rounded-xl border-2 border-amber-200 dark:border-amber-800 shadow-sm">
            <div class="p-2 bg-amber-200 dark:bg-amber-900/40 rounded-lg">
                <x-materiais::icon name="exclamation-triangle" class="w-5 h-5 text-amber-700 dark:text-amber-300" />
            </div>
            <div class="flex-1">
                <input type="checkbox"
                       id="baixo_estoque"
                       name="baixo_estoque"
                       value="1"
                       {{ request('baixo_estoque') ? 'checked' : '' }}
                       onchange="this.form.submit()"
                       class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600">
                <label for="baixo_estoque" class="ml-2 flex items-center gap-2 text-sm font-semibold text-amber-900 dark:text-amber-200 cursor-pointer">
                    <span>Mostrar apenas materiais com estoque baixo</span>
                </label>
            </div>
        </div>
    </x-materiais::filter-bar>

    <!-- Informações de Resultados e Paginação Superior -->
    @if($materiais->total() > 0)
    <div class="bg-gradient-to-r from-blue-50 via-indigo-50 to-blue-50 dark:from-blue-900/20 dark:via-indigo-900/20 dark:to-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-xl px-6 py-4 shadow-lg">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="p-2 bg-blue-200 dark:bg-blue-800 rounded-lg">
                    <x-materiais::icon name="information-circle" class="w-5 h-5 text-blue-700 dark:text-blue-300" />
                </div>
                <div>
                    <p class="text-sm font-semibold text-blue-900 dark:text-blue-200">
                        <span class="text-lg text-indigo-600 dark:text-indigo-400">{{ $materiais->total() }}</span>
                        {{ $materiais->total() == 1 ? 'material encontrado' : 'materiais encontrados' }}
                    </p>
                    @if(request()->hasAny(['search', 'categoria', 'ativo', 'baixo_estoque']))
                        <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">
                            Com os filtros aplicados
                        </p>
                    @endif
                </div>
            </div>
            @if($materiais->hasPages())
            <div class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-gray-800 rounded-lg border border-blue-200 dark:border-blue-700 shadow-sm">
                <x-materiais::icon name="document-text" class="w-4 h-4 text-blue-600 dark:text-blue-400" />
                <span class="text-sm font-medium text-blue-900 dark:text-blue-200">
                    Página <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $materiais->currentPage() }}</span> de <span class="text-indigo-600 dark:text-indigo-400 font-bold">{{ $materiais->lastPage() }}</span>
                </span>
            </div>
            @endif
        </div>
    </div>
    @endif

    <!-- Tabela de Materiais -->
    <x-materiais::data-table
        :headers="['Nome', 'Código', 'Categoria', 'Estoque', 'Mínimo', 'Unidade', 'Valor Unit.', 'Status']"
        :data="$materiais"
        export-route="{{ route('materiais.index') }}"
    >
        @forelse($materiais as $material)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-all duration-200 {{ $material->estaComEstoqueBaixo() ? 'bg-amber-50 dark:bg-amber-900/10 border-l-4 border-l-amber-500' : '' }}">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-gradient-to-br from-indigo-100 to-indigo-200 dark:from-indigo-900/30 dark:to-indigo-800/30 rounded-xl shadow-sm">
                            <x-materiais::icon name="cube" class="w-5 h-5 text-indigo-600 dark:text-indigo-400" />
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $material->nome }}</div>
                            @if($material->estaComEstoqueBaixo())
                                <div class="flex items-center gap-1 mt-1">
                                    <x-materiais::icon name="exclamation-triangle" class="w-3 h-3 text-red-500" />
                                    <span class="text-xs text-red-600 dark:text-red-400 font-medium">Estoque baixo</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-gradient-to-r from-indigo-100 to-indigo-200 text-indigo-800 dark:from-indigo-900/30 dark:to-indigo-800/30 dark:text-indigo-300 shadow-sm">
                        {{ $material->codigo ?? 'N/A' }}
                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($material->subcategoria)
                        <x-materiais::badge variant="secondary">
                            {{ $material->subcategoria->categoria->nome ?? '' }} - {{ $material->subcategoria->nome }}
                        </x-materiais::badge>
                    @else
                        <x-materiais::badge variant="secondary">
                            {{ $material->categoria_formatada }}
                        </x-materiais::badge>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="flex items-center gap-2">
                        <div class="p-1.5 bg-gray-100 dark:bg-gray-700 rounded-lg">
                            <x-materiais::icon name="archive-box" class="w-4 h-4 text-gray-500 dark:text-gray-400" />
                        </div>
                        <strong class="text-base font-bold {{ $material->estaComEstoqueBaixo() ? 'text-red-600 dark:text-red-400' : 'text-gray-900 dark:text-white' }}">
                            {{ formatar_quantidade($material->quantidade_estoque, $material->unidade_medida) }}
                        </strong>
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-400 font-medium">
                    {{ formatar_quantidade($material->quantidade_minima, $material->unidade_medida) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <x-materiais::badge variant="info">{{ ucfirst($material->unidade_medida) }}</x-materiais::badge>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($material->valor_unitario)
                        <div class="flex items-center gap-1.5">
                            <div class="p-1 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg">
                                <x-materiais::icon name="currency-dollar" class="w-4 h-4 text-emerald-600 dark:text-emerald-400" />
                            </div>
                            <strong class="text-emerald-600 dark:text-emerald-400 font-bold">R$ {{ number_format($material->valor_unitario, 2, ',', '.') }}</strong>
                        </div>
                    @else
                        <span class="text-gray-400 dark:text-gray-500">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($material->ativo)
                        <x-materiais::badge variant="success">
                            <x-materiais::icon name="check-circle" class="w-3 h-3 mr-1" />
                            Ativo
                        </x-materiais::badge>
                    @else
                        <x-materiais::badge variant="danger">
                            <x-materiais::icon name="x-circle" class="w-3 h-3 mr-1" />
                            Inativo
                        </x-materiais::badge>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                    <div class="flex items-center justify-end gap-1">
                        <a href="{{ route('materiais.show', $material) }}"
                           class="p-2.5 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg transition-all hover:scale-110"
                           title="Ver detalhes">
                            <x-materiais::icon name="eye" class="w-5 h-5" />
                        </a>
                        <a href="{{ route('materiais.edit', $material) }}"
                           class="p-2.5 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-all hover:scale-110"
                           title="Editar">
                            <x-materiais::icon name="pencil" class="w-5 h-5" />
                        </a>
                        <form action="{{ route('materiais.destroy', $material) }}"
                              method="POST"
                              class="inline"
                              onsubmit="return confirm('Tem certeza que deseja deletar este material? Esta ação não pode ser desfeita.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="p-2.5 text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 rounded-lg transition-all hover:scale-110"
                                    title="Deletar">
                                <x-materiais::icon name="trash" class="w-5 h-5" />
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="px-6 py-20 text-center">
                    <div class="flex flex-col items-center justify-center max-w-md mx-auto">
                        <div class="p-6 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-900 rounded-2xl mb-6 shadow-lg">
                            <x-materiais::icon name="inbox" class="w-16 h-16 text-gray-400 dark:text-gray-500" />
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">
                            Nenhum material encontrado
                        </h3>
                        <p class="text-gray-500 dark:text-gray-400 mb-8 text-center leading-relaxed">
                            @if(request()->hasAny(['search', 'categoria', 'ativo', 'baixo_estoque']))
                                Não encontramos materiais com os filtros aplicados. Tente ajustar os filtros ou limpar a busca para ver todos os materiais disponíveis.
                            @else
                                Comece cadastrando seu primeiro material no sistema para gerenciar seu estoque de forma eficiente.
                            @endif
                        </p>
                        <div class="flex flex-col sm:flex-row gap-3">
                            @if(request()->hasAny(['search', 'categoria', 'ativo', 'baixo_estoque']))
                                <a href="{{ route('materiais.index') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-sm font-medium text-gray-700 bg-white border-2 border-gray-300 rounded-xl hover:bg-gray-50 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-700 transition-all shadow-sm hover:shadow">
                                    <x-materiais::icon name="arrow-path" class="w-4 h-4" />
                                    Limpar Filtros
                                </a>
                            @endif
                            <x-materiais::button href="{{ route('materiais.create') }}" variant="primary" class="shadow-lg hover:shadow-xl transition-all">
                                <x-materiais::icon name="plus-circle" class="w-4 h-4 mr-2" />
                                Criar Primeiro Material
                            </x-materiais::button>
                        </div>
                    </div>
                </td>
            </tr>
        @endforelse
    </x-materiais::data-table>
</div>
@endsection
