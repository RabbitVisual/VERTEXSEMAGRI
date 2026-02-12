@extends('admin.layouts.admin')

@section('title', 'Pessoas - Admin')

@section('content')
<div class="space-y-6 md:space-y-8 animate-fade-in font-poppins pb-12">
    <!-- Page Header -->
    <div class="relative overflow-hidden bg-white dark:bg-slate-800 rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 dark:border-slate-700 transition-all duration-300">
        <div class="absolute top-0 right-0 w-64 h-64 bg-indigo-50/50 dark:bg-indigo-900/10 rounded-full -mr-32 -mt-32 blur-3xl"></div>

        <div class="relative z-10 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 md:w-16 md:h-16 bg-gradient-to-br from-indigo-500 to-indigo-700 rounded-2xl flex items-center justify-center shadow-lg shadow-indigo-200 dark:shadow-none text-white transition-transform hover:rotate-3">
                    <x-icon module="pessoas" style="duotone" class="w-7 h-7 md:w-8 md:h-8" />
                </div>
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                        Pessoas - CadÚnico
                    </h1>
                    <nav aria-label="breadcrumb" class="flex items-center gap-2 text-sm text-gray-500 dark:text-gray-400 font-medium">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">Admin</a>
                        <x-icon name="chevron-right" class="w-3 h-3" />
                        <span class="text-gray-900 dark:text-white font-bold">Listagem de Beneficiários</span>
                    </nav>
                </div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-5 py-3 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 focus:ring-4 focus:ring-gray-100 dark:bg-slate-700 dark:text-gray-300 dark:border-slate-600 dark:hover:bg-slate-600 transition-all duration-300 shadow-sm">
                    <x-icon name="arrow-left" style="duotone" class="w-5 h-5" />
                    Voltar
                </a>
            </div>
        </div>
    </div>

    <!-- Estatísticas -->
    @if(isset($estatisticas))
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach([
            ['label' => 'Total de Pessoas', 'value' => $estatisticas['total'] ?? 0, 'icon' => 'users', 'color' => 'indigo', 'gradient' => 'from-indigo-500 to-indigo-600'],
            ['label' => 'Beneficiários PBF', 'value' => $estatisticas['recebem_pbf'] ?? 0, 'icon' => 'hand-holding-dollar', 'color' => 'emerald', 'gradient' => 'from-emerald-500 to-emerald-600'],
            ['label' => 'Com Localidade', 'value' => $estatisticas['com_localidade'] ?? 0, 'icon' => 'map-location-dot', 'color' => 'blue', 'gradient' => 'from-blue-500 to-blue-600'],
            ['label' => 'Sem Localidade', 'value' => $estatisticas['sem_localidade'] ?? 0, 'icon' => 'location-cross', 'color' => 'amber', 'gradient' => 'from-amber-500 to-amber-600']
        ] as $stat)
        <div class="group relative bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-gray-100 dark:border-slate-700 p-6 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-gradient-to-br {{ $stat['gradient'] }} rounded-xl flex items-center justify-center text-white shadow-lg shadow-{{ $stat['color'] }}-200 dark:shadow-none transition-transform group-hover:scale-110">
                    <x-icon name="{{ $stat['icon'] }}" style="duotone" class="w-6 h-6" />
                </div>
                <div>
                    <p class="text-[10px] font-bold text-gray-400 dark:text-gray-500 uppercase tracking-widest">{{ $stat['label'] }}</p>
                    <p class="text-2xl font-black text-gray-900 dark:text-white mt-0.5">{{ number_format($stat['value'], 0, ',', '.') }}</p>
                </div>
            </div>
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r {{ $stat['gradient'] }} opacity-0 group-hover:opacity-100 transition-opacity rounded-b-2xl"></div>
        </div>
        @endforeach
    </div>
    @endif

    <!-- Filtros Panorâmicos -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-slate-700 bg-gray-50/30 dark:bg-slate-900/30 flex items-center gap-2">
            <x-icon name="filter" class="w-5 h-5 text-indigo-500" style="duotone" />
            <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest">Filtros de Pesquisa</h3>
        </div>
        <form method="GET" action="{{ route('admin.pessoas.index') }}" class="p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="space-y-2">
                    <label for="search" class="text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Buscar Pessoa</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none text-slate-400 group-focus-within:text-indigo-500 transition-colors">
                            <x-icon name="magnifying-glass" class="w-4 h-4" />
                        </div>
                        <input type="text" name="search" id="search" value="{{ $filters['search'] ?? '' }}" placeholder="Nome, NIS ou CPF..." class="w-full bg-slate-50 dark:bg-slate-900 border-gray-100 dark:border-slate-700 text-gray-900 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 block pl-11 p-3 transition-all">
                    </div>
                </div>
                <div class="space-y-2">
                    <label for="localidade_id" class="text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Localidade</label>
                    <select name="localidade_id" id="localidade_id" class="w-full bg-slate-50 dark:bg-slate-900 border-gray-100 dark:border-slate-700 text-gray-900 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 block p-3 transition-all appearance-none cursor-pointer">
                        <option value="">Todas as Localidades</option>
                        @foreach($localidades as $localidade)
                            <option value="{{ $localidade->id }}" {{ ($filters['localidade_id'] ?? '') == $localidade->id ? 'selected' : '' }}>
                                {{ $localidade->nome }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label for="recebe_pbf" class="text-sm font-bold text-gray-700 dark:text-gray-300 ml-1">Benefício (PBF)</label>
                    <select name="recebe_pbf" id="recebe_pbf" class="w-full bg-slate-50 dark:bg-slate-900 border-gray-100 dark:border-slate-700 text-gray-900 dark:text-white text-sm rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 block p-3 transition-all appearance-none cursor-pointer">
                        <option value="">Todos</option>
                        <option value="1" {{ ($filters['recebe_pbf'] ?? '') == '1' ? 'selected' : '' }}>Recebe PBF</option>
                        <option value="0" {{ ($filters['recebe_pbf'] ?? '') == '0' ? 'selected' : '' }}>Não Recebe</option>
                    </select>
                </div>
            </div>
            <div class="mt-8 flex gap-3">
                <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 text-sm font-black text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 focus:ring-4 focus:ring-indigo-500/20 transition-all shadow-lg shadow-indigo-500/20 active:scale-95">
                    <x-icon name="magnifying-glass" class="w-5 h-5" style="duotone" />
                    Filtrar Resultados
                </button>
                <a href="{{ route('admin.pessoas.index') }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-bold text-slate-500 bg-white border border-slate-200 rounded-xl hover:bg-slate-50 hover:text-indigo-600 transition-all active:scale-95 shadow-sm">
                    <x-icon name="rotate-right" class="w-5 h-5" style="duotone" />
                    Limpar
                </a>
            </div>
        </form>
    </div>

    <!-- Tabela Premium -->
    <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-gray-100 dark:border-slate-700/50 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 dark:border-slate-700/50 bg-gray-50/30 dark:bg-slate-900/30 flex items-center justify-between">
            <h3 class="text-xs font-black text-gray-900 dark:text-white uppercase tracking-widest flex items-center gap-2">
                <x-icon name="list-ul" class="w-4 h-4 text-indigo-500" style="duotone" />
                Listagem Detalhada
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-[10px] text-slate-400 uppercase tracking-widest bg-slate-50/50 dark:bg-slate-900/50 font-black border-b border-gray-100 dark:border-slate-700">
                    <tr>
                        <th class="px-6 py-5">Nome / NIS</th>
                        <th class="px-6 py-5">CPF</th>
                        <th class="px-6 py-5">Localidade</th>
                        <th class="px-6 py-5">Situação PBF</th>
                        <th class="px-6 py-5 text-right">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50 dark:divide-slate-700/50 font-medium">
                    @forelse($pessoas as $pessoa)
                    <tr class="hover:bg-indigo-50/30 dark:hover:bg-indigo-900/5 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="font-bold text-gray-900 dark:text-white text-base group-hover:text-indigo-600 transition-colors">
                                    {{ $pessoa->nom_pessoa }}
                                </span>
                                @if($pessoa->num_nis_pessoa_atual)
                                <span class="text-[10px] font-black text-gray-400 uppercase tracking-tighter mt-0.5">
                                    NIS: {{ $pessoa->num_nis_pessoa_atual }}
                                </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            <span class="font-mono text-gray-600 dark:text-gray-400 tracking-wide">
                                {{ $pessoa->num_cpf_pessoa ?? '-' }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            @if($pessoa->localidade)
                            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-lg bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-400 font-bold border border-blue-100 dark:border-blue-800/30 uppercase text-[10px]">
                                <x-icon name="map-pin" class="w-3 h-3" />
                                {{ $pessoa->localidade->nome }}
                            </span>
                            @else
                            <span class="text-gray-400 text-xs italic">Não informada</span>
                            @endif
                        </td>
                        <td class="px-6 py-5">
                            @if($pessoa->recebe_pbf)
                                <div class="flex items-center gap-1.5 text-emerald-600 dark:text-emerald-400 font-bold text-[11px] uppercase tracking-wider">
                                    <div class="w-2 h-2 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50 animate-pulse"></div>
                                    Beneficiário
                                </div>
                            @else
                                <div class="flex items-center gap-1.5 text-gray-400 dark:text-gray-500 font-bold text-[11px] uppercase tracking-wider">
                                    <div class="w-2 h-2 rounded-full bg-gray-300"></div>
                                    Não Recebe
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-5 text-right">
                            <a href="{{ route('admin.pessoas.show', $pessoa->id) }}" class="inline-flex items-center justify-center w-10 h-10 text-indigo-600 bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800 rounded-xl hover:bg-indigo-600 hover:text-white transition-all shadow-sm active:scale-95" title="Ver Detalhes">
                                <x-icon name="eye" class="w-5 h-5" style="duotone" />
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div class="flex flex-col items-center justify-center space-y-4">
                                <div class="w-20 h-20 bg-slate-50 dark:bg-slate-900 rounded-3xl flex items-center justify-center shadow-inner">
                                    <x-icon name="users-slash" class="w-10 h-10 text-slate-200" style="duotone" />
                                </div>
                                <div class="text-center">
                                    <h4 class="text-lg font-bold text-gray-400 uppercase tracking-widest">Nenhum Registro Encontrado</h4>
                                    <p class="text-sm text-gray-400 font-medium">Tente ajustar os filtros de pesquisa.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pessoas->hasPages())
        <div class="px-6 py-6 bg-slate-50/50 dark:bg-slate-900/30 border-t border-gray-100 dark:border-slate-700/50 mx-4 my-4 rounded-2xl">
            {{ $pessoas->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
