@props([
    'action' => null,
    'method' => 'GET',
    'filters' => [],
    'localidades' => collect([]),
    'equipes' => collect([]),
])

@php
    $action = $action ?? request()->url();
@endphp

<div class="filters-container">
    <form action="{{ $action }}" method="{{ $method }}" id="filters-form" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Filtro de Status -->
            @if(isset($filters['status']))
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Status
                </label>
                <select name="status" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Todos</option>
                    <option value="aberta" {{ ($filters['status'] ?? '') == 'aberta' ? 'selected' : '' }}>Aberta</option>
                    <option value="em_andamento" {{ ($filters['status'] ?? '') == 'em_andamento' ? 'selected' : '' }}>Em Andamento</option>
                    <option value="concluida" {{ ($filters['status'] ?? '') == 'concluida' ? 'selected' : '' }}>Concluída</option>
                    <option value="cancelada" {{ ($filters['status'] ?? '') == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
                    <option value="pendente" {{ ($filters['status'] ?? '') == 'pendente' ? 'selected' : '' }}>Pendente</option>
                </select>
            </div>
            @endif

            <!-- Filtro de Tipo -->
            @if(isset($filters['tipo']))
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Tipo
                </label>
                <select name="tipo" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Todos</option>
                    <option value="agua" {{ ($filters['tipo'] ?? '') == 'agua' ? 'selected' : '' }}>Água</option>
                    <option value="luz" {{ ($filters['tipo'] ?? '') == 'luz' ? 'selected' : '' }}>Luz</option>
                    <option value="estrada" {{ ($filters['tipo'] ?? '') == 'estrada' ? 'selected' : '' }}>Estrada</option>
                    <option value="poco" {{ ($filters['tipo'] ?? '') == 'poco' ? 'selected' : '' }}>Poço</option>
                </select>
            </div>
            @endif

            <!-- Filtro de Localidade -->
            @if($localidades->isNotEmpty())
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Localidade
                </label>
                <select name="localidade_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Todas</option>
                    @foreach($localidades as $localidade)
                        <option value="{{ $localidade->id }}" {{ ($filters['localidade_id'] ?? '') == $localidade->id ? 'selected' : '' }}>
                            {{ $localidade->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <!-- Filtro de Equipe -->
            @if($equipes->isNotEmpty())
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Equipe
                </label>
                <select name="equipe_id" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Todas</option>
                    @foreach($equipes as $equipe)
                        <option value="{{ $equipe->id }}" {{ ($filters['equipe_id'] ?? '') == $equipe->id ? 'selected' : '' }}>
                            {{ $equipe->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            @endif

            <!-- Filtro de Data Início -->
            @if(isset($filters['data_inicio']))
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Data Início
                </label>
                <input type="date" name="data_inicio" value="{{ $filters['data_inicio'] ?? '' }}" 
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            @endif

            <!-- Filtro de Data Fim -->
            @if(isset($filters['data_fim']))
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Data Fim
                </label>
                <input type="date" name="data_fim" value="{{ $filters['data_fim'] ?? '' }}" 
                       class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            @endif

            <!-- Filtro de Prioridade -->
            @if(isset($filters['prioridade']))
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Prioridade
                </label>
                <select name="prioridade" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Todas</option>
                    <option value="baixa" {{ ($filters['prioridade'] ?? '') == 'baixa' ? 'selected' : '' }}>Baixa</option>
                    <option value="media" {{ ($filters['prioridade'] ?? '') == 'media' ? 'selected' : '' }}>Média</option>
                    <option value="alta" {{ ($filters['prioridade'] ?? '') == 'alta' ? 'selected' : '' }}>Alta</option>
                    <option value="urgente" {{ ($filters['prioridade'] ?? '') == 'urgente' ? 'selected' : '' }}>Urgente</option>
                </select>
            </div>
            @endif

            <!-- Filtro de Categoria -->
            @if(isset($filters['categoria']))
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Categoria
                </label>
                <select name="categoria" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Todas</option>
                    <option value="lampadas" {{ ($filters['categoria'] ?? '') == 'lampadas' ? 'selected' : '' }}>Lâmpadas</option>
                    <option value="reatores" {{ ($filters['categoria'] ?? '') == 'reatores' ? 'selected' : '' }}>Reatores</option>
                    <option value="fios" {{ ($filters['categoria'] ?? '') == 'fios' ? 'selected' : '' }}>Fios</option>
                    <option value="canos" {{ ($filters['categoria'] ?? '') == 'canos' ? 'selected' : '' }}>Canos</option>
                    <option value="conexoes" {{ ($filters['categoria'] ?? '') == 'conexoes' ? 'selected' : '' }}>Conexões</option>
                    <option value="combustivel" {{ ($filters['categoria'] ?? '') == 'combustivel' ? 'selected' : '' }}>Combustível</option>
                    <option value="pecas_pocos" {{ ($filters['categoria'] ?? '') == 'pecas_pocos' ? 'selected' : '' }}>Peças de Poços</option>
                    <option value="outros" {{ ($filters['categoria'] ?? '') == 'outros' ? 'selected' : '' }}>Outros</option>
                </select>
            </div>
            @endif

            <!-- Filtro de Baixo Estoque -->
            @if(isset($filters['baixo_estoque']))
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Estoque
                </label>
                <select name="baixo_estoque" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Todos</option>
                    <option value="1" {{ ($filters['baixo_estoque'] ?? '') == '1' ? 'selected' : '' }}>Apenas Baixo Estoque</option>
                </select>
            </div>
            @endif

            <!-- Filtro de Ativo -->
            @if(isset($filters['ativo']))
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                    Status
                </label>
                <select name="ativo" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="">Todos</option>
                    <option value="1" {{ ($filters['ativo'] ?? '') == '1' ? 'selected' : '' }}>Ativo</option>
                    <option value="0" {{ ($filters['ativo'] ?? '') == '0' ? 'selected' : '' }}>Inativo</option>
                </select>
            </div>
            @endif
        </div>

        <div class="flex items-center justify-end gap-2 pt-2 border-t border-gray-200 dark:border-gray-700">
            <x-relatorios::button type="button" variant="outline" onclick="clearFilters('filters-form')">
                <x-relatorios::icon name="x-mark" class="w-4 h-4 mr-2" />
                Limpar
            </x-relatorios::button>
            <x-relatorios::button type="submit" variant="primary">
                <x-relatorios::icon name="check-circle" class="w-4 h-4 mr-2" />
                Filtrar
            </x-relatorios::button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function clearFilters(formId) {
    const form = document.getElementById(formId);
    if (form) {
        form.reset();
        window.location.search = '';
    }
}
</script>
@endpush

