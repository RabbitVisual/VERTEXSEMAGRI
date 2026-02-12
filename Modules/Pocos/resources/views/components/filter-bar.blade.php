@props(['action', 'filters' => [], 'searchPlaceholder' => 'Buscar...', 'showSearch' => true])

<div class="premium-card p-6 mb-8 border-slate-200 dark:border-slate-800/50 bg-white/50 dark:bg-slate-900/50 backdrop-blur-sm">
    <form method="GET" action="{{ $action }}" class="space-y-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @if($showSearch)
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">Buscar Ativo</label>
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-blue-500 transition-colors">
                            <x-icon name="magnifying-glass" class="w-4 h-4" />
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $searchPlaceholder }}" 
                            class="block w-full pl-11 pr-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-2xl text-xs font-bold placeholder-slate-400 focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 dark:text-slate-200 transition-all leading-relaxed">
                    </div>
                </div>
            @endif

            @foreach($filters as $filter)
                <div>
                    <label class="block text-[10px] font-black text-slate-400 uppercase tracking-widest mb-2 px-1">{{ $filter['label'] }}</label>
                    @if($filter['type'] === 'select')
                        <select name="{{ $filter['name'] }}" 
                            class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-2xl text-xs font-bold focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 dark:text-slate-200 transition-all leading-relaxed">
                            <option value="">{{ $filter['placeholder'] ?? 'Todos' }}</option>
                            @foreach($filter['options'] as $value => $label)
                                <option value="{{ $value }}" {{ request($filter['name']) == $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    @elseif($filter['type'] === 'date')
                        <input type="date" name="{{ $filter['name'] }}" value="{{ request($filter['name']) }}" 
                            class="block w-full px-4 py-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/50 rounded-2xl text-xs font-bold focus:outline-none focus:ring-4 focus:ring-blue-500/10 focus:border-blue-500 dark:text-slate-200 transition-all leading-relaxed">
                    @endif
                </div>
            @endforeach
        </div>

        <div class="flex items-center justify-end gap-3 pt-4 border-t border-slate-100 dark:border-slate-800/50">
            <a href="{{ $action }}" class="px-6 py-2.5 text-[10px] font-black text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200 uppercase tracking-widest transition-colors flex items-center gap-2">
                <x-icon name="rotate-left" class="w-3.5 h-3.5" />
                Limpar
            </a>
            <button type="submit" class="px-8 py-2.5 text-[10px] font-black text-white bg-slate-900 dark:bg-blue-600 rounded-xl hover:bg-black dark:hover:bg-blue-700 shadow-lg shadow-slate-900/10 dark:shadow-blue-500/20 active:scale-95 transition-all uppercase tracking-widest flex items-center gap-2">
                <x-icon name="filter" class="w-3.5 h-3.5" />
                Filtrar Resultados
            </button>
        </div>
    </form>
</div>
