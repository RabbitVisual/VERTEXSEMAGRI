@props(['action', 'filters' => [], 'searchPlaceholder' => 'Rastrear registro...', 'showSearch' => true])

<div class="premium-card p-10 mb-8 border-indigo-500/10">
    <form method="GET" action="{{ $action }}" class="space-y-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-end">
            @if($showSearch)
                <div class="lg:col-span-5 space-y-3">
                    <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest italic ml-2">Inteligência de Busca</label>
                    <div class="relative group">
                        <div class="absolute left-6 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-emerald-500 transition-colors">
                            <x-icon name="magnifying-glass" class="w-4 h-4" />
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ strtoupper($searchPlaceholder) }}" class="w-full pl-14 pr-6 py-4 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest placeholder:text-slate-300 dark:text-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all shadow-inner">
                    </div>
                </div>
            @endif

            @foreach($filters as $filter)
                <div class="lg:col-span-2 space-y-3">
                    <label class="block text-[9px] font-black uppercase text-slate-400 tracking-widest italic ml-2">{{ $filter['label'] }}</label>
                    <div class="relative group">
                        @if($filter['type'] === 'select')
                            <select name="{{ $filter['name'] }}" class="w-full px-6 py-4 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest dark:text-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all appearance-none cursor-pointer">
                                <option value="">{{ strtoupper($filter['placeholder'] ?? 'Todos') }}</option>
                                @foreach($filter['options'] as $value => $label)
                                    <option value="{{ $value }}" {{ request($filter['name']) == $value ? 'selected' : '' }}>{{ strtoupper($label) }}</option>
                                @endforeach
                            </select>
                            <div class="absolute right-6 top-1/2 -translate-y-1/2 text-slate-300 pointer-events-none">
                                <x-icon name="chevron-down" class="w-3 h-3" />
                            </div>
                        @elseif($filter['type'] === 'date')
                            <input type="date" name="{{ $filter['name'] }}" value="{{ request($filter['name']) }}" class="w-full px-6 py-4 bg-gray-50 dark:bg-slate-950 border-gray-100 dark:border-slate-800 rounded-2xl text-[11px] font-black uppercase tracking-widest dark:text-white focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all">
                        @endif
                    </div>
                </div>
            @endforeach

            <div class="lg:col-span-3 flex gap-4">
                <a href="{{ $action }}" class="p-4 bg-gray-100 dark:bg-slate-800 text-slate-400 rounded-2xl hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/20 transition-all border border-transparent hover:border-rose-200/50" title="Resetar Filtros">
                    <x-icon name="rotate-left" class="w-5 h-5" />
                </a>
                <button type="submit" class="flex-1 h-14 bg-slate-900 dark:bg-emerald-600 text-white rounded-2xl text-[11px] font-black uppercase tracking-widest hover:opacity-90 active:scale-95 transition-all shadow-xl flex items-center justify-center gap-3">
                    <x-icon name="filter" class="w-4 h-4" />
                    Filtrar Registros
                </button>
            </div>
        </div>
    </form>
</div>
